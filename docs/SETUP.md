# SENSESTICK Website — Setup Guide

> **Audience**: You (the operator). This is the one-pager that tells you what to do with the files in this repo to get the site live on Hostinger.
>
> **Source of truth for design**: [docs/PLAN.md](PLAN.md) + `figma/*.png`.
> **Source of truth for theme code**: this repo's `wordpress/sensestick-child/` folder.
> **Deploy target**: Hostinger shared hosting (direct, no LocalWP).

---

## Repo layout (what each folder is for)

```
Senstick/
├── docs/
│   ├── PLAN.md              ← THE build plan (always reflects latest decisions)
│   ├── SETUP.md             ← THIS file (operator steps)
│   ├── project-brief.pdf    ← Client brief (gitignored, keep locally)
│   └── TS-Series-datasheet.pdf  ← Product datasheet (gitignored)
├── figma/
│   ├── *.png                ← 20 Figma frame exports (gitignored)
│   └── website-wireframes.pdf  ← Historical low-fi (gitignored)
├── wordpress/
│   └── sensestick-child/    ← Hello Elementor child theme. UPLOAD THIS TO WORDPRESS.
│       ├── style.css
│       ├── functions.php
│       ├── inc/             ← CPTs, taxonomies, theme setup
│       └── acf-json/        ← 6 ACF field group definitions
├── content/                 ← Drafted page copy (to be filled)
├── assets/                  ← Brand assets, logos, exports for upload
├── qa/                      ← QA notes / screenshots
├── README.md
└── BUSINESS_PLAN.md         ← Freelance project notes (gitignored or repo-private)
```

---

## Phase 1 — Hostinger + WordPress (do these in order)

### 1.1  Buy + configure hosting

1. Sign up for **Hostinger Business Web Hosting** (Single plan is too tight on resources; Premium also works).
2. Register or connect your domain (e.g. `sensestick.com`) inside hPanel.
3. Wait for the free **SSL certificate** to show **Active** in hPanel → SSL. This takes a few minutes after DNS resolves.

### 1.2  Install WordPress

In hPanel → **Websites → Auto Installer → WordPress**:

- **Site title**: `SENSESTICK`
- **Admin username**: anything except `admin` (e.g. `senstick-admin`)
- **Admin password**: long random, store in a password manager
- **Admin email**: your address (transfer to client later)
- **Language**: English
- **WordPress version**: latest stable

After install, log in at `https://yourdomain.com/wp-admin/`.

### 1.3  Initial WP hygiene (5 minutes, do once)

In WP Admin:

- **Settings → General** — confirm both site URLs use `https://`.
- **Settings → Permalinks** — set to **Post name**.
- **Settings → Reading** — tick **Discourage search engines from indexing** (turn it back OFF only at launch).
- **Settings → Discussion** — untick **Allow people to submit comments on new posts**.
- **Users → Profile** — set Display name publicly to something other than your login username.
- **Posts** — delete the "Hello world!" sample post.
- **Pages** — delete the "Sample Page".
- **Plugins** — delete pre-installed dummy plugins (e.g. Akismet preview, Hello Dolly). **Keep** Hostinger's LiteSpeed Cache.

---

## Phase 2 — Upload the child theme

### 2.1  Install the parent theme

WP Admin → **Appearance → Themes → Add New** → search **Hello Elementor** → Install (do NOT activate yet).

### 2.2  Upload the child theme — pick one method

#### Option A — Zip upload (one-shot)

1. On your laptop, zip the folder `wordpress/sensestick-child/`. The zip must contain the folder itself, e.g. `sensestick-child.zip` → `sensestick-child/style.css`.
   - In Windows Explorer: right-click the `sensestick-child` folder → **Send to → Compressed (zipped) folder**.
2. WP Admin → **Appearance → Themes → Add New → Upload Theme** → choose zip → Install Now.
3. Click **Activate**.

After activation:

- ✅ 3 new admin menus appear in the sidebar: **Product Families**, **Resources**, **Downloads**.
- ✅ Canonical taxonomy terms are auto-seeded (Tutorial, Use Case, User Guide, Spreadsheet Integration, Installation Guide, etc.). Check at **Resources → Resource Types** and **Downloads → Categories** / **Types**.
- ✅ Image sizes and nav menu locations (`primary`, `footer`) are registered.

#### Option B — SFTP sync (recommended for ongoing dev)

