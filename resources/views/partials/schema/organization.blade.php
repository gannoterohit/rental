{{-- Organization Schema for Homepage and All Pages --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ \App\Models\Setting::get('website_name', 'RoomRental') }}",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('storage/' . \App\Models\Setting::get('website_logo')) }}",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "{{ \App\Models\Setting::get('contact_phone') }}",
    "email": "{{ \App\Models\Setting::get('contact_email') }}",
    "contactType": "Customer Service"
  },
  "sameAs": []
}
</script>
