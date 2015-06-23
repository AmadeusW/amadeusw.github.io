---
layout: post
title: Practical animations in XAML
category: ui
permalink: ui/practical-animations-xaml
tags: xaml ui csharp
---

Let's build a sleek way to display notifications to the user. The messages won't show up in traditional pop-up windows, but instead slide in at the top of the screen. User can dismiss each one of them by clicking at it.

*Complete project is available [on GitHub](https://github.com/AmadeusW/MessagePanel) and this blog post covers only bits related to animation.*

Each message animates twice: first, when it's added to the collection and first rendered, and second time, disappearing after user dismissed it.

Both animations are defined as [resources](http://msdn.microsoft.com/en-us/library/system.windows.frameworkelement.resources(v=vs.110).aspx) of [ItemsControl](http://msdn.microsoft.com/en-us/library/system.windows.controls.itemscontrol(v=vs.110).aspx), and invoked by [DataTrigger](http://msdn.microsoft.com/en-us/library/system.windows.datatrigger(v=vs.110).aspx) in [ItemsControl.ItemContainerStyle](http://msdn.microsoft.com/en-us/library/system.windows.controls.itemscontrol.itemcontainerstyle(v=vs.110).aspx). We are using ItemsControl element because it offers the most rendering flexibility.

{% highlight xml %}
<ItemsControl.Resources>
  <Storyboard x:Key="enterStoryboard">
      <ThicknessAnimation Storyboard.TargetProperty="Margin"
                                                   Duration="00:00:00.25"
                                                   From="0, 0, 500, 0"
                                                   To="0, 0, 0, 0"
                                                   DecelerationRatio="1"
                                                   FillBehavior="HoldEnd" />
      <DoubleAnimation Storyboard.TargetProperty="Opacity"
                                                   Duration="00:00:00.25"
                                                   From="0"
                                                   To="1"
                                                   FillBehavior="HoldEnd" />
  </Storyboard>
</ItemsControl.Resources>
 
<ItemsControl.ItemContainerStyle>
  <Style>
    <Style.Triggers>
      <DataTrigger Binding="{Binding RelativeSource={x:Static RelativeSource.Self}, Path=DataContext.IsAlive}" Value="True">
        <DataTrigger.EnterActions>
          <BeginStoryboard>
            <StaticResource ResourceKey="enterStoryboard"/>
          </BeginStoryboard>
        </DataTrigger.EnterActions>
      </DataTrigger>
    </Style.Triggers>
  </Style>
</ItemsControl.ItemContainerStyle>
{% endhighlight %}

The DataTrigger fires the animation whenever property **IsAlive** is found to be **true**. Here, we instantiate it to **true** in each **MessageObject**.

Let's see how it looks like:

<video width="524" height="112" autoplay loop>
  <source src="http://blog.amadeusw.com/content/images/animatedCollection1.webm" type="video/webm">
*Video that shows the slide-in animation. (your browser does not support the video tag)*
</video>

The slide-out effect for removed messages gets a bit more tricky. Once the element is removed from the collection, we can't animate it, because its graphical representation disappears.

We will use the property **IsAlive** to trigger the slide-out animation, and we will actually remove the message from the collection after the animation completes. Similarly to the enter animation, the exit animation is triggered by setting **isAlive** to **false**. This can be defined twofold in XAML:

{% highlight xml %}
<!-- Simple approach, but may break if IsAlive is not initialized to true -->
 
<DataTrigger Binding="{Binding RelativeSource={x:Static RelativeSource.Self}, Path=DataContext.IsAlive}" Value="True">
    <DataTrigger.EnterActions>
        <BeginStoryboard>
            <StaticResource ResourceKey="enterStoryboard"/>
        </BeginStoryboard>
    </DataTrigger.EnterActions>
    <DataTrigger.ExitActions>
        <BeginStoryboard>
            <StaticResource ResourceKey="exitStoryboard"/>
        </BeginStoryboard>
    </DataTrigger.ExitActions>
</DataTrigger>
 
<!-- Another approach. In our case, it has the same result.
     It may be used to create more complex and robust triggers -->
 
<DataTrigger Binding="{Binding RelativeSource={x:Static RelativeSource.Self}, Path=DataContext.IsAlive}" Value="True">
  <DataTrigger.EnterActions>
    <BeginStoryboard>
      <StaticResource ResourceKey="enterStoryboard"/>
    </BeginStoryboard>
  </DataTrigger.EnterActions>
</DataTrigger>
<DataTrigger Binding="{Binding RelativeSource={x:Static RelativeSource.Self}, Path=DataContext.IsAlive}" Value="False">
  <DataTrigger.EnterActions>
    <BeginStoryboard>
      <StaticResource ResourceKey="exitStoryboard"/>
    </BeginStoryboard>
  </DataTrigger.EnterActions>
</DataTrigger>        
{% endhighlight %}

Ideally, we would listen to StoryboardCompleted event and remove the item once the framework tell us that the animation has completed. However, the StoryboardCompleted event doesn't have a reference to the removed item or the collection. How would we know which item to remove from the collection?

We need to wait agreed amount of time in the code-behind before the element can be removed from the collection. This is not an ideal solution, but I can't think of another way to achieve this.

{% highlight csharp %}
internal void RemoveMessage(object parameter)
{
    var message = parameter as MessageObject;
    if (message != null)
    {
        // Trigger the move-out animation
        message.IsAlive = false;
        // Remove the element after animation completes
        Task.Run(() =>
            {
                Thread.Sleep(250);
                acutallyRemoveMessageFromCollection(message);
            }
        );
    }
}
 
private void acutallyRemoveMessageFromCollection(MessageObject message)
{
    // Make sure this runs on the UI thread.
    Application.Current.Dispatcher.BeginInvoke
        (System.Windows.Threading.DispatcherPriority.Normal,
        (Action)(() =>
            {
                Messages.Remove(message);
            }
        ));
}
{% endhighlight %}

Here's how it looks like:

<video width="524" height="112" autoplay loop>
  <source src="http://blog.amadeusw.com/content/images/animatedCollection2.webm" type="video/webm">
*Video that shows the first attempt slide-out animation. (your browser does not support the video tag)*
</video>

We can see the item occupies its space as it animates out, and other items abruptly jump in its space after the item is removed. 
We can address that by adding a slide-up animation to the **exitStoryboard**. The second animation starts only when the first animation ends (note the **BeginTime**). The animation changes the top margin of the item to -50, effectively dragging it up. We're happy to see that all items below it also move up!

{% highlight xml %}
<Storyboard x:Key="exitStoryboard">
    <ThicknessAnimation Storyboard.TargetProperty="Margin"
                                                     Duration="00:00:00.25"
                                                     From="0, 0, 0, 0"
                                                     To="500, 0, 0, 0"
                                                     AccelerationRatio="1"                                        
                                                     FillBehavior="HoldEnd" />
    <DoubleAnimation Storyboard.TargetProperty="Opacity"
                                                 Duration="00:00:00.25"
                                                 From="1"
                                                 To="0"
                                                 FillBehavior="HoldEnd" />
    <!-- After sliding out to the right, slide up so that remaining items 
         in the collection smoothly fill the gap -->
    <ThicknessAnimation Storyboard.TargetProperty="Margin"
                                                     BeginTime="00:00:00.25"
                                                     Duration="00:00:00.25"
                                                     From="500, 0, 0, 0"
                                                     To="500, -50, 0, 0"
                                                     DecelerationRatio="1"                                        
                                                     FillBehavior="HoldEnd" />                
</Storyboard>
{% endhighlight %}

Now we only need to change the code-behind to wait for both animations to finish before removing the element, so we change the delay from 250ms to 500ms. That's the final effect:

<video width="524" height="112" autoplay loop>
  <source src="http://blog.amadeusw.com/content/images/animatedCollection3.webm" type="video/webm">
*Video that shows the slide-out animation and removal animation. (your browser does not support the video tag)*
</video>

For best results, this control can be placed above the rest of your app with help of [Z-index](http://msdn.microsoft.com/en-us/library/system.windows.controls.panel.zindex(v=vs.110).aspx)


* [Browse "animating the collection" source on GitHub](https://github.com/AmadeusW/MessagePanel).