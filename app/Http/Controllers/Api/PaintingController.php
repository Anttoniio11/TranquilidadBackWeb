<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controllers;
use App\Models\Painting;
use Illuminate\Http\Request;

class PaintingController extends Controller
{
    
    public function index()
    {
        //$paintings=Painting::all();
        $paintings = Painting::included()->get();
        //$paintings=Painting::included()->filter();
        //$paintings=Painting::included()->filter()->sort()->get();
        //$paintings=Painting::included()->filter()->sort()->getOrPaginate();
        return response()->json($paintings);
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
            'user_id'=> 'required|exists:users,id',
            'gallery_id'=>'required|exists:galleries,id',
            'template_id'=>'required|exists:templates,id',
            'painting_name'=> 'required|max:100',
            'painting_url'=>'required|max:100'

        ]);

        $Painting = Painting::create($request->all());

        return response()->json($Painting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Painting  $Painting
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $Painting = Painting::included()->findOrFail($id);
        return response()->json($Painting);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Painting  $Painting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Painting $Painting)
    {
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'gallery_id'=>'required|exists:galleries,id',
            'template_id'=>'required|exists:templates,id',
            'Painting_name'=> 'required|max:100',
            'Painting_url'=>'required|max:100'
        ]);

        $Painting->update($request->all());

        return response()->json($Painting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Painting  $Painting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Painting $Painting)
    {
        $Painting->delete();
        return response()->json($Painting);
    }

}
