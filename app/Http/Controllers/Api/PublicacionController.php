<?php

namespace App\Http\Controllers\Api;
use App\Models\Publicacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index()
    {
        $publications=Publicacion::all();
        //$publications = Publicacion::included()->get();
        //$publications= Publicacion::included()->filter();
        //$publications=Publicacion::included()->filter()->sort()->get();
        //$publications=Publicacion::included()->filter()->sort()->getOrPaginate();
        return response()->json($publications);
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
           'nombre_Publicacion' => 'required|max:255',
            'descripcion_publicacion' => 'required|max:255',
            'num_reacciones' => 'required|max:255',
            'num_compartidos' => 'required|max:255',

            
          
        ]);

        $publication= Publicacion::create($request->all());

        return response()->json($publication);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publicacion  $publication
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $publication = Publicacion::included()->findOrFail($id);
        return response()->json($publication);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publicacion  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publicacion $publication)
    {
        $request->validate([
           'nombre_Publicacion' => 'required|max:255',
            'descripcion_publicacion' => 'required|max:255',
            'num_reacciones' => 'required|max:255',
            'num_compartidos' => 'required|max:255',

        ]);

        $publication->update($request->all());

        return response()->json($publication);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publicacion  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicacion $publication)
    {
        $publication->delete();
        return response()->json($publication);
    }
}
