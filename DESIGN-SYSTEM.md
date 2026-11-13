# Streamline Connect design system

Tokens live in `assets/css/theme.css` under `:root`. They are the source of truth for colour, type, spacing, motion, and elevation. Use them on every new page so the site stays consistent.

Comments in the stylesheet are marked `HOME-FIGMA-UPDATE` or `DESIGN-TOKENS`.

## Breakpoints

CSS variables cannot be used in media query conditions, so the breakpoints stay in the queries themselves.

| Max width | Role | Token changes |
| --- | --- | --- |
| (default, 1920 and up) | Desktop | `--gutter: 56px`, `--section: 112px` |
| 1919px | Laptop | `--gutter: 40px`, `--section: 96px` |
| 1439px | Tablet | `--gutter: 32px`, `--section: 80px` |
| 1199px | Small tablet | Some section layouts stack (no token change) |
| 1023px | Large phone | Footer, delivery, and similar rows stack (no token change) |
| 767px | Phone | `--gutter: 24px`, `--section: 64px` |

## Colour

Brand, neutrals, and borders use the same names as the Figma file variables (`Streamline Navy/900`, `Neutral/Grey 100`, `Border/Default`, and so on). Semantic aliases point at those values.

| Token | Value | Typical use |
| --- | --- | --- |
| `--navy-900` | `#111036` | Primary navy, filled buttons, dark sections |
| `--navy-200` | `#cbcad3` | Muted type on navy |
| `--orange-50` | `#fef5ee` | Light orange surface |
| `--orange-500` | `#f57f27` | Accent, hover, focus ring |
| `--orange-600` | `#d36d22` | Darker accent (stat prefix) |
| `--orange-700` | `#ac591b` | Figma-only; reserved for later pages |
| `--white` | `#fff` | Page surface, type on navy |
| `--grey-100` | `#f4f6f8` | Alternate section surface |
| `--grey-300` / `--line` | `#d9dee5` | Default divider |
| `--grey-500` | `#5a6472` | Subtle text |
| `--grey-700` | `#2b3645` | Muted text |
| `--ink` | `#0f1b2d` | Body text |
| `--line-inverse` | `#33325a` | Divider on navy |
| `--jump-line` | `#e7e7eb` | On-this-page panel rule (theme-only) |
| `--overlay` | `rgba(17, 16, 54, 0.56)` | Menu scrim |
| `--overlay-soft` | `rgba(17, 16, 54, 0.5)` | Image dim |

Semantic text and surface aliases: `--text`, `--text-muted`, `--text-subtle`, `--text-on-dark`, `--text-on-dark-muted`, `--text-accent`, `--surface`, `--surface-muted`, `--surface-inverse`, `--surface-accent`. Prefer these on new pages; existing rules still use the brand names (`--ink`, `--navy-900`) and must keep doing so.

## Type scale

Families: `--font-body` (Aptos, Segoe UI, sans-serif) and `--font-display` (Montserrat).

Weights: `--weight-regular` (400), `--weight-semibold` (600), `--weight-bold` (700).

Tracking: all letter spacing is `0` (`--track-tight` and `--track-normal` are both `0`; keep using the tokens so it can be tuned in one place).

| Size token | Value | Role |
| --- | --- | --- |
| `--text-2xs` | 10px | Rare chips (for example “Runs in parallel”) |
| `--text-xs` | 12px | Kickers and uppercase labels |
| `--text-sm` | 14px | Legal bar, supporting labels |
| `--text-md` | 16px | Body and buttons |
| `--text-lg` | 20px | Jump links, product names |
| `--text-xl` | 22px | Narrow-viewport sector titles |
| `--text-2xl` | 24px | Interior `h2`, tile titles |
| `--text-3xl` | 28px | Stage titles on small screens |
| `--text-4xl` | 32px | Stage titles |
| `--text-5xl` | 40px | Capabilities menu title |
| `--text-lead` | `clamp(16px, 1.042vw, 20px)` | Section intro copy |
| `--text-quote` | `clamp(22px, 1.6vw, 28px)` | Case-study quotes |
| `--text-h3` | `clamp(28px, 2.083vw, 40px)` | Card and project titles |
| `--text-h2` | `clamp(32px, 2.5vw, 48px)` | Section and page titles |
| `--text-display-sm` | `clamp(36px, 3.125vw, 60px)` | Hero headline |
| `--text-stat` | `clamp(36px, 3.2vw, 64px)` | Stat figures |
| `--text-display-lg` | `clamp(36px, 3.75vw, 72px)` | Enquiry headline |
| `--text-display-xl` | `clamp(48px, 5.833vw, 112px)` | Built here headline |

