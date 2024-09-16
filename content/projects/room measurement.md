---
title: "Room height measurement"
summary: "Estimate the height of the room from realtor's photos"
date: 2022-11-23T21:20:50-08:00
---

Craftsman houses are charming, but being 100 years old, their rooms are far too short for a tall individual like me. When looking for a place to live, far too often I'd be unable to fit in a house I visited.

To save time and visit only houses where I'd be comfortable in, I created a simple tool to extrapolate height of the room based on height of a known object, such as electrical socket that's 5" tall.

[github.com/amadeusw/measure](https://github.com/amadeusw/measure)

Due to [CORS](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS) restrictions, I couldn't get the images to open at my website. To work around this, I made this tool a browser extension. When running as a browser extension, there are no CORS issues. To estimate size of the room:
1. [Install the extension](https://github.com/AmadeusW/measure/releases/download/0%2C2/measure.0.2.crx)
1. Think of a feature of known size, such as electric socket. Adjust it's height (default 4.5")
1. Click on the top and bottom of the electric socket
1. Click on locations in line with the socket where the wall meets the floor and the ceiling
1. The tool estimates height of the room

The tool is finished only to extent necessary to accomplish its task, and no final polish was applied beyond that.
