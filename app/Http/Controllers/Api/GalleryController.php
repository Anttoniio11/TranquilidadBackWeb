<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controllers;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        //$galleries=Gallery::all();
        $galleries = Gallery::included()->get();
        //$galleries=Gallery::included()->filter();
        //$galleries=Gallery::included()->filter()->sort()->get();
        //$galleries=Gallery::included()->filter()->sort()->getOrPaginate();
        return response()->json($galleries);
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
            'user_id'=>'required|exists:users,id',
            'gallery_name' => 'required|max:255',
           

        ]);

        $Gallery = Gallery::create($request->all());

        return response()->json($Gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $Gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $Gallery = Gallery::included()->findOrFail($id);
        return response()->json($Gallery);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $Gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $Gallery)
    {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'gallery_name' => 'required|max:255',
        ]);

        $Gallery->update($request->all());

        return response()->json($Gallery);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $Gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $Gallery)
    {
        $Gallery->delete();
        return response()->json($Gallery);
    }

}
