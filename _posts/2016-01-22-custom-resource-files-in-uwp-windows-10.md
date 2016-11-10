---
layout: post
title: Custom resource files in UWP
category: iot
permalink: iot/custom-resource-files-in-uwp-windows-10
tags: [iot, csharp, windows]
---

I made a rookie mistake of hardcoding the weather service API token (key) into a public github repo, and did it all live on camera when recording an episode of [Coding with Amadeus: Smart Mirror](https://www.youtube.com/watch?v=NCMQIH0ilLo). I should have stored the token in an untracked resource file, but it's done differently in the Universal Windows Platform. In this blog post we will explore two ways of accessing data from files in UWP apps.

# Protect the API token 

When an API token is leaked, you need to invalidate it. Ensure that a new token won't be leaked again then get a new token:

1. Reset the API token
  * Ideally, the service provider offers a way to reset the API token. The old token becomes invalid, and you get a new one.
  * In another case, you need to create a new account and use its API token.
2. Remove the token from the source code
  * [Rewriting git history](https://www.atlassian.com/git/tutorials/rewriting-history/git-reflog) is possible, but not recommended - especially if you pushed your changes and others might have pulled them.
  * Replace the API token string literal with code that accesses the resources (the subject of this blog post)
3. Create a resource file that will hold sensitive data
  * Commit this (empty) file to avoid `FileNotFoundException` and other issues
4. Cease tracking the resource file. See [StackOverflow on What is best practice for keeping secrets out of a git repository?](https://stackoverflow.com/questions/8309304/what-is-best-practice-for-keeping-secrets-out-of-a-git-repository) for a basic and robust approach or tl;dr the basic approach:
  * `git update-index --skip-worktree secretFile.txt`
  * Now you can write your API tokens into the file, and git won't pick up these changes
  * Make sure to supply required tokens to continuous integration and build server

# Background: sensitive data in ASP.MVC

To provide some background, I stored the secret token in git-ignored `Sensitive.config` file ([see the file on GitHub](https://github.com/CodeConnect/SourceBrowser/blob/9848ba033619d9887e1c358bc721284c29ebe8e2/src/Security.config))

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

Universal apps run in a sandboxed UWP runtime and use a subset of the .NET framework.

On UWP, we have no access to [System.Configuration.ConfigurationManager](https://msdn.microsoft.com/en-us/library/system.configuration.configurationmanager%28v=vs.110%29.aspx), but we get limited access to filesystem using APIs shared across all platforms (Desktop, Mobile, IoT etc.)

In brief, access to the filesystem in UWP is limited to the [DownloadsFolder](https://msdn.microsoft.com/en-us/library/windows/apps/windows.storage.downloadsfolder.aspx), [KnownFolders](https://msdn.microsoft.com/library/windows/apps/windows.storage.knownfolders.aspx) (user's libraries such as photos, music, videos etc) and [ApplicationData.LocalFolder](https://msdn.microsoft.com/en-us/library/windows/apps/windows.storage.applicationdata.localfolder.aspx) 

Microsoft provides a very good guide on how to [Store and retrieve settings and other app data](https://msdn.microsoft.com/en-us/library/windows/apps/mt299098.aspx), which are loaded from the `LocalFolder`. Unfortunately, these settings need to be programatically created from within the app, for example on first launch. My IoT project doesn't have keyboard input so I can't rely on saving an API token typed in by the user. **In my use case, I must hide the data from source control**, so I need to store it in an untracked resource or configuration file. 

# UWP: Read any file bundled with the application

The good news is that UWP provides access to more than user's Documents. We have access to application's storage locker as well as read-only access to the directory where the application's `.exe` is located. 

To access files located where `.exe` is, we just need to set the file's **Build Action** to `Content`. **Copy to Output Directory** doesn't matter. 

![file properties](/blogData/custom-resource-files-in-uwp-windows-10/file-properties.png)

You can access the file using URI (read more about URIs in [Microsoft's tutorial](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965322.aspx))

```csharp
async Task<string> readSampleFile1()
{
    var uri = new System.Uri("ms-appx:///sample.txt");
	var sampleFile = await Windows.Storage.StorageFile.GetFileFromApplicationUriAsync(uri);
    return await Windows.Storage.FileIO.ReadTextAsync(sampleFile);
}
```

or using the `StorageFolder` class:

```csharp
async Task<string> readSampleFile2()
{
    var packageFolder = Windows.ApplicationModel.Package.Current.InstalledLocation;
    var sampleFile = await packageFolder.GetFileAsync("sample.txt");
    return await Windows.Storage.FileIO.ReadTextAsync(sampleFile);
}

```
`InstalledLocation` is a `StorageFolder`, and we can enumerate files contained within:

```csharp
async Task enumerateFiles()
{
    var packageFolder = Windows.ApplicationModel.Package.Current.InstalledLocation;
    var files = await packageFolder.GetFilesAsync();
    foreach (var file in files)
    {
        var path = file.Path;
        // Works only with text files:
        // var contents = await Windows.Storage.FileIO.ReadTextAsync(file);
    }
}
```

# UWP: Use string resources

Windows offers powerful ways to access localized string resources. You can use the resources from both C# back-end and XAML front-end. The main benefit of this approach is that the resources come localized and customized to the user's device (images use the best size and contrast variants). You don't need to load, read and parse the file yourself. Furthermore, when a user changes their language preferences while your app is running, the strings in your app will be updated! These resources go to a `.resw` file, which appears to be a Windows 10 equivalent of `.resx` files.

Read the [guide on loading string resources](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965323.aspx) and the
[guide on creating localized resource files](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965326.aspx) to learn about all the features of this approach. 

I just wanted to show how to use the most basic flavor of this approach, just to load the API token.

1. Right click on the project, `Add > New Item`, pick `Resources File (.resw)`. 
2. Save all, check the empty file into the source control and immediately ignore it (see "Protect the API token" section above)
3. Double click on the newly added file and add type in the API token.

![resource file properties](/blogData/custom-resource-files-in-uwp-windows-10/resource-properties.png)

To access the token from the code, create an instance of `ResourceLoader`, passing in the name of the resource file *without the extension*.
Suppose you created `resourcesFile.resw` and added a line with the key `secret`:

```csharp
var resources = new Windows.ApplicationModel.Resources.ResourceLoader("resourcesFile");
var token = resources.GetString("secret");
```

# Error handling

Suppose someone cloned your repo and wants to run your app. Whether you included an empty file in the repo, or ignored it without adding it, what will be their developer experience? Will your code fail gracefully, or crash the app?

* When the file doesn't exist:
 * Both `GetFileAsync` and `GetFileFromApplicationUriAsync` throw `FileNotFoundException` with message `The system cannot find the file 
 * `ResourceLoader` constructor throws `COMException` with message `ResourceMap Not Found.`

* When the file exists, but the resource can't be found
 * If you're parsing the file yourself, it's up to you to handle this scenario.
 * `ResourceLoader.GetString` returns an empty string.

# Conclusion

Whether you're using resources or reading files yourself, both options offer you a way to consume a file checked into the source control.
Using resources is slightly easier, as you don't need to open and parse the file. 
Loading the file yourself, however, gives you far more flexibility if you need it.

**Which method will I use?**

Initially, I was sure I would load and parse a `.json` file. On top of storing API keys, I wanted to store a number of other parameters. A JSON array would be the perfect data structure for the job, unlike resources that I need to directly access by name. 

I may feel inclined to try both approaches and store the JSON array as a string resource :)
