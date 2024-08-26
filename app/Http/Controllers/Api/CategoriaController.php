<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function index()
    {
        $categories=Categoria::all();
        //$categories = Categoria::included()->get();
        //$categories=Categoria::included()->filter();
        //$categories=Categoria::included()->filter()->sort()->get();
        //$categories=Categoria::included()->filter()->sort()->getOrPaginate();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombre_categoria' => 'required|max:255',
            

        ]);

        $category = Categoria::create($request->all());

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $category = Categoria::included()->findOrFail($id);
        return response()->json($category);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $category)
    {
        $request->validate([
            'nombre_categoria' => 'required|max:255' . $category->id,

        ]);

        $category->update($request->all());

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $category)
    {
        $category->delete();
        return response()->json($category);
    }
}
