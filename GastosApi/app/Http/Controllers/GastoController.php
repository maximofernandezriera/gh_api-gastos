<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GastoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // 📌 Listar todos los gastos del usuario autenticado
   public function index(Request $request)
{
    $user = JWTAuth::parseToken()->authenticate();
    
    // Obtener filtros opcionales
    $category = $request->query('categoria');
    $priceRange = $request->query('precio');

    // Iniciar la consulta de gastos del usuario
    $query = $user->gastos();

    // 📌 Filtrar por categoría si se proporciona
    if ($category) {
        $query->where('category', $category);
    }

    // 📌 Filtrar por rango de precio
    if ($priceRange) {
        if ($priceRange === 'bajo') {
            $query->where('amount', '<', 50);
        } elseif ($priceRange === 'medio') {
            $query->whereBetween('amount', [50, 200]);
        } elseif ($priceRange === 'alto') {
            $query->where('amount', '>', 200);
        }
    }

    // Ejecutar la consulta y obtener los resultados
    $gastos = $query->get();

    return response()->json([
        'message' => 'Lista de gastos obtenida correctamente',
        'gastos' => $gastos
    ], 200);
}


    // 📌 Crear un nuevo gasto
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        // Validar los datos
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:Comestibles,Ocio,Electrónica,Utilidades,Ropa,Salud,Otros'
        ]);

        $gasto = new Gasto($request->all());
        $user->gastos()->save($gasto);

        return response()->json([
            'message' => 'Gasto registrado correctamente',
            'gasto' => $gasto
        ], 201);
    }

    // 📌 Actualizar un gasto existente
    public function update(Request $request, Gasto $gasto)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($gasto->user_id !== $user->id) {
            return response()->json([
                'error' => 'No tienes permiso para modificar este gasto'
            ], 403);
        }

        // Validar los datos antes de actualizar
        $request->validate([
            'description' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:0',
            'category' => 'sometimes|in:Comestibles,Ocio,Electrónica,Utilidades,Ropa,Salud,Otros'
        ]);

        $gasto->update($request->all());

        return response()->json([
            'message' => 'Gasto actualizado correctamente',
            'gasto' => $gasto
        ], 200);
    }

    // 📌 Eliminar un gasto
    public function destroy(Gasto $gasto)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($gasto->user_id !== $user->id) {
            return response()->json([
                'error' => 'No tienes permiso para eliminar este gasto'
            ], 403);
        }

        $descripcion = $gasto->description;
        $gasto->delete();
    
        return response()->json([
            'message' => 'El Gasto "' . $descripcion . '" ha sido eliminado correctamente'
        ], 200);
    }
}
