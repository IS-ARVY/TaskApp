<?php

namespace App\Controllers;

use App\Entities\Task;

class Tasks extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\TaskModel;
        $this->current_user = service('auth')->getCurrentUser();
    }

    public function index()
    {
        $data = $this->model->paginateTasksByUserId( $this->current_user->id);

        return view("Tasks/index.php", [
            'tasks' => $data,
            'pager' => $this->model->pager
        ]);

    }

    public function show($id)
    {
        $task = $this->getTask0r404($id);

        return view("Tasks/show.php", [
            'task' => $task
        ]);
    }

    public function new()
    {
        $task = new Task;

        return view('Tasks/new' ,[
            'task' => $task
        ]);
    }

    public function create()
    {
        $task = new Task($this->request->getPost());

        $task->user_id = $this->current_user->id;

        if($this->model->insert($task)) {

                return redirect()->to("/tasks/show/{$this->model->insertID}")
                                 ->with('info', 'Task created sucessfully');
                    
        } else {

            return redirect()->back()
                             ->with('errors', $this->model->errors())
                             ->with('warning', 'Invalid data')
                             ->withInput();
        }

    }

    public function edit($id)
    {
        $task = $this->getTask0r404($id);

        return view("Tasks/edit.php", [
            'task' => $task
        ]);
    }

    public function update($id)
    {
        $task = $this->getTask0r404($id);

        $post = $this->request->getPost();
        unset($post['user_id']);

        
        $task->fill($post);

        if (! $task->hasChanged()){

            return redirect()->back()
                             ->with('warning', 'Nothing to update')
                             ->withInput();
        }

        if($this->model->save($task)){

            return redirect()->to("/tasks/show/$id")
                             ->with('info', 'Task updated successfully'); 

        } else{
                return redirect()->back()
                                 ->with('errors', $this->model->errors())
                                 ->with('warning', 'Invalid data')
                                 ->withInput();
        }       

    }
    
    public function delete($id)
	{
        $task = $this->getTask0r404($id);
		
        if ($this->request->getMethod() === 'POST') {
			
            $this->model->delete($id);
			
			return redirect()->to('/tasks')
                             ->with('info', 'Task deleted');
		}
		
		return view('Tasks/delete', [
            'task' => $task
        ]);
	}

    private function getTask0r404($id)
    {
        /* Prueba de validacion de tareas con el usuario que lo creo

        $task = $this->model->find($id);

        if ($task !== null && ($task->user_id !== $user->id)) {

            $task = null; 
        }
        */

        $task = $this->model->getTaskByUserId($id, $this->current_user->id);
        if ($task === null){

            throw new \CodeIgniter\Exceptions\PageNotFoundException("Task with id $id not found");
        }

        return $task;

    }

}