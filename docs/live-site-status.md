# Verified live-site status

Last verified: 2026-08-21

## WordPress channel

- Live content and SEO metadata: WordPress REST API
- Interactive fallback: WordPress admin only when a plugin has no REST endpoint
- cPanel: out of scope
- Production deployment from this repository: not connected

## Analytics

- Google Ads base tag: `AW-3440129958`
- GA4 measurement: `G-Z022CNN220`
- Booking conversion page: `/rezervacija/`
- Booking conversion event: configured through an active WPCode snippet

Public HTML verification confirms one GA4 configuration per page, the Ads base tag, and the booking conversion event on `/rezervacija/`.

## SEO

- `/rezervacija/` is `noindex, follow` and excluded from the page sitemap.
- `/vauceri/`, `/potraga-za-blagom/`, and `/kutija-izgubljenih-legendi/` have explicit Serbian SEO titles.
- `/category/saveti-i-ideje/` returns HTTP 200 and is listed in the category sitemap.
- `/sta-je-escape-room-vodic-za-pocetnike/` returns HTTP 200 and is listed in the post sitemap.
- The obsolete `7 igrača - 7.500 RSD` price was removed from the birthday page and both active FAQ schemas; a full published-content and WPCode scan is clean.
- Seven legacy English duplicate URLs now return exact 301 redirects to their canonical `/en/` pages and are removed from the page sitemap.
- All 26 indexed pages pass the automated check for HTTP 200, SEO title, meta description, canonical URL, and exactly one H1.

## Performance cleanup

- Disabled the redundant delayed Trustindex loader; the official plugin loader remains active.
- Disabled the ineffective legacy Trustindex shortcode helper.
- Fresh public HTML contains one official loader and no legacy helper code.

Do not place passwords, application passwords, cookies, database exports, or private customer data in this repository.
