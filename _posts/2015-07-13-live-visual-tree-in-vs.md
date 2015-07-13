---
layout: post
title: Using Live Visual Tree to discover internals of Visual Studio
category: debugging
permalink: debugging/live-visual-tree-vs
tags: [dotnet, visualstudio, debugging]
---

Visual Studio 2015 brings many new debugging and productivity tools. My favorites are [Diagnostic Tools](http://blogs.msdn.com/b/visualstudioalm/archive/2015/01/16/diagnostic-tools-debugger-window-in-visual-studio-2015.aspx) and **Live Visual Tree**. Live Visual Tree shows a hierarchy of WPF elements in the app that you're debugging. It is complimented by **Live Property Explorer** that shows (and lets you change) properties of UI elements at runtime! It gets very interesting if you're debugging Visual Studio itself (e.g. when debugging a Visual Studio extension)

***

Live Visual Tree and Live Property Explorer allow you to try out different looks of the UI without restarting the app with every change. Here, I changed the content of a `TextBlock` in the tab and applied red color to it

![screenshot](/blogData/live-visual-tree-vs/mischief1.PNG)

using Live Property Explorer

![screenshot](/blogData/live-visual-tree-vs/property-explorer.PNG)

Live Visual Tree shows where this TextBlock is located

![screenshot](/blogData/live-visual-tree-vs/visual-tree.PNG)


***

How to...
---

Launch
===

**Live Visual Tree** and **Live Property Explorer** are accessible from **Debug > Windows** menu in Visual Studio 2015.

Find UI element in the hierarchy
===

Toggle the first button *Enable selection in the running application* to select UI elements in your debugged application and bring them to your attention in hierarchy within Live Visual Tree. This overrides mouse click events.

![screenshot](/blogData/live-visual-tree-vs/gyazo1.PNG)

![screenshot](/blogData/live-visual-tree-vs/gyazo1result.png)


Find UI element visually
===

Toggle the second button *Display layout adorners in the running application* to highlight the UI element which is selected in hierarchy within Live Visual Tree

![screenshot](/blogData/live-visual-tree-vs/gyazo2.PNG)

![screenshot](/blogData/live-visual-tree-vs/gyazo2result.png)

***

Possibilities
---

Live Visual Tree came in handy when I needed to see how the VS search box was built. Clicking on the search box revealed it within the UI element hierarchy.

![screenshot](/blogData/live-visual-tree-vs/search-box.PNG)

In Live Visual Tree I backtracked a bit to find the parent class `FindControl`. Hovering the mouse over the element's name shows the tooltip with the type's namespace. By convention, I deduced that the code must be located in `Microsoft.VisualStudio.Editor.Implementation.dll`. Thank you Live Visual Tree for spilling Visual Studio's secrets!

![screenshot](/blogData/live-visual-tree-vs/search-box-hierarchy.png)