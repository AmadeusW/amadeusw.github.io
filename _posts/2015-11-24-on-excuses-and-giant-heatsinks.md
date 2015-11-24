---
layout: post
title: On excuses and giant heatsinks
category: thoughts
permalink: thoughts/on-excuses-and-giant-heatsinks
tags: [thoughts]
---

Today was going to be a good day. The night before I planned what to do: work on a technical blog post and record one or two videos, one of them being long overdue.

After breakfast I turned on the computer only to see that the screens are black. I found a PC speaker in the toolbox and mounted it. It called three disturbing and long beeps, followed by one short beep.
The motherboard manual's troubleshooting chapter didn't mention this beep pattern. After couple hours of tinkering with with PC's internals and reading now abandoned fora, the PC booted up! I thought 

> This would be a cool thing to blog about.


> No, everyone has laptops these days. Nobody will be interested in it.


> I guess... Wait a second! That's just an excuse! I don't want any more excuses in my life. After all...

<blockquote class="twitter-tweet" lang="en"><p lang="en" dir="ltr">The road to startup failure is paved with excuses for moving slowly.</p>&mdash; Sam Altman (@sama) <a href="https://twitter.com/sama/status/660252065864663041">October 31, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

A few days ago my friend Jef called me and asked if I want to come and shoot a video to promote my startup's product, [Alive - an interactive programming extension for Visual Studio](http://comealive.io/).
Excuses came flooding my mind:

> I have less than two days to preparation.
> You're not entertaining, the video's going to suck.

**Without waiting any further, I said yes**! Every moment of hestitation would make the decision harder. I knew I did the right thing, but I also felt immediate regret. **Excuses are like a drug, they give a blissful feeling and temporary relief from stress, but when abused, they're disastrous**. Filming with Jef was a lot of fun and went smoothly.

~~~

Here's what I initially wanted to write, dismissed it as being so 2000's, and eventually decided to write it anyways, because I want to stop having excuses:

Some people reported that long beep codes were caused by loose connections to the GPU. After pulling the GPUs out and back in and still hearing the dreaded beeps, I was worried that I will need to purchase new motherboard or CPU. Without really knowing what's wrong, I had 50% chance of replacing the broken component. More desperate, I removing the BIOS name (Award) from the search query and just looked for beep codes. Someone with a different motherboard said that removing the CPU, reapplying the thermal paste and putting it back in fixed the problem. I glanced at the CPU thinking how annoying it will be. That's when it hit me.

![the giant heatsink](/blogData/on-excuses-and-giant-heatsinks/before.jpg)

For the last 4 years my CPU was kept below 40°C with [Scythe Mine 2](http://www.scythe-eu.com/en/products/cpu-cooler/mine-2.html), a **two and a half pound heatsink**! I pressed it into the motherboard with one hand and turned the PC on with the other. The PC beeped once and the PC booted! Things started to make more sense - recently the PC intermittently wouldn't wake from sleep. Probably the connection between the motherboard and the CPU was loose. I tightened all screws that held the heatsink, and tightened the motherboard's mounting to the chassis as well. The PC booted by itself!

Now, to be extra sure, I held the heatsink up with my girlfriend's hair band. Hopefully by the time it gives up I'll build a new rig. 

![problem solved](/blogData/on-excuses-and-giant-heatsinks/after.jpg)

Alright, I'm going to do some work. There are no excuses today. Please slap me in the face the next time I have an excuse. Thanks :)