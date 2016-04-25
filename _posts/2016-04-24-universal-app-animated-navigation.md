---
layout: post
title: Animated navigation in Universal Apps
category: xaml
permalink: xaml/animated-navigation-universal-app
tags: [xaml, ui, windows]
---

Let's explore different ways to animate the navigation across Frames in an Universal App.
These animations are called Transitions, and WPF provides a few af them. 

![banner image](/blogData/animated-navigation-universal-app/animation.png)

We will see how easy it is to create a [transition from and back to a left edge](#directional-animation) of the screen. With some extra code, we will create [transitions that look like continuous scrolling](#continuous-swiping-animation) in one direction. Finally, we will see [demo videos](#demo-of-all-transitions) of all transitions. 

[Explore the source code](https://github.com/AmadeusW/xaml-page-transitions) and run the demo app yourself.


Basic transition
===

To add an animated transition to your page, just pass in a type of the transition to `Page.Transitions`. 
WPF invokes the animation behind the scenes when you're navigating to and from the page.

```xml
<!-- <Page -->
    <Page.Transitions>
        <TransitionCollection>
            <EntranceThemeTransition />
        </TransitionCollection>
    </Page.Transitions>
```

<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/entrance.mp4" type="video/mp4">  </video>

WPF provides a few implementations of `Windows.UI.Xaml.Media.Animation.Transition` that you can plug into `TransitionCollection`. 
Some implementations are more suitable for page navigation than others, and some of them allow you to pass in a parameter that further customizes the behavior.
You can [see all implementations](#demo-of-all-transitions) below. 

Directional animation
===

If a page always comes out from one edge and returns there afterwards, pass in transition's parameters through xaml. 

Here, the red popup page uses `EdgeUIThemeTransition` associated with the **left edge**.

<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/popupContent.mp4" type="video/mp4">  </video>

```xml
<Page.Transitions>
    <TransitionCollection>
        <EdgeUIThemeTransition Edge="Left" />
    </TransitionCollection>
</Page.Transitions>
```

Some transitions play exceptionally nice with others. Here, we are navigating between `PaneThemeTransition` and `EdgeUIThemeTransition` in the popup.

<video width="512" height="386" autoplay loop>
  <source src="{{baseurl}}/blogData/animated-navigation-universal-app/popupPane.mp4" type="video/mp4">  </video>


Continuous swiping animation
===

Transitions are not aware of direction of navigation.

To implement **scrolling**, you will need to inverese the direction of animation depending on whether you're navigating **to** or **from** the page.

First, pass in an optional parameter to the `Navigate` method to indicate the animation direction.

```csharp
// In the navigation logic
bool navigatingRight = true;
Frame rootFrame = Window.Current.Content as Frame;
rootFrame.Navigate(typeof(MyView), parameter: navigatingRight);
```

Now, add code that adjusts the transition's property just before the animation plays.

**Notice** that properties in **from** animation are opposites of these in **to** animation. 
This way, the page won't return to its initial position, but will simulate animation in one direction.

```csharp
// in MyView.xaml.cs
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

Demo of all transitions
===

Check out [the source code](https://github.com/AmadeusW/xaml-page-transitions) and see the animations in high fidelity. 
The code is using reflection to find implementations of `Windows.UI.Xaml.Media.Animation.Transition`

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

Cheers!