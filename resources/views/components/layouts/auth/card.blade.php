@php
   $config = $systemConfig ?? \App\Models\SystemConfiguration::current();
   $festival = $config?->festival_name ?? config('app.name');
   $logo = $config?->logo_url ?? asset('logo-vds-2025-colorido.jpg');
@endphp


@php
    $config = \App\Models\SystemConfiguration::current();
    $primaryColor = $config?->primary_color ?? '#800040';
    $secondaryColor = $config?->secondary_color ?? '#ffffff';
    $tertiaryColor = $config?->tertiary_color ?? '#500028';
    $textColor = $config?->text_color ?? '#333333';
    $buttonColor = $config?->button_color ?? '#e91e63';
    $buttonTextColor = $config?->button_text_color ?? '#ffffff';
@endphp

    

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-theme="light">
    <head>  
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased light "  style="--primary-color: {{ $primaryColor }}; 
            --secondary-color: {{ $secondaryColor }}; 
            --tertiary-color: {{ $tertiaryColor }}; 
            --text-color: {{ $textColor }}; 
            --button-color: {{ $buttonColor }}; 
            --button-text-color: {{ $buttonTextColor }};">
        <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                  <img src="{{ $logo }}" class="max-w-64" alt="{{ $festival }}">
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    <div class="rounded-xl border bg-white text-stone-800 shadow-xs">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
