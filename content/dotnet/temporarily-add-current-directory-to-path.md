---
title: Temporarily add current directory to PATH
date: 2015-11-05
summary: "Because Powershell must do it differently than Unix"
category: windows
permalink: windows/temporarily-add-current-directory-to-path
tags: [windows]
---

I wanted to quickly add a location to PATH just for the current console session.

Piecing together a couple StackOverflow answers, here is the command that adds the current directory to the PATH. 

`set path=%path%;%cd%`

Double-check that the directory you're in has been added to the PATH by echoing it:

`echo %path%`

The next time you run command prompt, the PATH will be reset to its original value.

Don't forget that holding shift when right-clicking in folder's window adds the convenient "Open command window here" menu item!

![exception screenshot](/techBlogData//temporarily-add-current-directory-to-path/open-command-window-here.png)
