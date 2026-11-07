---
title: "Git setup"
date: 2024-09-13T21:28:27-07:00
description: Get in the flow in git
summary: Get in the flow
---

## Config

```
git config merge.conflictstyle diff3
git config diff.wsErrorHighlight all
git config push.autoSetupRemote true
```

- `merge.conflictstyle diff3` adds original code to the diff view, this helps arrive at correct resolution when resolving a conflict
- `diff.wsErrorHighlight all` Displays whitespace in diff
- `push.autoSetupRemote true` automates the first push of a branch


## Aliases 

I feel at home with these aliases.
Run `git config --global --edit` and paste these under `[alias]` section:

```
        st = "status --short"
        last = "log --stat -1 HEAD"
        ls = "log --pretty=format:'%Cgreen %H %Creset%cr%Cred by %cn%Creset%n%s%n' --stat --graph"
        branches = "branch -avv  --sort=-committerdate"
        please = "push --force-with-lease"
        diffs = "diff -z --cached --color-moved"
        diffl = "diff  --color-moved HEAD~ HEAD"
        put = "!git add .; git commit -m"
        d = "!git diff -z  --color-moved --unified=0 && echo 'Summary:' && git status --short"
```

on Windows, use these variants. They lack unix's `&&` which runs second command only if first succeeded.
```
put = "!git add .; git commit -m"
d = "!git diff -z  --color-moved --unified=0; echo 'Summary:'; git status --short"
```

The only thing to watch out for is that speedy `git put` eagerly commits all changes in the working tree, including any unexpected or overlooked changes.

## Line endings

On Windows, convert CRLF to LF on commit, and LF to CRLF on checkout:
bash
```
git config --global core.autocrlf true
```

On Linux, convert CRLF to LF on commit only, to fix any CLRF line endings:
bash
```
git config --global core.autocrlf input
```

## Prompt summary

On Windows, use [PoshGit](https://github.com/dahlbyk/posh-git?tab=readme-ov-file#installation) to provide tab-completion and show status summary in the terminal.

## Tips

Miscellaneous notes.

Transition changes to my fork

```
git remote set-url origin <fork URL>
git fetch --all -p
```

To ignore a change to the file, and then undo it

```
git update-index --skip-worktree .gitignore
git update-index --no-skip-worktree .gitignore
```

To list all conflicts

```
git diff --name-only --diff-filter=U
```

Occasional manual cleanup (tip: run it on schedule)

```
git gc
git prune
git gc --aggressive
```
