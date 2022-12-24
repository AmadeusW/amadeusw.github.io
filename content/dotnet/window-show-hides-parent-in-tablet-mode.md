---
title: Window.Show hides parent window in Tablet mode
date: 2016-04-16
summary: "A workaround for an obscure issue."
category: windows
permalink: windows/window-show-hides-parent-in-tablet-mode
tags: [windows, dotnet, ui]
---

In Windows 10 Tablet Mode, the active window is always maximized and other windows are hidden. If you `Show()` a window it will maximize and parent window will minimize. 

*In this gif we are trying to create a red 200px x 200px popup window. 
In tablet mode it maximizes and white parent window minimizes.*

![demo gif](/techBlogData//window-show-hides-parent-in-tablet-mode/demo.gif)

This is not a desired behavior for small popup windows. To fix it, disallow the window from maximizing: 
Set `ResizeMode` property to either `NoResize` or `CanMinimize`. 

```csharp
var myWindow = new MyWindow()
{
    ResizeMode = ResizeMode.NoResize,
}
myWindow.Show();
```

With this code, Tablet mode won't maximize `myWindow`, and it won't minimize the parent window.

This is a very rare issue, since most dialog boxes already don't maximize. [This issue happened to TouchVS extension](https://github.com/CodeConnect/TouchVS/issues/10) because its `WindowStyle = WindowStyle.None` and it was never explicitly disallowed from maximizing. 
