<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Catálogo de Productos
            </h1>
            <p class="mt-2 text-sm text-slate-400">
                Administra los productos de Tienda Dolores, controla stock, precios y categorías.
            </p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0">
            <button wire:click="create" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition-all duration-200">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nuevo Producto
            </button>
        </div>
    </div>

    <!-- Alert / Toast Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between shadow-lg shadow-emerald-500/5 animate-fade-in">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
            <button class="text-emerald-400 hover:text-emerald-300 font-medium text-xs uppercase tracking-wider" onclick="this.parentElement.remove()">Cerrar</button>
        </div>
    @endif

    <!-- Search and Filter Bar -->
    <div class="mb-6 bg-slate-900/50 backdrop-blur-md rounded-2xl border border-slate-800 p-4">
        <div class="relative max-w-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Buscar por nombre o código de barra..." 
                   class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-10 pr-4 text-white ring-1 ring-inset ring-slate-800 placeholder:text-slate-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" />
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800">
                <thead>
                    <tr class="bg-slate-900/70">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Código / ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Producto</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Categoría</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Costo / Precio</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Stock</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Unidad</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 bg-transparent">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-800/20 transition-colors duration-150">
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <div class="font-mono text-slate-500">#{{ $product->id }}</div>
                                @if($product->barcode)
                                    <span class="mt-1 inline-flex items-center rounded-md bg-slate-800 px-1.5 py-0.5 text-xs font-medium text-slate-400 border border-slate-700">
                                        {{ $product->barcode }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-600">Sin código</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-slate-800 border border-slate-700/50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($product->image_path)
                                            @if(str_starts_with($product->image_path, 'http'))
                                                <img src="{{ $product->image_path }}" class="h-full w-full object-cover" alt="{{ $product->name }}" />
                                            @else
                                                <img src="{{ asset('storage/' . $product->image_path) }}" class="h-full w-full object-cover" alt="{{ $product->name }}" />
                                            @endif
                                        @else
                                            <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">{{ $product->name }}</div>
                                        @if($product->description)
                                            <div class="text-xs text-slate-400 truncate max-w-xs">{{ $product->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-300">
                                <span class="inline-flex items-center rounded-md bg-indigo-500/10 px-2.5 py-1 text-xs font-medium text-indigo-400 border border-indigo-500/10">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="text-slate-400 font-medium">C: ${{ number_format($product->cost, 2) }}</div>
                                <div class="text-emerald-400 font-semibold mt-0.5">P: ${{ number_format($product->price, 2) }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                @if ($product->stock <= $product->stock_min)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-500/10 px-3 py-1 text-xs font-medium text-rose-400 border border-rose-500/20 shadow-sm animate-pulse">
                                        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $product->stock }} (Bajo)
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400 border border-emerald-500/20">
                                        {{ $product->stock }}
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-slate-300">
                                <span class="uppercase font-medium text-xs tracking-wider bg-slate-800 px-2 py-1 rounded border border-slate-700">
                                    {{ $product->unit_measure }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="edit({{ $product->id }})" class="p-2 rounded-lg bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white transition-all duration-150" title="Editar">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $product->id }})" wire:confirm="¿Estás seguro de eliminar este producto?" class="p-2 rounded-lg bg-slate-800 hover:bg-rose-600 text-slate-400 hover:text-white transition-all duration-150" title="Eliminar">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-dasharray="4 4" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                    <span class="text-sm font-medium">No se encontraron productos</span>
                                    <p class="text-xs text-slate-600 mt-1">Intenta cambiar el término de búsqueda o crea uno nuevo.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <div class="px-6 py-4 bg-slate-900/60 border-t border-slate-800">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Product Form Modal -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal Box -->
                <div class="relative transform overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <!-- Modal Header -->
                    <div class="bg-slate-950 px-6 py-4 border-b border-slate-800/80 flex items-center justify-between">
                        <h3 class="text-lg font-semibold leading-6 text-white" id="modal-title">
                            {{ $productId ? 'Editar Producto' : 'Nuevo Producto' }}
                        </h3>
                        <button wire:click="closeModal" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Form -->
                    <form wire:submit.prevent="save">
                        <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Nombre del Producto</label>
                                <input type="text" wire:model="name" id="name" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="Ej. Coca Cola 600ml">
                                @error('name') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Barcode & Category -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="barcode" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Código de Barras</label>
                                    <input type="text" wire:model="barcode" id="barcode" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="Opcional">
                                    @error('barcode') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Categoría</label>
                                    <select wire:model="category_id" id="category_id" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                                        <option value="">Selecciona una categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Descripción</label>
                                <textarea wire:model="description" id="description" rows="2" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="Detalles del producto..."></textarea>
                                @error('description') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Cost & Price -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="cost" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Costo ($)</label>
                                    <input type="number" step="0.01" wire:model="cost" id="cost" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="0.00">
                                    @error('cost') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Precio de Venta ($)</label>
                                    <input type="number" step="0.01" wire:model="price" id="price" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="0.00">
                                    @error('price') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Stock & Stock Min & Unit Measure -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="stock" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Stock Actual</label>
                                    <input type="number" wire:model="stock" id="stock" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                                    @error('stock') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="stock_min" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Stock Mínimo</label>
                                    <input type="number" wire:model="stock_min" id="stock_min" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                                    @error('stock_min') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="unit_measure" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Unidad</label>
                                    <select wire:model="unit_measure" id="unit_measure" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                                        <option value="pza">Pza</option>
                                        <option value="kg">Kg</option>
                                        <option value="lt">Lt</option>
                                        <option value="cja">Cja</option>
                                    </select>
                                    @error('unit_measure') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Imagen del Producto -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Imagen del Producto</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-xl bg-slate-950/60 border border-slate-800 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                        @elseif ($existingImagePath)
                                            @if(str_starts_with($existingImagePath, 'http'))
                                                <img src="{{ $existingImagePath }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="{{ asset('storage/' . $existingImagePath) }}" class="w-full h-full object-cover">
                                            @endif
                                        @else
                                            <svg class="h-6 w-6 text-slate-655" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <input type="file" wire:model="image" id="image" accept="image/*" class="text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-indigo-650 hover:file:text-white transition-all cursor-pointer">
                                </div>
                                <div wire:loading wire:target="image" class="text-xs text-indigo-400 mt-1">Cargando previsualización...</div>
                                @error('image') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-slate-950 px-6 py-4 border-t border-slate-800/80 flex items-center justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all duration-150">
                                Cancelar
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition-all duration-200">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
