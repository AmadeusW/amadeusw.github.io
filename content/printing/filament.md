---
title: "Filament"
date: 2026-09-23T21:50:36-07:00
summary: Temperatures and other settings for various filaments
draft: false
weight: 100
---

# Temperature 

### Regular PLA
Temp: 200–215°C
Cooling: ~100% fan from layer 2–3 onward

### Silk PLA
Temp: 215–230°C (5–15°C above regular)
Cooling: 40–60% fan — lean toward the low end on an enclosed printer like the Core One
Use overhang/bridge-specific fan boost rather than raising overall fan %
Too much cooling → grainy/dulled finish instead of gloss

# Translucent PLA
Temp: 215–230°C, toward the higher end of the PLA range — more heat improves layer fusion, which cuts down internal light scattering and boosts clarity
Layer height: go thinner (0.1–0.15mm) — fewer/smaller air gaps between layers means better light transmission
Cooling: low, similar to silk (~40–50%) — aggressive cooling roughens the surface and re-introduces scattering/cloudiness
Print speed: **slower** than regular PLA — gives layers more time to fuse before solidifying, which matters more here than for opaque materials
Design considerations: thin walls (often single-wall/vase mode) and 0% infill for backlit parts — infill lines show through and kill the translucent effect
Outer wall temp bump (if your slicer supports per-feature temps): pushing just the visible perimeter a few degrees hotter than infill gets a glassier finish without over-melting the bulk of the print

### Matte PLA
Temp: 190–205°C (lower end of PLA range)
Cooling: ~100%, same as regular — helps lock in the matte texture
Under-cooling → faint glossy patches (opposite failure mode from silk)

### Wood-fill PLA
Temp: 195–215°C, lower-middle of range — higher temps scorch the wood particles
Cooling: 80–100%
Nozzle: 0.4mm minimum, 0.6mm+ preferred; hardened steel if used regularly (mildly abrasive)
Print speed: ~60–80% of normal PLA speed
Retraction: moderate, not aggressive (reduces carbonization buildup)
Moisture: dry before printing if filament's been out of a dry box >1–2 days


# Other settings
## TPU - reduce stringing
- Avoid crossing perimeters: true
- Wipe while retracting: false → true
- Other layer temp: 210 → 205°C (keep first layer at 220)
- Seam position: Aligned → Nearest
- Coasting: enable if available (Print Settings → Advanced)
- Leave retraction length/speed at 1mm / 30mm/s for now
- If stringing persists at one specific spot after seam change: retraction length 1mm → ~1.3mm

## Wood-fill stringing fixes

- Retraction distance: +0.5–1mm (direct drive) / +2–3mm (Bowden)
- Retraction speed: 35–45mm/s
- Enable coasting
- Enable wipe-on-retract
- Minimize travel moves (avoid-crossing-perimeters / combing)
- Extrusion multiplier: 98–99%
- Calibrate pressure/linear advance specifically for wood-fill