---
title: Home network topology
date: 2026-11-08
category: hardware
summary: How to segment home network for security
tags: [iot, hardware]
---

In the past month we've had weekly 0-day security vulnerabilities, notably in PHP, Synology, MCTCP. 

I don't think we're going to catch a break with AI that tirelessly pores over every nook and cranny of the world's source code.

## Network segmentation

With each device being a potential trojan horse on your home network, one thing that brings me peace is how the network is segmented and isolated.

- **Trusted VLAN**: Unrestricted WAN internet access and full routing access to all other VLANs.
  - This is the default you get with your ISP router.
- **Untrusted VLAN**: Outbound WAN internet access only; blocked from accessing other VLANs.
  - All IOT gadgets go here.
- **TV VLAN**: No access to internet or any other part of network.
  - The TV only receives HDMI signal.
- **Camera VLAN**: No access to internet.
  - At a time I had two WiFi access points and camera SSID was on a different channel, to avoid interference.

## Networking infrastructure

This is possible thanks to a few prosumer devices

- **Router**: Defines VLANs and firewall
  - Defines VLANs
  - Firewall constrains traffic from and across VLANs
  - DHCP, DNS
  - Proxy
  - Avahi and other workarounds against complexity of segmentation

- **Access Point**
  - Broadcasts SSIDs corresponding to all VLANs
  - Sets VLAN tags based on SSID.

- **Managed switch**: 
  - Sets VLAN tags based on physical port or MAC address

## Caveats

You can find solutions online, so I'll just list special stuff I had to do. This guide is intentionally vague because I'm not laying out a cyberattack guide against myself.

1. Network discovery does not work across VLANs.
  - To work around it, use Avahi on the router. It's a mDNS reflector and allows devices to discover over the network
  - Set firewall to allow mDNS traffic
2. Printer discovery did not work.
  - The printer needs to *just work*, so it's promoted to trusted VLAN so that personal devices can use it and all its features.
  - Get a trusted, reliable workhorse, like Brother.
  - You may make compromises for convenience, just know what they are.
3. Use proxy server to give docker services a friendly name.
  - After a few docker containers running on the home lab, I could no longer remember the port numbers.
  - DNS Resolver maps human-readable name to IP address of the docker host
  - HAProxy maps human-readable name to IP address and a port
4. Use custom DNS server!
  - DNS over TLS, DNS over HTTPS mean that your ISP has less data on you to sell to advertisers.
  - Also the default ISP dns is so slow
  - Quad9: `9.9.9.9` - security, privacy
  - CloudFlare: `1.1.1.1` - low latency
  - ControlD: `76.76.2.5` - security, ad blocking
  - OpenDNS: `208.67.222.222` - filtering
