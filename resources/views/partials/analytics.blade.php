{{-- Google Analytics & Search Console Integration --}}
@if(\App\Models\Setting::get('google_analytics_id'))
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ \App\Models\Setting::get('google_analytics_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ \App\Models\Setting::get('google_analytics_id') }}');
</script>
@endif

@if(\App\Models\Setting::get('google_search_console_code'))
<meta name="google-site-verification" content="{{ \App\Models\Setting::get('google_search_console_code') }}" />
@endif
