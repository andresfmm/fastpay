<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class EloquentRepository 
{

    protected $model;

    /**
     * EloquentRepository constructor.
     * @param Model $modelClass
    */

    public function __construct(Model $modelCLass)
    {
         $this->model = $modelCLass;
    }


    public function all()
    {

        return $this->model->all();
        
    }

    public function getById($id) {

        $result = $this->model->find($id);

        return empty($result) ? [] : $result;

    }

    public function save(array $params)
    {
        $model = $this->model->fill($params);
        $model->save();

        return $model;
    }

}