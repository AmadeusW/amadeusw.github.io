---
layout: post
title: XAML for Universal Windows cheat sheet
category: xaml
permalink: xaml/uwp-cheat-sheet
tags: [xaml, csharp, windows]
---

I'm finishing up the smart mirror project that runs an UWP app on Raspberry Pi. The last bits of work are in the user interface department. In fact, the only UI code I have so far is responsible for data binding and placing elements within a logical hierarchy:

![no theming applied](/blogData/xaml-cheat-sheet/initial.png)

# Use dark theme

The easiest thing to get 90% of theming for this project is to request a **dark theme**. In `App.xaml`:

```xml
<Application
    RequestedTheme="Light">
```

change this into

```xml
<Application
    RequestedTheme="Dark">
```

For immediate results:
![dark theme](/blogData/xaml-cheat-sheet/dark.png)

# Put styles in their own file

It's a good practice to file data in specific location as opposed to putting every style into `App.xaml`. Later on, this will allow us to swap one style for another at runtime.

Create a new **Resource Dictionary** (right click on a project, Add New Item > XAML > Resource Dictionary). I named it `White.xaml` and put it in `Themes`. Now, in `App.xaml` add `<ResourceDictionary.MergedDictionaries>` where you will specify which dictionary to use.
```xml
<Application>
  <Application.Resources>
    <ResourceDictionary>
      <ResourceDictionary.MergedDictionaries>
        <ResourceDictionary Source="Themes/MyApp.xaml" />
      </ResourceDictionary.MergedDictionaries>
```

Important notice: You might have had some resources stored directly in `<Application.Resources>` before. Now that you're using a resource dictionary, you need to move all resources into the `<ResourceDictionary>`.

Let's store a brush in `MyApp.xaml`. We will use it in the next section.
```xml
<ResourceDictionary>
  <SolidColorBrush x:Key="TextColor" Color="#FFFF0000" />
```

# Style (almost) all TextBlocks

Let's try to theme all instances of `TextBlock`. To do this, create a `Style` without the `Key`. You can put it either into `ResourceDictionary` in `App.xaml` or `MyApp.xaml`

```xml
<ResourceDictionary>
  <Style TargetType="TextBlock">
    <Setter Property="FontFamily" Value="Helvetica World" />
    <Setter Property="FontSize" Value="20" />
    <Setter Property="Foreground" Value="{StaticResource TextColor}" />
  </Style>
```
  <Style TargetType="TextBlock">
    <Setter Property="FontFamily" Value="Helvetica World" />
    <Setter Property="FontSize" Value="20" />
    <Setter Property="Foreground" Value="#FFFF0000" />
  </Style>

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

Changing resource dictionaries at runtime
===

_Do you really want to do it? There is no nice solution_

I would like the theme of the app to be amber at night. In Universal Windows Apps there is no `DynamicResource`, so changing properties of resources is not as elegant as in regular Win32 app. If you want to look at all failed attempts, [here is my SO question](https://stackoverflow.com/questions/35544034/update-resource-in-universal-windows-app-xaml/).

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

* Create your style and store it in Light and Dark themes

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

Here's what we get:
![gif of changing themes](/blogData/xaml-cheat-sheet/changing-theme.gif)

Now we need to overwrite the light theme such that it looks like the dark theme - and the only change is the text color. Notice that this will force users of your app to use the dark theme, despite their personalized system settings.

1. Go to `C:\Program Files (x86)\Windows Kits\10\DesignTime\CommonConfiguration\Neutral\UAP\10.0.10586.0\Generic\themeresources.xaml` 
2. Copy it into a new dictionary in your solution. 
3. Remove all nodes except for `<ResourceDictionary x:Key="Default">`. 
4. Rename this node to `<ResourceDictionary x:Key="Light">`.
5. Use this dictionary in App.xaml
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
![final gif of changing themes](/blogData/xaml-cheat-sheet/changing-theme-completed.gif)


Conditionally display UI elements
===

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

[![thumbnail](http://i.ytimg.com/vi/4mIuIHNF3JA/default.jpg) Smart Mirror episode 11 - XAML](http://youtu.be/4mIuIHNF3JA)