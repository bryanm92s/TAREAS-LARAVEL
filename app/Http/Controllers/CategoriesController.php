<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías.
        $categories = Category::all();
        // Regresamos una vista
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        // Insertar
    }

    public function store(Request $request)
    {
        // Guardar.
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'color' => 'required|max:7'
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->color = $request->color;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Nueva categoría agregada');
    }

    public function show($id)
    {
        // Mostrar formulario para actualizar.
        $category = Category::find($id);
        return view('categories.show', ['category' => $category]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $category)
    {
        //
        $category = Category::find($category);
        // Recuperamos los inputs del formulario.
        $category->name = $request->name;
        $category->color = $request->color;
        // Guardamos.
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada!');
    }

    public function destroy($category)
    {
        // Buscarla y eliminarla.
        $category = Category::find($category);
        // Eliminar los elementos.
        $category->todos()->each(function($todo){
            $todo->delete();
        });
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada!');
    }
}
