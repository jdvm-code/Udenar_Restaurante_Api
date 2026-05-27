<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userServices)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userServices->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userServices->store($request);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->userServices->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->userServices->update($request, $id);
    }
        /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->userServices->delete($id);
    }
}
