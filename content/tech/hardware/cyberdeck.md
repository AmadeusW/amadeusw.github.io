---
title: "Raspberry Pi cyberdeck setup"
summary: "Notes from creating a cyberdeck"
date: 2025-12-31
---

# To connect to a bluetooth device
The `trust` command makes it auto-connect on boot

1. Enter Bluetooth control
```
bluetoothctl
```

2. Now, typing inside bluetoothctl:
```
power on
agent on
default-agent
scan on
```

3. Wait for your device to appear, note its MAC address
```
pair XX:XX:XX:XX:XX:XX
trust XX:XX:XX:XX:XX:XX
connect XX:XX:XX:XX:XX:XX
```

4. Exit
```
scan off
exit
```

# List wifi networks
```
nmcli device wifi list
```
Might need to `sudo apt install network-manager`

# tmux
- Scrolling; enter the copy mode `Ctrl+b [`

# i3
- [Reference guide](https://i3wm.org/docs/refcard.html)
- Launch app; `mod+d` type name, enter


# Minimal support for windowed apps
```
sudo apt install xserver-xorg xinit openbox
```
Then, use `startx` to enable windowed apps.

