---
title: "Raspberry Pi cyberdeck setup"
summary: "Notes from creating a cyberdeck"
date: 2025-12-31
---

# To connect to a bluetooth device
The `trust` command makes it auto-connect on boot

# 1. Enter Bluetooth control
bluetoothctl

# 2. Now, typing inside bluetoothctl:
power on
agent on
default-agent
scan on

# 3. Wait for your device to appear, note its MAC address (XX:XX:XX:XX:XX:XX)
# Then:
pair XX:XX:XX:XX:XX:XX
trust XX:XX:XX:XX:XX:XX
connect XX:XX:XX:XX:XX:XX

# 4. Exit
scan off
exit
