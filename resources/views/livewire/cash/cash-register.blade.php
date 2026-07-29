<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Corte de Caja y Arqueo
        </h1>
        <p class="mt-2 text-sm text-slate-400">
            Controla las aperturas de turno, ventas acumuladas en efectivo y realiza arqueos para detectar faltantes o sobrantes.
        </p>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between shadow-lg shadow-emerald-500/5">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button class="text-emerald-400 hover:text-emerald-300 font-semibold text-xs uppercase tracking-wider" onclick="this.parentElement.remove()">Cerrar</button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center justify-between shadow-lg shadow-rose-500/5">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-rose-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button class="text-rose-400 hover:text-rose-300 font-semibold text-xs uppercase tracking-wider" onclick="this.parentElement.remove()">Cerrar</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- LEFT: Control Panel Shift (4 Cols) -->
        <div class="lg:col-span-5 xl:col-span-4">
            @if(!$activeShift)
                <!-- Cash Register Closed state (Needs Opening) -->
                <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-6 shadow-2xl space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rose-500/10 rounded-xl text-rose-400 border border-rose-500/10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Caja Cerrada</h2>
                            <p class="text-xs text-slate-400">Abre un nuevo turno para registrar ventas.</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="openShift" class="space-y-4 pt-3 border-t border-slate-850">
                        <div>
                            <label for="opening_amount" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Fondo Inicial de Caja</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-slate-450 text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" wire:model="opening_amount" id="opening_amount" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-7 pr-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none font-mono" placeholder="0.00">
                            </div>
                            @error('opening_amount') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all duration-200">
                            Abrir Turno / Registrar Fondo
                        </button>
                    </form>
                </div>
            @else
                <!-- Cash Register Open state (Active Shift / Reconciliation) -->
                <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-6 shadow-2xl space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/10 rounded-xl text-emerald-400 border border-emerald-500/10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h16.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Caja Abierta</h2>
                            <p class="text-xs text-slate-400">Turno activo de {{ $activeShift->user->name ?? 'Cajero' }}</p>
                        </div>
                    </div>

                    <!-- Live statistics -->
                    <div class="space-y-3 pt-3 border-t border-slate-850 text-sm">
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-400">Apertura (Fondo):</span>
                            <span class="font-mono text-white font-semibold">${{ number_format($activeShift->opening_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-400">Ventas en POS:</span>
                            <span class="font-mono text-emerald-400 font-semibold">+${{ number_format($sales_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-t border-slate-850/60">
                            <span class="text-slate-300 font-medium">Dinero esperado:</span>
                            <span class="font-mono text-white font-extrabold text-base">${{ number_format($expected_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Closing form -->
                    <form wire:submit.prevent="closeShift" class="space-y-4 pt-3 border-t border-slate-850">
                        <div>
                            <label for="actual_amount" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Efectivo Contado (Físico)</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-slate-450 text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" wire:model.live="actual_amount" id="actual_amount" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-7 pr-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-emerald-500 sm:text-sm focus:outline-none font-mono font-bold" placeholder="0.00">
                            </div>
                            @error('actual_amount') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Live Arqueo calculation display -->
                        @if($actual_amount !== '')
                            @php
                                $diff = floatval($actual_amount) - $expected_amount;
                            @endphp
                            <div class="p-3.5 rounded-xl border flex justify-between items-center
                                @if($diff == 0) bg-emerald-500/10 border-emerald-500/20 text-emerald-400
                                @elseif($diff > 0) bg-amber-500/10 border-amber-500/20 text-amber-400
                                @else bg-rose-500/10 border-rose-500/20 text-rose-400
                                @endif">
                                <span class="text-xs font-semibold uppercase tracking-wider">
                                    @if($diff == 0) Balance Cuadrado
                                    @elseif($diff > 0) Sobrante
                                    @else Faltante
                                    @endif
                                </span>
                                <span class="font-mono font-bold text-lg">
                                    {{ $diff >= 0 ? '+' : '' }}${{ number_format($diff, 2) }}
                                </span>
                            </div>
                        @endif

                        <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200">
                            Cerrar Turno y Realizar Arqueo
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- RIGHT: History Log Shifts (8 Cols) -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                Historial de Cortes de Caja
            </h2>

            <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead>
                            <tr class="bg-slate-900/70">
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Fecha Cierre</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Cajero</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Fondo Inicial</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Ventas</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Contado</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Diferencia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-transparent">
                            @forelse ($shiftsHistory as $shift)
                                <tr class="hover:bg-slate-800/20 transition-colors duration-150">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400 font-mono">
                                        {{ $shift->closed_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-white whitespace-nowrap">
                                        {{ $shift->user->name ?? 'Cajero' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-300 font-mono">
                                        ${{ number_format($shift->opening_amount, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-300 font-mono">
                                        ${{ number_format($shift->sales_amount, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-emerald-400 font-mono font-semibold">
                                        ${{ number_format($shift->actual_amount, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-mono font-bold">
                                        @if($shift->difference == 0)
                                            <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-xs text-emerald-400 border border-emerald-500/20">
                                                $0.00
                                            </span>
                                        @elseif($shift->difference > 0)
                                            <span class="inline-flex items-center rounded-full bg-amber-500/10 px-2.5 py-0.5 text-xs text-amber-400 border border-amber-500/20">
                                                +${{ number_format($shift->difference, 2) }} (Sobrante)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-rose-500/10 px-2.5 py-0.5 text-xs text-rose-400 border border-rose-500/20">
                                                -${{ number_format(abs($shift->difference), 2) }} (Faltante)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm font-medium">No hay historial de turnos cerrados</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($shiftsHistory->hasPages())
                    <div class="px-6 py-4 bg-slate-900/60 border-t border-slate-800">
                        {{ $shiftsHistory->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
