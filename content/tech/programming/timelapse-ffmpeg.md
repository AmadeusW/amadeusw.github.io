---
title: "Creating timelapses with Fujifilm and FFmpeg"
date: 2026-09-18T10:00:00-07:00
description: Camera interval shooting settings and FFmpeg recipes for daytime and stargazing timelapses
summary: Fujifilm camera settings and FFmpeg recipes for smooth timelapses
category: programming
tags: [photography, ffmpeg, video, linux]
---

Notes on capturing interval sequences with a Fujifilm camera and assembling them into smooth timelapse videos using FFmpeg.

## Camera settings (Fujifilm)

Before beginning the shoot:

- **Image quality:** Set photo quality to JPEG (Fine or Normal depending on SD card space) and aspect ratio to 16:9 to match video output.
  - *Tip:* Remember to restore your standard shooting settings (e.g. 3:2 RAW) once the timelapse session is complete.
- **Interval timer shooting:**
  - Navigate to `INTERVAL TIME SHOOTING` in the `SHOOTING SETTING` menu (camera icon).
- **Interval and shot count:**
  - **Interval duration:** The time between each shot. Check the camera's estimated remaining shot count on your SD card and divide by your planned session length to determine the fastest safe interval.
  - **Number of shots:** Set to infinity ($\infty$) or your target count.

---

## Assembling with FFmpeg

Once the photos are transferred to your computer, use `ffmpeg` to encode the sequence.

### Daytime timelapse (with frame skipping)

For a 60 fps daytime video where you want to drop every other frame (effectively doubling the playback speed):

```bash
ffmpeg -r 60 -pattern_type glob -i "*.JPG" -s:v 1920x1080 -c:v libx264 -pix_fmt yuv420p10le -vf "select=not(mod(n\,2))" s1080r60skip2.mp4
```

### Stargazing / Night timelapse

For night skies or astrophotography where you want lower framerates and maximum fidelity:

```bash
ffmpeg -r 15 -pattern_type glob -i "*.jpg" -s:v 3996x2664 -c:v libx264 -pix_fmt yuv420p10le -crf 18 stargazing.mp4
```

---

## Parameter breakdown

| Parameter | Purpose |
| :--- | :--- |
| `-r 60` | Output frame rate (e.g. 60 fps or 15 fps). |
| `-pattern_type glob -i "*.JPG"` | Reads all JPEG files in the directory in alphabetical/chronological order. |
| `-s:v 1920x1080` | Sets output resolution. Use a lower resolution for quick test renders, then full resolution for the final cut. |
| `-c:v libx264` | H.264 video codec for broad device compatibility. |
| `-crf 18` | Constant Rate Factor. Lower values yield higher quality; `18` is visually near-lossless (default is around `23`). |
| `-pix_fmt yuv420p10le` | 10-bit YUV 4:2:0 pixel format, providing smoother gradients across skies and gradients without color banding. |
| `-vf` | Video filter chain (see below). |

### Video filters (`-vf`)

Filters can be combined with commas:

- **Frame selection:**
  - `select='not(mod(n\,2))'`: Keeps every second frame.
  - `select='not(mod(n\,4))'`: Keeps every fourth frame.
- **Fade in / out:**
  - `fade=in:0:30`: Fades in from black over the first 30 frames.
  - `fade=out:1524:30`: Begins a 30-frame fade to black starting at frame 1524.

Example combining frame skipping and fades:

```bash
ffmpeg -r 180 -pattern_type glob -i "*.JPG" -s:v 1920x1080 -c:v libx264 -crf 18 -pix_fmt yuv420p10le -vf "select=not(mod(n\,4)),fade=out:1524:30,fade=in:0:30" s1080r180skip4crf18fade.mp4
```

---

## Concatenating multiple sequences

To join multiple rendered clips together without re-encoding, create a `concat.txt` file listing each segment:

```text
file 'part1.mp4'
file 'part2.mp4'
```

Then concatenate with stream copying:

```bash
ffmpeg -f concat -safe 0 -i concat.txt -c copy combined_timelapse.mp4
```
