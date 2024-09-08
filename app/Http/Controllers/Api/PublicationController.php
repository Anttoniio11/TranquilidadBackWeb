<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    
    public function index()
    {
        //$publications=Publication::all();
        $publications = Publication::included()->get();
        //$publications=Publication::included()->filter();
        //$publications=Publication::included()->filter()->sort()->get();
        //$publications=Publication::included()->filter()->sort()->getOrPaginate();
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
            'user_id'=>'required|exists:users,id',
            'publication_description' => 'required|max:255',
            'publication_url'=>'required|max:100',
            'reaction_count'=>'required|max:100',
            'shared_count'=>'required|max:100'

        ]);

        $Publication = Publication::create($request->all());

        return response()->json($Publication);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $Publication
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $Publication = Publication::included()->findOrFail($id);
        return response()->json($Publication);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $Publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $Publication)
    {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'Publication_description' => 'required|max:255',
            'publication_url'=>'required|max:100',
            'reaction_count'=>'required|max:100',
            'shared_count'=>'required|max:100'
        ]);

        $Publication->update($request->all());

        return response()->json($Publication);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $Publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $Publication)
    {
        $Publication->delete();
        return response()->json($Publication);
    }

}
