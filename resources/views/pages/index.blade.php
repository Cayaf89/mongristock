@php
    /* @var \App\Models\Page $page */
@endphp

<x-base-layout title="{{ $page->title }}" wide="true">
    <x-flexible-hero :page="$page" />

    <div class="prose content">
        <x-flexible-content-blocks :page="$page"/>
    </div>
</x-base-layout>
