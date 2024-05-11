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
        $n->range();
        return view('globale',$data);
    }
    
    public function specific(): string
    {
        $n=new Net();
        $host=$this->request->getVar('nom_hote');
        $mac=$this->request->getVar('mac');
        $ip=$this->request->getVar('ip');
        if($this->request->getVar('supprimer')!="")
        {
            $num_ligne = $this->request->getVar("supprimer");
            $lignes = $n->getLinesHost();
            foreach($lignes as $key=>$value)
            {
                if($key+1 == $num_ligne)
                {
                    $n->delHostWithLines($value);
                }
            }
        }
        $d = $this->request->getVar("modifier");
        $status = $this->request->getVar("status");
        $data['modifier']["nom_hosts"] = "";
        $data['modifier']["mac"] = "";
        $data['modifier']["ip"] = "";
        if($d != "")
        {
            $data['modifier'] = $n->getHostWithLines($d);
            $n->modif_host_lines($d,$data['modifier']["nom_hosts"],$data['modifier']["mac"],$data['modifier']["ip"]);
        }
        if($host != "")
        {
            if($n->getLigneHost($host)>0)
            {
                $num = $n->getLigneHost($host);
                $tab = $n->getLinesHost();
                foreach($tab as $key=>$value)
                {
                    if($value == $num)
                    {
                        $num = $key;
                        break;
                    }
                }
                $n->modif_host_lines($num+1,$host,$mac,$ip);
            }
            else
            {
                $n->addHost($host,$mac,$ip);
            }
        }

        if($this->request->getVar('supprimer')>0){
            header("Location: " . str_replace('index.php/','',$_SERVER['PHP_SELF']));
            exit;
        }
        
        $data['host']=$n->getHost();
        return view('specific',$data);
    }
    
}
