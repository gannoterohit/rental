SEO Setup for RoomRental
=======================

What I implemented
- Central SEO partial: `resources/views/partials/seo.blade.php` (canonical, OG, Twitter, sitemap link)
- Homepage JSON-LD: `resources/views/partials/home-ld.blade.php` (WebSite + SearchAction)
- Room page JSON-LD (safe): pushed via `@push('head')` in `resources/views/rooms/show.blade.php`
- Listings JSON-LD: `resources/views/partials/listings-ld.blade.php` (ItemList), included in `rooms/index`
- Plans JSON-LD: `resources/views/partials/plans-ld.blade.php` (OfferCatalog), included in `plans/index`
- Sitemap:
  - Dynamic route `/sitemap.xml` via `SitemapController` (returns XML)
  - Artisan command `php artisan sitemap:generate` writes `public/sitemap.xml`
  - `app/Console/Kernel.php` registers and schedules sitemap generation daily at 02:00
- `public/robots.txt` references the sitemap (already present)

How to regenerate sitemap manually

Open a terminal in project root and run:
```powershell
cd C:\xampp\htdocs\roomrental
php artisan sitemap:generate
```

Production recommendation (cron)
- Ensure `APP_URL` in `.env` is set to your production URL (not localhost).
- Add Laravel scheduler to server cron (Linux example):
```
* * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1
```
This will run scheduled tasks (including sitemap generation) per the schedule defined in `app/Console/Kernel.php`.

SEO checklist (quick)
- Ensure each page sets `@section('title')` and `@section('description')` (templates already do for main pages).
- Provide `og_image` where possible (the SEO partial uses site logo by default).
- Ensure images have meaningful `alt` attributes (existing templates mostly set `alt` to room title).
- Robots: confirm `public/robots.txt` allows crawling of necessary pages and points to sitemap.
- Submit sitemap URL to Google Search Console and Bing Webmaster Tools.

Monitoring & next steps
- Add Google Analytics / GA4 measurement ID to Admin Settings and include the tracking snippet in `layouts.app` (can be dynamic).
- Add canonical tags for paginated listings (append `?page=` handling).
- Add hreflang if you plan multi-language support.
- Consider adding structured data for breadcrumbs and organization/company if applicable.

If you want, I can:
- Add GA4 snippet and admin settings (dynamic)
- Generate JSON-LD for more page types (breadcrumbs, organization)
- Run a simple audit to list pages missing meta/alt text
