@php
    $offers = [];
    if (isset($listingPlans)) {
        foreach($listingPlans as $plan) {
            $offers[] = [
                '@type' => 'Offer',
                'name' => $plan->name,
                'price' => (string) $plan->price,
                'priceCurrency' => 'INR',
                'url' => route('plans')
            ];
        }
    }
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'OfferCatalog',
        'name' => 'Subscription Plans',
        'itemListElement' => $offers
    ];
@endphp
<script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
