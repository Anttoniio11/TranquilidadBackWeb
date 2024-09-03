<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Http;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $food)
    {

        $apiKey = env('API_KEY');  //la api key metida en una variable

        $response = Http::withHeaders([
            'Accept' => 'application/json'  //encabezados 
        ])->get('https://api.nal.usda.gov/fdc/v1/foods/search', [
            'query' => $food,   //consulta la fruta que quiere a traves de la varible de la ruta
            'API_KEY' => $apiKey  //pasa la api key como un parametro de la consulta
        ]);

        if ($response->successful()) {
            return $response->json(); //si esta correcto te muestra la api
        } else {
            return response()->json([
                'error' => 'Error en la respuesta de la API'
            ], $response->status());
        }
        

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
