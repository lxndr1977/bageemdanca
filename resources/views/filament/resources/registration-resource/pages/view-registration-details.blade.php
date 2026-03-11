<x-filament-panels::page>
    <div class="space-y-6 text-gray-950 dark:text-white">

        {{-- ── Banner: Inscrição Confirmada ── --}}
        @if ($record->status_registration->value === 'finished')
            <x-filament::section>
                <div class="flex items-center gap-4 py-2">
                    <x-filament::icon
                        icon="heroicon-o-check-circle"
                        class="h-10 w-10 shrink-0 text-success-500 dark:text-success-400"
                    />
                    <div>
                        <p class="text-base font-semibold leading-tight">Inscrição Confirmada</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Finalizada com sucesso em {{ $record->updated_at->format('d/m/Y \à\s H:i') }}.
                        </p>
                    </div>
                </div>
            </x-filament::section>
        @endif


        {{-- ══════════════════════════════════════
             RESUMO
        ══════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <x-filament::section>
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/10">
                        <x-filament::icon icon="heroicon-o-users" class="h-6 w-6 text-gray-500 dark:text-gray-400" />
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Participantes</p>
                        <p class="mt-0.5 text-3xl font-bold leading-none tabular-nums">
                            {{ ($record->school->members->count() ?? 0)
                               + ($record->school->dancers->count() ?? 0)
                               + ($record->school->choreographers->count() ?? 0) }}
                        </p>
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/10">
                        <x-filament::icon icon="heroicon-o-musical-note" class="h-6 w-6 text-gray-500 dark:text-gray-400" />
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Coreografias</p>
                        <p class="mt-0.5 text-3xl font-bold leading-none tabular-nums">
                            {{ $record->school->choreographies->count() ?? 0 }}
                        </p>
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/10">
                        <x-filament::icon icon="heroicon-o-tag" class="h-6 w-6 text-gray-500 dark:text-gray-400" />
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Status</p>
                        <div class="mt-1">
                            <x-filament::badge size="lg">
                                {{ $record->status_registration->getLabel() }}
                            </x-filament::badge>
                        </div>
                    </div>
                </div>
            </x-filament::section>

        </div>


        {{-- ══════════════════════════════════════
             INSTITUIÇÃO
        ══════════════════════════════════════ --}}
        <x-filament::section heading="Instituição" icon="heroicon-o-building-office-2">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

                <div>
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-400">Identificação</p>
                    <dl class="space-y-3">
                        @foreach ([
                            'Nome'              => $record->school->name,
                            'Projeto'           => $record->school->is_social_project ? 'Sim' : 'Não',
                            'Responsável'       => $record->school->responsible_name,
                            'E-mail'            => $record->school->responsible_email,
                            'Telefone/WhatsApp' => $record->school->responsible_phone,
                        ] as $label => $value)
                            <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-2 dark:border-white/5 last:border-0">
                                <dt class="shrink-0 text-sm text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                                <dd class="text-right text-sm font-medium">{{ $value ?: '—' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div>
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-400">Endereço</p>
                    <address class="not-italic rounded-xl bg-gray-50 p-4 text-sm leading-relaxed text-gray-700 dark:bg-white/5 dark:text-gray-300">
                        {{ $record->school->street }}, {{ $record->school->number }}<br>
                        @if ($record->school->complement)
                            {{ $record->school->complement }}<br>
                        @endif
                        {{ $record->school->district }}<br>
                        {{ $record->school->city }} – {{ $record->school->state }}<br>
                        <span class="font-semibold">{{ $record->school->zip_code }}</span>
                    </address>
                </div>

            </div>
        </x-filament::section>


        {{-- ══════════════════════════════════════
             PARTICIPANTES
        ══════════════════════════════════════ --}}

        <x-filament::section collapsible icon="heroicon-o-identification">
            <x-slot name="heading">
                <span class="flex items-center gap-2">
                    Equipe Diretiva
                    <x-filament::badge color="gray" size="sm">{{ $record->school->members->count() }}</x-filament::badge>
                </span>
            </x-slot>
            <div class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse ($record->school->members as $member)
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium">{{ $member->name }}</span>
                        <x-filament::badge color="gray" size="sm">
                            {{ $member->memberType->name ?? 'Não definido' }}
                        </x-filament::badge>
                    </div>
                @empty
                    <p class="py-4 text-center text-sm italic text-gray-400">Nenhum membro da equipe diretiva cadastrado.</p>
                @endforelse
            </div>
        </x-filament::section>

        <x-filament::section collapsible icon="heroicon-o-user-circle">
            <x-slot name="heading">
                <span class="flex items-center gap-2">
                    Coreógrafos
                    <x-filament::badge color="gray" size="sm">{{ $record->school->choreographers->count() }}</x-filament::badge>
                </span>
            </x-slot>
            <div class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse ($record->school->choreographers as $choreographer)
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium">{{ $choreographer->name }}</span>
                        <span class="text-xs text-gray-400">{{ $choreographer->choreographer_types }}</span>
                    </div>
                @empty
                    <p class="py-4 text-center text-sm italic text-gray-400">Nenhum coreógrafo cadastrado.</p>
                @endforelse
            </div>
        </x-filament::section>

        <x-filament::section collapsible icon="heroicon-o-user-group">
            <x-slot name="heading">
                <span class="flex items-center gap-2">
                    Bailarinos
                    <x-filament::badge color="gray" size="sm">{{ $record->school->dancers->count() }}</x-filament::badge>
                </span>
            </x-slot>
            <div class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse ($record->school->dancers as $dancer)
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium">{{ $dancer->name }}</span>
                        <span class="text-xs text-gray-400">{{ $dancer->birth_date }}</span>
                    </div>
                @empty
                    <p class="py-4 text-center text-sm italic text-gray-400">Nenhum bailarino cadastrado.</p>
                @endforelse
            </div>
        </x-filament::section>


        {{-- ══════════════════════════════════════
             COREOGRAFIAS
        ══════════════════════════════════════ --}}

        @forelse ($record->school->choreographies as $choreography)

            <x-filament::section collapsible icon="heroicon-o-musical-note">

                <x-slot name="heading">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-semibold">{{ $choreography->name }}</span>
                        <x-filament::badge color="gray" size="sm">{{ $choreography->choreographyType->name }}</x-filament::badge>
                        <x-filament::badge color="gray" size="sm">{{ $choreography->choreographyCategory->name }}</x-filament::badge>
                        <x-filament::badge color="gray" size="sm">{{ $choreography->danceStyle->name }}</x-filament::badge>
                    </div>
                </x-slot>

                <div class="grid grid-cols-1 gap-8 pt-2">

                    <div>
                        <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-400">Informações Técnicas</p>
                        <dl class="space-y-2">
                            @foreach ([
                                'Música'                => $choreography->music,
                                'Compositor'            => $choreography->music_composer,
                                'Duração'               => $choreography->duration,
                            ] as $label => $value)
                                <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-2 dark:border-white/5 last:border-0">
                                    <dt class="shrink-0 text-sm text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                                    <dd class="text-right text-sm font-medium">{{ $value ?: '—' }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="space-y-5">
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Participantes</p>

                        <div>
                            <p class="mb-2 flex items-center gap-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                <x-filament::icon icon="heroicon-o-user-circle" class="h-3.5 w-3.5" />
                                Coreógrafos
                                <x-filament::badge color="gray" size="sm">{{ $choreography->choreographers->count() }}</x-filament::badge>
                            </p>
                            <div class="space-y-1">
                                @foreach ($choreography->choreographers as $choreographer)
                                    <div class="flex items-center justify-between text-sm">
                                        <span>{{ $choreographer->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $choreographer->choreographer_types }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="mb-2 flex items-center gap-1.5 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                <x-filament::icon icon="heroicon-o-user-group" class="h-3.5 w-3.5" />
                                Bailarinos
                                <x-filament::badge color="gray" size="sm">{{ $choreography->dancers->count() }}</x-filament::badge>
                            </p>
                            <div class="max-h-48 space-y-1 overflow-y-auto pr-1">
                                @foreach ($choreography->dancers as $dancer)
                                    <div class="flex items-center justify-between text-sm">
                                        <span>{{ $dancer->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $dancer->birth_date }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            </x-filament::section>

        @empty

            <x-filament::section>
                <div class="flex flex-col items-center justify-center gap-3 py-12 text-gray-400">
                    <x-filament::icon icon="heroicon-o-musical-note" class="h-10 w-10 opacity-30" />
                    <p class="text-sm italic">Nenhuma coreografia cadastrada.</p>
                </div>
            </x-filament::section>

        @endforelse

    </div>
</x-filament-panels::page>