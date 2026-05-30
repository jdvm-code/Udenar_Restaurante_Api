<?php
namespace App\Http\Repository;

use App\Http\Services\ReservaService;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ReservaRepository extends BaseRepository implements ReservaService {
    public function __construct(private Reserva $model)
    {
        parent::__construct($model);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        try {
            $data = $request->all();
            return $this->model->create($data);

        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                throw new \Exception('Ya tienes una reserva registrada para este tipo de comida en la fecha seleccionada.', 409);
            }
            throw $e;
        }
    }

    /**
     * Busca una reserva por su código único de QR.
     */
    public function buscarPorCodigo(string $codigo): ?Reserva
    {
        return Reserva::where('codigo', $codigo)->first();
    }

    /**
     * Opcional: Método para actualizar el estado si se consume la reserva
     */
    public function actualizarEstado(Reserva $reserva, int $nuevoEstadoId): bool
    {
        return $reserva->update(['estados_reservas_id' => $nuevoEstadoId]);
    }

    /**
     * Implementación del método verificarQR definido en la interfaz ReservaService.
      * Este método valida el código QR, verifica la fecha de la reserva y su estado.
      * Lanza excepciones con mensajes claros para cada caso de error.
     */

    public function verificarQR(string $codigo)
    {
        // 1. Buscar la reserva por el código único utilizando la instancia del modelo
        $reserva = $this->model->where('codigo', $codigo)->first();

        // Validación A: ¿Existe la reserva?
        if (!$reserva) {
            throw new \Exception('El código QR no es válido o la reserva no existe.', 404);
        }

        // 2. Obtener fechas limpias forzando la zona horaria local
        $hoy = Carbon::now('America/Bogota')->format('Y-m-d');
        $fechaReserva = Carbon::parse($reserva->fecha_reserva)->format('Y-m-d');

        // Validación B: ¿La reserva coincide con el día de hoy?
        if ($fechaReserva !== $hoy) {
            throw new \Exception("Esta reserva es para la fecha {$fechaReserva}, no para el día de hoy.", 400);
        }

        // Validación C: ¿La reserva está activa? (estados_reservas_id = 1)
        if ($reserva->estados_reservas_id !== 1) {
            throw new \Exception('Esta reserva ya ha sido utilizada o se encuentra inactiva.', 400);
        }

        //cambiar el estado de la reserva a "Asistio" (ejemplo: estados_reservas_id = 2)
        $reserva->update(['estados_reservas_id' => 2]); // Ejemplo: 2 = Consumido

        return $reserva;
    }

    /**
     * Actualiza una reserva existente.
     */
    public function update(Request $request, int $id)
    {
        // 1. Buscar la reserva por su ID
        $reserva = $this->model->find($id);

        if (!$reserva) {
            throw new \Exception('La reserva no existe.', 404);
        }

        // 2. [Opcional] Regla de negocio: No permitir cancelar si ya fue "Consumida" (ej: estado 2)
        if ($request->input('estados_reservas_id') == 3 && $reserva->estados_reservas_id == 2) {
            throw new \Exception('No se puede cancelar una reserva que ya ha sido consumida.', 400);
        }

        // 3. Actualizar los campos permitidos que vienen en el Request
        $reserva->update($request->only(['estados_reservas_id', 'horarios_id', 'comidas_id']));

        return $reserva;
    }
    
}