# 01 — Home page build guide

> Figma source: [figma/Home.png](../../figma/Home.png) (full frame) + [Home-part1.png](../../figma/Home-part1.png) / [Home-part2.png](../../figma/Home-part2.png) / [Home-part3.png](../../figma/Home-part3.png) / [Home-part4.png](../../figma/Home-part4.png) (height-sliced strips).
> Spec source: [PLAN.md → Template 1 — Homepage](../PLAN.md).
> ACF schema: [acf-json/group_page_home.json](../../wordpress/sensestick-child/acf-json/group_page_home.json).
> Page template: [page-templates/page-home.php](../../wordpress/sensestick-child/page-templates/page-home.php).

This guide walks through building the Home page top-to-bottom in WordPress + Elementor Pro. Sections 1 and 2 are one-time global setup; do them once, then they apply to every page. Sections 3–7 are the actual Home build.

---

## §0 — Prerequisites

Before touching Elementor, confirm each of the following in WP Admin:

- [ ] Hostinger WordPress install is live on HTTPS (see [SETUP.md](../SETUP.md)).
- [ ] Hello Elementor (parent) + `SENSESTICK Child` are both installed; child theme is **active** under Appearance → Themes.
- [ ] Elementor + Elementor Pro are activated; Pro license is connected (Elementor → License).
- [ ] ACF Free is activated. Go to ACF → Field Groups and click the yellow **Sync** banner if visible — all 9 groups from [acf-json/](../../wordpress/sensestick-child/acf-json/) should show as synced.
- [ ] WP Admin → Pages shows a `Home` page at slug `/home` (auto-seeded by [inc/seed-pages.php](../../wordpress/sensestick-child/inc/seed-pages.php)).
- [ ] WP Admin → Settings → Reading → "Your homepage displays" is set to **A static page** with `Home` selected as Homepage (also auto-seeded; verify it stuck).
- [ ] On the `Home` edit screen, the Page Attributes → Template dropdown shows **SENSESTICK Home** selected. If it shows "Default template", switch it and Update.
- [ ] On the same screen, the **Page — Home** ACF panel appears below the editor (this confirms the ACF location rule matched).

---

## §1 — Elementor Site Settings (one-time, applies to every page)

> The CSS custom properties in [style.css](../../wordpress/sensestick-child/style.css) `:root` do NOT propagate into the Elementor editor. You must enter the same values manually so Site Editor and stylesheet stay in sync.

Open any page → Edit with Elementor → top-left hamburger → **Site Settings**.

### 1.1 Global Colors

Settings → Global Colors → replace the defaults with these 8 named swatches (delete any extras):

| Name | Hex | Source |
|---|---|---|
| Navy | `#000064` | `--ss-navy` |
| Yellow | `#FFFF00` | `--ss-yellow` |
| White | `#FFFFFF` | `--ss-white` |
| Ink | `#111111` | `--ss-ink` |
| Ink Muted | `#6B7280` | `--ss-ink-muted` |
| Panel Grey | `#F5F7FA` | `--ss-panel-grey` |
| Panel Blue Grey | `#E8EDF3` | `--ss-panel-blue-grey` |
| Rule | `#E5E7EB` | `--ss-rule` |

**Rule of usage** — Yellow is **accent-on-navy only**. Never use it as body text and never on a white background. Yellow is reserved for the `Book Demo` button fill, the logo wordmark, and small accents on navy bands.

### 1.2 Global Fonts

Settings → Global Fonts → set the family to **Inter** (Google Fonts; load weights 400 / 600 / 700, per [PLAN.md → Typography](../PLAN.md)), then configure each role:

| Role | Size | Weight | Line height |
|---|---|---|---|
| Primary Headline (H1) | 40 px | 700 | 1.15 |
| Secondary Headline (H2) | 32 px | 700 | 1.20 |
| Text — H3 | 24 px | 600 | 1.25 |
| Text — H4 | 20 px | 600 | 1.30 |
| Body Text | 16 px | 400 | 1.60 |
| Accent (small / caption) | 14 px | 400 | 1.50 |

Mobile responsive sizes (set the mobile column in the same dialog):
- H1 → 32 px
- H2 → 26 px
- H3 → 20 px

### 1.3 Buttons

Settings → Buttons:
- Typography: weight 600, size 16, line-height 1.
- Padding: 12 px top/bottom, 24 px left/right.
- **Border radius: 8 px** (all four corners). This is the canonical token — wide buttons read as pills, narrow buttons read as rounded squares; do not split into separate styles.

### 1.4 Layout

