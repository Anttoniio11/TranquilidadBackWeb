<?php

namespace App\Http\Controllers\Api\arteTerapia;
use App\Http\Controllers\Controller;
use App\Models\arteTerapia\Category;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class CategoryController extends Controller
{
    //
    public function index()
    {
        //$category=Category::all();
        $category = Category::included()->get();
        //$category=Category::included()->filter();
        //$category=Category::included()->filter()->sort()->get();
        //$category=Category::included()->filter()->sort()->getOrPaginate();
        return response()->json($category);
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

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $category = Category::included()->findOrFail($id);
        
        return response()->json($category);
        //http://tranquilidad.test/v1/categories/1/?included=plantilla
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $category
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|max:255',
        ]);
        
        $category->update($request->only(['category_name']));

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
