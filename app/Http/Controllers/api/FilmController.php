<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();
        if(count($films) <= 0){
            return response()->json([
                'result' => false,
                'msg' => "Por el momento no hay peliculas disponibles."
            ]);
        }
        return response()->json([
            'result' => true,
            'msg' => "Peliculas del momento",
            'data' => $films
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:128',
            'description' => 'nullable|string',
            'release_year' => 'nullable|digits:4|integer|between:1900,' . date('Y'),
            'language_id' => 'required|exists:languages,id',
            'original_language_id' => 'nullable|exists:languages,id',
            'rental_duration' => 'nullable|integer|min:0',
            'rental_rate' => 'nullable|numeric|min:0',
            'length' => 'nullable|integer|min:1',
            'replacement_cost' => 'nullable|numeric|min:0',
            'rating' => 'nullable|in:G,PG,PG-13,R,NC-17',
            'special_features' => 'nullable',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.string' => 'El título debe ser una cadena de texto.',
            'title.max' => 'El título no puede tener más de 128 caracteres.',

            'description.string' => 'La descripción debe ser una cadena de texto.',

            'release_year.digits' => 'El año de estreno debe tener 4 dígitos.',
            'release_year.integer' => 'El año de estreno debe ser un número entero.',
            'release_year.between' => 'El año de estreno debe estar entre 1900 y el año actual.',

            'language_id.required' => 'El idioma es obligatorio.',
            'language_id.exists' => 'El idioma seleccionado no existe en la base de datos.',

            'original_language_id.exists' => 'El idioma original seleccionado no existe en la base de datos.',

            'rental_duration.integer' => 'La duración del alquiler debe ser un número entero.',
            'rental_duration.min' => 'La duración del alquiler debe ser al menos 1.',

            'rental_rate.numeric' => 'La tarifa de alquiler debe ser un número.',
            'rental_rate.min' => 'La tarifa de alquiler debe ser al menos 0.',

            'length.integer' => 'La duración de la película debe ser un número entero.',
            'length.min' => 'La duración de la película debe ser al menos 1.',

            'replacement_cost.numeric' => 'El costo de reemplazo debe ser un número.',
            'replacement_cost.min' => 'El costo de reemplazo debe ser al menos 0.',

            'rating.in' => 'El valor del campo calificación debe ser uno de los siguientes: G, PG, PG-13, R, NC-17.',

            'special_features.array' => 'Las características especiales deben ser un arreglo.',
            'special_features.*.in' => 'Cada característica especial debe ser uno de los siguientes: Trailers, Commentaries, Deleted Scenes, Behind the Scenes.',
        ]);
        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }
        $film = Film::create($request->only(['title','description','release_year','language_id','original_language_id','rental_duration','rental_rate','length','replacement_cost','rating','special_features']));
        return response()->json([
            'result' => true,
            'msg' => "Se creo la pelicula de " . $film->title . " de manera exitosa."
        ]);
    }

    public function show(int $id)
    {
        $film = Film::find($id);
        if(!$film){
            return response()->json([
                'result' => false,
                'msg' => "No se encontro la pelicula buscada."
            ]);
        }
        return response()->json([
            'result' => true,
            'msg' => "Se encontro la pelicula de " . $film->title . ".",
            'data' => $film
        ]);
    }
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:128',
            'description' => 'nullable|string',
            'release_year' => 'nullable|digits:4|integer|between:1900,' . date('Y'),
            'language_id' => 'required|exists:languages,id',
            'original_language_id' => 'nullable|exists:languages,id',
            'rental_duration' => 'nullable|integer|min:1',
            'rental_rate' => 'nullable|numeric|min:0',
            'length' => 'nullable|integer|min:1',
            'replacement_cost' => 'nullable|numeric|min:0',
            'rating' => 'nullable|in:G,PG,PG-13,R,NC-17',
            'special_features' => 'nullable',
            'special_features.*' => 'in:Trailers,Commentaries,Deleted Scenes,Behind the Scenes',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.string' => 'El título debe ser una cadena de texto.',
            'title.max' => 'El título no puede tener más de 128 caracteres.',

            'description.string' => 'La descripción debe ser una cadena de texto.',

            'release_year.digits' => 'El año de estreno debe tener 4 dígitos.',
            'release_year.integer' => 'El año de estreno debe ser un número entero.',
            'release_year.between' => 'El año de estreno debe estar entre 1900 y el año actual.',

            'language_id.required' => 'El idioma es obligatorio.',
            'language_id.exists' => 'El idioma seleccionado no existe en la base de datos.',

            'original_language_id.exists' => 'El idioma original seleccionado no existe en la base de datos.',

            'rental_duration.integer' => 'La duración del alquiler debe ser un número entero.',
            'rental_duration.min' => 'La duración del alquiler debe ser al menos 1.',

            'rental_rate.numeric' => 'La tarifa de alquiler debe ser un número.',
            'rental_rate.min' => 'La tarifa de alquiler debe ser al menos 0.',

            'length.integer' => 'La duración de la película debe ser un número entero.',
            'length.min' => 'La duración de la película debe ser al menos 1.',

            'replacement_cost.numeric' => 'El costo de reemplazo debe ser un número.',
            'replacement_cost.min' => 'El costo de reemplazo debe ser al menos 0.',

            'rating.in' => 'El valor del campo calificación debe ser uno de los siguientes: G, PG, PG-13, R, NC-17.',

            'special_features.array' => 'Las características especiales deben ser un arreglo.',
            'special_features.*.in' => 'Cada característica especial debe ser uno de los siguientes: Trailers, Commentaries, Deleted Scenes, Behind the Scenes.',
        ]);
        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }
        $film = Film::find($id);
        if(!$film){
            return response()->json([
                'result' => false,
                'msg' => "La pelicula ingresada no existe."
            ]);
        }
        $film->update($request->only(['title','description','release_year','language_id','original_language_id','rental_duration','rental_rate','length','replacement_cost','rating','special_features']));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizaron los datos de " . $film->title . " de manera exitosa."
        ]);


    }
    public function destroy($id)
    {
        $film = Film::find($id);
        if(!$film){
            return response()->json([
                'result' => false,
                'msg' => "No se encontro la pelicula buscada."
            ]);
        }
        $film->delete();
        return response()->json([
            'result' => true,
            'msg' => "Se elimino la pelicula de " . $film->title . ".",
        ]);
    }
}
