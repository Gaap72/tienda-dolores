<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Punto de Venta (POS)
        </h1>
        <p class="mt-2 text-sm text-slate-400">
            Escanea códigos de barras o busca productos para agregarlos al carrito y procesar la venta.
        </p>
    </div>

    <!-- Alert Messages (Success/Error) -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between shadow-lg shadow-emerald-500/5 animate-fade-in">
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
        <!-- LEFT COLUMN: Search & Products Catalog (8 Cols) -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            <!-- Search Input and Auto-complete dropdown -->
            <div class="bg-slate-900/50 backdrop-blur-md rounded-2xl border border-slate-800 p-5 relative">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Buscador de Productos</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live="search" 
                           id="search"
                           placeholder="Escribe el nombre o escanea el código de barras..." 
                           class="block w-full rounded-xl border-0 bg-slate-950/60 py-3 pl-11 pr-4 text-white ring-1 ring-inset ring-slate-800 placeholder:text-slate-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200"
                           autocomplete="off" />
                </div>

                <!-- Live Search Dropdown -->
                @if(!empty($search))
                    <div class="absolute left-0 right-0 mt-2 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl z-20 max-h-72 overflow-y-auto divide-y divide-slate-800">
                        @forelse($searchResults as $product)
                            <button wire:click="addToCart({{ $product->id }})" 
                                    class="w-full text-left px-4 py-3 hover:bg-indigo-600/10 flex items-center justify-between transition-colors duration-150 group">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-lg bg-slate-950 border border-slate-800 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                        @if($product->image_path)
                                            @if(str_starts_with($product->image_path, 'http'))
                                                <img src="{{ $product->image_path }}" class="h-full w-full object-cover" alt="{{ $product->name }}" />
                                            @else
                                                <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover" alt="{{ $product->name }}" />
                                            @endif
                                        @else
                                            <svg class="h-4.5 w-4.5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white group-hover:text-indigo-400 transition-colors">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">
                                            @if($product->barcode)
                                                <span class="font-mono">{{ $product->barcode }}</span>
                                            @endif
                                            <span class="mx-1.5">•</span>
                                            Stock: {{ $product->stock }} {{ $product->unit_measure }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-emerald-400 font-semibold">${{ number_format($product->price, 2) }}</div>
                                    <span class="text-[10px] text-slate-500 uppercase">{{ $product->unit_measure }}</span>
                                </div>
                            </button>
                        @empty
                            <div class="px-4 py-3 text-sm text-slate-500 text-center">
                                No se encontraron productos coincidentes
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            <!-- Quick Access Catalog -->
            <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800/80 p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.5a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75h-3.5a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                    </svg>
                    Catálogo de Acceso Rápido
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($quickProducts as $product)
                        <div class="bg-slate-950/60 rounded-xl border border-slate-800 p-3.5 flex flex-col justify-between hover:border-slate-700 transition-all duration-150 group overflow-hidden">
                            <div>
                                <div class="w-full h-24 rounded-lg bg-slate-900 border border-slate-850/50 mb-3 overflow-hidden flex items-center justify-center">
                                    @if($product->image_path)
                                        @if(str_starts_with($product->image_path, 'http'))
                                            <img src="{{ $product->image_path }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" alt="{{ $product->name }}" />
                                        @else
                                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" alt="{{ $product->name }}" />
                                        @endif
                                    @else
                                        <svg class="h-8 w-8 text-slate-750" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-[10px] text-slate-500 uppercase font-medium tracking-wide">
                                    {{ $product->category->name }}
                                </span>
                                <h3 class="font-semibold text-sm text-white mt-0.5 group-hover:text-indigo-400 transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-emerald-400">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="text-xs font-medium uppercase text-slate-400">
                                        /{{ $product->unit_measure }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between gap-2">
                                @if($product->stock <= 0)
                                    <span class="text-[11px] text-rose-500 font-semibold uppercase">Agotado</span>
                                @else
                                    <span class="text-[11px] font-medium {{ $product->stock <= $product->stock_min ? 'text-rose-400' : 'text-slate-400' }}">
                                        Stock: {{ $product->stock }}
                                    </span>
                                    <button wire:click="addToCart({{ $product->id }})" 
                                            class="p-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white shadow-md shadow-indigo-600/10 hover:shadow-indigo-600/20 transition-all duration-150">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-slate-500 text-sm">
                            No hay productos en el catálogo
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Cart and Pay Section (4 Cols) -->
        <div class="lg:col-span-5 xl:col-span-4">
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 shadow-2xl p-6 sticky top-8 flex flex-col max-h-[85vh] justify-between">
                
                <!-- Cart Items Section -->
                <div>
                    <h2 class="text-lg font-bold text-white mb-4 flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            Carrito
                        </span>
                        <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded-full font-medium">
                            {{ count($cart) }} Items
                        </span>
                    </h2>

                    <!-- Cart List -->
                    <div class="space-y-3 overflow-y-auto max-h-[35vh] pr-1">
                        @forelse($cart as $item)
                            <div class="bg-slate-950/60 rounded-xl border border-slate-800 p-3 flex items-center justify-between gap-3 group">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-white truncate">{{ $item['name'] }}</h4>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        ${{ number_format($item['price'], 2) }} c/u
                                    </div>
                                </div>
                                
                                <!-- Quantity Input Control -->
                                <div class="flex items-center gap-1.5">
                                    <button wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] - 1 }})" 
                                            class="w-6 h-6 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center font-bold text-sm transition-colors">
                                        -
                                    </button>
                                    <input type="number" 
                                           value="{{ $item['quantity'] }}" 
                                           wire:change="updateQuantity({{ $item['product_id'] }}, $event.target.value)" 
                                           class="w-10 text-center bg-slate-950 border border-slate-800 rounded py-0.5 text-xs text-white focus:outline-none focus:border-indigo-500 font-semibold" />
                                    <button wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] + 1 }})" 
                                            class="w-6 h-6 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center font-bold text-sm transition-colors">
                                        +
                                    </button>
                                </div>

                                <div class="text-right">
                                    <div class="text-xs font-bold text-emerald-400">${{ number_format($item['subtotal'], 2) }}</div>
                                    <button wire:click="removeFromCart({{ $item['product_id'] }})" class="text-[10px] text-rose-500 hover:text-rose-400 font-semibold uppercase mt-0.5">Quitar</button>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-slate-500 text-sm">
                                Carrito vacío. Agrega productos.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pay & Summary Section -->
                <div class="mt-6 pt-6 border-t border-slate-800 space-y-4">
                    <!-- Totals -->
                    <div class="flex justify-between items-baseline">
                        <span class="text-slate-400 text-sm font-semibold uppercase tracking-wider">Total a Pagar</span>
                        <span class="text-3xl font-extrabold text-emerald-400">${{ number_format($total, 2) }}</span>
                    </div>

                    <!-- Payment inputs -->
                    <div class="space-y-3">
                        <div>
                            <label for="received" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Dinero Recibido</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-slate-400 text-sm font-semibold">$</span>
                                </div>
                                <input type="number" 
                                       step="0.01" 
                                       wire:model.live="received" 
                                       id="received" 
                                       placeholder="0.00" 
                                       class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-7 pr-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-emerald-500 sm:text-sm focus:outline-none transition-all duration-200 font-mono font-bold" />
                            </div>
                        </div>

                        <!-- Change Box -->
                        @if($received !== '')
                            <div class="p-3.5 rounded-xl bg-slate-950/80 border border-slate-850 flex justify-between items-center">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Cambio</span>
                                <span class="font-mono text-xl font-bold {{ $change > 0 ? 'text-yellow-400' : 'text-slate-500' }}">
                                    ${{ number_format($change, 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <!-- Process sale button -->
                    <button wire:click="processSale" 
                            id="confirm-pay-btn"
                            class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide text-white transition-all duration-200 flex items-center justify-center gap-2
                                   {{ count($cart) > 0 && floatval($received) >= $total ? 'bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-500/20' : 'bg-slate-800 text-slate-500 cursor-not-allowed border border-slate-700/50' }}"
                            {{ count($cart) > 0 && floatval($received) >= $total ? '' : 'disabled' }}>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Confirmar Cobro
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Floating Offline Indicator -->
    <div id="connection-status-badge" class="fixed bottom-6 left-6 z-50 transition-all duration-300 transform translate-y-0">
        <div class="inline-flex items-center gap-2 rounded-full px-4 py-2.5 text-xs font-semibold shadow-2xl border bg-slate-900 text-slate-100 border-slate-800">
            <span id="connection-status-dot" class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span id="connection-status-text">En línea</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.getElementById('connection-status-badge');
            const dot = document.getElementById('connection-status-dot');
            const text = document.getElementById('connection-status-text');
            const payButton = document.getElementById('confirm-pay-btn');

            function updateConnectionStatus() {
                if (navigator.onLine) {
                    dot.className = "h-2 w-2 rounded-full bg-emerald-500 animate-pulse";
                    text.innerText = "En línea";
                    badge.classList.remove('border-rose-500/30', 'bg-rose-950/20');
                    if (payButton) {
                        payButton.disabled = false;
                    }
                    syncOfflineSales();
                } else {
                    dot.className = "h-2 w-2 rounded-full bg-rose-500 animate-ping";
                    text.innerText = "Modo Sin Conexión - Sincronizará al reconectar";
                    badge.classList.add('border-rose-500/30', 'bg-rose-950/20');
                }
            }

            window.addEventListener('online', updateConnectionStatus);
            window.addEventListener('offline', updateConnectionStatus);
            updateConnectionStatus();

            if (payButton) {
                payButton.addEventListener('click', function(e) {
                    if (!navigator.onLine) {
                        e.preventDefault();
                        e.stopPropagation();

                        const cartItems = @json($cart);
                        const total = @json($total);
                        const receivedInput = document.getElementById('received');
                        const received = receivedInput ? receivedInput.value : 0;

                        if (Object.keys(cartItems).length === 0) {
                            alert('El carrito está vacío.');
                            return;
                        }

                        if (parseFloat(received) < parseFloat(total)) {
                            alert('El dinero recibido es menor al total.');
                            return;
                        }

                        const pendingSale = {
                            id: Date.now(),
                            cart: cartItems,
                            total: total,
                            received: received,
                            timestamp: new Date().toISOString()
                        };

                        let pending = JSON.parse(localStorage.getItem('pendingSales') || '[]');
                        pending.push(pendingSale);
                        localStorage.setItem('pendingSales', JSON.stringify(pending));

                        alert('⚠️ Modo Sin Conexión activo. Venta guardada localmente en tu navegador. Se transmitirá automáticamente cuando vuelva el internet.');
                        location.reload();
                    }
                });
            }

            function syncOfflineSales() {
                const pending = JSON.parse(localStorage.getItem('pendingSales') || '[]');
                if (pending.length === 0) return;

                pending.forEach(sale => {
                    if (window.Livewire) {
                        const component = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
                        if (component) {
                            component.call('processOfflineSale', Object.values(sale.cart), sale.received)
                                .then(() => {
                                    let currentPending = JSON.parse(localStorage.getItem('pendingSales') || '[]');
                                    currentPending = currentPending.filter(s => s.id !== sale.id);
                                    localStorage.setItem('pendingSales', JSON.stringify(currentPending));
                                    console.log('Venta offline sincronizada:', sale.id);
                                })
                                .catch(err => {
                                    console.error('Error al sincronizar venta offline:', err);
                                });
                        }
                    }
                });
            }
        });
    </script>
</div>
