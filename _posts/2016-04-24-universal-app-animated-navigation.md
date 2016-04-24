---
layout: post
title: Animated navigation in Universal App
category: xaml
permalink: xaml/animated-navigation-universal-app
tags: [xaml, ui, windows]
---

Let's explore different ways to navigate across Frames in an Universal App.
Check out gifs below or download the source code.

Default animation
===

By default, the page appears and some elements on the page animate:


Custom page transition
===

WPF comes with a few transitions. Each transition has a "from" and a "to" animation.
In the gifs below, the checkerboard page has a transition and the plain page has no transition.

```xaml
<Page.Transitions>
    <TransitionCollection>
        <EntranceThemeTransition x:Name="EntranceAnimation" />
    </TransitionCollection>
</Page.Transitions>
```

Here, both pages have a transition

Page transition dependent on a navigation movement
===

To set the direction of the animation, pass in an optional parameter to the `Navigate` method

```csharp
bool navigatingRight = true; // provided by the navigation logic
Frame rootFrame = Window.Current.Content as Frame;
rootFrame.Navigate(typeof(MyView), parameter: navigatingRight);
```

Add code that sets the transition's property based on the parameter

```csharp
public sealed partial class MyView : Page
{
	protected override void OnNavigatedTo(NavigationEventArgs e)
	{
	    if (!(e.Parameter is bool))
	        return;
	    bool navigatingRight = (bool)e.Parameter;
	    EntranceAnimation.FromHorizontalOffset = navigatingRight ? 300 : -300;
	}

	protected override void OnNavigatingFrom(NavigatingCancelEventArgs e)
	{
	    if (!(e.Parameter is bool))
	        return;
	    bool navigatingRight = (bool)e.Parameter;
	    EntranceAnimation.FromHorizontalOffset = navigatingRight ? -300 : 300;
	}
}
```

And give a name to the transition, so that you can access it from the C# code.

```xaml
<Page.Transitions>
    <TransitionCollection>
        <EntranceThemeTransition x:Name="EntranceAnimation" />
    </TransitionCollection>
</Page.Transitions>
```

Here's the result:

![demo gif](/blogData/animated-navigation-universal-app/directional.gif)

