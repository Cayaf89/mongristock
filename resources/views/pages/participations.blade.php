<x-base-layout title="Participer à Mongristock" wide="true">
    <div
        class="relative overflow-hidden w-full min-h-[192px] bg-center bg-cover py-10 sm:h-[380px] before:bg-black/40 before:z-10 before:absolute before:inset-0 hero">
        <div class="container max-w-screen-lg h-full px-4 mx-auto">
            <div class="relative z-10 flex flex-col justify-center h-full grow text-center">
                <h1 class="text-3xl font-bold tracking-tight hero__title text-white drop-shadow md:text-4xl mb-4">
                    Participer à Mongristock
                </h1>

                <div
                    class="max-w-4xl font-light text-white drop-shadow hero__intro [&_a]:underline hover:[&_a]:no-underline">
                    Afin de simplifier l'organisation de l'évènement, renseignez votre nom et prénom, le nombre de
                    participant de votre groupe (si vous venez à plusieurs) et le ou les jours ou vous serez présent.
                </div>
            </div>
        </div>
        @if($hasHeroImage())
            <div class="absolute inset-0 w-full h-full">
                {{$getHeroImageMedia(null, [
                    'class' => 'absolute inse-0 w-full h-full object-cover hero__image',
                    'loading' => 'lazy',
                ])}}
                @if($heroImageCopyright)
                    <span class="absolute bottom-0 right-0 px-2 py-1 text-sm text-white bg-black/30 hero__copyright">&copy; {{ Statikbe\FilamentFlexibleContentBlocks\FilamentFlexibleContentBlocks::replaceParameters($heroImageCopyright) }}</span>
                @endif
            </div>
        @endif
    </div>


    <div class="prose content">
        <x-flexible-content-blocks :page="$page"/>
    </div>
</x-base-layout>
