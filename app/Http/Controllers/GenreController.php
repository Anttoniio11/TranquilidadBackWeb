<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('URL_SERVER_API', 'http://tranquilidad.test/v1');
    }


    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        } else {
            abort(500, 'Error al conectar con la API');
        }
    }

    public function index(){

        $url = $this->apiUrl . '/genres';
        $genres = $this->fetchDataFromApi($url);
        return view('genres.index', compact('genres'));
    }

    public function show($id){

        $url = $this->apiUrl . "/genres/$id?included=audios";

        $genre = $this->fetchDataFromApi($url);
        return view('genres.show', compact('genre'));
    }


    
}
