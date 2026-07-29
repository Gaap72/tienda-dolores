<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Componente Livewire para la gestión de categorías.
 * Permite crear, listar, buscar, editar y eliminar o desactivar categorías del catálogo.
 */
class ManageCategories extends Component
{
    use WithPagination;

    // Filtro de búsqueda en tiempo real
    public $search = '';

    // Propiedades vinculadas al formulario
    public $categoryId = null; // ID de la categoría (nulo si es creación)
    public $name = '';        // Nombre de la categoría
    public $slug = '';        // Slug amigable para URLs
    public $description = '';  // Descripción de la categoría
    public $is_active = true; // Estado de actividad de la categoría

    // Estado del modal de formulario
    public $isOpen = false;

    /**
     * Resetea la página actual cuando se cambia el filtro de búsqueda.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Genera automáticamente el slug cuando se escribe el nombre
     * (sólo en modo de creación).
     */
    public function updatedName()
    {
        if (!$this->categoryId) {
            $this->slug = Str::slug($this->name);
        }
    }

    /**
     * Reglas de validación para guardar una categoría.
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($this->categoryId),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Inicializa y abre el modal en modo de creación.
     */
    public function create()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->categoryId = null;
        $this->isOpen = true;
    }

    /**
     * Carga una categoría para su posterior edición.
     */
    public function edit($id)
    {
        $this->resetValidation();
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->is_active = (bool) $category->is_active;
        $this->isOpen = true;
    }

    /**
     * Guarda la categoría (crea o actualiza) y cierra el modal.
     */
    public function save()
    {
        $this->validate();

        Category::updateOrCreate(
            ['id' => $this->categoryId],
            [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description ?: null,
                'is_active' => $this->is_active,
            ]
        );

        $this->isOpen = false;
        $this->resetForm();
        session()->flash('message', $this->categoryId ? 'Categoría actualizada correctamente.' : 'Categoría creada correctamente.');
    }

    /**
     * Elimina la categoría seleccionada.
     * Si tiene productos asociados, la desactiva en lugar de borrarla para mantener la integridad referencial.
     */
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->exists()) {
            $category->is_active = false;
            $category->save();
            session()->flash('message', 'La categoría tiene productos asociados. Se ha desactivado en lugar de eliminar.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Categoría eliminada correctamente.');
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
     * Limpia los valores del formulario a su estado original.
     */
    private function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->is_active = true;
    }

    /**
     * Obtiene el listado filtrado y paginado de categorías para renderizar en la vista.
     */
    public function render()
    {
        $categories = Category::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.categories.manage-categories', [
            'categories' => $categories,
        ])->layout('components.layouts.app');
    }
}
