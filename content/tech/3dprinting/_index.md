---
title: '3D printing'
summary: Cheatsheet
date: 2022-12-17
weight: 2
---

# 3D Printing
3D printing is one of my favorite hobbies. It helps shape my surroundings to my liking. It manifests through three facets:
1. Helps shape my surroundings to my liking, mostly through shims and adapters scattered around the house to bond two objects which otherwise wouldn't match together
2. Let's me print parts for my other hobbies
3. Lastly, prints neat holiday decor and gifts

When I got into 3D printing, I found these pointers useful:

## Tolerances
- Screw hole diameter
```
8.0mm might be forced with hammer
8.2mm (+.2mm) allows for constrained movement of screw in the part
0.3mm (+.3mm) allows for free movement of screw in the part
```
- Hex slots: diameter of circumscribed hexagon - cut away from the body
```
12.8mm might be forced with hammer
13.0mm (+.2mm) experiences minimal friction at first layer, enough to hold the hex nut in place
13.1mm (+.3mm) allows for free movement of hex nut in the part
```
- Typical
```
0.05mm tolerance for snug fit.
```

## Notes
 - Tensile strength: the print is the weakest in the Z dimension, where layers adhere to one another. When your piece needs to be strong in multiple dimensions, consider splitting it into multiple parts and printing them such that the strongest forces act on the XY pane. See grill hooks below.
- Fillet vastly increases strength of a corner in the Z dimension (across layer lines)
- Fillet allows for high nozzle speed
- Chamfer at 45% degree is a simple way to build overhangs


# Models

Here are some of my creations, a few that you may find useful and many which are tailored to specific use cases.

## Hat hook
Makes hats accessible. Use with a 4D box nail.
[Hat hook by Amadeus Vee | Download free STL model | PrusaPrinters](https://www.prusaprinters.org/prints/140993-hat-hook)

## Can lid
Some cans don't get emptied at once. They get a snap lid.

## Grill hooks
Keeps the grilling utensils handy and keeps them from dirtying surfaces. Fits the side rack on the Nexgrill.

## Keyboard mount
Saves space and keeps the volume buttons accessible.
Fits the "microsoft wirleless all-in-one keyboard" (N9Z-00001).

## Blinds stopper
Keeps my bottom-up blinds from fluttering in the wind.
[Blinds stopper by Amadeus Vee | Download free STL model | PrusaPrinters](https://www.prusaprinters.org/prints/149150-blinds-stopper)

## Bicycle rack adapter
Attaches a "tactical bag" to the Topeak bike rack. I store there a spare tire, pump, bungee cords, keys etc.

## Saucer
Keeps water from seeping out from pots onto the table.

## Cube
At first, it's just a 10mm cube. Scale it in slicer to make a perfectly fitting shim. Without getting into details, this shim placed in a strategic location recouped the cost of the 3D printer.
