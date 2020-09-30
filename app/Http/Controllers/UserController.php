<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // METODO POST
    // @$request => viene en un obj los datos que quiero modificar
    public function store(Request $request){

        // Se consume el metodo de abajo de validacion
        $this->validar($request);

        // Validar si viene una foto
        $input             = $request->all();
        $input['password'] = Hash::make($request->password);
        
        // Crear los datos
        User::create($input);

        // Retornar en estandar JSON, con estado
        return response()->json([
            'response'  => 'Registro insertado correctamente',
        ], 200);
        
    }

    // METODO PARA VALIDAR CAMPOS
    // @$request => bag de datos para validar
    // @$id      => id por si se esta consumiento el metodo desde el update
    // private function validar($request, $id = null){
    private function validar($request){

        // Validar los datos
        // *****************
        $this->validate($request, [
            'name'            => 'required|min:3|max:100', 
            'email'           => 'required|unique:users',
            'password'        => 'required'
        ]);

    }

    // METODO PARA VALIDAR CAMPOS
    // @$request => bag de datos para validar
    public function login(Request $request){

        $user = User::whereEmail($request->email)->first();

        if(!is_null($user) && Hash::check($request->password, $user->password)){

            $user->api_token = Str::random(150);
            $user->save();

            // Retornar en estandar JSON, con estado
            return response()->json([
                'response'  => 'Autenticacion OK',
                'token'     => $user->api_token,
                'message'   => 'Bienvenido al sistema'
            ], 200);

        } else {

            // Retornar en estandar JSON, con estado
            return response()->json([
                'response'  => 'Error de autenticacion',
                'message'   => 'Cuenta o password incorrectos'
            ], 401);

        }

    }

    // METODO PARA CERRAR SESSION
    public function logout(){

        $user            = auth()->user();
        $user->api_token = null;
        $user->save();

        // Retornar en estandar JSON, con estado
        return response()->json([
            'response'  => 'Session cerrada',
        ], 200);

    }
}
