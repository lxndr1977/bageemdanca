@php
    $config = \App\Models\SystemConfiguration::current();
    $primaryColor = $config?->primary_color ?? '#800040';
    $secondaryColor = $config?->secondary_color ?? '#ffffff';
    $tertiaryColor = $config?->tertiary_color ?? '#500028';
    $textColor = $config?->text_color ?? '#333333';
    $buttonColor = $config?->button_color ?? '#e91e63';
    $buttonTextColor = $config?->button_text_color ?? '#ffffff';
@endphp

<div class="flex flex-col md:flex-row min-h-screen overflow-y lg:overflow-hidden"
     style="--primary-color: {{ $primaryColor }}; 
            --secondary-color: {{ $secondaryColor }}; 
            --tertiary-color: {{ $tertiaryColor }}; 
            --text-color: {{ $textColor }}; 
            --button-color: {{ $buttonColor }}; 
            --button-text-color: {{ $buttonTextColor }};">

    @include('livewire.site.partials.registration-form-sidebar')

    @include('livewire.site.partials.registration-form-content')

    <livewire:settings.profile />
  
   <livewire:settings.password />
   
</div>
