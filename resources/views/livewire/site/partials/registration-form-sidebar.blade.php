<div
   class="sidebar w-full md:w-80 xl:w-94 flex-shrink-0 h-auto lg:h-screen md:flex md:flex-col md:justify-between"
   style="background-color: var(--primary-color);">
   <div class="p-6">
      <div class=" md:block mb-6">
         <div class="md:h-10 xl:h-16 flex justify-center md:justify-start">
            <img src="{{ $systemConfig?->logo_url ?? asset('images/logo-vds-2025.png') }}"
               alt="{{ $systemConfig?->festival_name ?? config('app.name') }}" width="900" height="156"
               class="max-h-10 xl:max-h-10 w-auto">
         </div>
      </div>

      <h1 class="text-white text-sm font-bold mb-4 text-center md:text-start md:block mb-6 xl:mb-8">{{ $systemConfig?->festival_name ?? config('app.name') }}
      </h1>

      <div class="flex flex-row justify-around md:flex-col space-y-1 xl:space-y-8 text-white">

         @if ($registrationsOpenToPublic && $registration?->isDraft())
            @foreach ($this->steps as $stepNumber => $stepLabel)
            <div
               class="flex items-center space-x-0 md:space-x-3 p-0 md:p-2 rounded-lg hover:cursor-pointer transition-colors"
               style="{{ $currentStep == $stepNumber ? 'background-color: var(--tertiary-color);' : '' }}"
               onmouseover="this.style.backgroundColor='var(--tertiary-color)'"
               onmouseout="this.style.backgroundColor='{{ $currentStep == $stepNumber ? 'var(--tertiary-color)' : 'transparent' }}'"
               data-step="{{ $stepNumber }}" wire:click="goToStep({{ $stepNumber }})">
               <div
                  class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2 border-transparent {{ $isFinished && $stepNumber < $totalSteps ? 'opacity-50' : 'opacity-100' }}"
                  style="background-color: {{ $currentStep >= $stepNumber ? 'var(--button-color)' : 'rgba(255,255,255,0.1)' }}; color: var(--button-text-color);">
                  {{ $stepNumber }}
               </div>
               <span class="font-medium hidden md:inline text-sm xl:text-base">{{ $stepLabel }}</span>
            </div>
            @endforeach
         @elseif ($registration?->isFinished())
            <div
               class="flex items-center space-x-0 md:space-x-3 p-0 md:p-2 rounded-lg hover:cursor-pointer transition-colors"
               style="background-color: var(--tertiary-color);"
               onmouseover="this.style.backgroundColor='var(--tertiary-color)'"
               onmouseout="this.style.backgroundColor='var(--tertiary-color)'"
               wire:click="goToStep({{ count($this->steps) }})">
               <div
                  class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold border-2 border-transparent opacity-100"
                  style="background-color: var(--button-color); color: var(--button-text-color);">
                  <x-mary-icon name="o-check" class="w-5 h-5" />
               </div>
               <span class="font-medium hidden md:inline text-sm xl:text-base">Ficha de inscrição</span>
            </div>
         @endif
      </div>
   </div>

   <div class="p-6 hidden md:block mt-auto"> 
      <div class="rounded-lg px-2 py-2 flex items-center justify-between" style="background-color: var(--tertiary-color);">
         <div class="flex items-center">
            <x-mary-dropdown>
               <x-slot:trigger>
                  <x-mary-button icon="o-user" class="btn-circle btn-sm mr-2" style="background-color: var(--button-color); color: var(--button-text-color); border: none;" />
               </x-slot:trigger>

               <x-mary-menu-item title="Editar Perfil" @click="$dispatch('openUserModalProfile')" />
               <x-mary-menu-item title="Alterar Senha" @click="$dispatch('openUserPasswordModal')" />
            </x-mary-dropdown>

            <p class="font-semibold text-sm line-clamp-1 text-white">{{ $userName }}</p>
         </div>

         <div>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
               @csrf
               <x-mary-button
                  icon="o-arrow-left-start-on-rectangle"
                  type="submit"
                  class="btn-ghost btn-square text-white hover:bg-white/10"
                  tooltip="Sair" />
            </form>
         </div>
      </div>
   </div>

</div>