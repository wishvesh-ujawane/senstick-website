# SENSESTICK Website — Build Plan

> **Status**: Plan approved, pre-implementation.
> **Authority**: Wireframes (`figma/website-wireframes.pdf`, 15 frames) are the source of truth for layout. Requirements brief (`docs/project-brief.pdf`) is authoritative for scope and content. Datasheet (`docs/TS-Series-datasheet.pdf`) is authoritative for product specifications.

---

## TL;DR

Build the SENSESTICK product site as a self-contained freelance project. Recommended stack: **WordPress + Hello Elementor child + Elementor Pro + ACF Free + CPT UI**, with four reusable templates (Homepage, Product Family, Resource Article, Downloads) and three CPTs (Product Family, Resource, Download). Brand tokens: navy `#000064` + yellow `#FFFF00` accent-on-navy only.

---

## Information Architecture (wireframe-driven, authoritative)

- **Top-level nav**: `Home | Getting Started ▾ | Products ▾ | Resources ▾ | About | Contact`
- **Getting Started ▾**: Microsoft Excel, Google Sheets, LibreOffice Calc (each → Resource Article)
- **Products ▾**: Temperature Sensor Family
- **Resources ▾**: Tutorials, Use Cases, Downloads (no User Guides menu entry)
- **Header**: navy bar, uppercase yellow underlined links, no accent stripe
- **Footer**: navy band — Contact / About / Follow Us: YouTube / LinkedIn (right) + tagline + trademarks (left)

### Contradictions vs. original brief (defaulting to wireframes)

1. **Getting Started** is a TOP-LEVEL menu item (brief had it nested under Resources).
2. **User Guides** has NO menu entry — reachable via Product page button + Downloads page only (brief described it as a Resources sub-menu).
3. **Use Cases on homepage** = **6 cards** including *Smart Buildings* (brief listed 5).

---

## Architecture decision — Path A (recommended)

| Path | Page builder | Templates on CPT | Cost | Use if… |
|---|---|---|---|---|
| **A (rec.)** | Elementor + **Elementor Pro** | Yes — Theme Builder | ~€59/yr | Default. Required for reusable templates applied to many CPT items. |
| B | Block theme (Kadence / GeneratePress Free) + Gutenberg | Yes — block template parts | Free | Pro license refused. Steeper learning curve for owner. |
| C | Elementor Free + duplicate-page workaround | No — breaks reusable templates | Free | Not recommended. Violates a core requirement. |

Plugin stack (Path A): Elementor + Pro, ACF Free, CPT UI, WPForms Lite or Fluent Forms, Rank Math Free, WP Super Cache or LiteSpeed Cache, ShortPixel or Smush, UpdraftPlus, WPCode.

---

## Brand & global styles

- **Colors** — Primary `#000064` (navy), Secondary `#FFFF00` (yellow). Neutrals: `#FFFFFF`, `#111111`, `#6B7280`, `#F5F7FA`, `#E5E7EB`.
- **Yellow rule** — accent-on-navy only. WCAG fails on white; never use as body text or on light backgrounds.
- **Typography** — single sans-serif (Inter or Source Sans 3), engineering tone. Explicit px line-heights for H1–H6, body, small, button.
- **Layout** — container 1240 px, gutter 24 px, section padding 80/120 desktop and 48/64 mobile.
- **Breakpoints** — mobile <768, tablet 768–1024, desktop >1024.

---

## Build phases

### Phase 1 — Project setup

1. Folder scaffold under `Senstick/` (`docs/`, `figma/`, `assets/`, `content/`, `wordpress/`, `qa/`).
2. Stash source PDFs locally (brief, datasheet, wireframes). Gitignored.
3. This plan saved at `docs/PLAN.md`.

### Phase 2 — WordPress environment

4. Install LocalWP (or Local by Flywheel). Site name `senstick.local`. Latest WP, PHP 8.1+, set timezone, permalinks → post-name, disable comments site-wide, media sizes (thumb 300, medium 600, large 1200), enable WebP via image-optimization plugin later.
5. Install **Hello Elementor** + child theme. Configure site identity, favicon placeholder, container width 1240 px.
6. Install plugin stack listed above (Path A). Keep additions strictly justified.

### Phase 3 — Globals, IA, CPTs

