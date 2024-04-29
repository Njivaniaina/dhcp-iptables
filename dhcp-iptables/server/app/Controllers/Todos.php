<?php

namespace App\Controllers;

use App\Models\TodoModel;



class Todos extends BaseController
{

    public function index()
    {
        $model = new TodoModel();
        $pager = \Config\Services::pager();

        $data['todos'] = $model->paginate(2);
        $data['pager'] = $model->pager;

        return view('index', $data);
    }


    public function create()
    {
        $model = new TodoModel();
        $pager = \Config\Services::pager();
        
        $data['todos'] = $model->paginate(2);
        $data['add'] = '';
        $data['pager'] = $model->pager;

        return view('index' , $data);
    }
    
    public function store()
    {
        $model = new TodoModel();
        $pager = \Config\Services::pager();

        $model->save($this->request->getVar());
        
        $data['todos'] = $model->paginate(2);
        $data['pager'] = $model->pager;
        return view('index' , $data);
    }

    public function delete()
    {
        $model = new TodoModel();
        $model->delete($this->request->getPost('id'));
        
        $data['todos'] = $model->findAll();
        return view('index' , $data);
    }

    public function search(){
        $model = new TodoModel();    
        $pager = \Config\Services::pager();
        
        if(empty($this->request->getVar('search'))) $data['todos'] = [];
        else{
            $data['todos'] = $model->like('name', $this->request->getVar('search'))->paginate(2);
            $data['pager'] = $model->pager;
        }
        return view('index' , $data);
    }
    
    public function edit()
    {
        $model = new TodoModel();
        
        $data['todos'] = $model->findAll();
        $data['edit'] = $model->where('id' , $this->request->getPost('id'))->findAll();
        
        return view('index', $data);
    }
    

    public function update()
    {
        $model = new TodoModel();
        $model->update($this->request->getPost('id'), $this->request->getPost());
        $data['todos'] = $model->findAll();
        return view('index' , $data);
    }
}