Settings → Layout:
- Content Width: **1240 px**.
- Widgets Space: 20.
- Page Title Selector: leave empty (page titles are rendered inside Elementor, not by the theme).
- Breakpoints: keep defaults (Mobile ≤ 767, Tablet ≤ 1024).

Click **Update** in Site Settings before closing.

---

## §2 — Theme Builder: header + footer (one-time)

Built once, applied to **Entire Site** so every page (including Home) inherits them.

### 2.1 Header

WP Admin → Templates → **Theme Builder** → Header → **Add New** → name `Site Header` → Create Template (skip the blocks library).

Build with these widgets in a single container (flex row, 80 px tall, white bg, light bottom rule):

| Position | Widget | Settings |
|---|---|---|
| Left | Site Logo | Link to `/`. Use the SENSESTICK logo from [assets/](../../assets/). |
| Center | Nav Menu | Menu: `Primary` (build it in Appearance → Menus first — see 2.1.1). Link Hover Color: Navy. Pointer: None. |
| Right | Button | Text: `Book Demo`. Link: `/book-a-demo`. Type: Custom → background Yellow, text Navy, radius 8. |

**Display Conditions**: click Publish → Add Condition → **Entire Site**.

#### 2.1.1 Primary menu structure (Appearance → Menus)

Create a menu named `Primary`. Add these items in order. For Getting Started, select the submenu rows and drag-indent them to nest under Getting Started.

