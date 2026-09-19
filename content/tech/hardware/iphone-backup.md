---
title: "Fixing iPhone photo transfer disconnects on PC"
date: 2026-09-18T10:00:00-07:00
description: Stop iOS from disconnecting during USB photo transfers to Windows or Mac
summary: How to stop iPhone from disconnecting during photo transfers over USB
category: hardware
tags: [ios, hardware, troubleshooting, backup]
---

Backing up photos directly from an iPhone to a computer over USB can be surprisingly frustrating:

- Transfers frequently freeze or disconnect midway through large batches of photos.
- Reconnecting often displays different sets of photos or a mess of split `.jpg` and `.mov` pairs.
- Relying entirely on iCloud isn't always viable if the photo library exceeds the cloud tier or when trying to retain offline archival copies.

## The root cause

By default, iOS attempts to convert HEIC/HEVC photos and videos into older formats (JPEG / H.264) on the fly during transfer over USB. This real-time transcoding process is resource-heavy, stalls on large batches, and causes the device connection to time out and drop.

## The fix: Keep Originals

Instructing iOS to transfer the original uncompressed files eliminates the transcoding step and prevents connection drops:

1. Open **Settings** on your iPhone.
2. Tap **Photos**.
3. Scroll all the way down to **Transfer to Mac or PC**.
4. Change the setting from *Automatic* to **Keep Originals**.

```text
Settings > Photos > Transfer to Mac or PC > Keep Originals
```

Photos will now transfer rapidly over USB without intermittent disconnects.

## Handling HEIC files on Windows

With *Keep Originals* enabled, photos will copy as `.heic` files rather than converted JPEGs:

- **Windows Photo Viewer:** Install the [HEVC Video Extensions from the Microsoft Store](ms-windows-store://pdp/?ProductId=9n4wgh0z6vhq) to view HEIC images natively in Windows Photos.
- **Third-party viewers:** Tools like IrfanView or ImageGlass also support viewing and converting `.heic` files out of the box.
