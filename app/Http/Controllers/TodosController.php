<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;

class TodosController extends Controller
{
    // index para mostrar todos los elementos.
    public function index()
    {
        $todos = Todo::all();
        // Mostrar las categorías.
        $categories = Category::all();
        return view('todos.index', ['todos' => $todos , 'categories' =>$categories]);
    }

    // Show para mostrar una tarea en particular.
    public function show($id)
    {
        $todo = Todo::find($id);
        return view('todos.show', ['todo' => $todo]);
    }

    // update para actualizar un todo.
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $todo->title = $request->title;
        $todo->save();
        //dd($request);
        return redirect()->route('todos')->with('success', 'Tarea actualizada!');
    }

    // destroy para eliminar un todo.
    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        return redirect()->route('todos')->with('success', 'Tarea ha sido eliminada!');
    }

    // store para guardar un todo.
    // Recibimos un parámetro
    public function store(Request $request)
    {
        // Validamos.
        $request->validate([
            'title' => 'required|min:3'
        ]);
        // Instanciamos el modelo.
        // Creamos el objeto.
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->category_id =$request->category_id;
        // Guardamos.
        $todo->save();

        return redirect()->route('todos')->with('success', 'Tarea creada correctamente');
    }
}
