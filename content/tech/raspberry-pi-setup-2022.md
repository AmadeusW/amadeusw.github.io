---
title: "Headless Raspberry pi setup"
summary: "Raspbian setup changed in the April 2020 Bullseye release"
date: 2022-11-23T21:20:50-08:00
---

Setting up Raspberry Pi has changed a bit since when I first used it, and most of search results on the web describe steps applicable to Raspbian versions before Raspbian Bullseye (released in April 2020).

Specifically, before Raspbian Bullseye you could run `ssh pi@raspberrypi` and use the default password `raspberry`. Now, you need to generate the password using `openssl`.

Here are the newest (as of 2022) steps needed to get set up a **headless Raspberry pi**, specifically with Raspbian Bullseye (released on April 2020) and later:

# Generate the password
* In unix terminal run the following command, using your `password`:
```
$ echo 'password' | openssl passwd -6 -stdin
$6$k5M8bJM8sciQg4N4$8STzoHVsSyzdjpzjuUhn6UDhxcbe/JlQB4WUbEBPl/1kIRBd8q3QA.I4h6hGCEdACLgt3ejDQj4qJIxNohOts0
```

# Setup of headless raspberry pi
* Download [Raspberry Pi OS Lite]([Operating system images – Raspberry Pi](https://www.raspberrypi.com/software/operating-systems/))
* Use [Etcher]([balenaEtcher - Flash OS images to SD cards & USB drives](https://www.balena.io/etcher/)) to flash downloaded .zip onto a MicroSD card
* After flashing, open the FAT partition as folder in your code editor, and
  * Create file named `ssh`. Keep it empty
  * Create file named `wpa_supplicant.conf` with the following content

```wpa_supplicant.conf
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
update_config=1
country=US

network={
     ssid="ssid name"
     psk="password"
     scan_ssid=1
}
```
  * Create file named `userconf` with the following content `username:encrypted-password` where encrypted-password is output of the openssl command above
  
* Insert MicroSD in Raspberry Pi and power it up
* If you see an error about tampering with fingerprint, open `~/.ssh/known-hosts` and remove line containing `raspberry`
* Run `sudo raspi-config` to configure the hostname, timezone, and other relevant settings. When quitting, you'll be prompted to restart.
* When Rapsberry Pi reboots, connect using new hostname, e.g. `ssh pi@newhostname`
* Change password `passwd pi`
* Update available package sources `sudo apt update`
* Upgrade installed packages `sudo apt full-upgrade`


