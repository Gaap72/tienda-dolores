<div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8 bg-slate-900/60 backdrop-blur-md rounded-2xl border border-slate-800 p-8 shadow-2xl relative overflow-hidden group">
        <!-- Glowing background decorator -->
        <div class="absolute -right-16 -top-16 w-36 h-36 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all duration-500"></div>
        <div class="absolute -left-16 -bottom-16 w-36 h-36 bg-violet-500/10 rounded-full blur-3xl group-hover:bg-violet-500/20 transition-all duration-500"></div>

        <!-- Logo/Brand header -->
        <div class="text-center">
            <div class="mx-auto h-12 w-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center font-bold text-white text-2xl tracking-wider shadow-lg shadow-indigo-500/25">
                TD
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white tracking-tight">
                Tienda Dolores
            </h2>
            <p class="mt-2 text-sm text-slate-450">
                Inicia sesión para acceder al sistema
            </p>
        </div>

        <!-- Login Form -->
        <form wire:submit.prevent="login" class="mt-8 space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Correo Electrónico</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <input type="email" 
                           wire:model="email" 
                           id="email" 
                           required 
                           class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-10 pr-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" 
                           placeholder="ejemplo@tiendadolores.com" />
                </div>
                @error('email') <span class="text-rose-450 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Contraseña</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <input type="password" 
                           wire:model="password" 
                           id="password" 
                           required 
                           class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-10 pr-3 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" 
                           placeholder="••••••••" />
                </div>
                @error('password') <span class="text-rose-450 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" 
                       wire:model="remember" 
                       id="remember_me" 
                       class="h-4 w-4 rounded border-slate-800 bg-slate-950 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-900" />
                <label for="remember_me" class="ml-2 block text-xs text-slate-400 font-semibold uppercase tracking-wider cursor-pointer">
                    Recordar sesión
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all duration-200">
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>
