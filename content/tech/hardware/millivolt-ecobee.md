---
title: "Connecting fireplace to smart thermostat"
summary: "Using relay in a box to connect Ecobee to a gas fireplace on millivolt wiring"
date: 2025-06-01T21:20:53-00:00
---

Smart thermostat lets you easily adjust heating schedule, automatically turn up the heat when you walk in the room, and warm up the place ahead of coming back from a trip. It learns the response of the heating system, and keeps it on for as little time as necessary to maintain the temperature without overshooting it. 

![Heating chart](/techBlogData/2025-06-02-millivolt-ecobee/heating.png)
> Blue line represents the actual temperature temperature. Yellow line is the target temperature. Orange highlight represents when the stove was on.

The smart thermostat expects to be plugged into a 24V AC HVAC wiring, and the stove operates on milivolt wiring. These systems can be joined by a _Relay in a Box_.

I followed these instructions: [Using an Ecobee Thermostat with a Millivolt Heating System](https://medium.com/@ZekeS/using-an-ecobee-thermostat-with-a-millivolt-heating-system-217047db5d56)

## Main pieces
The gas stove uses a combination valve, which has a thermopile and thermocouple.

### Thermopile
When heated by the pilot light, thermopile produces a sustained voltage that's connected to thermostat. When thermostat is cold, it connects theat voltage to the valve, opening the flow of gas. It takes just a few millivolts to actuate the valve, and so the signal from the thermopile suffices to control the stove. 

### Thermocouple
In the combination valve, it shuts off the gas flow when no longer heated by the pilot light. It provides a layer of safety, so that the gas does not flow when there's no flame to burn it.

_Aside: If pilot light won't stay on after lighting, most likely the thermocouple is broken. They have a lifespan of 20 years. You may get lucky cleaning it, but most likely you'll need a new combination valve. These are standard components, don't believe a company charging you through the roof for "manufacturer part" that needs to be "ordered". Go with the tech who has the part in the truck._

### Relay
For purposes of this note, a relay is a device which connects two wires when it detects a signal across two other wires. It's triggered by the 24V AC signal that the thermostat sends to turn on heating. In this case, it completes the millivolt circuit and causes the voltage from the thermopile to open the flow of gas. I used `RIBU1C Enclosed Pilot Relay, 10 Amp Spdt with 10-30 Vac/Dc/120 Vac Coil`

## Result

![Upgraded stove](/techBlogData/2025-06-02-millivolt-ecobee/stove.jpg)

## Schematic
TBD


## Cost
TBD - measure power draw