@php $festival = \App\Models\SystemConfiguration::current(); @endphp
<x-layouts.app :title="__('Inscrições') . ' - ' . ($festival?->festival_name ?? '')">
    <livewire:site.registration-form />
</x-layouts.app>
