---
layout: post
title: XAML for Universal Windows cheat sheet
category: xaml
permalink: xaml/uwp-cheat-sheet
tags: [xaml, csharp, windows]
---

Working on the user interface can take disproportionate amount of time. I usually do the logic work first, and UI last, in the spare time. In the smart mirror project the UI is very bare bones: it's only here to test data bindings. Let's improve the looks of it.

![no theming applied](/blogData/xaml-cheat-sheet/initial.png)

# Use dark theme

The biggest bang for the buck for the smart mirror project is to request a **dark theme**. In `App.xaml`:

```xml
<Application
    RequestedTheme="Light">
```

change this into

```xml
<Application
    RequestedTheme="Dark">
```

Drastically changes the appearance of the app:

![dark theme](/blogData/xaml-cheat-sheet/dark.png)

# Put styles in their own file

It's a good practice to keep related code together and unrelated code separately. We will leave the viewmodels in the main `App.xaml` and move style-related code to its own file.

Create a new **Resource Dictionary** (right click on a project, Add New Item > XAML > Resource Dictionary). If you call it `MyApp.xaml` and put it in `Themes`, use the following code in `App.xaml`: Add `<ResourceDictionary.MergedDictionaries>` where you will specify the path to the new dictionary.
```xml
<Application>
  <Application.Resources>
    <ResourceDictionary>
      <ResourceDictionary.MergedDictionaries>
        <ResourceDictionary Source="Themes/MyApp.xaml" />
      </ResourceDictionary.MergedDictionaries>
```

Important notice: If you had some resources stored directly in `<Application.Resources>` before, now you need to move all resources into the `<ResourceDictionary>`.

# Style (almost) all TextBlocks

Let's try to theme all instances of `TextBlock`. To do this, create a `Style` with `TargetType` but without the `Key`. You can put it either into `ResourceDictionary` in `App.xaml` or `MyApp.xaml`

```xml
<ResourceDictionary>
  <SolidColorBrush x:Key="TextColor" Color="#FFFF0000" />
  <Style TargetType="TextBlock">
    <Setter Property="FontFamily" Value="Helvetica World" />
    <Setter Property="FontSize" Value="20" />
    <Setter Property="Foreground" Value="{StaticResource TextColor}" />
  </Style>
```

This works for free-standing `TextBlocks`, but not for these embedded in a template, e.g. `DataTemplate`

