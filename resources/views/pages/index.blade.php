@php
    /* @var \App\Models\Page $page */
@endphp
@extends('layouts.base')

@section('content')
    <x-flexible-hero :page="$page"/>

    <div class="prose md:!max-w-5xl mx-auto mt-12">
        {!! tiptap_converter()->asHTML($page->content) !!}
    </div>
@endsection
