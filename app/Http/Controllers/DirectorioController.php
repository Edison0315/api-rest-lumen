<?php

namespace App\Http\Controllers;

use App\Directorio;
use Illuminate\Http\Request;


class DirectorioController extends Controller {

    // Variable de clase para la respuesta del API
    public $response;
    
    // METODO INDEX
    // @$request => Si viene algun filtro, o vacio que seria un valor tambien
    public function index(Request $request){

        // Validador para un filtro 
        if($request->has('txtBuscar')){

            // Almacenar el Response en una variable
            $this->response = Directorio::whereTelefono($request->txtBuscar)
                                    ->orWhere('nombre_completo', 'like', '%'.$request->txtBuscar.'%')->get();

            // Validar el estado de la peticion
            if(count($this->response) > 0){
                // Retornar en estandar JSON, con estado
                return response()->json([
                    'response'  => $this->response,
                ], 200);

            } else { 
                // Retornar en estandar JSON, con estado
                return response()->json([
                    'response'  => 'No existen resultados',
                ], 400);
            }
            

        } else {

            $this->response = Directorio::all();

            // Retornar en estandar JSON, con estado
            return response()->json([
                'response'  => $this->response,
            ], 200);
        } 


    }


    // METODO SHOW
    // @$id => viene el ID del registro a consultar
    public function show($id){

        // Del tutorial
        // $this->response = Directorio::findOrFail($id);
        $this->response = Directorio::find($id);

        // Validar el estado de la peticion
        if($this->response){

            // Retornar en estandar JSON, con estado
            return response()->json([
                'response'  => $this->response,
            ], 200);

        } else {

            // Retornar en estandar JSON, con estado
            return response()->json([
                'response'  => 'No existen resultados',
            ], 400);

        }

    }


    // METODO POST
    // @$request => viene en un obj los datos que quiero modificar
    public function store(Request $request){

        // Se consume el metodo de abajo de validacion
        $this->validar($request);

        // Validar si viene una foto
        $input = $request->all();
        if ($request->has('url_foto'))
            $input['url_foto'] = $this->cargarFoto($request->url_foto);
        
        // Crear los datos
        Directorio::create($input);

        // Retornar en estandar JSON, con estado
        return response()->json([
            'response'  => 'Registro insertado correctamente',
        ], 200);
        
    }

    // METODO PUT
    // @$id      => viene el ID del registro a consultar
    // @$request => viene en un obj los datos que quiero modificar
    public function update(Request $request, $id){

        // Validar los datos
        // *****************
        // En el validador en el UNIQUE cuando se ve ese parametro: @id
        // se usa para validar todos menos el que yo tengo        
        $this->validar($request, $id);

        // Validar si viene una foto
        $input = $request->all();
        if ($request->has('url_foto'))
            $input['url_foto'] = $this->cargarFoto($request->url_foto);
        
        // Buscar los datos
        $directorio = Directorio::find($id);

        // Actualizar los datos encontrados
        $directorio->update($input);

        // Retornar en estandar JSON, con estado
        return response()->json([
            'response'  => 'Registro modificado correctamente',
        ], 200);
        
    }

    // METODO DELETE
    // @$id      => viene el ID del registro a eliminar
    public function delete($id){
        // Eliminar los datos
        $directorio = Directorio::destroy($id);

        // Retornar en estandar JSON, con estado
        return response()->json([
            'response'  => 'Registro eliminado correctamente',
        ], 200);

    }

    // METODO PARA VALIDAR CAMPOS
    // @$request => bag de datos para validar
    // @$id      => id por si se esta consumiento el metodo desde el update
    private function validar($request, $id = null){
        
        // Operador ternario para validar el ID
        $rule = is_null($id) ? '' : ',' . $id;

        // Validar los datos
        // *****************
        $this->validate($request, [
            'nombre_completo' => 'required|min:3|max:100', 
            'telefono'        => 'required|unique:directorios,telefono'.$rule
        ]);

    }

    // METODO PARA VALIDAR CAMPOS
    // @$file  => valor de la foto que necesitamos 
    private function cargarFoto($file){
        
        $nombreArchivo = time() . "." . $file->getClientOriginalExtension();
        $file->move(base_path('/public/fotografias'), $nombreArchivo);
        return $nombreArchivo;

    }
}