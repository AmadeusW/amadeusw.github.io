---
layout: post
title: Custom resource files in UWP
category: iot
xpermalink: iot/connect-to-ADC-using-SPI-in-windows-10
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
  <appSettings file="../Sensitive.config">
  <add key="public" value="sample text" />
  </appSettings>
  <!-- ... -->
</configuration>
```
On my computer, I had a different version of `Sensitive.config` that had a value for the `secret` key.
In the code, you could easily access the data:
```csharp
var secret = ConfigurationManager.AppSettings["secret"];
```

# State of things in UWP

A universal app runs in a sandboxed UWP runtime and a different subset of .NET framework.

We have no access to [System.Configuration.ConfigurationManager](https://msdn.microsoft.com/en-us/library/system.configuration.configurationmanager%28v=vs.110%29.aspx), but UWP exposes limited access to filesystem using APIs shared across all platforms (Desktop, Mobile, IoT etc.)

In brief, access to the filesystem is limited to the [DownloadsFolder](https://msdn.microsoft.com/en-us/library/windows/apps/windows.storage.downloadsfolder.aspx), user-defined libraries (photos, music, videos etc.) listed under [KnownFolders](https://msdn.microsoft.com/library/windows/apps/windows.storage.knownfolders.aspx) and [ApplicationData.LocalFolder](https://msdn.microsoft.com/en-us/library/windows/apps/windows.storage.applicationdata.localfolder.aspx) 

Microsoft provides a very good guide on how to [Store and retrieve settings and other app data](https://msdn.microsoft.com/en-us/library/windows/apps/mt299098.aspx), which are loaded from the `LocalFolder`. The caveat is that 

# UWP: Read any file bundled with the application

# UWP: Use string resources
https://msdn.microsoft.com/en-us/library/windows/apps/xaml/hh965323.aspx