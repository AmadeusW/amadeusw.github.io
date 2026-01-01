---
title: "Starting with UV"
date: 2024-09-13T21:28:27-07:00
description: Get in the flow with python and UV
summary: Python UV cheatsheet
---

I just got into using UV, and I needed to onboard a few projects. UV recently changed how it uses virtual environments.

- Create `pyproject.toml` if it does not exist.
```
uv init
```

- Create the virtual environment
```
uv venv
```

- Activate the virtual environment. This is not needed if `uv venv` was created without overriding the default name. Then, using `uv run ...` automatically detects the virtual environment.
```
source .venv/bin/activate
```

- Install dependencies
```
uv sync
```
  
- Move dependencies defined in `requirements.txt` into `pyproject.toml`
```
uv add -r requirements.txt
```

- Run the script 
```
uv run .\file.py
```

