<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
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
        $url = $this->apiUrl . '/albums';

        try {
            $albums = $this->fetchDataFromApi($url);

            if (empty($albums)) {
                return view('albums.index')->with('message', 'No hay álbumes disponibles.');
            }

            return view('albums.index', compact('albums'));
        } catch (\Exception $e) {
            return view('albums.index')->with('error', 'Error al obtener los álbumes.');
        }
    }

    public function show($id)
    {
        $url = $this->apiUrl . "/albums/$id?included=audios";

        try {
            $album = $this->fetchDataFromApi($url);

            if (empty($album)) {
                return redirect()->route('albums.index')->with('error', 'Álbum no encontrado.');
            }

            return view('albums.show', compact('album'));
        } catch (\Exception $e) {
            return redirect()->route('albums.index')->with('error', 'Error al obtener los detalles del álbum.');
        }
    }



    
}
