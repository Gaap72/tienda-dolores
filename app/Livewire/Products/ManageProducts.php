<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

/**
 * Componente Livewire para la administración de productos en el catálogo.
 * Soporta creación, edición, eliminación y búsqueda paginada, con carga de imágenes.
 */
class ManageProducts extends Component
{
    use WithPagination, WithFileUploads;

    // Propiedad pública para almacenar la cadena de búsqueda en tiempo real
    public $search = '';

    // Propiedades del formulario para almacenar los valores del producto
    public $productId = null; // ID del producto en caso de edición
    public $name = '';        // Nombre del producto
    public $barcode = '';     // Código de barras del producto (opcional, indexado)
    public $category_id = ''; // ID de la categoría a la que pertenece
    public $description = '';  // Descripción larga del producto (opcional)
    public $price = '';       // Precio de venta al público
    public $cost = '';        // Costo de adquisición
    public $stock = 0;        // Stock físico actual
    public $stock_min = 5;    // Stock mínimo de alerta
    public $unit_measure = 'pza'; // Unidad de medida (pza, kg, lt, cja)
    
    // Propiedades para la gestión de imágenes
    public $image; // Archivo de imagen subido
    public $existingImagePath = null; // Ruta de imagen existente

    // Propiedad para controlar la visualización del modal
    public $isOpen = false;

    /**
     * Resetea la paginación cuando el usuario cambia el input de búsqueda.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Reglas de validación para el formulario de productos.
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_min' => 'required|integer|min:0',
            'unit_measure' => 'required|in:pza,kg,lt,cja',
            'image' => 'nullable|image|max:2048', // Límite de 2MB
        ];
    }

    /**
     * Prepara e inicializa el formulario para la creación de un nuevo producto.
     */
    public function create()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->productId = null;
        $this->isOpen = true; // Abre el modal
    }

    /**
     * Carga la información de un producto existente para su edición.
     */
    public function edit($id)
    {
        $this->resetValidation();
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->category_id = $product->category_id;
        $this->description = $product->description ?? '';
        $this->price = $product->price;
        $this->cost = $product->cost;
        $this->stock = $product->stock;
        $this->stock_min = $product->stock_min;
        $this->unit_measure = $product->unit_measure;
        $this->existingImagePath = $product->image_path;
        $this->isOpen = true; // Abre el modal
    }

    /**
     * Valida y guarda (crea o actualiza) el producto en la base de datos.
     */
    public function save()
    {
        $this->validate();

        // Determina la ruta de la imagen a guardar
        $imagePath = $this->existingImagePath;
        if ($this->image) {
            // Guarda la imagen en la carpeta public/products y retorna la ruta
            $imagePath = $this->image->store('products', 'public');
        }

        Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'category_id' => $this->category_id,
                'barcode' => $this->barcode ?: null,
                'name' => $this->name,
                'description' => $this->description ?: null,
                'price' => $this->price,
                'cost' => $this->cost,
                'stock' => $this->stock,
                'stock_min' => $this->stock_min,
                'unit_measure' => $this->unit_measure,
                'is_active' => true,
                'image_path' => $imagePath,
            ]
        );

        $this->isOpen = false; // Cierra el modal
        $this->resetForm();
        session()->flash('message', $this->productId ? 'Producto actualizado correctamente.' : 'Producto creado correctamente.');
    }

    /**
     * Elimina el producto de la base de datos.
     */
    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Producto eliminado correctamente.');
    }

    /**
     * Cierra el modal del formulario y limpia el estado del mismo.
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    /**
     * Limpia los campos del formulario a sus valores por defecto.
     */
    private function resetForm()
    {
        $this->name = '';
        $this->barcode = '';
        $this->category_id = '';
        $this->description = '';
        $this->price = '';
        $this->cost = '';
        $this->stock = 0;
        $this->stock_min = 5;
        $this->unit_measure = 'pza';
        $this->image = null;
        $this->existingImagePath = null;
    }

    /**
     * Renderiza la vista del listado de productos, aplicando filtros de búsqueda y paginación.
     */
    public function render()
    {
        $products = Product::with('category')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('barcode', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('livewire.products.manage-products', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('components.layouts.app');
    }
}