![doesn't work with templates](/blogData/xaml-cheat-sheet/no-template.png)

# Style specifix TextBlocks

To style absolutely all instances of `TextBlock`, we need to set each one's `Style` property. It's unfortunate that it requires much more code changes and it's not as elegant as CSS tag selector. Let's take advantage of this, though, and create different styles for different `TextBlocks`. XAML styles implement inheritance with `BasedOn` property:

```xml
<ResourceDictionary>
  <Style x:Key="MyText" TargetType="TextBlock">
    <Setter Property="FontFamily" Value="Helvetica World" />
    <Setter Property="Foreground" Value="{StaticResource TextColor}" />
  </Style>
  <Style x:Key="LargeText" BasedOn="{StaticResource MyText}" TargetType="TextBlock">
    <Setter Property="FontSize" Value="20" />
  </Style>
  <Style x:Key="VeryLargeText" BasedOn="{StaticResource MyText}" TargetType="TextBlock">
      <Setter Property="FontSize" Value="30" />
  </Style>
```

To use these styles, assign appropriate `StaticResource` to element's `Style`. Here we're using all three styles for various `TextBlocks`:

```xml
<TextBlock Style="{StaticResource MyText}" />
<TextBlock Style="{StaticResource LargeText}" />
<TextBlock Style="{StaticResource VeryLargeText}" />
```

![each element gets styled](/blogData/xaml-cheat-sheet/various-styles.png)

# Modify the default theme

We can also override the resources used by the default theme. Unfortunately, we can't set the color of TextBlocks (their color is hard-coded rather than provided by another resource). 

For the sake of showing an example, we will modify application's background which is provided by a `SolidColorBrush` with `Key="ApplicationPageBackgroundThemeBrush"`. All we need to do is create a new resource with the same `Key` as resources found in the base theme, and put it in correct hierarchy of resources. Specifically, we put the resource in `ResourceDictionary` which

1. Is inside `<ResourceDictionary.ThemeDictionaries>` - this tells XAML that we want to override resources that make up one of the three base themes: `Light`, `Dark` or `HighContrast`
2. Has the key `"Default"` for the dark theme, `"Light"` for the light theme, and `"HighContrast"` for the high contrast theme.

```xml
<Application>
  <Application.Resources>
    <ResourceDictionary>
      <ResourceDictionary.ThemeDictionaries>
        <ResourceDictionary x:Key="Default">
          <SolidColorBrush x:Key="ApplicationPageBackgroundThemeBrush" Color="Green" />
        </ResourceDictionary>
      </ResourceDictionary.ThemeDictionaries>
```

![changed background color](/blogData/xaml-cheat-sheet/background-color.png)

How did I know to change `ApplicationPageBackgroundThemeBrush`?

The base themes are available for your reference in `generic.xaml` and `themeresources.xaml` in `C:\Program Files (x86)\Windows Kits\10\DesignTime\CommonConfiguration\Neutral\UAP\10.0.10586.0\Generic` (the version number might be different)

Explore these files to find resources that base styles depend on. You can change them to easily theme large chunks of your app.

# Changing resource dictionaries at runtime

_Think again if you really want to do it. There is no nice solution_

I would like the theme of the app to use a red color at night. In Universal Windows Apps there is no `DynamicResource`, so changing properties of resources is not as elegant as in regular Win32 app. If you want to look at all failed attempts to get it working, [here is my SO question](https://stackoverflow.com/questions/35544034/update-resource-in-universal-windows-app-xaml/).

The following options don't work in Universal Windows App:

1. Using `DynamicResource`
 * This type is no longer used, for performance reasons
2. Changing a dictionary at runtime
 * As demonstrated in [Dynamically Skinning Your Windows 8 App](http://blog.jerrynixon.com/2013/01/walkthrough-dynamically-skinning-your.html)
3. Using an [Effect](https://msdn.microsoft.com/en-us/library/system.windows.uielement.effect%28v=vs.110%29.aspx) to change colors
 * `Effects` are also removed from `UIElements`

Here's what you can do:

1. Change element's `Style`
 * To enumerate all elements, use [this code](http://stackoverflow.com/a/978352/879243)
2. Change the element's theme
 * As there are only Light and Dark themes, you don't have much flexibility.

For the complete solution, read [this SO answer](http://stackoverflow.com/a/35548390/879243). In brief:

* Create and use `ThemeAwareFrame` that inherits from `Frame`

```csharp
// App.OnLaunched
  rootFrame = new ThemeAwareFrame(ElementTheme.Dark);
```

* Create your resource in both Light and Dark themes

```xml
<ResourceDictionary
  <ResourceDictionary.ThemeDictionaries>
    <ResourceDictionary x:Key="Dark">
      <SolidColorBrush x:Key="MyTextColor" Color="#FFFFDD99" />
    </ResourceDictionary>
    <ResourceDictionary x:Key="Light">
      <SolidColorBrush x:Key="MyTextColor" Color="#FFDDEEFF" />
    </ResourceDictionary>
  </ResourceDictionary.ThemeDictionaries>
  <Style x:Key="MyText" TargetType="TextBlock">
    <Setter Property="Foreground" Value="{ThemeResource MyTextColor}" />
  </Style>
```

* Change the `AppTheme` of the instance of `ThemeAwareTheme`

```csharp
private void TimeOfDayChangedHandler(bool nightFall)
{
  (Window.Current.Content as ThemeAwareFrame).AppTheme = nightFall ? ElementTheme.Dark : ElementTheme.Light;
}
```

In this example, we're calling `TimeOfDayChangedHandler` every second with alternating boolean flag. Here's the result:

![gif of changing themes](/blogData/xaml-cheat-sheet/changing-theme.gif)

Now we need to overwrite the light theme such that it looks like the dark theme. Notice that this will force users of your app to use the dark theme, despite their personalized system settings. This will also force you to stick to one theme, as the other one will be sacrificed for the effect.

1. Go to `C:\Program Files (x86)\Windows Kits\10\DesignTime\CommonConfiguration\Neutral\UAP\10.0.10586.0\Generic\themeresources.xaml` 
2. Copy it into a new dictionary in your solution: `Themes/LightOverride.xaml` 
3. Remove all nodes except for `<ResourceDictionary x:Key="Default">` (dark theme)
4. Rename this node to `<ResourceDictionary x:Key="Light">` (make it light theme)
5. Merge this dictionary in App.xaml

```xml
<Application>
  <Application.Resources>
    <ResourceDictionary>
      <ResourceDictionary.MergedDictionaries>
        <ResourceDictionary Source="Themes/MyApp.xaml" />
        <ResourceDictionary Source="Themes/LightOverride.xaml" />
      </ResourceDictionary.MergedDictionaries>
```

We're done:

![final gif of changing themes](/blogData/xaml-cheat-sheet/changing-theme-complete.gif)


# Conditionally display UI elements

When displaying weather forecast, I don't want to show "0mm rain" on each sunny day. We can use a converter to hide this text.

Create a class `NonZeroValueToVisibilityConverter` in namespace `My.App.Converters`, add it to the dictionary in the following way:

```xml
<ResourceDictionary
  xmlns:converters="using:My.App.Converters">

  <converters:NonZeroValueToVisibilityConverter x:Key="NonZeroValueToVisibilityConverter" />
```

And use it in the following way:
```xml
<StackPanel Orientation="Horizontal" Visibility="{Binding Path=Rainfall, Converter={StaticResource NonZeroValueToVisibilityConverter}}">
    <TextBlock Text="{Binding Path=Rainfall}" />
    <TextBlock Margin="10 0 0 0" Text="mm rain" />
</StackPanel>
```

This screenshot was taken halfway through UI redesign. The rain and snow quantities are shown only when they're non-zero.

![conditionally displaying rain information](/blogData/xaml-cheat-sheet/conditional-rain.png)

# Watch this in a video instead

I wrote this blog post in preparation and after shooting a video about XAML. You can watch me go through these steps:

[![thumbnail](http://i.ytimg.com/vi/4mIuIHNF3JA/default.jpg) Smart Mirror episode 12 - XAML](http://youtu.be/4mIuIHNF3JA)