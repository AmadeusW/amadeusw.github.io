---
layout: post
title: `PIN is required to connect to this device` when debugging IoT
category: debugging
permalink: debugging/access-denied-pin-is-required-to-connect
tags: [visualstudio, iot, debugging, windows]
---

Remote deploy and remote debugging on Raspberry Pi is great, but if you take one wrong step, it can turn very confusing and appear there is no way to fix it.

To remote debug in Raspberry Pi, set the configuration to `ARM` and pick `Remote Machine` from the debug dropdown.

![Screenshot of how to debug](/blogData/access-denied-pin-is-required-to-connect/debugging.png)

The first time you do it, Visual Studio will prompt you for the remote machine's settings. Make sure to select `Authentication Mode: None`, or better yet, select an auto-detected device if there's one.

![Screenshot of correct way to connect](/blogData/access-denied-pin-is-required-to-connect/correct.png)

If you select `Authentication Mode: Universal (Unencrypted Protocol)`, Visual Studio will ask you for a device PIN.

![Screenshot of incorrect way to connect](/blogData/access-denied-pin-is-required-to-connect/wrong.png)
![Screenshot of the PIN dialog](/blogData/access-denied-pin-is-required-to-connect/pin.png)

Not knowing what is the PIN, the deployment will fail with error 
```
Error : DEP6200 : Bootstrapping 'minwinpc' failed. Device cannot be found. Access denied.  A PIN is required to connect to this device.

Error : DEP6100 : The following unexpected error occurred during bootstrapping stage 'Connecting to the device 'minwinpc'.': 
DeviceException - Access denied.  A PIN is required to connect to this device.
```
![Screenshot of errors](/blogData/access-denied-pin-is-required-to-connect/error.png)

Next time you try to remotely debug, Visual Studio will use stored settings with `Authentication Mode: Universal (Unencrypted Protocol)`, which will naturally fail. It's not obvious how to change these settings: Go to the properties of the project that you're debugging, then to *Debug*. You can revise the connection settings here.

![Screenshot of fix](/blogData/access-denied-pin-is-required-to-connect/fix.png)

Happy debugging!
