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

The child theme's `style.css` defines CSS variables like `--ss-navy: #000064`. **Elementor doesn't read those automatically** — you have to mirror them in Site Settings once. They become the source of truth Elementor widgets pull from.

WP Admin → **Elementor → Site Settings → Global Colors**:

| Token name | Hex | Use in Elementor |
|---|---|---|
| Navy | `#000064` | Primary color |
| Yellow | `#FFFF00` | Accent color |
| Ink | `#111111` | Text |
| Ink Muted | `#6B7280` | Caption / metadata |
| Panel Grey | `#F5F7FA` | Section bg |
| Panel Blue Grey | `#E8EDF3` | About philosophy panel |
| Rule | `#E5E7EB` | Dividers |

**Global Fonts** — primary `Inter` (or `Source Sans 3`), set sizes per the brand-token table in [PLAN.md](PLAN.md#typography).

**Site Settings → Buttons** — border radius **8 px**, padding per spec.

**Site Settings → Layout** — container max width **1240 px**, breakpoints mobile <768 / tablet 768–1024 / desktop >1024.

---

## Phase 5 — Build pages (Elementor)

Pages to create in WP Admin → **Pages → Add New**:

- Home (set as static homepage in **Settings → Reading**)
- About
- Contact Us
- Book a Demo
- Industries
- Downloads
- Getting Started

Plus CPT entries:

- 1 **Product Family** post (TS Series) at **Product Families → Add New**.
- 3 **Resource** posts with taxonomy `Spreadsheet Integration`: Google Sheets, LibreOffice Calc, ONLYOFFICE Spreadsheet.
- 1+ **Resource** post each for Tutorial, Use Case, User Guide (to populate listings).
- All file PDFs as **Download** posts.

Then build the 11 Elementor templates per [PLAN.md → Phase 4](PLAN.md#phase-4--templates-11-effective-8-user-visible-page-types). Each template binds to either a Page or a CPT via Theme Builder.

### Menu construction

WP Admin → **Appearance → Menus** → create `Primary Menu`:

- Home
- Getting Started ▾
  - Microsoft Excel → **Custom Link** (client-supplied external URL placeholder)
  - Google Sheets → Resource post
  - LibreOffice Calc → Resource post
  - ONLYOFFICE Spreadsheet → Resource post
- Products ▾
  - TS Series → Product Family post
- Resources ▾
  - Tutorials → category archive `/resource-type/tutorial/`
  - Use Case → `/resource-type/use-case/`
  - Industries → Industries page
  - Downloads → Downloads page
- About
- Contact

Assign location: **Primary**.

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