7. Apply global design tokens in Elementor Site Settings (colors, typography, buttons, container, breakpoints).
8. **Information architecture**
    - Static Pages: Home, Products (optional landing), Resources (optional landing), About, Contact, Downloads, Book Demo (or merged into Contact), Getting Started landing (optional).
    - **CPT `Product Family`** (slug `products`). ACF group: overview, configurations repeater (name, image, short description), features repeater, specifications table (key/value repeater), downloads relationship (Datasheet, Brochure), related resources relationship (User Guide, Quick Start).
    - **CPT `Resource`** with taxonomy `Resource Type` — terms: Tutorial, Use Case, Getting Started, User Guide, Installation Guide. Single template = Template 3. Menu surfaces only Tutorials / Use Cases / Downloads under Resources; User Guide and Installation Guide articles reachable via Product page buttons + Downloads page.
    - **CPT `Download`** with ACF: file (PDF/zip upload), type taxonomy (Datasheet, Brochure, Software, User Guide PDF, Installation Guide PDF), associated product relationship, version, date. Used so the Product Family page can pull its own downloads dynamically.
    - Why CPTs: client adds a new tutorial / use case / download by creating a post, not by duplicating page layouts.
9. **Menu construction** — primary menu matches the wireframe nav exactly. Header + footer built via Elementor Pro Theme Builder. No yellow accent stripe under header.

### Phase 4 — Templates

#### Template 1 — Homepage

Per wireframes, top to bottom:

1. **Hero** (white bg, centered) — H1 `Spreadsheet Measurement™`, subhead `Stream Live Measurement Data Directly Into Spreadsheet Environments`, full-width light-grey band beneath with the laptop+sensor hero image centered. No CTAs in hero.
2. **Spreadsheet Measurement** (light grey, two columns) — left H2 + lead `From physical measurements to spreadsheet analysis.`; right 4 stacked benefit blocks (bold title + paragraph): *Analyze Data Where It Is Logged*, *Reduce Setup Complexity*, *Avoid Workflow Fragmentation*, *Reduce Manual Data Entry Errors*.
3. **Our Approach + Workflow** (light grey) — left text block bolding `Spreadsheet Measurement`, `Microsoft® Excel®`, `Google Sheets™`. Right 3 rounded-border boxes with navy arrows: Sensor → Spreadsheet → What You Can Do (Report / Analysis / Simulation). Caption `Spreadsheet Measurement Workflow` + tagline `Acquire. Analyze. Act`.
4. **Demo Video** — centered label + 16:9 placeholder/embed.
5. **Product Overview band** (light grey) — short paragraph + wide navy pill button `Learn More About Spreadsheet Sensor Devices` (yellow text) → TS Series page.
6. **Use Cases / Applications** — H2 left-aligned. 3×2 card grid (6 cards): Educational, Laboratories, Agriculture, Environmental Monitoring, Smart Buildings, Engineering Analysis. Card = 16:9 image + bold centered title + short paragraph + italic `Learn More` link.
7. **Final CTA** (white, centered) — H2 `Interested in Spreadsheet Measurement?` + 2-line paragraph + navy `Book a Demo` button.
8. **Footer** (navy) — right group Contact / About / Follow Us / YouTube / LinkedIn (yellow underlined). Left group `SENSESTICK | Spreadsheet Measurement™` + `2023 – All Rights Reserved`. Trademark paragraph italic on the right.

#### Template 2 — Product Family Page (TS Series first, reusable)

Wireframes show a single-scroll layout, NOT a tabbed page:

- **H1** top-left: `Product Title Family` (e.g., `Temperature Sensor Family`).
- **Two-column layout** — LEFT (≈55%) text stack: Overview, Features (bullet list), Specifications (key/value table), Available Configurations (list with short descriptions). RIGHT (≈45%): single Product Image inside a thin navy border box.
- **Downloads row** (left) — H3 + navy pill buttons `Datasheet`, `Brochure`.
- **Related Resources row** (right) — H3 + navy pill buttons `User Guide`, `Quick Start`.
- Built once via Elementor Theme Builder, applied to every Product Family CPT single. ACF-driven so the client can add a second product family with no developer work.
- **Removed** from earlier plan: ti.com-style sticky tab nav. May add lightweight on-page anchor links if the page grows long.

#### Template 3 — Resource Article Page (Getting Started, Tutorials, Use Cases, optionally User Guides)

Per wireframe page 15:

- **Top-left** — Title (large) + small Thumbnail/icon to the right.
- **Below title** — Description paragraph.
- **Center column** — vertical stack of mixed content blocks: Text, Image, Video, Text — repeatable in any order. Implement as Gutenberg post body OR an ACF Flexible Content field with block types: text, image, video embed, downloadable PDF, callout. Owner adds/reorders blocks per article.
- No right-rail sidebar in wireframe. Recommend a small breadcrumb anyway (low visual cost, high navigation value).

#### Template 4 — Downloads Page

Per wireframe page 14, grouped by category, NOT a card grid with filter chips:

- **H1** `Downloads`.
- **Repeating groups**, each with group H2 (e.g., `Product Title Family`, `Microsoft Excel`), short description, then either (a) horizontal row of navy pill buttons labeled with file type for short groups, or (b) vertical list of rows: label left + navy `Download` button right.
- **Implementation** — ACF Flexible Content `Download Groups` on the Downloads page. Each group: `{ title, description, layout = inline-buttons | rows-with-labels, items[] = { label, file upload } }`. Use the Download CPT only when downloads must also be referenced dynamically from product pages (recommended: yes).

