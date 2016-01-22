---
layout: post
title: "Custom resource files in UWP
category: iot
permalink: iot/connect-to-ADC-using-SPI-in-windows-10
tags: [iot, csharp, windows]
---

I made a rookie mistake of hardcoding the API token (key) to a weather service. I then committed the code to a public github repo, and did it all live on camera when recording an episode of [Coding with Amadeus: Smart Mirror](https://www.youtube.com/watch?v=NCMQIH0ilLo).

# Protect the API token 

When an API key (token) is leaked, the recovery steps are straightforward:
1. Reset the API token
 * Ideally, the service provider offers a reset of the API token. You click a button, get a new token, and the old one becomes invalid.
 * In another case, you need to create a new free account and use the new API token
2. Remove the token from the source code
 * [Rewriting git history](https://www.atlassian.com/git/tutorials/rewriting-history/git-reflog) is possible, but not recommended - especially if you pushed your changes and others might have pulled them
 * Replace the API token string literal with an access to resources
3. Create a resource file that will hold sensitive data
 * Commit this code to avoid `FileNotFoundException` and other issues
4. Stop tracking the resource file ([GitHub guide](https://help.github.com/articles/ignoring-files/#ignoring-versioned-files))
 * Add the file to `.gitignore`
 * `git rm --cached`
 * Now you can write your API tokens into the file, and git won't pick up these changes
 * This may break your continuous integration, but it's all fixable (but not a subject of this blog post)

Now that the crisis is averted, let's read the resource file.
Oh wait, we're using the sandboxed UWP runtime and a different subset of .NET framework.
We can't just access a solution file



