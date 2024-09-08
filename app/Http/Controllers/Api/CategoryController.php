<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
<<<<<<< HEAD:app/Http/Controllers/Api/CategoriaController.php
        //$categories=Categoria::all();
        //$categories = Categoria::included()->get();
        $categories = Categoria::filter()->included()->get();
        //$categories=Categoria::included()->filter()->sort()->get();
        //$categories=Categoria::included()->filter()->sort()->getOrPaginate();
=======
        //$categories=Category::all();
        $categories = Category::included()->get();
        //$categories=Category::included()->filter();
        //$categories=Category::included()->filter()->sort()->get();
        //$categories=Category::included()->filter()->sort()->getOrPaginate();
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Http/Controllers/Api/CategoryController.php
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
            'category_name' => 'required|max:255',
            

        ]);

        $category = Category::create($request->all());

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
<<<<<<< HEAD:app/Http/Controllers/Api/CategoriaController.php
        //$category = Categoria::findOrFail($id);
        $category = Categoria::included()->findOrFail($id);
=======
        
        $category = Category::included()->findOrFail($id);
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Http/Controllers/Api/CategoryController.php
        return response()->json($category);
        //http://tranquilidad.test/v1/categories/1/?included=plantilla
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|max:255' . $category->id,

        ]);

        $category->update($request->all());

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json($category);
    }
}
