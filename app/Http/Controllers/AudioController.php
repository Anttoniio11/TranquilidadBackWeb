<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;

class AudioController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        // Inicializa la URL base de la API
        $this->apiUrl = env('URL_SERVER_API', 'http://tranquilidad.test/v1');
    }

    // Método para listar los audios (sólo títulos en el index)
    public function index()
    {
        $url = $this->apiUrl . '/audios';

        try {
            $audios = $this->fetchDataFromApi($url);

            if (empty($audios)) {
                return view('audios.index')->with('message', 'No hay audios disponibles.');
            }

            return view('audios.index', compact('audios'));
        } catch (\Exception $e) {
            return view('audios.index')->with('error', 'Error al obtener los audios.');
        }
    }

    // Método para mostrar los detalles de un audio
    public function show($id)
    {

        $url = $this->apiUrl . "/audios/$id";  
        try {
            $audio = $this->fetchDataFromApi($url);
    
    
            return view('audios.show', compact('audio'));
        } catch (\Exception $e) {
            return redirect()->route('audios.index')->with('error', 'Error al obtener los detalles del audio.');
        }
       
    }

    // Función para manejar las llamadas a la API
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error al conectarse a la API.');
    }
}
