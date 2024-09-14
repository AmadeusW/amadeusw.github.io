---
title: "Git"
date: 2024-09-13T21:28:27-07:00
---

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
