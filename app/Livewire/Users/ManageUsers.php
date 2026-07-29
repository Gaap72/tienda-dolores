<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Componente Livewire para la gestión de usuarios y cajeros.
 * Permite administrar las credenciales de inicio de sesión y el PIN de seguridad de los cajeros.
 */
class ManageUsers extends Component
{
    use WithPagination;

    // Filtro de búsqueda por nombre o correo electrónico
    public $search = '';

    // Propiedades vinculadas al formulario
    public $userId = null;  // ID del usuario en caso de edición
    public $name = '';      // Nombre completo del cajero/usuario
    public $email = '';     // Correo electrónico
    public $password = '';  // Contraseña de acceso
    public $role = 'cajero'; // Rol dentro de la tienda ('admin', 'cajero')
    public $pin_code = '';  // PIN de seguridad de 4 dígitos

    // Estado del modal del formulario
    public $isOpen = false;

    /**
     * Resetea la página actual cuando se cambia el filtro de búsqueda.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Reglas de validación para guardar un usuario.
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->userId),
            ],
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:admin,cajero',
            'pin_code' => 'required|digits:4',
        ];
    }

    /**
     * Abre el modal y limpia el formulario para la creación de un nuevo usuario.
     */
    public function create()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->userId = null;
        $this->isOpen = true;
    }

    /**
     * Carga un usuario existente para su posterior edición.
     */
    public function edit($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Se mantiene en blanco para que no cambie a menos que se escriba algo
        $this->role = $user->role ?? 'cajero';
        $this->pin_code = $user->pin_code ?? '';
        $this->isOpen = true;
    }

    /**
     * Guarda el usuario (crea o actualiza) aplicando hashing a la contraseña si se definió una.
     */
    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'pin_code' => $this->pin_code,
        ];

        // Hashea la contraseña sólo si no está en blanco
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        $this->isOpen = false;
        $this->resetForm();
        session()->flash('message', $this->userId ? 'Usuario/Cajero actualizado correctamente.' : 'Usuario/Cajero creado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos (evita que se borre el único usuario existente).
     */
    public function delete($id)
    {
        if (User::count() <= 1) {
            session()->flash('error', 'No se puede eliminar el único usuario del sistema.');
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('message', 'Usuario/Cajero eliminado correctamente.');
    }

    /**
     * Cierra el modal de formulario.
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    /**
     * Limpia los campos del formulario.
     */
    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'cajero';
        $this->pin_code = '';
    }

    /**
     * Consulta y filtra los usuarios con paginación para inyectarlos en la vista.
     */
    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.users.manage-users', [
            'users' => $users,
        ])->layout('components.layouts.app');
    }
}
