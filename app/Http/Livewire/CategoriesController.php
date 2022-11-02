<?php

namespace App\Http\Livewire;

use App\Helpers\GlobalApp;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $search, $image, $selected_id = 0, $pageTitle, $componentName;
    protected $listeners = ['deleteRow' => 'destroy'];
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorías';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $categories = Category::when($this->search, function($q) {
            $q->where('name', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.category.categories', compact('categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function edit(Category $category)
    {
        $this->name = $category->name;
        $this->selected_id = $category->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function store()
    {
        $rules = $this->getRulesAndMessages('store');
        $this->validate($rules['rules'], $rules['messages']);
        $data['name'] = $this->name;

        if($this->image) {
            $customFileName = GlobalApp::saveFile($this->image, 'categories');
            $data['image'] = $customFileName;
        }

        Category::create($data);

        $this->resetUI();
        $this->emit('category-added', 'Categoria Registrada');
    }

    public function update()
    {
        $rules = $this->getRulesAndMessages('update');
        $this->validate($rules['rules'], $rules['messages']);
        $data['name'] = $this->name;

        $category = Category::find($this->selected_id);

        if($this->image) {
            $customFileName = GlobalApp::saveFile($this->image, 'categories');
            $data['image'] = $customFileName;

            if ($category->image != null && file_exists('storage/categories/' . $category->image)) {
                unlink('storage/categories/'. $category->image);
            }
        }

        $category->update($data);

        $this->resetUI();
        $this->emit('category-updated', 'Categoria Actualizada');
    }

    public function destroy(Category $category)
    {
        $image_name = $category->image;
        $category->delete();

        $image_name && unlink('storage/categories/' . $image_name);

        $this->resetUI();
        $this->emit('category-deleted', 'Categoria Eliminada');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    protected function getRulesAndMessages($type = null)
    {
        $rules = [
            'name' => 'required|min:3|unique:categories',
        ];

        $type === 'update' && $rules['name'] .= ",name,{$this->selected_id}";

        $messages = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.unique' => 'Nombre de la categoria ya existe',
            'name.min' => 'Nombre de la categoria debe tener al menos 3 caracteres',
        ];

        return [
            'rules' => $rules,
            'messages' => $messages
        ];
    }
}
