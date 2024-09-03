<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carpeta;
use Illuminate\Http\Request;

class CarpetaController extends Controller
{
    public function index()
    {
        //$folders=Carpeta::all();
        $folders = Carpeta::included()->get();
        //$folders=Carpeta::included()->filter();
        //$folders=Carpeta::included()->filter()->sort()->get();
        //$folders=Carpeta::included()->filter()->sort()->getOrPaginate();
        return response()->json($folders);
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
            'nombre_carpeta' => 'required|max:255',

        ]);

        $folder = Carpeta::create($request->all());

        return response()->json($folder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carpeta  $folder
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $folder = Carpeta::included()->findOrFail($id);
        return response()->json($folder);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carpeta  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carpeta $folder)
    {
        $request->validate([
            'nombre_carpeta' => 'required|max:255' . $folder->id,

        ]);

        $folder->update($request->all());

        return response()->json($folder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carpeta  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carpeta $folder)
    {
        $folder->delete();
        return response()->json($folder);
    }

}
