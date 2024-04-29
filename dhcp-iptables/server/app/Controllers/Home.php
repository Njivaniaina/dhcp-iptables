<?php

namespace App\Controllers;
use App\Models\Net;
class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }
    public function subnet(): string 
    {
        $n=new Net();
        $data['subnet']=$n->getSubnet();
        return view('subnet',$data);
    }
    public function hote(): string 
    {
        $n=new Net();
        $data['host']=$n->getHost();
        return view('hote',$data);
    }
    
}