This keeps your laptop repo as source of truth and lets you push code changes without re-zipping.

1. hPanel → **Advanced → FTP Accounts** → create one. Note **host**, **port 22** (SFTP), **username**, **password**.
2. Install **WinSCP** (or FileZilla, or the VS Code "SFTP" extension by Natizyskunk).
3. Connect over **SFTP** (never plain FTP):
   - Local: `C:\ByteBrain\Senstick\wordpress\sensestick-child\`
   - Remote: `/public_html/wp-content/themes/sensestick-child/`
4. Upload the whole folder once.
5. Activate the theme in WP Admin → Appearance → Themes.
6. For future edits: enable **upload-on-save** in your SFTP client so changes in VS Code sync immediately.

### 2.3  Activate the child theme

WP Admin → **Appearance → Themes** → hover **SENSESTICK Child** → **Activate**.

---

## Phase 3 — Plugins (install in this order)

WP Admin → **Plugins → Add New**, then search + install + activate:

| # | Plugin | Why | Cost |
|---|---|---|---|
| 1 | **Elementor** | Page builder. | Free |
| 2 | **Elementor Pro** | Theme Builder for CPT singles + archives, dynamic content. Upload as zip after purchase. | ~€59/yr |
| 3 | **Advanced Custom Fields** (ACF, free) | Loads the 6 field groups from `acf-json/` automatically. | Free |
| 4 | **WPForms Lite** *(or Fluent Forms)* | Contact page form. | Free |
| 5 | **Rank Math SEO** | Sitemap, schema, meta tags. | Free |
| 6 | **WPCode Lite** | Paste Calendly + analytics snippets without editing PHP. | Free |
| 7 | **UpdraftPlus** | Off-site backups (point at Google Drive / Dropbox). | Free |
| 8 | **ShortPixel** *or* **Smush** | Image compression. | Free tier |

Do NOT install:

- ❌ A second cache plugin. LiteSpeed Cache (pre-installed by Hostinger) is enough; doubling up causes conflicts.
- ❌ Jetpack (heavy, redundant with the stack above).
- ❌ CPT UI **unless** you want a UI to tweak CPT labels. The CPTs are already registered in the child theme code.

### 3.1  Sync ACF field groups

After ACF Free is activated:

1. Go to **ACF → Field Groups**. A yellow notice **"Sync available"** appears with 6 groups.
2. Tick **Bulk select** → **Sync changes**.
3. Confirm all 6 groups now show in the list:
   - Product Family
   - Resource — Article
   - Resource — Spreadsheet Integration (conditional)
   - Download
   - Page: Industries
   - Page: Downloads

From this point on, ACF reads + writes JSON back to `wordpress/sensestick-child/acf-json/` whenever you edit a field group in WP Admin. Pull those changes back to your laptop via SFTP so your repo stays in sync.

---

## Phase 4 — Mirror brand tokens in Elementor

The child theme's `style.css` defines CSS variables like `--ss-navy: #000064` and `--ss-font-sans: 'Inter'`. **Elementor doesn't read those automatically** — you have to mirror them in Site Settings once. They become the source of truth Elementor widgets pull from. Do all four sub-sections below in one sitting; values come from [PLAN.md → Brand & global styles](PLAN.md#brand--global-styles-locked-from-figma) and must not drift from `style.css`.

Open the Elementor editor on any page, then top-left **hamburger menu → Site Settings**.

### 4.1  Global Colors

Delete the 4 default colors, then click **+ Add Color** for each row:

| Token name | Hex | Use in Elementor |
|---|---|---|
| Navy | `#000064` | Primary color |
| Yellow | `#FFFF00` | Accent color |
| White | `#FFFFFF` | Section bg |
| Ink | `#111111` | Text |
| Ink Muted | `#6B7280` | Caption / metadata |
| Panel Grey | `#F5F7FA` | Section bg |
| Panel Blue Grey | `#E8EDF3` | About philosophy panel |
| Rule | `#E5E7EB` | Dividers |

### 4.2  Global Fonts

Font family is locked to **Inter** (Google Fonts; loaded automatically by Elementor on first save). Set the 4 typography presets:

| Preset | Family | Weight | Use |
|---|---|---|---|
| Primary | Inter | 700 | Headings (H1–H2) |
| Secondary | Inter | 600 | H3–H4 |
| Text | Inter | 400 | Body |
| Accent | Inter | 600 | Buttons, badges |