### Phase 5 — About, Contact, polish, QA

14. **About** — Company Philosophy, Spreadsheet Measurement Vision, Our Approach, Contact Info.
    **Contact** — Contact form + Book Demo form. Book Demo includes preferred date, company, role, intended application.
15. **Responsive tuning** — manual breakpoint pass on every template at 1440 / 1024 / 768 / 390. Tables horizontally scroll on mobile, hero text remains legible.
16. **Content seeding** — populate TS Series Product Family from the datasheet (description, applications, specs, mechanical specs, legal notice). At least one Tutorial, one User Guide, one Use Case, one Getting Started article so each template is visibly proven.
17. **QA + handoff**
    - Cross-browser: Chrome, Edge, Firefox, Safari.
    - Real device: one iOS, one Android.
    - Forms: submission, spam protection (honeypot or hCaptcha), email delivery.
    - Performance: Lighthouse mobile ≥ 85 perf, ≥ 95 SEO/Accessibility.
    - Accessibility: heading order, alt text, focus states, color contrast (yellow ONLY on navy).
    - Backups configured, admin user handed over, 1–2 page written CMS guide for: creating tutorial, creating use case, uploading PDF, swapping product image, editing menu.

---

## Verification checklist

1. All 4 templates verified by editing only ACF/Gutenberg fields and seeing the layout intact.
2. Owner can create a new tutorial, new use case, new download, and replace a product image without touching Elementor.
3. Brand colors applied only via global styles — no hardcoded hex in widgets.
4. Yellow used only as accent on navy. Never as body text or on white.
5. Menu matches the wireframe hierarchy exactly: `Home | Getting Started ▾ (Excel, Sheets, Calc) | Products ▾ (Temperature Sensor Family) | Resources ▾ (Tutorials, Use Cases, Downloads) | About | Contact`.
6. Homepage section order matches wireframe page 1: Hero → Spreadsheet Measurement → Our Approach + Workflow → Demo Video → `Learn More About Spreadsheet Sensor Devices` CTA → 6-card Use Cases → `Interested in Spreadsheet Measurement?` + Book a Demo → Footer.
7. Use Cases grid shows exactly 6 cards in wireframe order; `Smart Buildings` present.
8. Product Family page renders single-scroll (no tabbed nav) with left content stack + right product image and the two bottom button rows.
9. Downloads page renders as grouped category sections with rows, not as a filterable card grid.
10. Each PDF download triggers an actual download (not in-browser open) with the correct filename.
11. Forms send to client email; spam test passes.
12. Lighthouse mobile perf ≥ 85; no console errors.
13. Site restorable from latest UpdraftPlus backup.

---

## Decisions

- **Scope in**: full site per brief — 4 templates, CPT model, brand globals, forms, downloads, content seeding from datasheet, owner CMS training doc.
- **Scope out**: copywriting beyond what's in the brief/datasheet, translations, e-commerce, blog, user accounts, multilingual.
- **Default architecture**: Path A (Elementor Pro + ACF + CPT UI). Switch to Path B only if the Pro license is refused.
- **Color usage rule**: yellow `#FFFF00` is an accent on navy only, due to WCAG contrast failure on white.
- **TS Series** is the only product family at launch; structure must accept 2nd/3rd families with no template changes.

---

## Open decisions (blocking implementation)

1. Confirm or override the 3 wireframe-vs-brief contradictions above.
2. Confirm Path A (Elementor Pro) vs Path B (Free block theme) vs Path C (Free workaround).
3. Hosting choice (Hostinger / Cloudways / SiteGround) — affects caching plugin pick.
4. Domain & email — confirm `sensestick.com` ownership and DNS access.
5. Book a Demo form fields beyond `{ name, email, company, role, preferred date, intended application }`.

---

## Further considerations

1. Once pixel-spec Figma frames arrive (we currently have low-fi wireframes only), reconcile exact tokens (fonts, navy/yellow shades, spacing scale) and revise Phase 3 globals before building Phase 4.
2. Consider a small custom Elementor widget (or shortcode) for the **Specifications** table if the ACF repeater + Elementor loop becomes layout-fragile — most likely place custom code will be needed.

---

## Relevant files

- [docs/project-brief.pdf](project-brief.pdf) — full requirements (gitignored, local only)
- [docs/TS-Series-datasheet.pdf](TS-Series-datasheet.pdf) — product reference content (gitignored, local only)
- `figma/website-wireframes.pdf` — 15-page low-fi wireframes, authoritative for layout (gitignored)
