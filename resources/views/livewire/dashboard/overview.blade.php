{{-- Contenedor Principal del Panel de Control --}}
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header Section: Título y descripción del panel -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Panel de Control (Dashboard)
        </h1>
        <p class="mt-2 text-sm text-slate-400">
            Resumen en tiempo real del estado de Tienda Dolores.
        </p>
    </div>

    <!-- Quick Action / Shortcut Buttons: Enlaces rápidos a módulos comunes -->
    <div class="mb-8 flex flex-wrap gap-4">
        <a href="/pos" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-500 hover:shadow-emerald-500/30 focus:outline-none transition-all duration-200">
            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
            Nueva Venta (POS)
        </a>
        <a href="/productos" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 hover:shadow-indigo-500/30 focus:outline-none transition-all duration-200">
            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nuevo Producto
        </a>
        <a href="/inventario" class="inline-flex items-center justify-center rounded-xl bg-slate-800 hover:bg-slate-700 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:text-white border border-slate-700/60 transition-all duration-200">
            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            </svg>
            Bitácora de Inventario
        </a>
    </div>

    <!-- KPI Metrics Grid: Cuadrícula con las tres tarjetas de métricas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Metric Card: Sales Today (Ventas acumuladas hoy) -->
        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-6 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-32 h-32 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                </svg>
            </div>
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Ventas de Hoy</span>
                <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400 border border-emerald-500/10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white">
                ${{ number_format($todaySales, 2) }}
            </div>
            <p class="text-xs text-slate-400 mt-2">Acumulado del punto de venta</p>
        </div>

        <!-- Metric Card: Stock Warnings (Alertas de stock bajo) -->
        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-6 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-32 h-32 text-rose-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
            </div>
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alertas de Stock</span>
                <div class="p-2 bg-rose-500/10 rounded-lg text-rose-400 border border-rose-500/10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white flex items-center gap-2">
                {{ $lowStockCount }}
                @if($lowStockCount > 0)
                    <span class="inline-flex items-center rounded-full bg-rose-500/10 px-2 py-0.5 text-[11px] font-medium text-rose-400 border border-rose-500/20 animate-pulse">
                        ¡Atención!
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-400 mt-2">Productos con stock bajo el mínimo</p>
        </div>

        <!-- Metric Card: Total Products (Total catálogo registrado) -->
        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-6 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-32 h-32 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 14H4v-4h11v4zm0-5H4V9h11v4zm5 5h-4V9h4v9z"/>
                </svg>
            </div>
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Productos</span>
                <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400 border border-indigo-500/10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white">
                {{ $totalProducts }}
            </div>
            <p class="text-xs text-slate-400 mt-2">Productos activos en el catálogo</p>
        </div>
    </div>

    <!-- Recent Inventory Movements: Tabla con los últimos 5 movimientos -->
    <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800 shadow-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 2.24a4.81 4.81 0 013.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Últimos Movimientos de Inventario
            </h2>
            <a href="/inventario" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors uppercase tracking-wider">
                Ver todos
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800">
                <thead>
                    <tr class="bg-slate-900/60">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Fecha</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Producto</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Tipo</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Cantidad</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Motivo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 bg-transparent">
                    @forelse($recentMovements as $movement)
                        <tr class="hover:bg-slate-800/10 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400 font-mono">
                                {{ $movement->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-white">
                                {{ $movement->product->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                {{-- Renderiza badge coloreado según tipo de movimiento --}}
                                @if ($movement->type === 'entrada')
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-400 border border-emerald-500/20">
                                        Entrada
                                    </span>
                                @elseif ($movement->type === 'salida')
                                    <span class="inline-flex items-center rounded-full bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-400 border border-rose-500/20">
                                        Salida
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-400 border border-amber-500/20">
                                        Ajuste
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-mono font-bold">
                                {{-- Muestra cantidad con signos +/- correspondientes --}}
                                @if ($movement->type === 'entrada')
                                    <span class="text-emerald-400">+{{ $movement->quantity }}</span>
                                @elseif ($movement->type === 'salida')
                                    <span class="text-rose-400">-{{ $movement->quantity }}</span>
                                @else
                                    <span class="{{ $movement->quantity >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $movement->quantity >= 0 ? '+' : '' }}{{ $movement->quantity }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $movement->reason }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">
                                No hay registros recientes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
