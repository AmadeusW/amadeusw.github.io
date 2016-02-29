---
layout: post
title: Soldering audio jack (phone connector)
category: hardware
permalink: hardware/solder-3-5-mm-audio-jack
tags: [iot, hardware]
---

When you wiggle the headphone cable near the jack and the sound stops in one or both channels, the jack might be worn out. When the only way to hear the sound is to wiggle the cable, the jack is definitely worn out. You can fix it with a soldering iron and wire strippers.

Read this blog post if you'd like to replace an [3.5mm / audio / phone jack (connector)](https://en.wikipedia.org/wiki/Phone_connector_%28audio%29){:target="_blank"} or you're building your own audio device. 

The right channel in my speakers stopped working unless I wiggled the cable. Eventually it stopped working for good. One end of the audio cable is embedded into the volume controller which is fairly expensive to replace.

I picked up a Sennheiser 3.5mm jack from the local electronics store. It was roughly one dollar.

![audio jack](/blogData/solder-audio-jack/screwed.png)

The case unscrews and reveals three separate plates

![opened audio jack](/blogData/solder-audio-jack/unscrewed.png)

Cut the faulty cable and strip the wires. The actual audio wires were too small for the wire strippers, and too fragile to be stripped with the sharp part of strippers. I pinched the plastic with nails and stripped it manually.

![stripped wires](/blogData/solder-audio-jack/prepared.png)

In the photo above the wires are longer than it's possible to fit into the jack. When trimming, keep the ground wires the shortest, since they are the first ones to attach. 
The red wire carries signal for the right channel, and should be the longest. In between the two there is the white (sometimes black) wire that carries signal for the left channel.

![audio jack schematics](/blogData/solder-audio-jack/audiojack.png)

Put the jack casing over the wires and keep it around the cable. Place the wires in the correct spots. Use a precise tool to wrap the wires around the connectors. It will make it easier to keep them in correct place when soldering.

You can now test the connection. Turn the speakers on. When you probe the jack with a finger or a hand-held metal tool, make sure that you hear a buzzing sound in correct channels. Turn the speakers off before soldering.

![audio jack ready for soldering](/blogData/solder-audio-jack/ready.png)

When soldering, heat up the connector and the wires, and then apply solder over the hot metal. Use the alligator clips to hold the pieces in place. Try not to touch the plastic with the iron.

I found the most difficult connection to be the right channel - the connector is large and rather flat. The easiest connection was the ground, because the connector had a hole to loop the wire through. Ground connection is very important because it gives the structural integrity to your creation. The two other solder joints come off very easily and their wires don't have anything to latch onto. 

![audio jack is soldered](/blogData/solder-audio-jack/soldered.png)

Screw the jack casing over the connections you're ready to go!

How would you make the connection stronger? Would heatshrink or glue gun do a good job keeping the soldered joints secure?