<?php 

namespace App\Repositories;

use App\Models\User;

class UserRepository extends EloquentRepository 
{

    public function __construct(User $modelCLass)
    {
        return parent::__construct($modelCLass);
    }

}