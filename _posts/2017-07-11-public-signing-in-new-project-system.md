---
layout: post
title: Publicly signing assemblies in the Common Project System
category: dotnet
permalink: dotnet/public-signed-assemblies-in-the-common-project-system
tags: [dotnet]
---

I ran into an obscure error that wasn't discussed on the internet yet, so I thought I'd share what I found out.

My team is lucky to migrate to the [new Project System](https://github.com/dotnet/project-system) which significantly simplifies the .csproj files and the overall infrastructure.  We also have to sign our assemblies. As the new projecy system uses simpler syntax, we needed to update the directive that signs the code. 

I ran into error CS8102: `Public signing was specified and requires a public key, but no public key was specified.` I did provide the public key, so what went wrong? I didn't define the `SignAssembly` property.

To avoid this error, make sure to define all three boolean properties and provide the key, like so:
```xml
<PropertyGroup>
    <SignAssembly>true</SignAssembly>
    <DelaySign>false</DelaySign>
    <PublicSign>true</PublicSign>
    <AssemblyOriginatorKeyFile>MyPublicKey.snk</AssemblyOriginatorKeyFile>
</PropertyGroup>
```

FYI, a .snk file with the public key is 160 bytes. [This article](https://blogs.msdn.microsoft.com/kirillosenkov/2014/03/25/sn-exe-cheat-sheet/) has commands you'll find useful when working with the key files.
