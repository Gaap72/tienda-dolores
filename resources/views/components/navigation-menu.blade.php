<nav class="bg-slate-900/90 border-b border-slate-800/80 sticky top-0 z-40 backdrop-blur-md bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <!-- Brand logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center font-bold text-white tracking-wider shadow-md shadow-indigo-500/25">
                        TD
                    </div>
                    <span class="text-lg font-bold text-white tracking-wide">Tienda Dolores</span>
                </div>

                <!-- Desktop navigation menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="/" class="{{ request()->is('/') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Dashboard
                            </a>
                            <a href="/productos" class="{{ request()->is('productos*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Catálogo
                            </a>
                            <a href="/categorias" class="{{ request()->is('categorias*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Categorías
                            </a>
                            <a href="/inventario" class="{{ request()->is('inventario*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Inventario
                            </a>
                            <a href="/mermas" class="{{ request()->is('mermas*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Mermas
                            </a>
                            <a href="/usuarios" class="{{ request()->is('usuarios*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Cajeros
                            </a>
                        @endif

                        @if(auth()->check())
                            <a href="/pos" class="{{ request()->is('pos*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Punto de Venta
                            </a>
                            <a href="/corte-caja" class="{{ request()->is('corte-caja*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }} px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                                Corte de Caja
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Desktop user profile & logout -->
            @if(auth()->check())
                <div class="hidden md:flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-xs font-semibold text-white">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-indigo-400 uppercase tracking-wider font-semibold">{{ auth()->user()->role === 'admin' ? 'Administrador' : 'Cajero' }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-800 hover:bg-slate-700 px-3 py-1.5 text-xs font-semibold text-slate-300 hover:text-white border border-slate-700/50 transition-all duration-150 cursor-pointer">
                            Salir
                        </button>
                    </form>
                </div>
            @endif
            
            <!-- Mobile Menu -->
            <div class="-mr-2 flex md:hidden items-center gap-3" x-data="{ open: false }">
                @if(auth()->check())
                    <div class="text-right text-[11px] font-semibold text-slate-400">
                        {{ auth()->user()->name }}
                    </div>
                @endif

                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white focus:outline-none transition-colors" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Abrir menú</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path :class="open ? 'hidden' : 'block'" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        <path :class="open ? 'block' : 'hidden'" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" class="absolute right-4 top-16 w-52 rounded-xl bg-slate-900 border border-slate-800 shadow-2xl p-2 space-y-1 z-50 animate-fade-in" style="display: none;">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="/" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('/') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Dashboard</a>
                        <a href="/productos" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('productos*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Catálogo</a>
                        <a href="/categorias" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('categorias*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Categorías</a>
                        <a href="/inventario" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('inventario*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Inventario</a>
                        <a href="/mermas" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('mermas*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Mermas</a>
                        <a href="/usuarios" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('usuarios*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Cajeros</a>
                    @endif

                    @if(auth()->check())
                        <a href="/pos" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('pos*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Punto de Venta</a>
                        <a href="/corte-caja" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('corte-caja*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800/60' }}">Corte de Caja</a>
                        
                        <div class="border-t border-slate-800/60 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST" class="block w-full">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-sm font-semibold text-rose-400 hover:bg-rose-500/10 transition-colors">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