Line heights keep every value already used in the sheet: `--leading-none` (1), `--leading-display-xl` (1.08), `--leading-display-lg` (1.1), `--leading-h2` (1.16), `--leading-snug` (1.2), `--leading-h3` (1.24), `--leading-mega` (1.25), `--leading-title` (1.32), `--leading-tight` (1.4), `--leading-body` (1.5). Do not round them.

## Spacing and layout

The spacing scale is 4px-based, plus the 2px, 6px, and 60px values the current CSS already needed:

`--space-0` through `--space-0_5` (2px), `--space-1` (4px), `--space-1_5` (6px), `--space-2` (8px), `--space-3` (12px), `--space-4` (16px), `--space-5` (20px), `--space-6` (24px), `--space-7` (28px), `--space-8` (32px), `--space-10` (40px), `--space-12` (48px), `--space-14` (56px), `--space-15` (60px), `--space-16` (64px), `--space-20` (80px), `--space-24` (96px), `--space-28` (112px), `--space-32` (128px).

Layout: `--content` (1808px), `--gutter` (56px at 1920, then 40 / 32 / 24), `--header` (80px), `--section` (112px at 1920, then 96 / 80 / 64), `--touch` (44px minimum hit area).

Hairline borders use `--border-width` (1px). Focus rings use `--focus-width`, `--focus-offset`, and `--focus-offset-lg`. The UI is square and unshadowed: `--radius-none` and `--shadow-none`.

Motion: `--duration` (500ms), `--ease`, `--shift` (20px), `--stagger` (80ms).

Z-index: `--z-base`, `--z-overlay`, `--z-header`, `--z-nav`, `--z-skip`.

## Building a new page

1. Wrap the main column in `.wrap`. It centres the `--content` measure and applies the current `--gutter`.
2. Use `.section` for vertical padding (`--section`). Add `.section--grey` or `.section--navy` for a surface change.
3. Titles: `.section-heading` (or `.heading-1`) for the page or section title, `.heading-2` for interior headings, `.heading-3` for card-scale titles. Kickers use `.kicker`. Intro copy can use `.lede`.
4. Actions: `.btn` / `.btn--block` for filled buttons, `.text-link` / `.text-link--light` for uppercase arrow links.
5. Full-bleed rows (a divider or background that must reach the viewport edge, while text stays on the content column) belong outside `.wrap`. Put the border on the full-width box and inset the content with `.full-bleed`, or with:

   `padding-inline: max(var(--gutter), calc((100% - var(--content)) / 2));`

   Prefer `%` over `100vw` so a scrollbar does not overflow the page.
6. Do not invent new hex values, type sizes, or spacing. If a value is missing, add a token to `:root` first and document it here.
7. Copy comes from ACF fields with theme fallbacks in `inc/content.php`. Read values with `slc_plain()` (plain text), `slc_inline()` (a heading or label that may contain emphasis and links), `slc_rich()` (body HTML), `slc_href()` (a URL), and `slc_bind_list()` (repeatable rows). Theme-wide settings (logo, footer phone) live on the Theme settings post, not `wp_options`. Leave Latin placeholders and empty optional fields hidden until an editor fills them in.

Component-specific widths (logo, accreditation marks, some column max-widths) stay as local values. They are not part of the spacing scale.
