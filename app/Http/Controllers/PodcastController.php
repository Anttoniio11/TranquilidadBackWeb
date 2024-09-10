<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;

class PodcastController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        // Inicializa la URL base de la API
        $this->apiUrl = env('URL_SERVER_API', 'http://tranquilidad.test/v1');
    }


    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error al conectarse a la API.');
    }



    public function index()
{
    // Construimos la URL de la API para obtener todos los podcasts
    $url = $this->apiUrl . "/podcasts";

    try {
        // Llamamos a la API para obtener todos los podcasts
        $podcasts = $this->fetchDataFromApi($url);

        // Si no se encuentran podcasts, redirigimos con un error
        if (!$podcasts) {
            return redirect()->route('podcasts.index')->with('error', 'No se encontraron podcasts.');
        }

        // Retornamos la vista con los títulos de los podcasts
        return view('podcasts.index', compact('podcasts'));
    } catch (\Exception $e) {
        // En caso de error, redirigimos con un mensaje de error
        return redirect()->route('podcasts.index')->with('error', 'Error al obtener los podcasts.');
    }
}

    public function show($id)
    {
        $url = $this->apiUrl . "/podcasts/$id";




        try {
            // Llamamos a la API para obtener el podcast y sus relaciones
            $podcast = $this->fetchDataFromApi($url);

            // Si no se encuentra el podcast, redirigimos con un error
            if (!$podcast) {
                return redirect()->route('podcasts.index')->with('error', 'Podcast no encontrado.');
            }

            // Retornamos la vista con los datos del podcast y sus relaciones
            return view('podcasts.show', compact('podcast'));
        } catch (\Exception $e) {
            // En caso de error, redirigimos con un mensaje de error
            return redirect()->route('podcasts.index')->with('error', 'Error al obtener los detalles del podcast.');
        }
    }
}
