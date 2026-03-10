@php
   $config = $systemConfig ?? \App\Models\SystemConfiguration::current();
   $festival = $config?->festival_name ?? config('app.name');
   $logo = $config?->logo_url ?? asset('logo-vds-2025-colorido.jpg');
@endphp

<div class="flex w-63 items-center justify-center">
    <img src="{{ $logo }}" class="max-w-64" alt="{{ $festival }}">
</div> 
