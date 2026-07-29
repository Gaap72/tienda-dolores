<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Control de Mermas y Caducidades
        </h1>
        <p class="mt-2 text-sm text-slate-400">
            Registra pérdidas de inventario por vencimiento, averías o daños, y analiza las pérdidas económicas estimadas.
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
        <!-- LEFT: Waste Form (4 Cols) -->
        <div class="lg:col-span-4">
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-6 sticky top-8 shadow-2xl space-y-5">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Reportar Merma
                </h2>

                <form wire:submit.prevent="save" class="space-y-4">
                    <!-- Product Select -->
                    <div>
                        <label for="product_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Producto Merma</label>
                        <select wire:model="product_id" id="product_id" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                            <option value="">Selecciona un producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }} / Costo: ${{ number_format($product->cost, 2) }})</option>
                            @endforeach
                        </select>
                        @error('product_id') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Type Select -->
                    <div>
                        <label for="type" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Tipo de Merma</label>
                        <select wire:model="type" id="type" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                            <option value="caducado">Caducado / Vencido</option>
                            <option value="dañado">Dañado / Averiado</option>
                            <option value="roto">Roto / Quebrado</option>
                            <option value="robo">Robo / Extraviado</option>
                        </select>
                        @error('type') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Cantidad</label>
                        <input type="number" wire:model="quantity" id="quantity" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="0">
                        @error('quantity') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Detalles / Notas</label>
                        <textarea wire:model="notes" id="notes" rows="3" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="Ej. Lote de galletas dañado por humedad en el estante..."></textarea>
                        @error('notes') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide text-white bg-rose-600 hover:bg-rose-500 shadow-lg shadow-rose-500/20 hover:shadow-rose-500/30 transition-all duration-200">
                        Confirmar Merma
                    </button>
                </form>
            </div>
        </div>

        <!-- RIGHT: Wastes History Log (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            <!-- Loss summary card -->
            <div class="bg-gradient-to-tr from-slate-900 to-rose-950/20 rounded-2xl border border-slate-800/80 p-5 flex items-center justify-between shadow-2xl">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-rose-400">Pérdida Económica Total</h3>
                    <p class="text-xs text-slate-500 mt-1">Suma del costo de todos los productos mermados</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-extrabold text-rose-500 font-mono">
                        ${{ number_format($totalLoss, 2) }}
                    </span>
                </div>
            </div>

            <!-- Search box -->
            <div class="bg-slate-900/50 backdrop-blur-md rounded-2xl border border-slate-800 p-4">
                <div class="relative max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Filtrar por producto o detalles..." 
                           class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-10 pr-4 text-white ring-1 ring-inset ring-slate-800 placeholder:text-slate-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" />
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead>
                            <tr class="bg-slate-900/70">
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Fecha</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Producto</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Tipo Merma</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Cantidad</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Pérdida ($)</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-transparent">
                            @forelse ($wastes as $movement)
                                @php
                                    // Parse reason "Merma: Type | Details" or "Merma: Type"
                                    $reasonPart = str_replace('Merma: ', '', $movement->reason);
                                    $parts = explode(' | ', $reasonPart);
                                    $typeLabel = $parts[0] ?? 'Desconocido';
                                    $detailsLabel = $parts[1] ?? 'Sin detalles';
                                @endphp
                                <tr class="hover:bg-slate-800/20 transition-colors duration-150">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400 font-mono">
                                        {{ $movement->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-white">
                                        {{ $movement->product->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium border
                                            @if(strtolower($typeLabel) === 'caducado') bg-amber-500/10 text-amber-400 border-amber-500/20
                                            @elseif(strtolower($typeLabel) === 'dañado') bg-purple-500/10 text-purple-400 border-purple-500/20
                                            @elseif(strtolower($typeLabel) === 'roto') bg-orange-500/10 text-orange-400 border-orange-500/20
                                            @else bg-rose-500/10 text-rose-400 border-rose-500/20
                                            @endif">
                                            {{ $typeLabel }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-mono font-bold text-rose-400">
                                        -{{ $movement->quantity }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-mono font-bold text-rose-500">
                                        ${{ number_format($movement->quantity * $movement->product->cost, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">
                                        <div class="line-clamp-2 max-w-xs">{{ $detailsLabel }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-12 w-12 text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                            </svg>
                                            <span class="text-sm font-medium">No se han registrado mermas</span>
                                            <p class="text-xs text-slate-600 mt-1">Registra pérdidas de inventario utilizando el formulario de la izquierda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($wastes->hasPages())
                    <div class="px-6 py-4 bg-slate-900/60 border-t border-slate-800">
                        {{ $wastes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
