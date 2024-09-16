---
title: "Git"
date: 2024-09-13T21:28:27-07:00
---

# Config

```
git config merge.conflictstyle diff3
git config diff.wsErrorHighlight all
git config push.autoSetupRemote true
```

`merge.conflictstyle diff3` adds original code to the diff view, this helps arrive at correct resolution when resolving a conflict
`diff.wsErrorHighlight all` Displays whitespace in diff
`push.autoSetupRemote true` automates the first push of a branch

# Aliases 

I feel at home with these aliases:

```
git config --global alias.st "status --short"
git config --global alias.last "log --stat -1 HEAD"
git config --global alias.ls "log --pretty=format:'%Cgreen %H %Creset%cr%Cred by %cn%Creset%n%s%n' --stat --graph"
git config --global alias.put "!git add .; git commit -m"
git config --global alias.branches "branch -avv  --sort=-committerdate"
git config --global alias.diffs "diff -z --cached --color-moved"
git config --global alias.diffl "diff  --color-moved HEAD~ HEAD"
git config --global alias.d "!git diff -z  --color-moved --unified=0; echo 'Summary:'; git status --short"
git config --global alias.please "push --force-with-lease"
git config --global alias.pub "!f() { branch=$(git rev-parse --abbrev-ref HEAD); git push --set-upstream origin $branch; }; f"
```

The only thing to watch out for is that speedy `git put` eagerly commits all changes in the working tree, including any unexpected or overlooked changes.

# Prompt summary

On Windows, I use [PoshGit](https://github.com/dahlbyk/posh-git?tab=readme-ov-file#installation) to show status summary in the prompt

# Tips

When I started work on a clone, and then want to transition to my fork

```
git remote set-url origin <fork URL>
git fetch --all -p
```

To ignore a change to the file

```
git update-index --skip-worktree .gitignore
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
