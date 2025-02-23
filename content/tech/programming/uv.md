---
title: "Starting with UV"
date: 2024-09-13T21:28:27-07:00
description: Get in the flow with python and UV
summary: Python UV cheatsheet
---

I just got into using UV, and I needed to onboard a few projects.

- `uv init`
  - Creates `pyproject.toml` if it does not exist.
- `uv venv`
  - This is the only command you need to run, whether venv has been set up or not yet.
- `uv add -r requirements.txt`
  - Moves dependencies defined in `requirements.txt` into `pyproject.toml`
- `uv run .\file.py`
  - Runs the script
