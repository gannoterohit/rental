@php
    $items = [];
    foreach($rooms->take(10) as $idx => $r) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $idx + 1,
            'url' => route('rooms.show', $r),
            'name' => $r->title ?? ''
        ];
    }
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => $items
    ];
@endphp
<script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
