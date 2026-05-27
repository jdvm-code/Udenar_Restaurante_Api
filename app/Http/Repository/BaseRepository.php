<?php
namespace App\Http\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository
{
   // private Model $model;

    public function __construct(private Model $model)
    {
        $this->model = $model;
    }

     public function index(Request $request)
    {
        return  $this->model::all();
    }

    public function show(int $id)
    {
        return $this->model::findOrFail($id);
    }

    public function delete(int $id): bool
    {
        return $this->model::findOrFail($id)->delete();
    }

     public function store(Request $data)
    {
        return $this->model::create($data->all());
    }
    
     public function update(Request $data, int $id)
    {
        $model = $this->model::findOrFail($id);
        $model->fill($data->all());
        $model->save();
        return $model;
    }
}