---
layout: post
title: Custom resource files in UWP
category: iot
permalink: iot/custom-resource-files-in-uwp-windows-10
tags: [iot, csharp, windows]
---

I made a rookie mistake of hardcoding the weather service API token (key) into a public github repo, and did it all live on camera when recording an episode of [Coding with Amadeus: Smart Mirror](https://www.youtube.com/watch?v=NCMQIH0ilLo). A good way to secure a secret token is to load it from a resource file. This isn't as easy in Universal Windows Platform. In this blog post I will explore this subject and provide code 

# Protect the API token 

When an API key (token) is leaked, you need to invalidate the leaked token, make sure it won't get leaked again, and get a new token:

1. Reset the API token
  * Ideally, the service provider offers a reset of the API token. You click a button, get a new token, and the old one becomes invalid.
  * In another case, you need to create a new free account and use the new API token
2. Remove the token from the source code
  * [Rewriting git history](https://www.atlassian.com/git/tutorials/rewriting-history/git-reflog) is possible, but not recommended - especially if you pushed your changes and others might have pulled them
  * Replace the API token string literal with an access to resources
3. Create a resource file that will hold sensitive data
  * Commit this code to avoid `FileNotFoundException` and other issues
4. Stop tracking the resource file ([GitHub guide](https://help.github.com/articles/ignoring-files/#ignoring-versioned-files))
  * Add the file to `.gitignore`
  * `git rm --cached`
  * Now you can write your API tokens into the file, and git won't pick up these changes
  * This may break your continuous integration, but it's all fixable (but not a subject of this blog post)

# How to access sensitive data in ASP.MVC

To provide some background, in an ASP.MVC application ([see on GitHub](https://github.com/CodeConnect/SourceBrowser/blob/9848ba033619d9887e1c358bc721284c29ebe8e2/src/Security.config)) I stored the secret token in git-ignored `Sensitive.config` file

```xml
﻿<?xml version="1.0" encoding="utf-8" ?>
<appSettings>
	<add key="secret" value="" />
</appSettings>
```

Which I then merged into `Web.config`

```xml
<configuration>
  <!-- ... -->
  <appSettings file="Sensitive.config">
    <add key="public" value="sample text" />
  </appSettings>
  <!-- ... -->
</configuration>
```

I could then easily access the data:

```csharp
var secret = ConfigurationManager.AppSettings["secret"];
```

On my dev machine, CI server and production server, we had a version of `Sensitive.config` that set the `secret` key. Everyone else is encouraged to use their own API token or face limited functionality.

# State of things in UWP

Universal apps run in a sandboxed UWP runtime and use a subset of .NET framework.

On UWP, we have no access to [System.Configuration.ConfigurationManager](https://msdn.microsoft.com/en-us/library/system.configuration.configurationmanager%28v=vs.110%29.aspx), but we get limited access to filesystem using APIs shared across all platforms (Desktop, Mobile, IoT etc.)

In brief, access to the filesystem in UWP is limited to the [DownloadsFolder](https://msdn.microsoft.com/en-us/library/windows/apps/windows.storage.downloadsfolder.aspx), user-defined libraries (photos, music, videos etc.) listed under [KnownFolders](https://msdn.microsoft.com/library/windows/apps/windows.storage.knownfolders.aspx) and [ApplicationData.LocalFolder](https://msdn.microsoft.com/en-us/library/windows/apps/windows.storage.applicationdata.localfolder.aspx) 

Microsoft provides a very good guide on how to [Store and retrieve settings and other app data](https://msdn.microsoft.com/en-us/library/windows/apps/mt299098.aspx), which are loaded from the `LocalFolder`. Unfortunately, these settings need to be created from within the app, for example on first launch. I need to hide the data from source control, so this solution won't work in my use case.

# UWP: Read any file bundled with the application

The good news is that UWP provides access not only to some of user's files, and application's little storage locker, but we also have read-only access to the directory where the application's **.exe** is! 

This means that we just need to include the file in the output directory, and set its build action to `Content`. This way, the file will be shipped with the application. 

![file properties](/blogData/custom-resource-files-in-uwp-windows-10/file-properties.png)

You can access the file using URI (follow [Microsoft's tutorial](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965322.aspx)
```csharp
async Task<string> readSampleFile1()
{
    var uri = new System.Uri("ms-appx:///sample.txt");
	var sampleFile = await Windows.Storage.StorageFile.GetFileFromApplicationUriAsync(uri);
    var contents = await Windows.Storage.FileIO.ReadTextAsync(sampleFile);
}
```
or read file directly:

```csharp
async Task<string> readSampleFile2()
{
    var packageFolder = Windows.ApplicationModel.Package.Current.InstalledLocation;
    var sampleFile = await packageFolder.GetFileAsync("sample.txt");
    var contents = await Windows.Storage.FileIO.ReadTextAsync(sampleFile);
}
```
`InstalledLocation` is a `StorageFolder`, and we can enumerate files contained within:
```csharp
async Task<List<string>> readAllFiles()
{
    var packageFolder = Windows.ApplicationModel.Package.Current.InstalledLocation;
    var files = await packageFolder.GetFilesAsync();
    foreach (var file in files)
    {
        var path = file.Path;
        var contents = await Windows.Storage.FileIO.ReadTextAsync(file);
    }
}
```

# UWP: Use string resources

Windows offers a pretty powerful way to access localized string resources. You can use the resources from both C# back-end and XAML front-end. The main benefit this approach is that the resources come localized and customized to user's device (images use the best size and contrast variants). You don't need to load, read and parse the file yourself. Furthermore, when user changes their language preferences while your app is running, the strings in your app will be updated! These resources go to a `.resw` file, which appears to be a Windows 10 equivalent of `.resx` files.

Read the [guide on loading string resources](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965323.aspx) and the
[guide on creating localized resource files](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965326.aspx) to learn about all features of this approach. 

I just wanted to show how to use this approach to load the API token in the most basic way.

1. Right click on the project, Add > New Item, pick `Resources File (.resw)`. 
2. Save all, check the empty file into the source control and immediately ignore it (see "Protect the API token" section above)
3. Double click on the newly added file and add the API token.

![resource file properties](/blogData/custom-resource-files-in-uwp-windows-10/resource-properties.png)

Now, create an instance of `ResourceLoader`, passing in the name of the resource file *without the extension*.
Suppose you created `resourcesFile.resw` and added a line with key `secret`:

```csharp
var rl = new Windows.ApplicationModel.Resources.ResourceLoader("resourcesFile");
var token = rl.GetString("secret");
```

# Error handling

Suppose someone cloned your repo and wants to run your app. Whether you included an empty file in the repo, or ignored it without adding it, what will be their developer experience? Will your code fail gracefully, or crash the app?

* When the file doesn't exist:
 * Both `GetFileAsync` and `GetFileFromApplicationUriAsync` throw `FileNotFoundException` with message `The system cannot find the file 
 * `ResourceLoader` constructor throws `COMException` with message `ResourceMap Not Found.`

* When the file exists, but the resource can't be found
 * If you're reading the file yourself, it's up to you to parse it
 * `ResourceLoader.GetString` returns an empty string :) 

# Conclusion

Whether you're using resources or reading files yourself, both options offer you a way to check in an empty file to the source control.
Using resources is slightly easier, as you don't need to open and parse the file. 
Loading the file yourself, however, gives you far more flexibility if you need it.

**Which method will I use?**

I was confident I would load and parse a `.json` file, because on top of storing API keys, I wanted to store a variable number of parameters. A JSON array would be the perfect data structure for the job, unlike resources that I need to directly access one by one. Technically, I could store a JSON string in the resource... 