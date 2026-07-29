<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Control de Cajeros y Usuarios
            </h1>
            <p class="mt-2 text-sm text-slate-400">
                Administra los accesos de cajeros y administradores, asignando un PIN de seguridad de 4 dígitos.
            </p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0">
            <button wire:click="create" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition-all duration-200">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nuevo Usuario
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

    @if (session()->has('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center justify-between shadow-lg shadow-rose-500/5">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-rose-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button class="text-rose-400 hover:text-rose-300 font-medium text-xs uppercase tracking-wider" onclick="this.parentElement.remove()">Cerrar</button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-6 bg-slate-900/50 backdrop-blur-md rounded-2xl border border-slate-800 p-4">
        <div class="relative max-w-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Buscar por nombre o correo electrónico..." 
                   class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 pl-10 pr-4 text-white ring-1 ring-inset ring-slate-800 placeholder:text-slate-500 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" />
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-slate-900/40 backdrop-blur-md rounded-2xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800">
                <thead>
                    <tr class="bg-slate-900/70">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Usuario</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Correo Electrónico</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Rol</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Código PIN</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 bg-transparent">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-800/20 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center font-bold text-slate-300 border border-slate-700">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="font-semibold text-white">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                @if(($user->role ?? 'cajero') === 'admin')
                                    <span class="inline-flex items-center rounded-md bg-purple-500/10 px-2.5 py-1 text-xs font-medium text-purple-400 border border-purple-500/20">
                                        Administrador
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-sky-500/10 px-2.5 py-1 text-xs font-medium text-sky-400 border border-sky-500/20">
                                        Cajero
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-400">
                                <span class="font-mono bg-slate-950 px-2.5 py-1 rounded-lg border border-slate-800 font-bold tracking-wider text-yellow-400">
                                    {{ $user->pin_code ?? '----' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="edit({{ $user->id }})" class="p-2 rounded-lg bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white transition-all duration-150" title="Editar">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $user->id }})" wire:confirm="¿Estás seguro de eliminar este cajero/usuario?" class="p-2 rounded-lg bg-slate-800 hover:bg-rose-600 text-slate-400 hover:text-white transition-all duration-150" title="Eliminar">
                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                    </svg>
                                    <span class="text-sm font-medium">No se encontraron usuarios</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 bg-slate-900/60 border-t border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- User Form Modal -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-slate-900 border border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <!-- Header -->
                    <div class="bg-slate-950 px-6 py-4 border-b border-slate-800/80 flex items-center justify-between">
                        <h3 class="text-lg font-semibold leading-6 text-white" id="modal-title">
                            {{ $userId ? 'Editar Usuario / Cajero' : 'Nuevo Usuario / Cajero' }}
                        </h3>
                        <button wire:click="closeModal" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="save">
                        <div class="px-6 py-5 space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Nombre Completo</label>
                                <input type="text" wire:model="name" id="name" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="Ej. Juan Pérez">
                                @error('name') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Correo Electrónico</label>
                                <input type="email" wire:model="email" id="email" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200" placeholder="juan@example.com">
                                @error('email') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                                    Contraseña {{ $userId ? '(Dejar vacío para no cambiar)' : '' }}
                                </label>
                                <input type="password" wire:model="password" id="password" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                                @error('password') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Role and PIN Code -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Rol</label>
                                    <select wire:model="role" id="role" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200">
                                        <option value="cajero">Cajero</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                    @error('role') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="pin_code" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">PIN de Seguridad (4 dígitos)</label>
                                    <input type="text" maxlength="4" wire:model="pin_code" id="pin_code" class="block w-full rounded-xl border-0 bg-slate-950/60 py-2.5 px-3.5 text-white ring-1 ring-inset ring-slate-800 focus:ring-2 focus:ring-indigo-500 sm:text-sm focus:outline-none transition-all duration-200 font-mono text-center tracking-widest text-yellow-400 font-bold" placeholder="1234">
                                    @error('pin_code') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
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