- `Home` → page Home
- `Getting Started` → page Getting Started
  - `Microsoft Excel` → **Custom Link**, URL = `#excel-placeholder` (client to supply final URL pre-launch), open in new tab. Per [PLAN.md Open Decision #1](../PLAN.md).
  - `Google Sheets` → resource post (Spreadsheet Integration term)
  - `LibreOffice Calc` → resource post (Spreadsheet Integration term)
  - `ONLYOFFICE Spreadsheet` → resource post (Spreadsheet Integration term)
- `Products` → CPT archive `/products` (or the TS Series single if only one family at launch)
- `Resources` → no parent landing; mark as `#` and add submenu:
  - `Tutorials` → term archive `/resource_type/tutorial`
  - `Use Case` → term archive `/resource_type/use-case`
  - `Industries` → page Industries
  - `Downloads` → page Downloads
- `About` → page About SENSESTICK
- `Contact` → page Contact Us

Save the menu, assign Menu Location → **Primary**.

### 2.2 Footer

Templates → Theme Builder → Footer → **Add New** → name `Site Footer`.

Single container, Navy background, padding 80/40 vertical, 5-column inner section:

| Column | Content |
|---|---|
| 1 | Logo (white variant) + tagline (placeholder until client supplies — see [PLAN.md Open Decision #5](../PLAN.md)) + social icons (YouTube, LinkedIn). |
| 2 | Heading `PRODUCT` (H4, white) + nav link `Temperature Family`. |
| 3 | Heading `RESOURCES` + links `Getting Started`, `User Guide`. |
| 4 | Heading `COMPANY` + links `About`, `Company`. |
| 5 | Heading `GET IN TOUCH` + lines `Locations`, `WhatsApp Call`, `Email Address`. |

Bottom strip: thin white rule + centered copyright `© 2026 SENSESTICK. All rights reserved.`.

Text color throughout: White. Link hover: Yellow. **Display Conditions: Entire Site.**

---

## §3 — Build the Home page in Elementor

WP Admin → Pages → Home → **Edit with Elementor**.

Set page layout: Elementor settings (gear icon, bottom-left) → Page Layout → **Elementor Full Width**. (Do NOT use Elementor Canvas — Canvas hides the Theme Builder header/footer.)

Build the 7 sections below, in order. Each section starts with a fresh top-level Container.

### 3.1 Hero band  → Figma `Home-part1.png` (top)

Container settings:
- Width: Full Width / Content: Boxed (1240).
- Padding: 120 top / 80 bottom desktop; 64 / 48 mobile.
- Background: White.

Inner: 2 columns (50/50). On Tablet, set Direction → Column so it stacks.

**Left column** (vertical center):
1. **Heading** — Tag H1. Dynamic Tags → ACF Field → `hero_h1` (defaults to `Spreadsheet Measurement™`). Color: Navy.
2. **Text Editor** — Dynamic Tags → ACF Field → `hero_subhead`. Typography: Body. Margin top: 16.
3. **Button** — Text: Dynamic → `hero_cta_label`. Link: Dynamic → `hero_cta_link`. Style: Background Navy, Text White, radius 8. Margin top: 32.

**Right column**:
1. **Image** — Dynamic Tags → ACF Image → `hero_image`. Size: Full. Alignment: Right. Add a max width 100% rule on mobile.

### 3.2 Spreadsheet Measurement benefits  → Figma `Home-part1.png` (bottom) → `Home-part2.png` (top)

Container settings:
- Background: Global Color `Panel Grey`.
- Padding: 80 top / 80 bottom desktop; 48 / 48 mobile.

Inner: 2 columns (40/60).

**Left column**:
1. **Heading** — H2, static text `Spreadsheet Measurement`, color Navy.
2. **Text Editor** — static lead `From physical measurements to spreadsheet analysis.` — Body, color Ink Muted.

**Right column** (4 stacked benefit blocks from ACF repeater `benefits`):

Recommended approach — **Loop Grid (Elementor Pro)** bound to the ACF repeater:
1. Insert **Loop Grid** widget → Source: ACF Repeater → Field: `benefits`.
2. Edit the loop item template:
   - Heading (H3) → Dynamic → `title`, color Navy.
   - Text Editor → Dynamic → `body`, color Ink.
3. Layout: 1 column, 4 rows, gap 24.

Fallback if Loop Grid for ACF repeaters is not available — drop 4 **Icon Box** widgets and bind each to a specific repeater index via Dynamic Tags → ACF Repeater → Row 0 / Row 1 / Row 2 / Row 3.

### 3.3 Our Approach + Workflow  → Figma `Home-part2.png` (middle)

Container settings:
- Background: Global Color `Panel Grey`.
- Padding: 80 / 80 desktop.

Inner: 2 columns (45/55).

**Left column**:
1. **Heading** — H2 (static), `Our Approach`, Navy.
2. **Text Editor** — static body that bolds `Spreadsheet Measurement`, `Microsoft® Excel®`, `Google Sheets™`. Copy from Figma frame.

**Right column** — 3 rounded boxes connected by curved navy arrows:
1. Insert an **Inner Section** with 3 columns.
2. Each column: rounded white card (border 1 px `Rule`, radius 10), icon + label centered.
   - Card 1: Sensor icon + label `Sensor`.
   - Card 2: Spreadsheet icon + label `Spreadsheet`.
   - Card 3: Inner 3-icon row (Report, Analysis, Simulation) + label `What You Can Do`.
3. Curved arrows between cards — use SVG arrows uploaded to [assets/](../../assets/) and inserted as Image widgets positioned absolutely between columns. Hide on mobile.
4. Below the inner section, add a centered caption row: heading `Spreadsheet Measurement Workflow` (H4) + tagline `Acquire. Analyze. Act` (Body, Ink Muted).

### 3.4 Demo Video  → Figma `Home-part2.png` (bottom) / `Home-part3.png` (top)

Container settings:
- Background: White.
- Padding: 80 / 80 desktop.
- Content alignment: Center.

Widgets:
1. **Heading** — H2 centered, static `See SENSESTICK in action`, Navy.
2. **Video** widget:
   - Source: Self Hosted or YouTube — set the URL via Dynamic Tags → ACF Field → `demo_video_url`.
   - Aspect Ratio: 16:9.
   - Image Overlay: ON → Dynamic Tags → ACF Image → `demo_video_poster`.
   - Play Icon: ON, color White.
   - Lightbox: **ON** (so click opens a modal player).
   - Max width: 960 px, centered.

### 3.5 Product Overview — "Sensestick Temperature Family"  → Figma `Home-part3.png` (middle)

Container settings:
- Background: White.
- Padding: 80 / 80 desktop.

Inner: 2 columns (50/50).

**Left column**:
1. **Heading** — H2 (static), `Sensestick Temperature Family`, Navy.
2. **Text Editor** — Dynamic Tags → ACF Field → `product_overview_body`, color Ink.
3. **Icon List** — 5 rows (Layout: Inline, 2 per row on tablet, stacked on mobile). Labels — Real Time Monitoring · Spreadsheet Integration · High Accuracy · Easy Setup · Export Ready. Use Elementor's built-in icons (Font Awesome solid: clock, table, crosshairs, plug, file-export) or upload SVGs to [assets/icons/](../../assets/).
4. **Button** — Text `View Product`. Link: Dynamic → `product_overview_cta_link` (target = TS Series single). Style: Background Navy, Text White, radius 8.

**Right column**:
1. **Image** widget — product render (upload to media library and link to it; not currently an ACF field, so it is static).
2. **Inner section** below the image with `Panel Blue Grey` background, radius 10, padding 24:
   - Text Editor: bold `Learn More About Spreadsheet Sensor Devices`.
   - Button: Text `Learn More`, Link → same TS Series URL, outline-navy variant.

### 3.6 Application & Use Cases  → Figma `Home-part3.png` (bottom) / `Home-part4.png` (top)

> **Exactly 5 cards, sourced dynamically from the Industries page's ACF repeater filtered by `featured_on_home == true`.** Do not duplicate Industries content here. See [acf-json/group_page_industries.json](../../wordpress/sensestick-child/acf-json/group_page_industries.json).

Container settings:
- Background: White.
- Padding: 80 / 80 desktop.
- Content alignment: Center.

Widgets:
1. **Heading** — H2 centered, static `Application & Use Cases`, Navy.
2. **Card grid** — built via one of the following, in preference order:

   **Option A — Loop Grid (Elementor Pro) bound to ACF repeater with filter (preferred).** Insert Loop Grid → Source: ACF Repeater → Field: `industries` → Filter: `featured_on_home = true` → Limit: 5. Loop item template:
   - Image (16:9) → Dynamic → `icon` (image field).
   - Heading H3 → Dynamic → `title`, Navy.
   - Text Editor → Dynamic → `body`, Ink Muted, max 2 lines.

   **Option B — coded shortcode helper.** If Loop Grid cannot filter the repeater, add a helper in [inc/helpers.php](../../wordpress/sensestick-child/inc/helpers.php) that registers a shortcode (e.g. `[ss_use_cases limit="5"]`) which queries the Industries page repeater rows where `featured_on_home` is truthy and renders the 5-card grid. Insert via the Elementor Shortcode widget. *(Note: this requires a small code change and is out of scope for the admin-only build path — only fall back to it if Option A fails.)*

   Grid layout: 5 columns desktop, 3 columns tablet, 1 column mobile. Gap 24. Card padding 16.

3. **Button** — Text `View all Use Cases`. Link: `/industries`. Style: Outline (transparent, Navy text, 1 px Navy border, radius 8). Centered, margin top 40.

### 3.7 Final CTA banner  → Figma `Home-part4.png` (bottom)

Container settings:
- Width: Boxed (1240).
- Inner: single column, padding 0.
- Margin bottom: 80.

Inside, a single-column **inner section** with:
- Background: Global Color `Navy`.
- Border radius: 10.
- Padding: 80 vertical, 60 horizontal desktop; 48 / 24 mobile.
- Content alignment: Center.

Widgets:
1. **Heading** — H2 centered, color White. Dynamic Tags → ACF Field → `final_cta_h2` (defaults to `Interested in Spreadsheet Measurement?`).
2. **Text Editor** — centered, color White. Dynamic Tags → ACF Field → `final_cta_subhead`.
3. **Inner section** — 2 columns, horizontally centered, gap 16:
   - Column 1: Button — Text `Book Demo`, Link `/book-a-demo`, background Yellow, text Navy.
   - Column 2: Button — Text `Contact us`, Link `/contact`, transparent fill, White text, 1 px White border (outline-on-navy variant).

On mobile, set the inner section Direction → Column so buttons stack.

Click **Update** in the bottom-left of the Elementor editor.

---

## §4 — Responsive tuning

Open Elementor's Responsive Mode (footer of left panel → device icons) and check each breakpoint. Expected behavior at each width:

| Breakpoint | Hero | Benefits | Approach 3-box | Video | Product Overview | Use Cases grid | Final CTA |
|---|---|---|---|---|---|---|---|
| Desktop 1440 | 2-col | 2-col | 3-box row | 960 max | 2-col | 5 cards | 2 buttons inline |
| Tablet 1024 | 2-col, tighter | 2-col | 3-box row | full container | 2-col | 3 cards | 2 buttons inline |
| Tablet 768 | stacked | stacked | stacked, arrows hidden | full | stacked | 2 cards | stacked |
| Mobile 390 | stacked, H1=32 | stacked | stacked | full | stacked | 1 card | stacked |

Use cases grid alternative: if 5 cards feel too tight at 1440, accept 5 → 3 → 2 → 1 instead of 5 → 3 → 2 → 1 — confirm with the Figma frame.

Verify:
- Hero image never overflows its column.
- Yellow Book Demo button in the header remains visible on mobile (collapses cleanly with the burger menu or stays pinned right).
- No horizontal scroll on any breakpoint.

---

## §5 — Populate ACF on the Home page

WP Admin → Pages → Home → scroll to the **Page — Home** ACF panel below the editor. Fill in:

| Field | Value source |
|---|---|
| `hero_h1` | Defaults to `Spreadsheet Measurement™` — leave or override. |
| `hero_subhead` | `Stream Live Measurement Data Directly Into Spreadsheet Environments` (default). |
| `hero_cta_label` | `View Product` (default). |
| `hero_cta_link` | Permalink of TS Series single (e.g. `/products/ts-series`). |
| `hero_image` | Upload laptop + device render (use [figma/Home.png](../../figma/Home.png) hero region as visual reference for the asset to source/create). |
| `benefits` (repeater × 4) | From Figma copy: *Analyze Data Where It Is Logged* / *Reduce Setup Complexity* / *Avoid Workflow Fragmentation* / *Reduce Manual Data Entry Errors* — title + 2–3 sentence body each. |
| `demo_video_url` | YouTube / Vimeo URL of the product walkthrough video. |
| `demo_video_poster` | Upload office-desk poster image. |
| `product_overview_body` | 3–4 sentence overview of the TS Series family — copy from project brief. |
| `product_overview_cta_link` | Same TS Series permalink as `hero_cta_link`. |
| `final_cta_h2` | Default OK. |
| `final_cta_subhead` | 1–2 sentence subhead (write or pull from Figma `Home-part4.png`). |

**Prerequisite for Use Cases section**: the **Industries** page (`/industries`) must already be published with **at least 5** entries in its `industries[]` repeater, and each of those 5 must have `featured_on_home` ticked. If Industries is not populated yet, the Use Cases grid will render empty. Populate Industries first (see [04-industries.md](04-industries.md) when authored).

Click **Update** on the Home page when done.

---

## §6 — Verification checklist

Do not move on to the next page until every box below is ticked.

- [ ] Visual diff vs [figma/Home.png](../../figma/Home.png) (and the 4 strips) — section order, copy, button styles, color usage all match.
- [ ] Use Cases grid renders **exactly 5 cards** at desktop.
- [ ] Hero `View Product` button is Navy fill, White text, 8 px radius, weight 600.
- [ ] Final CTA banner is Navy with rounded corners; contains Yellow `Book Demo` + outline-on-navy `Contact us`.
- [ ] Header `Book Demo` CTA renders Yellow on White on every viewport.
- [ ] No widget has a hardcoded color — every color setting reads from Global Colors.
- [ ] Editing any ACF field in WP Admin → Home updates the live page without re-opening Elementor.
- [ ] Adding or removing an Industries entry with `featured_on_home == true` changes the Use Cases grid count live (after a cache flush if a cache plugin is active).
- [ ] Lighthouse mobile: Performance ≥ 85, SEO ≥ 95, Accessibility ≥ 95.
- [ ] Real device check — open the page on one iOS device and one Android device; verify scroll, lightbox, and Book Demo CTA.

---

## §7 — Troubleshooting / gotchas

| Symptom | Cause | Fix |
|---|---|---|
| **Page — Home** ACF panel not visible on the Home edit screen | Page template is not `SENSESTICK Home`, OR ACF JSON wasn't synced. | Set Template = `SENSESTICK Home`, Update, refresh. Then go to ACF → Field Groups and click Sync. The location rule is `page_template == page-templates/page-home.php` OR `page_type == front_page`. |
| Dynamic Tags dropdown is greyed out in Elementor | Elementor Pro license is not active. | Elementor → License → reconnect. Dynamic Tags is a Pro-only feature. |
| Changing a Global Color in Site Settings doesn't update existing widgets | Elementor doesn't backfill Global Colors onto widgets created before the color was bound. | Open each widget, re-pick the Global Color swatch (the chain icon next to the color picker). |
| Use Cases grid is empty even though `featured_on_home` is set | Industries page itself isn't published yet, OR the Loop Grid is querying the wrong post. | Confirm Industries is `Published`. In the Loop Grid widget, the ACF Repeater source needs to be told *which post* to read the repeater from — pin it to the Industries page ID, not the current (Home) post. |
| Hero image overflows column on mobile | Image widget Max Width not set. | Image widget → Advanced → Width: 100%, Max Width: 100%. |
| Header / footer not visible on Home | Page Layout was set to `Elementor Canvas` instead of `Elementor Full Width`. | Edit with Elementor → gear icon → Page Layout → Elementor Full Width → Update. |
| Final CTA banner Yellow button looks washed out | `Book Demo` button is using outline style instead of yellow fill. | Re-pick Background: Global Color `Yellow`, Text: Global Color `Navy`. |
