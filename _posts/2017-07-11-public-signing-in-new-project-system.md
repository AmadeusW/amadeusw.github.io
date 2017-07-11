---
layout: post
title: Public signing in the "new" project system
category: dotnet
permalink: dotnet/public-signing-in-the-new-project-system
tags: [dotnet, windows, csharp]
---

I ran into an obscure error that wasn't discussed on the internet yet, so I thought I'd share what I found out.

My team is lucky to migrate to the [new project system](https://github.com/dotnet/project-system) which significantly simplifies the .csproj files and the overall infrastructure. 

We also have to continue to sign our assemblies, and as the new projecy system uses simple and minimal syntax, we needed to update the directive that signs the code. Unfortunately, we run into error CS8102: `Public signing was specified and requires a public key, but no public key was specified.`

I did provide the public key, so what went wrong? I didn't define the `SignAssembly` property.

To avoid this error, make sure to define all three boolean properties and provide the key, like so:
```xml
<PropertyGroup>
<SignAssembly>true</SignAssembly>
<DelaySign>false</DelaySign>
<PublicSign>true</PublicSign>
<AssemblyOriginatorKeyFile>MyPublicKey.snk</AssemblyOriginatorKeyFile>
</PropertyGroup>
```
Note, based on Kirill's post, a file with the public key is 160 bytes long.

