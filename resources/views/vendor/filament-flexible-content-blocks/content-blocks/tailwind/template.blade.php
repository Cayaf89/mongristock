@if($template)
    <div class="py-12">
        <div class="container max-w-screen-lg">
            @include($template, ['record' => $record])
        </div>
    </div>
@endif
