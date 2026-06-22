# Page Build Guides

Click-by-click WordPress + Elementor recipes for each of the 8 user-visible page types defined in [PLAN.md](../PLAN.md). Each guide assumes the Phase 0–2 scaffolding is in place:

- `sensestick-child` theme is active.
- ACF Free is active and the 9 JSON groups under [wordpress/sensestick-child/acf-json/](../../wordpress/sensestick-child/acf-json/) have been synced.
- Canonical pages have been auto-seeded by [inc/seed-pages.php](../../wordpress/sensestick-child/inc/seed-pages.php).
- Elementor + Elementor Pro are active and licensed.

These guides describe **admin actions only** (where to click in WordPress and Elementor, which ACF fields to fill, which dynamic tags to bind). They do not duplicate the data model, component spec, or brand tokens — those live in [PLAN.md](../PLAN.md) and the child theme code.

## Build order

| # | Guide | Page | Figma frame(s) | Template |
|---|---|---|---|---|
| 01 | [01-home.md](01-home.md) | Home | `Home.png` / `Home-part1..4.png` | `page-home.php` |
| 02 | [02-getting-started.md](02-getting-started.md) | Getting Started hub | `Getting-Started.png` | `page-getting-started.php` |
| 03 | [03-products-ts-series.md](03-products-ts-series.md) | TS Series single (Product Family CPT) | `Product-Family-Single.png` | Theme Builder single |
| 04 | [04-industries.md](04-industries.md) | Industries | `Industries.png` | `page-industries.php` |
| 05 | [05-downloads.md](05-downloads.md) | Downloads | `Downloads.png` | `page-downloads.php` |
| 06 | [06-about.md](06-about.md) | About SENSESTICK | `About.png` | `page-about.php` |
| 07 | [07-contact.md](07-contact.md) | Contact Us | `Contact.png` | `page-contact.php` |
| 08 | [08-book-a-demo.md](08-book-a-demo.md) | Book a Demo | `Book-Demo.png` | `page-book-demo.php` |

Resource singles (Tutorials / Use Cases / User Guides / Spreadsheet Integrations) and Resource archive listings are covered by Theme Builder templates shared across the `resource` CPT — separate guides for those will be added once the static pages above are validated against the live site.

## Conventions used in every guide

- **Click paths** are shown as `WP Admin → Pages → Home → Edit with Elementor`.
- **Dynamic ACF bindings** are noted inline as `Dynamic Tags → ACF Field → field_name`.
- **Brand tokens** are always referenced by name (Global Color `Navy`, Global Color `Yellow`) — never hardcoded hex.
- **Figma reference frames** are linked at the top of each guide and again at the start of every section.
- **Verification checkpoints** appear at the end of every guide; do not move on to the next page until all boxes are ticked.
