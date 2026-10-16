<x-layout.app>
    <x-navbar />
    <x-hero />
    <x-product-catalog :produks="$produks ?? null" :kategoris="$kategoris ?? null" />
    <x-product-modal />
    <x-about />
    <x-contact />
</x-layout.app>
