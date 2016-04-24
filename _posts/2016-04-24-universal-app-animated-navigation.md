---
layout: post
title: Animated navigation in Universal Apps
category: xaml
permalink: xaml/animated-navigation-universal-app
tags: [xaml, ui, windows]
---

Let's explore different ways to animate the navigation across Frames in an Universal App.

Check out the videos below or [explore the source code](https://github.com/AmadeusW/xaml-page-transitions) and run the app yourself.


Basic transition
===

Add a transition to `Page.Transitions` to set how the page appears and disappears. This is all the code you need, as WPF invokes the animation behind the scenes.

```xml
<!-- <Page -->
    <Page.Transitions>
        <TransitionCollection>
            <EntranceThemeTransition />
        </TransitionCollection>
    </Page.Transitions>
```

WPF provides a few implementations of `Windows.UI.Xaml.Media.Animation.Transition` that you can plug into `TransitionCollection`. The code sample uses reflection to explore all of the implementations.

Some implementations are more suitable for page navigation than others, and some of them allow you to pass in a parameter that further customizes the behavior.

**AddDeleteThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/addDelete.mp4" type="video/mp4">  </video>


**ContentThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/content.mp4" type="video/mp4">  </video>


**EdgeThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/edge.mp4" type="video/mp4">  </video>


**EntranceThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/entrance.mp4" type="video/mp4">  </video>


**PaneThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/pane.mp4" type="video/mp4">  </video>


**PopupThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/popup.mp4" type="video/mp4">  </video>


**ReorderThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/reorder.mp4" type="video/mp4">  </video>


**RepositionThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/reposition.mp4" type="video/mp4">  </video>


**NavigationThemeTransition**
<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/navigation.mp4" type="video/mp4">  </video>


*Note that Left and Right animations were implemented using the "control animation direction" code below.*


Directional animation
===

If you know that a page always comes out from one edge and returns there afterwards, hard-code the transition's parameters into the xaml. 

Here, the red popup page uses `EdgeUIThemeTransition` and hard-codes the **left edge**.

<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/popupContent.mp4" type="video/mp4">  </video>

```xml
<Page.Transitions>
    <TransitionCollection>
        <EdgeUIThemeTransition Edge="Left" />
    </TransitionCollection>
</Page.Transitions>
```

Some transitions play exceptionally nice with others. Here, we are navigating **from** `EdgeUIThemeTransition` **to** `PaneThemeTransition`.

<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/popupPane.mp4" type="video/mp4">  </video>

Not all combinations of "to" and "from" play well together - a race condition may occur and only one transition would play.

Control animation direction
===

Transitions are not aware of direction of navigation.

To implement **scrolling**, you will need to provide direction of animation, and **inverse** it depending on whether you're navigating **to** or **from** the page.

First, pass in an optional parameter to the `Navigate` method to indicate the animation direction.

```csharp
// In the navigation logic
bool navigatingRight = true;
Frame rootFrame = Window.Current.Content as Frame;
rootFrame.Navigate(typeof(MyView), parameter: navigatingRight);
```

Add code that adjusts the transition's property just before the animation plays.

**Notice** that properties in **from** animation are opposites of these in **to** animation to create an illusion of scrolling.

```csharp
// in MyView.xaml.cs
public sealed partial class MyView : Page
{
    protected override void OnNavigatedTo(NavigationEventArgs e)
    {
        if (!(e.Parameter is bool))
            return;
        bool navigatingRight = (bool)e.Parameter;

        EntranceAnimation.FromHorizontalOffset = towardsRight ? 300 : -300;
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

Finally, give a name to the transition, so that you can access it from the C# code.

```xml
<!-- in MyView.xaml -->
    <EntranceThemeTransition x:Name="EntranceAnimation" />
```

or use it without the name:

```csharp
// in MyView.xaml.cs
    var entranceAnimation = this.Transitions.FirstOrDefault() as EntranceThemeTransition;
    entranceAnimation.FromHorizontalOffset = navigatingRight ? -300 : 300;
```

Voilà!

<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/paneSwipe.mp4" type="video/mp4">  </video>

