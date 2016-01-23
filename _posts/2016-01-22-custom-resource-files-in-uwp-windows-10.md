---
layout: post
title: Custom resource files in UWP
category: iot
permalink: iot/connect-to-ADC-using-SPI-in-windows-10
tags: [iot, csharp, windows]
---

I made a rookie mistake of hardcoding the API token (key) to a weather service. I then committed the code to a public github repo, and did it all live on camera when recording an episode of [Coding with Amadeus: Smart Mirror](https://www.youtube.com/watch?v=NCMQIH0ilLo).

# Protect the API token 

When an API key (token) is leaked, the recovery steps are straightforward:

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

My workflow in ASP.MVC ([see on GitHub](https://github.com/CodeConnect/SourceBrowser/blob/9848ba033619d9887e1c358bc721284c29ebe8e2/src/Security.config)) was to merge settings from the `Sensitive.config` file 

```xml
﻿<?xml version="1.0" encoding="utf-8" ?>
<appSettings>
	<add key="secret" value="" />
</appSettings>
```

into `Web.config`

```xml
<configuration>
  <!-- ... -->
  <appSettings file="Sensitive.config">
    <add key="public" value="sample text" />
  </appSettings>
  <!-- ... -->
</configuration>
```
In the code, you could easily access the data:

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

The good news is that UWP provides access not only to some of user's files, and application's little storage locker, but we also have access to the directory where the application's **.exe** is! This means that we just need to include the files that we need, and they will be shipped with the application. 

![file properties](/blogData/custom-resource-files-in-uwp-windows-10/file-properties.png)

```csharp
async Task<List<string>> listFiles()
{
    var packageFolder = Windows.ApplicationModel.Package.Current.InstalledLocation;
    var files = await packageFolder.GetFilesAsync();
    var fileList = new List<string>();
    foreach (var file in files)
    {
        fileList.Add(file.Path);
    }
    return fileList;
}
```

```csharp
async Task<string> readSampleFile()
{
    var packageFolder = Windows.ApplicationModel.Package.Current.InstalledLocation;
    var testFile = await packageFolder.GetFileAsync("sample.txt");
    var contents = await Windows.Storage.FileIO.ReadTextAsync(testFile);
}
```

This solution works well for me because it allows me to ship my settings in the format that I want, such as json. I publish the source code of the app on [my public GitHub repo](https://github.com/AmadeusW/Mirror) yet I don't distribute the app to others - it runs locally on Raspberry Pi.

Let's look at another way to read string resources:

# UWP: Use string resources

**WORK IN PROGRESS**

[https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965323.aspx](https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965323.aspx)