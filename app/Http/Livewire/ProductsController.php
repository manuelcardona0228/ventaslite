<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsController extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $barcode, $cost, $price, $stock, $alerts, $category_id,
    $search, $image, $selected_id, $pageTitle, $componentName;

    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->category_id = 'Elegir';
    }

    public function render()
    {
        $categories = [];
        $products = Product::when($this->search, function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('barcode', 'like', '%' . $this->search . '%')
                ->orWhere(function ($q) {
                    $q->whereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
                });
        })->orderBy('name', 'asc')
            ->paginate($this->pagination);

        return view('livewire.product.products', compact('products', 'categories'))
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
