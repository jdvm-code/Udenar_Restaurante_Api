<?php

namespace App\Http\Repository;

use App\Http\Services\BecaService;
use App\Models\Beca;
use Illuminate\Http\Request;

class BecaRepository extends BaseRepository implements BecaService
{
    public function __construct(private Beca $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        try {
            $query = Beca::with(['usuario', 'estadoBeca']);

            if ($request->has('estado')) {
                $query->where('estados_becas_id', $request->estado);
            }

            $becas = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Becas obtenidas',
                'data' => $becas,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener becas',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getBecaActivaByUsuario($userId)
    {
        try {
            $beca = Beca::where('users_id', $userId)
                ->where('estados_becas_id', 2)
                ->first();

            if (!$beca) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario no tiene beca activa',
                    'data' => null,
                    'error' => 'No se encontró beca activa para este usuario',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Beca activa encontrada',
                'data' => $beca,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar la beca',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function solicitar(Request $request)
{
    try {
        // Verificar si tiene CUALQUIER beca (Activa o Pendiente)
        $becaExistente = Beca::where('users_id', $request->users_id)
            ->whereIn('estados_becas_id', [1, 2]) // 1=Pendiente, 2=Activa
            ->first();

        if ($becaExistente) {
            $estado = $becaExistente->estados_becas_id == 1 ? 'Pendiente' : 'Activa';
            
            return response()->json([
                'success' => false,
                'message' => "Ya tiene una beca {$estado}",
                'data' => null,
                'error' => 'No puede solicitar otra beca',
            ], 400);
        }

        // Crear beca con estado "Pendiente" (id=1)
        $beca = Beca::create([
            'users_id' => $request->users_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estados_becas_id' => 1, // Pendiente
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitud de beca enviada. Esperando aprobación.',
            'data' => $beca,
            'error' => null,
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al solicitar beca',
            'data' => null,
            'error' => $e->getMessage(),
        ], 500);
    }
}
    public function activar($id)
    {
        try {
            $beca = Beca::find($id);

            if (!$beca) {
                return response()->json([
                    'success' => false,
                    'message' => 'Beca no encontrada',
                    'data' => null,
                    'error' => 'ID de beca inválido',
                ], 404);
            }

            // Cambiar estado a "Activa" (id=2)
            $beca->estados_becas_id = 2;
            $beca->save();

            return response()->json([
                'success' => true,
                'message' => 'Beca activada exitosamente',
                'data' => $beca,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al activar beca',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
