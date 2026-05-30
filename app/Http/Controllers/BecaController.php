<?php
namespace App\Http\Controllers;

use App\Http\Services\BecaService;
use Illuminate\Http\Request;

class BecaController extends Controller
{
    public function __construct(private BecaService $becaServices)
    {
        //
     }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->becaServices->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->becaServices->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->becaServices->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->becaServices->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->becaServices->delete($id);
    }
}
