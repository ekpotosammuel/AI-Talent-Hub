---
name: talent-hub-design-system
description: "Invoke whenever you add or change a screen, Blade component or style in this application. Covers the AI Talent Hub design system: the ink/brand/signal colour tokens, the Bricolage Grotesque + Instrument Sans + JetBrains Mono type pairing, the component layer in resources/css/app.css, the three app shells, and the rule that every screen in this build is a mockup fed by App\\Support\\MockData. Read it before writing Tailwind classes here, and pair it with the tailwindcss-development skill for Tailwind v4 syntax."
---

# AI Talent Hub Design System

## The one rule that shapes every screen

This build is an **interface mockup**. There is no database behind a screen, no AI
provider and no verification integration. All screen content comes from
`App\Support\MockData`, so the same candidate (Amara Okonkwo), role (JOB-4821) and
company (Northwind Pay) read identically everywhere. Never invent a new figure in a
Blade file — add it to `MockData` and read it from there.

Every screen ends with `<x-mockup-note>` saying plainly what does not work.

## Colour

Tokens live in the `@theme` block of `resources/css/app.css`. Use the token names,
never a raw Tailwind palette colour.

| Scale | Role |
| --- | --- |
| `ink-50` … `ink-950` | Neutrals, pulled slightly toward the brand hue. `ink-50` is the app background; `ink-900`/`ink-950` are the dark panels. |
| `brand-50` … `brand-900` | Azure. The product voice: primary buttons, active navigation, links. |
| `signal-200` … `signal-700` | Lime. **Reserved for a score or a passed check.** Never use it for chrome, headings or decoration. |
| `pass` / `warn` / `stop` | Semantic only — verification states, severities, risk. Separate from the accent. |

The design is deliberately light-only, matching the Artisan-Marketplace project this
app is modelled on. Dark `ink` panels are a layout device, not a theme — do not add
`dark:` variants to one screen in isolation.

## Type

Three roles, loaded from Google Fonts in `components/layouts/base.blade.php`:

- `font-display` — Bricolage Grotesque. Headings only (`h1`–`h3` get it in `@layer base`) and large figures.
- `font-sans` — Instrument Sans. Everything else.
- `font-mono` — JetBrains Mono, applied through the `.num` class. Use `.num` for **every** figure that lines up or is read as data: scores, money, dates, references, feed names, percentages.

## Component layer

Prefer these over re-deriving utilities: `.btn` with `.btn-primary`/`.btn-secondary`/
`.btn-ink`/`.btn-signal`/`.btn-ghost`/`.btn-danger` plus `.btn-sm`/`.btn-lg`;
`.input`, `.checkbox`, `.radio-card`; `.card`, `.card-ink`, `.panel`; `.link`,
`.eyebrow`, `.rule`; `.table`, `.num`, `.meter`; `.sidebar-link`, `.tab`;
`.device`/`.device-screen`/`.device-notch` for mobile frames; `.ink-grid` and
`.paper-grid` backgrounds.

## Blade components

`x-logo`, `x-icon` (one inline SVG set — add new paths to its `$paths` map rather
than inlining SVG in a screen), `x-avatar`, `x-badge`, `x-status-badge`, `x-score`
(the ring), `x-meter` (bar, optionally with a `:bar` marker for a threshold),
`x-stat`, `x-page-header`, `x-field`, `x-empty-state`, `x-flash`,
`x-pipeline-card`, `x-mockup-note`.

## Shells

- `<x-layouts.base>` — html skeleton, fonts, Vite.
- `<x-layouts.marketing>` — public site: sticky header, footer.
- `<x-layouts.auth>` — split sign-in with the dark proof panel.
- `<x-layouts.app side="candidate|employer|admin">` — the three app shells. Navigation
  for each side is declared at the top of that file; add a screen there and to
  `MockupIndexController` so it appears in the screen index at `/screens`.

## Layout habits

- Space siblings with flex/grid `gap`, not margins.
- Give any flex or grid child holding text or a table `min-w-0`; wrap wide tables in `overflow-x-auto`.
- Numbered markers (`01`, `02`) are only for content that genuinely is a sequence, such as the ingest → verify → score → explain pipeline.
- Card styling (border, fill, radius, shadow) marks a thing as a separate object. Do not apply it to every block.
