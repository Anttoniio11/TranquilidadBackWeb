<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     // Obtener todos los usuarios
     public function index()
    {
       //$categories=Category::all();
           // $perfil = Perfil::with(['estudios'])->get();
           //$categories=Category::included()->filter();
           $usuario= User::included()->get();
            //$categories=Category::included()->filter()->sort()->get();
            //$categories=Category::included()->filter()->sort()->getOrPaginate();
            return response()->json($usuario);
    }
     // Obtener un usuario por ID
     public function show($id)
     {
         return User::findOrFail($id);
     }

     // Crear un nuevo usuario
    //  public function store(Request $request)
    //  {
    //      $validated = $request->validate([
    //          'nombres' => 'required|string|max:255', // Agrega la validación para el campo 'name'
    //          'apellidos' => 'required|string|max:255',
    //          'email' => 'required|email|unique:users,email',
    //          'password' => 'required|min:8',
    //      ]);

    //      $usuario = User::create($validated);
    //      return response()->json($usuario, 201);
    //  }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Asegúrate de agregar confirmación de contraseña
            // Validación del perfil
            'foto_perfil'=>'string',
            'tipo_perfil' => 'required|string|in:Normal,Profesional',
            'fecha_nacimiento' => 'required|date',
            'lugar_residencia' => 'required|string|max:255',
            'lugar_nacimiento' => 'required|string|max:255',
            'acerca_de_mi' => 'required|string|max:500',
        ]);

        // Crear el usuario
        $usuario = User::create([
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'password' =>$request->password, // Hashear la contraseña
        ]);

        // Crear el perfil asociado al usuario
        $usuario->perfil()->create([
            'foto_perfil'=>$validated['foto_perfil'],
            'tipo_perfil' => $validated['tipo_perfil'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'lugar_residencia' => $validated['lugar_residencia'],
            'lugar_nacimiento' => $validated['lugar_nacimiento'],
            'acerca_de_mi' => $validated['acerca_de_mi'],
        ]);

        return response()->json($usuario, 201);
    }


     // Actualizar un usuario
     public function update(Request $request, $id)
     {
         $usuario = User::findOrFail($id);
         $usuario->update($request->all());
         return response()->json($usuario, 200);
     }

     // Eliminar un usuario
     public function destroy($id)
     {
         $usuario = User::findOrFail($id);
         $usuario->delete();
         return response()->json(null, 204);
     }
}
