# SENSESTICK Website — Build Plan (Figma-Reconciled)

> **Status**: Phase 0 + Phase 2 scaffolding complete. Child theme + CPTs + taxonomies + 6 ACF field groups committed and pushed to [github.com/wishvesh-ujawane/senstick-website](https://github.com/wishvesh-ujawane/senstick-website). Currently unblocked: Hostinger provisioning + theme upload (see [docs/SETUP.md](SETUP.md)).
> **Hosting**: Direct-to-Hostinger (no LocalWP). The repo is the source of truth for theme code; Hostinger File Manager / SFTP is the deploy target.
> **Authority**: High-fidelity Figma exports (`figma/*.png`, 20 frames) are the source of truth for layout, components, and tokens. Requirements brief (`docs/project-brief.pdf`) remains authoritative for scope. Datasheet (`docs/TS-Series-datasheet.pdf`) authoritative for product specifications. Low-fi wireframes (`figma/website-wireframes.pdf`) retained for historical reference only.

---

## TL;DR

Build the SENSESTICK product site as a self-contained freelance project hosted on **Hostinger**. Stack: **WordPress + Hello Elementor + `sensestick-child` (scaffolded, in this repo) + Elementor Pro + ACF Free + CPT UI + Calendly embed**. Figma defines **8 user-visible page types** delivered via **11 effective Elementor templates** and three CPTs (`Product Family`, `Resource`, `Download`) that are already registered in the child theme. Brand tokens: navy `#000064` + yellow `#FFFF00` accent-on-navy only; **buttons are rounded ~8–10 px** (visually pill when wide, rounded-square when narrow). **Home page Use Cases grid is 5 cards** (not 6), **Industries is its own page** with 6 cards, **Getting Started is a hub landing**, **Getting Started dropdown lists Microsoft Excel (external link, TBD by client) + Google Sheets + LibreOffice Calc + ONLYOFFICE Spreadsheet**, **Book a Demo uses an embedded scheduler** (Calendly recommended).

---

## Information Architecture (Figma-driven, authoritative)

- **Top-level nav**: `Home | Getting Started ▾ | Products ▾ | Resources ▾ | About | Contact`
- **Header CTA** (right of nav): persistent yellow `Book Demo` button.
- **Getting Started ▾** (per `Getting-Started-Dropdown.png`, extended): **Microsoft Excel, Google Sheets, LibreOffice Calc, ONLYOFFICE Spreadsheet** (4 items). Dropdown rendered as a white menu panel with light-grey row dividers, navy body text, no icons.
  - **Microsoft Excel** is an external link only (placeholder URL, client to supply). No internal WordPress page is built for Excel.
  - **Google Sheets, LibreOffice Calc, ONLYOFFICE Spreadsheet** link to internal Spreadsheet Integration singles (Template 11).
  - ONLYOFFICE is added to the dropdown (extends the original 3-item Figma mockup) so the designed `Integration-OnlyOffice.png` page is reachable from the primary nav.
- **Products ▾**: Temperature Sensor Family.
- **Resources ▾**: Tutorials, Use Case, Industries, Downloads. No Resources hub landing page — the `Resources-Dropdown.png` frame is the dropdown component, not a page.
- **Footer**: navy band, **5 columns**:
  1. Logo + tagline + social icons (YouTube, LinkedIn)
  2. **PRODUCT** — Temperature Family
  3. **RESOURCES** — Getting Started, User Guide
  4. **COMPANY** — About, Company
  5. **GET IN TOUCH** — Locations, WhatsApp Call, Email Address
  Copyright line at bottom center.

### Changes vs the original wireframe-driven plan

1. **Getting Started** is a hub landing page (not just a menu) with hero + 4 quickstart cards + integration grid + support box.
2. **Industries** is a Resources-menu page with 6 cards.
3. **Use Cases on home = 5 cards** (Education, Environmental Monitoring, Agricultural, Engineering Analysis, Research Laboratories) plus a `View all Use Cases` button. Wireframe expected 6 with Smart Buildings — Figma drops that on the homepage. Smart Buildings remains on the Industries page.
4. **Resources has no hub landing page** — dropdown only.
5. **Spreadsheet integrations** in nav: **Microsoft Excel (external link) + Google Sheets + LibreOffice Calc + ONLYOFFICE Spreadsheet**. Only the latter three get internal WordPress pages (built from the shared Spreadsheet Integration template). The Excel dropdown item points to a client-supplied external URL.

6. **Buttons** are rounded ~8–10 px (visually pill when wide, rounded-square when narrow) — same token, different aspect.
7. **Book a Demo** uses an embedded scheduler (Calendly recommended), not a traditional form.
8. **Product Family page is single-column** with hero carousel (NOT the 55/45 two-column described in the wireframe plan).
9. **Download buttons are icon-only navy rounded-squares** in row layouts (NOT inline pill buttons with labels).

---

## Architecture decision — Path A (confirmed)

| Path | Page builder | Templates on CPT | Cost | Use if… |
|---|---|---|---|---|
| **A (selected)** | Elementor + **Elementor Pro** | Yes — Theme Builder | ~€59/yr | Default. Required for reusable templates applied across CPT singles + archives. |
| B | Block theme (Kadence / GeneratePress Free) + Gutenberg | Yes — block template parts | Free | Only if Pro license is refused. |
| C | Elementor Free + duplicate-page workaround | No | Free | Not viable — breaks reusable templates. |

**Plugin stack (Path A)**: Elementor + Pro, ACF Free, CPT UI, WPForms Lite or Fluent Forms, **Calendly embed (or Cal.com)**, Rank Math Free, WP Super Cache or LiteSpeed Cache, ShortPixel or Smush, UpdraftPlus, WPCode.

---

## Brand & global styles (locked from Figma)

### Colors

| Token | Hex | Use |
|---|---|---|
| `--navy` | `#000064` | Primary. Header / footer bg, primary button fill, body headings on white. |
| `--yellow` | `#FFFF00` | Accent. Logo wordmark, `Book Demo` button fill, accents on navy only. Never body text, never on white. |
| `--white` | `#FFFFFF` | Page bg, button text on navy. |
| `--ink` | `~#111111` | Body text on white. |
| `--ink-muted` | `~#6B7280` | Captions, file metadata, breadcrumbs. |
| `--panel-grey` | `~#F5F7FA` | Section panels. |
| `--panel-blue-grey` | `~#E8EDF3` | About philosophy panel. |
| `--rule` | `~#E5E7EB` | Hairline dividers, card borders. |

Tutorials article previews show a green chart accent (data-viz only) — not promoted to a brand token until confirmed. See Open Decision #4.

### Typography

Single sans-serif family — Inter or Source Sans 3. Approximate scale (verify on first render):

| Token | px | Weight | Line-height |
|---|---|---|---|
| `--h1` | 36–40 | 700 | 1.15 |
| `--h2` | 28–32 | 700 | 1.2 |
| `--h3` | 22–24 | 600 | 1.25 |
| `--h4` | 18–20 | 600 | 1.3 |
| `--body` | 16 | 400 | 1.6 |
| `--small` | 14 | 400 | 1.5 |
| `--button` | 16 | 600 | 1 |

### Buttons (rounded ~8–10 px radius)

| Variant | Fill | Text | Border | When |
|---|---|---|---|---|
| Primary navy | `--navy` | `--white` | none | Most CTAs (`View Product`, `Learn More…`, `View User Guide`). |
| Primary yellow | `--yellow` | `--navy` | none | `Book Demo` (header + final CTA banners). |
| Outline | transparent | `--navy` | 1 px `--navy` | Secondary CTAs (`Contact us`, `View all Use Cases`). |
| Outline-on-navy | transparent | `--white` | 1 px `--white` | `Contact us` inside the navy CTA banner. |
| Icon-only download | `--navy` | `--white` icon | none | Right-aligned download row buttons, ~40–44 px square. |

### Layout

- Container max-width 1240 px; side padding 40–60 px desktop.
- Section vertical padding: 80/120 desktop, 48/64 mobile.
- Breakpoints: mobile <768, tablet 768–1024, desktop >1024.
- Header ~80 px tall, persistent; no accent stripe under header.

---

## Build phases

### Phase 0 — Asset hygiene  *(complete)*

1. ✅ Folder scaffold under `Senstick/` (`docs/`, `figma/`, `assets/`, `content/`, `wordpress/`, `qa/`).
2. ✅ Source PDFs in `docs/` and `figma/` excluded via `.gitignore`.
3. ✅ Figma PNGs moved into `figma/` with standardized hyphen-spaced names; `.gitignore` extended to exclude `figma/*.{png,jpg,jpeg,webp}` (large, local-only).
4. ✅ This plan saved at `docs/PLAN.md` (replaces the wireframe-driven v1; git history preserves the original).
5. ✅ Repo pushed to [github.com/wishvesh-ujawane/senstick-website](https://github.com/wishvesh-ujawane/senstick-website) under `main`.

### Phase 1 — Hostinger provisioning  *(user-side, in progress)*

*Direct-to-Hostinger — no LocalWP. Step-by-step instructions live in [docs/SETUP.md](SETUP.md).*

6. Buy Hostinger plan (Business recommended) + connect domain (`sensestick.com` or chosen domain) + wait for free SSL active.
7. Install WordPress via hPanel Auto Installer. Pick a non-`admin` username, strong password.
8. WP hygiene: permalinks → Post name, disable comments, set HTTPS site URLs, hide from search engines until launch.
9. Install Hello Elementor (parent). Do NOT activate yet — upload the child first.
10. Upload `sensestick-child` zip via Appearance → Themes → Upload (or sync via SFTP). Activate.
11. Install plugin stack: Elementor + Pro, ACF Free, WPForms Lite or Fluent Forms, Rank Math, WPCode Lite, UpdraftPlus, ShortPixel/Smush. Keep Hostinger's built-in LiteSpeed Cache — do NOT add a 2nd cache plugin.

### Phase 2 — Globals, IA, CPTs  *(child-theme scaffolding complete)*

The child theme already ships CPTs, taxonomies (with seeded terms), image sizes, nav menu locations, brand-token CSS variables, and 6 ACF field groups. Activating the theme + ACF Free populates the data model automatically. Remaining work is in WP admin.

12. **Already in code** ✅: `product_family`, `resource`, `download` CPTs registered in [wordpress/sensestick-child/inc/cpts.php](../wordpress/sensestick-child/inc/cpts.php).
13. **Already in code** ✅: `resource_type`, `download_category`, `download_type` taxonomies + canonical terms seeded in [wordpress/sensestick-child/inc/taxonomies.php](../wordpress/sensestick-child/inc/taxonomies.php).
14. **Already in code** ✅: 6 ACF JSON field groups in [wordpress/sensestick-child/acf-json/](../wordpress/sensestick-child/acf-json/) covering Product Family, Resource (10-block flexible content), Spreadsheet Integration variant, Download, Industries page, Downloads page.
15. **Already in code** ✅: Brand tokens as CSS custom properties in [wordpress/sensestick-child/style.css](../wordpress/sensestick-child/style.css).
16. **In WP admin (manual)**: After theme activation, go to ACF → Field Groups → Sync (yellow banner) to bulk-sync the 6 groups.
17. **In Elementor Site Settings (manual)**: mirror the brand tokens (Global Colors, Global Fonts, Buttons radius 8 px, Container 1240 px). Elementor does not read the CSS variables automatically.
18. **Static pages** to create in WP admin: Home, Products (optional landing), About, Contact Us, Book a Demo, Industries, Downloads, Getting Started.
19. **Menu construction** — primary menu matches the Figma nav exactly. Header + footer built via Elementor Pro Theme Builder. The Microsoft Excel item under Getting Started is a **Custom Link** (external URL placeholder); the other three integration items (Google Sheets, LibreOffice Calc, ONLYOFFICE Spreadsheet) are linked to their internal Spreadsheet Integration `Resource` posts.

#### Reference — CPT and ACF schema (now in code)

Retained below for design / content reviewers. Actual field keys and types live in the JSON files referenced above.

- **`Product Family`** (slug `products`). ACF group:
      - `overview` (wysiwyg)
      - `feature_icons[]` — repeater `{ icon, label }` (e.g., High Accuracy ±0.1°C / Real-Time Logging / USB Powered / Rugged & Reliable).
      - `feature_highlights[]` — repeater `{ icon, title, body }` (5 cards: Wide Temperature Range / High Resolution / Fast Sampling / Plug & Play / Cross Platform).
      - `configurations[]` — repeater `{ image, name, bullet_specs[] }` (3 cards: TH-001, TH-002, TH-003).
      - `specifications[]` — repeater `{ key, value }` (key/value table).
      - `downloads_relationship` → `Download` posts (Datasheet, Brochure, Certificate of Calibration).
      - `related_resources_relationship` → `Resource` posts (User Guide, Quick Start, Software Integration).
      - `works_with[]` — repeater `{ logo, name, link }` (Excel, Google Sheets, LibreOffice Calc, Sense Streamer).
    - **`Resource`** with taxonomy `Resource Type` — terms: **Tutorial, Use Case, User Guide, Spreadsheet Integration, Installation Guide**. ACF on single: hero badge text, subtitle, hero product image. Body via ACF Flexible Content (see Template 9). Spreadsheet Integration uses a dedicated single template (Template 11). Menu surfaces Tutorials / Use Case / Industries / Downloads under Resources; User Guides reachable via Product Family buttons + Footer + Downloads page.
    - **`Download`** with ACF: `file` (PDF/zip upload), `category` taxonomy (Temperature Family / Microsoft Excel / Google Sheets / LibreOffice Calc / ONLYOFFICE Spreadsheet / Tutorials / Use Cases), `type` taxonomy (Datasheet / Brochure / Software / User Guide PDF / Installation Guide PDF / Certificate), `associated_product` relationship, `version`, `date`. `file_size` auto-resolved from upload.
    - **Spreadsheet Integration posts to seed**: Google Sheets, LibreOffice Calc, ONLYOFFICE Spreadsheet (three internal pages). Microsoft Excel is an external menu link only — no internal post or page.
- **Industries page** — static page + ACF repeater `industries[] { icon, title, body, learn_more_link, featured_on_home (bool), featured_on_about (bool) }`. About reuses 5 entries; Home reuses 5.

### Phase 3 — Reusable global components

Build once as Elementor Global Widgets or Theme Builder parts.

| Component | Used by |
|---|---|
| Header (Theme Builder) | All pages |
| Footer (Theme Builder, 5-col) | All pages |
| Breadcrumb | Every non-home page (`Home > Section > Page`) |
| **CTA Banner** — navy bg, white headline + body + `Book Demo` (yellow) + `Contact us` (outline-on-navy) | Product Family, Resource Single, all 3 Spreadsheet Integrations, About |
| **File Card** — icon + label + metadata (type, size) + right-aligned navy download arrow button | Downloads page rows, Product Family Downloads/Related Resources, Resource Single inline downloads |
| **Step Card (4-up)** — icon + title + body | Getting Started quickstart, Integration install steps |
| **Quick Start block** — left screenshot + right numbered 1–5 list | All 3 Spreadsheet Integrations |
| **Feature Icon Row (inline)** — icons + short labels | Product Family hero |
| **Feature Highlight Cards (5-up)** — icon + title | Product Family |
| **Circular Step Cards (5-up)** — navy circle + yellow icon + title + body | About "How SENSESTICK Works" |
| **Related Tutorials Widget** — vertical link list | Tutorials article sidebar / bottom |
| **Industry Card** | Industries page (6), About (5), Home Use Cases (5) — same component, different filters |
| **Support box** — icon + "Need Help Finding Something?" + `Contact us` button | About, Downloads |

### Phase 4 — Templates (11 effective, 8 user-visible page types)

| # | Template | Built on | Driven by |
|---|---|---|---|
| 1 | Homepage | Page | Static + ACF (industry repeater shared) |
| 2 | About | Page | Static + ACF (philosophy quote, work-step cards, industry cards) |
| 3 | Contact Us | Page | Form plugin + static info |
| 4 | Book a Demo | Page | Calendly/Cal.com embed |
| 5 | Industries | Page | ACF `industries[]` repeater |
| 6 | Getting Started (hub) | Page | ACF quickstart cards + integration cards |
| 7 | Product Family — Single | `Product Family` CPT | ACF |
| 8 | Downloads | Page | ACF Flexible Content groups OR queries against `Download` CPT |
| 9 | Resource — Single (article) | `Resource` CPT | ACF Flexible Content body |
| 10 | Resource — Listing (archive) | Theme Builder archive | Term-filtered card grid + search + pagination |
| 11 | Spreadsheet Integration — Single | `Resource` (taxonomy `Spreadsheet Integration`) | Dedicated Elementor template |

#### Template 1 — Homepage (Figma `Home.png`)

Top to bottom:

1. **Hero** — white bg, 2-column. Left: H1 `Spreadsheet Measurement™`, subhead `Stream Live Measurement Data Directly Into Spreadsheet Environments`, primary `View Product` button (navy fill). Right: laptop + SENSESTICK Temperature device render (charts visible on laptop screen).
2. **Spreadsheet Measurement band** (light grey) — left H2 + lead `From physical measurements to spreadsheet analysis.`; right 4 stacked benefit blocks (bold title + paragraph): *Analyze Data Where It Is Logged*, *Reduce Setup Complexity*, *Avoid Workflow Fragmentation*, *Reduce Manual Data Entry Errors*.
3. **Our Approach + Workflow** (light grey) — left text block bolding `Spreadsheet Measurement`, `Microsoft® Excel®`, `Google Sheets™`. Right 3 rounded boxes connected by navy curved arrows: Sensor → Spreadsheet → What You Can Do (3 icons: Report / Analysis / Simulation). Caption `Spreadsheet Measurement Workflow` + tagline `Acquire. Analyze. Act`.
4. **Demo Video** — centered label + landscape play-button overlay on an office-desk photo (modal-video on click; embed swappable later).
5. **Product Overview band** (light grey) — short paragraph + right-aligned navy `Learn More About Spreadsheet Sensor Devices` button → TS Series page.
6. **Use Cases** — H2 `Use Cases`. **5-card row** (NOT 6): Education / Environmental Monitoring / Agricultural / Engineering Analysis / Research Laboratories. Each card: 16:9 image + bold title + 1-line description. Below grid: navy-outline `View all Use Cases` button → Use Cases listing.
7. **Final CTA** (navy band, rounded section) — H2 `Interested in Spreadsheet Measurement?` + 1-line subhead, with two buttons: yellow `Book Demo` + outline-on-navy `Contact us`.
8. **Footer** (5-column navy, as specified).

#### Template 2 — About (Figma `About.png`)

1. **Hero** — breadcrumb `Home > About`, H1 `About SENSESTICK`, subhead `Engineering measurement tools that work with your existing spreadsheet workflow.`
2. **Philosophy** (light blue-grey panel) — yellow-left-border quote block: *"Measurement tools should adapt to the way people already work, not force them to learn complex software ecosystems."*; subsection `Spreadsheet Measurement` with Excel / Sheets / Calc icons; tagline `One Workflow. Any Spreadsheet. Complete Flexibility.`
3. **How SENSESTICK Works** — 5 **circular** cards (navy circle + yellow icon): Sensor / Measurement / Spreadsheet / Analysis / Decision.
4. **Who Uses SENSESTICK** — 5 industry cards (Education, Laboratories, Environmental Monitoring, Agriculture, Engineering Analysis).
5. **Our Vision** — image left + text + `Book Demo` (navy) CTA.
6. **Support box** — `Need Help Finding Something?` + `Contact us` (navy).
7. **Footer**.

#### Template 3 — Contact Us (Figma `Contact.png`)

1. **Hero** — navy bg, breadcrumb `Home > Contact Us`, H1 `Let's Build the Future Together!`, subhead `Connect With Us`, body `Connect with our team for expert guidance.`
2. **Two-column** — left: email / address / phone (with icons) + decorative hexagon world-map illustration. Right: contact form with fields `First Name`, `Last Name`, `Email`, `Phone Number`, `Service` (dropdown), `Country` (dropdown), `Message`. Primary `Send Message` button (navy).
3. **Footer**.

#### Template 4 — Book a Demo (Figma `Book-Demo.png`)

1. **Hero** — navy bg, breadcrumb `Home > Book a Demo`, yellow SENSESTICK badge, H1 `Book a demo`, intro body, meeting metadata block: `30 min` duration icon, `Web conferencing details provided upon confirmation.` Note: `Please Select Your Convenient Slot`; reference to alternative times + Microsoft Teams.
2. **Scheduling embed** — Calendly (or Cal.com): calendar grid (month view, pre-selected day highlighted yellow) + timezone selector + slot list.
3. **Footer** with cookie/privacy links.

#### Template 5 — Industries (Figma `Industries.png`)

1. **Hero** — navy bg, breadcrumb `Home > Industries`, H1 `Industries We Serve`, short body.
2. **6-card grid** — Educational, Laboratories, Agriculture, Environmental Monitoring, Smart Buildings, Engineering Analysis. Card: large icon + navy title + body + `Learn More` link.
3. Optional inline CTA band.
4. **Footer**.

#### Template 6 — Getting Started hub (Figma `Getting-Started.png`)

1. **Hero** — breadcrumb `Home > Getting Started`, H1 `Getting Started with SenseStick` + intro.
2. **Quickstart cards** — 4-up Step Cards: `Setup & Configuration`, `Data Export`, `Integration Guides`, `Troubleshooting`.
3. **Integration cards** — 4-card grid: Microsoft Excel, Google Sheets, LibreOffice Calc, Sense Streamer. Each card has a `Learn More` link.
   - Microsoft Excel card → external URL (client-supplied placeholder).
   - Google Sheets / LibreOffice Calc → internal Spreadsheet Integration singles.
   - Sense Streamer → per Open Decision #3, defaults to download-only (card may link to its Download entry or be a placeholder).
   - Note: ONLYOFFICE is in the nav dropdown but is NOT a 5th card here (keeps the 4-card grid intact). Consider swapping Sense Streamer for ONLYOFFICE if Sense Streamer is descoped.
4. **Support box** — `Still need help?` + `Contact us`.
5. **Footer**.

#### Template 7 — Product Family Single (Figma `Product-Family-Single.png`)

**Single-column, NOT 55/45 two-column, NOT tabbed.**

1. Header / breadcrumb `Home > Product`.
2. **Hero band** — yellow SENSESTICK badge, H1 `SENSESTICK Temperature`, short description, product carousel (image + left/right arrows + thumbnail strip below).
3. **Feature Icon Row** — `High Accuracy ±0.1°C` · `Real-Time Logging` · `USB Powered` · `Rugged & Reliable`.
4. **Feature Highlights** — 5 cards: `Wide Temperature Range`, `High Resolution`, `Fast Sampling`, `Plug & Play`, `Cross Platform`.
5. **Available Configurations** — 3 product cards (TH-001, TH-002, TH-003) with image + bullet specs.
6. **Specifications (All Configurations)** — clean key/value table, 2 columns, no borders/stripes, generous spacing.
7. **Downloads** — **File Cards** (NOT pill buttons): Datasheet PDF · Brochure PDF · Certificate of Calibration PDF.
8. **Related Resources** — File Cards: User Guide PDF · Quick Start Guide PDF · Software Integration PDF.
9. **Works Seamlessly With** — 4 integration cards (Microsoft Excel, Google Sheets, LibreOffice Calc, Sense Streamer) with `Learn More` links.
10. **CTA Banner** — yellow `Book Demo` + outline-on-navy `Contact us`.
11. **Footer**.

#### Template 8 — Downloads (Figma `Downloads.png`)

1. **Hero** — H1 `Downloads`, subtitle `All the documents, software and resources you need…`, product-render in top-right.
2. **Category groups** (icon + H2/H3 title + description + item rows). Groups in order:
    1. Temperature Measurement Family
    2. Microsoft Excel
    3. Google Sheets
    4. LibreOffice Calc
    5. ONLYOFFICE Spreadsheet
    6. Tutorials (dark navy pill heading)
    7. Use Cases (dark navy pill heading)
3. **Item rows** — `[file-type icon] [filename] [PDF, 1.8 MB] [→ navy rounded-square download icon button]`. All icon-only download buttons (no labels, no inline pill buttons).
4. **Support box** — `Need Help Finding Something?` + `Contact us`.
5. **Footer**.
6. **Implementation** — primary: ACF Flexible Content `download_groups[]` on the Downloads page. Each group: `{ title, icon, description, items[] = { label, file_upload (auto file_size) } }`. Secondary: surface `Download` CPT items dynamically on Product Family pages so a single upload feeds both places.

#### Template 9 — Resource Single (Figma `Tutorials-Single.png`, `User-Guide-Single.png`)

1. **Hero** — yellow SENSESTICK badge + H1 + subtitle + product render (right).
2. **Article body** — ACF Flexible Content `article_body[]` with block types:
    - `text` (wysiwyg paragraph)
    - `numbered_section` (H2 with auto-numbering)
    - `image_with_caption` (figure + caption)
    - `numbered_steps[]` (ordered list)
    - `callout` (highlighted box; brand-defined accent color)
    - `configuration_table` (key/value or simple grid)
    - `code_block`
    - `download_inline` (file card)
    - `video_embed` (responsive iframe)
    - `related_articles_widget` (auto-pulled from same taxonomy or curated)
3. **Legal / Notices** — `Legal Notice`, `Pilot Product Notice`, `Disclaimer Notice` sections (per User Guide frame).
4. **CTA Banner**.
5. **Footer**.

Used by Tutorial, Use Case, User Guide, Installation Guide single posts.

#### Template 10 — Resource Listing (Figma `Tutorials-Listing.png`, `Use-Cases-Listing.png`)

Theme Builder archive applied to `Resource Type` term archives.

1. **Hero** — breadcrumb + H1 (term name, e.g., `Tutorials`, `Use Case`) + intro/search bar.
2. **Card grid** — 3 columns × N rows. Card: 16:9 image + navy title + body + date footer.
3. **Pagination**.
4. **Footer**.

#### Template 11 — Spreadsheet Integration Single (Figma `Integration-GoogleSheets.png`, `Integration-LibreOfficeCalc.png`, `Integration-OnlyOffice.png`)

Dedicated single template for posts in the `Spreadsheet Integration` term. All three frames share this structure:

1. **Hero** — breadcrumb `Home > Getting Started > {Integration}`, H1, subtitle, primary `View User Guide` button (navy), laptop-with-device image right.
2. **Installation Steps** — 4 Step Cards (Download → Install/Authorize → Connect → Start).
3. **Quick Start** — left screenshot + right numbered 1–5 list.
4. **Related Documentation** — 4-card grid (`{Integration} User Guide` / `Tutorials` / `Use Cases` / `Downloads`) with `View →` links.
5. **Full-page product screenshot**.
6. **CTA Banner** — message varies (`Ready for Cloud-Based Measurement?` for Sheets; `Ready for Open-Source Measurement?` for Calc/ONLYOFFICE).
7. **Footer**.

ACF on this template: `hero_image`, `hero_cta_link`, `install_steps[] { icon, title, body }`, `quickstart_screenshot`, `quickstart_steps[]`, `related_docs[] (relationship)`, `fullpage_screenshot`, `cta_banner_message`.

### Phase 5 — Content seeding

- **TS Series Product Family** — full population from datasheet (hero, feature icons, 5 highlights, 3 configurations, spec table, legal notice, downloads relationships, related resources).
- **Industries** — 6 cards with icons + copy (canonical 6: Educational, Laboratories, Agriculture, Environmental Monitoring, Smart Buildings, Engineering Analysis).
- **About** — philosophy quote, 5 work-step cards, 5 reused industry cards, vision copy.
- **Getting Started** — 4 quickstart card copy + 3–4 integration cards.
- **At least one of each Resource**: 1 Tutorial (full article with figures, steps, callouts), 1 Use Case, 1 User Guide, 3 Spreadsheet Integrations (Sheets, Calc, ONLYOFFICE).
- **Downloads** — real PDFs per category: Datasheet, Brochure, Certificate of Calibration, User Guide, Quick Start, Software Integration.
- **Copy fixes flagged on ONLYOFFICE Figma frame**: subtitle currently says "LibreOffice Calc"; documentation intro says "Excel"; CTA banner reuses LibreOffice copy. Author distinct ONLYOFFICE copy.
- **Footer tagline placeholder** (Lorem ipsum in Figma) — request real tagline from client.
- **Footer contact number** `+44 123-456-7890` paired with a San Francisco address — confirm correct values with client.

### Phase 6 — QA + handoff

- **Responsive tuning** — manual pass per template at 1440 / 1024 / 768 / 390. Tables horizontally scroll on mobile, hero stack collapses to 1-column, carousel touch-swipes, dropdown menus expand to accordion on mobile.
- **Cross-browser** — Chrome, Edge, Firefox, Safari.
- **Real device** — one iOS, one Android.
- **Forms** — contact form submission, honeypot/hCaptcha, email delivery, success/error states.
- **Book a Demo** — Calendly event creation, calendar invite delivery, timezone handling.
- **Performance** — Lighthouse mobile ≥ 85 perf, ≥ 95 SEO/Accessibility.
- **Accessibility** — heading order, alt text on every render + screenshot, focus states, color contrast (yellow ONLY on navy).
- **Backups** — UpdraftPlus configured + restore test.
- **CMS guide** — written, 1–2 pages, covering: create tutorial / create use case / create user guide / create integration page / upload PDF to Downloads / swap product image / swap industry card / edit menu.

---

## Verification checklist

1. **Tutorials archive** renders as 3×N card grid with search + pagination matching `Tutorials-Listing.png`.
2. **Tutorial single** renders hero + numbered sections + inline figures + legal block + CTA banner matching `Tutorials-Single.png`.
3. **Google Sheets, LibreOffice Calc, ONLYOFFICE Spreadsheet** pages are structurally identical (one template) and produce content from a single Spreadsheet Integration ACF schema. The Microsoft Excel dropdown item opens an external URL (placeholder until client supplies final URL); no internal Excel page is built.
4. **Product Family single** is single-column with hero carousel, feature icon row, 5 highlight cards, 3 configuration cards, spec table, File Card Downloads + Related Resources, Works Seamlessly With grid, CTA banner. **No tabs. No 55/45 split. No pill buttons in download rows.**
5. **Downloads page** renders 7 grouped sections in the correct order, with File Card rows + navy rounded-square icon-only download buttons. File metadata (type, size) visible.
6. **Book a Demo** loads scheduling widget; selecting a slot creates a real event and sends a calendar invite.
7. **Industries page** renders 6 cards matching `Industries.png`.
8. **About page** renders philosophy quote with yellow border, 5 circular work-step cards, 5 industry cards, vision section, support box.
9. **Contact** renders 2-column with 7-field form; submit succeeds and email arrives.
10. **Homepage** matches `Home.png` in section order and counts (5 use case cards, not 6; `View Product` hero CTA; final navy CTA banner with Book Demo + Contact us).
11. Header / footer render identically across every page; primary yellow CTA shape consistent; download buttons are consistently navy icon-only rounded squares.
12. Owner adds a new tutorial via WP admin (post + taxonomy + ACF body blocks) → appears in archive without Elementor edits. Adds a new download → appears on Downloads page + Product Family page automatically.
13. Brand colors applied only via global Site Settings — no hardcoded hex in widgets.
14. Yellow used only as accent on navy. Never as body text or on white.
15. Lighthouse mobile perf ≥ 85; a11y/SEO ≥ 95; no console errors.
16. Site restorable from latest UpdraftPlus backup.

---

## Decisions captured

- **Figma supersedes wireframes** for layout AND tokens.
- **Path A** (Elementor Pro + ACF + CPT UI) confirmed.
- **Buttons** are rounded ~8–10 px; pill-vs-rounded-square is a function of aspect, not a separate token.
- **Templates** expand from 4 → 11 effective (8 user-visible page types).
- **Book a Demo** is a Calendly embed, not a form.
- **Industries** is its own page; 6 cards canonical, reused on About (5) and Home (5).
- **Getting Started** is a hub landing page, not a menu-only item.
- **Resources** has no hub landing — dropdown only.
- **Spreadsheet integrations** in nav: Google Sheets + LibreOffice Calc + ONLYOFFICE Spreadsheet. Microsoft Excel page TBD (Open Decision #1).
- **Resource Article** body uses ACF Flexible Content with named block types.
- **CTA Banner + File Card** are global reusable components.
- **Product Family** is single-column with carousel hero.
- **Color usage rule**: yellow `#FFFF00` is accent-on-navy only.
- **TS Series** is the only product family at launch; CPT model accepts 2nd/3rd families with no template changes.

---

## Open decisions (need client / owner input before unblocking)

1. **Microsoft Excel page** — RESOLVED. No internal Excel page is built. The Getting Started dropdown carries Microsoft Excel as an **external link only** (placeholder URL, client to supply final URL pre-launch). Excel still appears on Downloads (as a category group) and on the Getting Started hub integration card grid (linking to the same external URL).

1b. **ONLYOFFICE Spreadsheet placement** — RESOLVED. ONLYOFFICE is added to the Getting Started dropdown as a 4th item, linking to its internal Spreadsheet Integration single (Template 11). Dropdown now: Microsoft Excel → ext / Google Sheets / LibreOffice Calc / ONLYOFFICE Spreadsheet.
2. **Scheduling tool** — Calendly free (recommended for v1) vs Cal.com self-hosted vs custom form + manual scheduling. Default Calendly unless overridden.
3. **Sense Streamer** — referenced on Product Family ("Works Seamlessly With") and Getting Started. Options: A) Its own Product Family CPT entry. B) A Spreadsheet Integration Resource entry. C) Download-only, no dedicated page (default).
4. **Tutorials green accent** — used for chart callouts in the tutorial frame. Promote to a token (define hex + permitted use) or treat as imagery only? Default imagery only unless overridden.
5. **Footer tagline + contact** — Figma footer carries Lorem ipsum and `+44 123-456-7890` paired with a San Francisco address. Confirm real copy and phone.
6. **ONLYOFFICE copy** — current frame text incorrectly references LibreOffice / Excel. Need authored ONLYOFFICE-specific subtitle, doc intro, and CTA banner.
7. **Home Use Cases vs About Industries vs Industries page** — three card sets overlap but are not identical. Confirm canonical 6 (Industries page) and which 5 are featured on Home (Research Laboratories + Agricultural use slightly different names than About / Industries — confirm one canonical naming).
8. **Hosting + domain + email** — pre-launch decisions: Hostinger / Cloudways / SiteGround; `sensestick.com` ownership; DNS access; client email destination for forms.

---

## Relevant files

- [docs/project-brief.pdf](project-brief.pdf) — full requirements (gitignored, local only)
- [docs/TS-Series-datasheet.pdf](TS-Series-datasheet.pdf) — product reference content (gitignored, local only)
- `figma/*.png` — 20 high-fidelity frames, **authoritative for layout & tokens** (gitignored). Includes `Getting-Started-Dropdown.png` (the menu panel itself).
- `figma/website-wireframes.pdf` — 15-page low-fi wireframes (historical reference only, gitignored)
- `figma/Home-part{1..4}.png` — homepage split for image-viewer reading (regenerable; can be deleted)
