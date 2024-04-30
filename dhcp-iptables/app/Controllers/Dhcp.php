<?php

namespace App\Controllers;
use App\Models\Net;
class Dhcp extends BaseController
{
    public function index(): string
    {
        return view('dhcp');
    }

    public function globale(): string
    {
        $n=new Net();
        $netmask=$this->request->getVar("netmask");
        $subnet=$this->request->getVar("subnet");
        $debut=$this->request->getVar("debut");
        $fin=$this->request->getVar("fin");
        $data['subnet']=$n->getSubnet();
        $n->modifierSubnet($subnet,$netmask,$debut,$fin);
        return view('globale',$data);
    }
    
    public function specific(): string
    {
        $n=new Net();
        $host=$this->request->getVar('nom_hote');
        $mac=$this->request->getVar('mac');
        $ip=$this->request->getVar('ip'); 
        if((strcmp($host,"")!=0 && strcmp($mac,"")!=0) && strcmp($ip,"")!=0){
            $n->addHost($host,$mac,$ip);
            $n->range();
        }
        $data['host']=$n->getHost();
        return view('specific',$data);
    }
    
}
