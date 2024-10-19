<?php

namespace App\Models;

class TaskModel extends \CodeIgniter\Model
{
    protected $table = 'task';

    protected $allowedFields = ['description', 'user_id'];

    protected $returnType = 'App\Entities\Task';

    protected $useTimestamps = true;

    #le dice que valide el campo como requerido (funcion del codeigniter)
    protected $validationRules = [
        'description' => 'required'
    ];

    #personaliza el mensaje de error 
    protected $validationMessages = [
        'description' => [
            'required' => 'Please enter a description'
        ]
    ];

    public function paginateTasksByUserId($id)
    {
        return $this->where('user_id', $id)
                    ->orderBy('created_at')
                    ->paginate();
    }

    public function getTaskByUserId($id, $user_id)
    {
       return $this->where('id', $id)
             ->where('user_id', $user_id)
             ->first();
    }

    public function search($term, $user_id)
    {
        if ($term === null) {
            
            return [];
        }
        
        return $this->select('id, description')
                    ->where('user_id', $user_id)
                    ->like('description', $term)
                    ->get()
                    ->getResultArray();
    }

}