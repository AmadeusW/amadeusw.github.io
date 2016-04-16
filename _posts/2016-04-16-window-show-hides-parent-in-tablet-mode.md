---
layout: post
title: Window.Show hides parent window in Tablet mode
category: windows
permalink: windows/window-show-hides-parent-in-tablet-mode
tags: [windows, dotnet, ui]
---

I just received an [issue on TouchVS extension](https://github.com/CodeConnect/TouchVS/issues/10) that in **Tablet mode**, Visual Studio minimizes when user launches TouchVS. 

It turns out that in Windows 10 Tablet Mode, the active window is always maximized and other windows are hidden. If you `Show()` another window, it will maximize and previous window will minimize. 

*In this gif we are trying to create a 200px x 200px popup window, but in tablet mode the popup window gets maximized and parent window gets minimized:*
![demo gif](/blogData/window-show-hides-parent-in-tablet-mode/demo.gif)

This is not a desired behavior for small popup windows. To fix it, disallow the window from maximizing by setting `ResizeMode` property to either `NoResize` or `CanMinimize`. 

```csharp
var myWindow = new MyWindow()
{
    ResizeMode = ResizeMode.NoResize,
}
myWindow.Show();
```

Now Tablet mode won't maximize `myWindow`, and it won't minimize the parent window.

This is a very rare issue, since most dialog boxes already don't maximize. TouchVS had this issue because its `WindowStyle = WindowStyle.None` and it was never explicitly disallowed from maximizing.