Then **Theme Style → Typography**, set sizes:

| Element | px | Weight | Line-height |
|---|---|---|---|
| H1 | 40 | 700 | 1.15 |
| H2 | 32 | 700 | 1.2 |
| H3 | 24 | 600 | 1.25 |
| H4 | 20 | 600 | 1.3 |
| Body | 16 | 400 | 1.6 |

### 4.3  Buttons

**Theme Style → Buttons** (these match `.ss-btn` in [style.css](../wordpress/sensestick-child/style.css)):

- **Typography**: size 16, weight 600, line-height 1.
- **Padding**: top/bottom `12`, left/right `24`.
- **Border radius**: `8` px (apply to all corners).
- **Background**: Navy global color.
- **Text color**: White.
- **Hover background**: `#00004a`.
- **Hover text**: White.

*(The yellow `Book Demo` button and outline variants are added as Elementor button widget presets per-page; you don't set them globally.)*

### 4.4  Layout

- **Container Width**: `1240` px.
- **Widgets default padding**: `0`.
- **Page Title selector**: off (templates render their own hero).
- **Breakpoints**: mobile `<768`, tablet `768–1024`, desktop `>1024` (defaults match — leave alone).

Click **Save Changes**. Open any page on the front-end + DevTools → Computed → `font-family` to confirm Inter loaded.

---

## Phase 5 — Seed content + build pages

Content seeding (CPT entries + ACF panels on static pages + primary menu) is now a **guided click-by-click walkthrough** in the build plan. Do it in this order:

1. **Create the empty Pages** first — WP Admin → **Pages → Add New** for each: Home, About, Contact Us, Book a Demo, Industries, Downloads, Getting Started (and optionally a Products landing page). Leave them blank; ACF / Elementor will fill them.
2. **Set Home as the static homepage** — Settings → Reading → *A static page* → Homepage = Home.
3. **Follow [PLAN.md → Phase 5](PLAN.md#phase-5--content-seeding-guided-walkthrough--placeholder-content-first)** step-by-step:
   - 5.0 Glossary (read first if "CPT" / "ACF" / "Taxonomy" are unfamiliar).
   - 5.1 Pre-flight check.
   - 5.2 Seed the 6 placeholder **Downloads**.
   - 5.3 Seed the **Product Family** (TS Series, full ACF).
   - 5.4 Seed the 6 placeholder **Resources** (1 Tutorial / 1 Use Case / 1 User Guide / 3 Spreadsheet Integrations).
   - 5.5 Fill the **Industries** + **Downloads** static pages via ACF.
   - 5.6 Build the **Primary menu**.
   - 5.7 Exit criteria.
4. **Build the 11 Elementor templates** per [PLAN.md → Phase 4](PLAN.md#phase-4--templates-11-effective-8-user-visible-page-types). Each template binds to either a Page or a CPT via Elementor Pro Theme Builder. Templates and content can be built in either order — if you build content first (per step 3), every template has real data to bind to as you go.

Placeholder content (Lorem + dummy PDF + Unsplash images) is fine for Phase 5 sign-off. Real client copy + real PDFs + ONLYOFFICE copy fixes + footer tagline are tracked in [PLAN.md → 5.8 Deferred](PLAN.md#58-deferred-to-a-later-content-swap-pass-not-a-phase-5-blocker).

---

## Phase 6 — Book a Demo (Calendly)

1. Create a free [Calendly](https://calendly.com) account.
2. Create a **30-minute Demo** event type. Set timezone, availability, buffer.
3. Copy the embed code (Inline option).
4. On the Book a Demo page in Elementor, drop an **HTML widget** and paste the embed.
5. Test from an incognito browser: pick a slot, confirm a calendar invite arrives.

---

## Phase 7 — Pre-launch checklist

- [ ] **Settings → Reading** → uncheck "Discourage search engines".
- [ ] All template links resolve (no 404s). Check primary nav + footer + every CTA.
- [ ] Contact form submission delivers email; success state visible.
- [ ] Calendly slot booking actually creates a calendar invite.
- [ ] Verify on real devices: 1 iOS, 1 Android, Chrome + Edge + Firefox + Safari desktop.
- [ ] Lighthouse mobile ≥ 85 perf, ≥ 95 SEO + Accessibility, 0 console errors.
- [ ] Yellow `#FFFF00` only ever sits on navy. Never on white. Never as body text.
- [ ] UpdraftPlus scheduled (weekly), one off-site backup verified by test-restore.
- [ ] Rank Math sitemap submitted to Google Search Console.
- [ ] hPanel → SSL still Active. Force HTTPS redirect ON.
- [ ] Replace placeholder Excel URL with client-supplied final URL.
- [ ] Replace footer Lorem ipsum tagline + phone number with real values.
- [ ] Rewrite ONLYOFFICE page copy (Figma currently has LibreOffice / Excel references).

---

## Editing workflow after launch

### When you change theme code (PHP / CSS)

1. Edit in VS Code on your laptop under `wordpress/sensestick-child/`.
2. Save → SFTP upload-on-save pushes the change to `/public_html/wp-content/themes/sensestick-child/`.
3. Refresh the site. Hard-reload if CSS caches (`Ctrl+F5`).
4. Commit + push:

   ```powershell
   cd C:\ByteBrain\Senstick
   git add wordpress/sensestick-child/
   git commit -m "<your message>"
   git push origin main
   ```

### When you change an ACF field group in WP admin

1. ACF writes a JSON file into `acf-json/` on the live server.
2. Pull that file back via SFTP into your laptop repo so it's not lost.
3. Commit + push.

### When you want to roll back

1. UpdraftPlus → Restore from latest backup (full site).
2. Or `git revert <commit>` + SFTP upload the previous file versions.

---

## Common questions

**Q: Do I need to install Local WP?**
No. The child theme code is in this repo. You upload it directly to Hostinger via zip (one-shot) or SFTP (ongoing). Skipping LocalWP saves setup time. The tradeoff: you edit against the live site, so be careful with destructive changes — keep UpdraftPlus current.

**Q: Why are CPTs in PHP code instead of CPT UI?**
Portability + version control. If you ever migrate to a new host or hand the site off, the CPTs travel with the theme rather than living in the WP database. CPT UI is optional and only useful if a non-developer wants to tweak labels later.

**Q: Why mirror brand tokens in Elementor when they're already in style.css?**
Elementor's UI references its own Site Settings — it doesn't read CSS variables. Without the mirror, designers using the Elementor builder won't see the navy/yellow swatches in dropdowns. The CSS in `style.css` is the fallback for non-Elementor markup (admin previews, classic widgets, etc.).

**Q: Where do PDFs go?**
Upload each one as a **Download** CPT post (WP Admin → Downloads → Add New). Attach the file in the ACF `file` field, set its category + type taxonomies, and link it to the associated Product Family. The Downloads page + Product Family page both pull from this single source.

**Q: How do I onboard the client to manage content?**
After launch, write a 1–2 page CMS guide covering: create tutorial, create use case, create user guide, create integration page, upload a PDF, swap a product image, swap an industry card, edit menu. This is the deliverable in [PLAN.md → Phase 6](PLAN.md#phase-6--qa--handoff).

---

## Quick reference — file → purpose

| File / folder | What you do with it |
|---|---|
| `wordpress/sensestick-child/style.css` | Edit to change brand tokens. Mirror changes in Elementor Site Settings. |
| `wordpress/sensestick-child/functions.php` | Add custom shortcodes, enqueue extra assets. Rarely touched. |
| `wordpress/sensestick-child/inc/cpts.php` | Edit if you add a new CPT (e.g. `case_study`) or change slugs. |
| `wordpress/sensestick-child/inc/taxonomies.php` | Edit to add new taxonomy terms (then re-activate theme to seed). |
| `wordpress/sensestick-child/inc/theme-setup.php` | Edit to add new image sizes or menu locations. |
| `wordpress/sensestick-child/acf-json/*.json` | Auto-written by ACF when you edit a field group. Pull via SFTP to keep repo in sync. |
| `docs/PLAN.md` | Read before building each template. Update when decisions change. |
| `figma/*.png` | Visual reference per template. Open the matching file when building. |
| `content/` | Stage Markdown drafts of page copy before pasting into Elementor. |
| `assets/` | Brand assets ready for upload to Media Library. |
| `qa/` | Screenshots, Lighthouse reports, QA notes. |

---

## You are currently here

✅ Repo scaffolded, child theme written, plan documented, all pushed to GitHub.
🔜 **Next step**: Phase 1 above (buy Hostinger plan + register domain).
