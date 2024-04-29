<?php

namespace App\Models;

use CodeIgniter\Model;

class TodoModel extends Model
{   
    protected $table = 'todos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id' , 'name'];

    public function get_all_data($limit , $start){
        $this->db->limit($limit , $start);
        $query = $this->db->get($table);
        return $query->result();
    }

}
