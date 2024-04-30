<?php

namespace App\Controllers;

use App\Models\Iptables;

class Netfilter extends BaseController
{
    # Pour le page d'accueil
    public function index(): string
    {
        return view('netfilter');
    }

    public function error($msg): string {
        $this->request->getVar("");
        $data["msg"] = $msg;
        return view('error', $data);
    }
    
    # Pour le page list
    public function list(): string {
        $tables  = new Iptables();

        $delete = $this->request->getVar('delete');
        $line = $this->request->getVar('line');
        if(isset($delete) && isset($line)) {
            tables->deleteData($delete, $line);
        }

        $data = $tables->get_table_csv();
        $d['rules'] = $data;

        # print_r($data);
        return view('netfilter_list', $d);
    }

    # Pour le page d'ajout
    public function add(): string {
        $tables  = new Iptables();

        $data = $tables->get_interface_csv();
        $this->addData("/netfilter/list");
        $d['interface_iptables'] = $data;

        return view('netfilter_add', $d);
    }

    # Pour la page a propos 
    public function police(): string {
        $tables  = new Iptables();

        $data = $tables->get_table_csv();
        $this->changePolice();
        $d['rules'] = $data;

        return view('netfilter_police', $d);
    }

    ################################
    #   Pour l'ajout d'une regle   # 
    ################################
    public function addData($lien): void {
        $command = "sudo iptables -A "; # Pour la commande finale
        $exist = false;

        $chain = $this->request->getVar("chain");
        if(isset($chain))
            $exist = true;
        $target = $this->request->getVar("target");
        $protocole = $this->request->getVar("protocole");
        $port = $this->request->getVar("port");
    
        $check_mac = $this->request->getVar("check_mac");
        $check_source = $this->request->getVar("check_source");
        $check_destination = $this->request->getVar("check_destination");
        $check_interface_source = $this->request->getVar("check_interface_source");
        $check_interface_destination = $this->request->getVar("check_interface_destination");
    
        
    
    /*  -------------------------------------------------------------------------------------------- */
        if(isset($chain))
            $command = $command . $chain . " ";
    
        if(isset($target))
            $command = $command  . "-j " . $target . " ";
    
    /*  ---------------------------------------- default check ------------------------------------- */
        
        if(isset($protocole))
        {
            $p = $this->request->getVar("prot");
            if(isset($p))
                $command = $command  . "-p " . $p . " ";
        }
     
        if(isset($port))
        {
            $po = $this->request->getVar("p");
            if($po != ""){
                if(multiPort($po))          // verify the chaine structure
                {
                    $command = $command  . "-m multiport --ports " . $po . " ";
                }                
                else
                    $command = $command  . "--dport " . $po . " ";        
            }
            else    
                error("port empty");
        }
    /* --------------------------------------------check error ------------------------------------- */ 
    
    
        if(isset($check_mac))
            $command = checkMac($command, $chain, $check_mac, $check_source, $check_destination, $check_interface_source, $check_interface_destination);
        
        if(isset($check_source))
            $command = checkS($command, $chain, $check_mac, $check_source, $check_destination, $check_interface_source, $check_interface_destination);
            
    
        if(isset($check_destination))
            $command = checkD($command, $chain, $check_mac, $check_source, $check_destination, $check_interface_source, $check_interface_destination);
           
    
        if(isset($check_interface_source))
            $command = checkIfaceS($command, $chain, $check_mac, $check_source, $check_destination, $check_interface_source, $check_interface_destination);
        
        if(isset($check_interface_destination))
            $command = checkIfaceD($command, $chain, $check_mac, $check_source, $check_destination, $check_interface_source, $check_interface_destination);
        
        if($exist) {
            exec($command);
            header("location:$lien");
        }
    }
    
    
    /* -------------------------------------function-------------------------------------- */
    
    function checkMac($command, $chain, $check_mac, $check_s, $check_d, $check_i_s, $check_i_d)
    {
        if($chain != "INPUT")
            error("can not be OUTPUT or FORWARD");

        if(isset($check_mac) && !isset($check_s) && !isset($check_d) && !isset($check_i_d) && !isset($check_i_s))
        {
            $mac = $this->request->getVar("mac");
            
            if($mac != "")
                if(macStruct($mac))
                    $command = $command  . "-m mac --mac-source " . $mac . " ";
                else
                    error("mac incorrect structure");
            else
                error("mac empty");       
        }
        else
            error("erreur multiCheck mac");

        return $command;
    }

    function checkS($command, $chain, $check_mac, $check_s, $check_d, $check_i_s, $check_i_d)
    {
        if($chain != "INPUT")
            error("can not be OUTPUT or FORWARD");

        if($chain == "INPUT" && !isset($check_mac) && isset($check_s) && !isset($check_d) && !isset($check_i_d) && !isset($check_i_s))
        {
            $source = $this->request->getVar("source");
            try{
                if($source == "")
                    throw new Exception("source empty");

                try{
                    if(!isIP($source) && !isURL($source))    
                        throw new Exception("incorrect source structur");
                    
                    
                    $command = $command  . "-s " . $source . " ";   

                }catch(Exception $e){
                    error($e->getMessage());
                    return null;
                }

                        
            }catch(Exception $e){
                error($e->getMessage());
                return null;
            }
            
        }
        else   
            error("erreur multiCheck source");

        return $command;
    }

    function checkD($command, $chain, $check_mac, $check_s, $check_d, $check_i_s, $check_i_d)
    {
        if($chain != "OUTPUT")
            error("can not be INPUT or FORWARD");

        if($chain == "OUTPUT" && !isset($check_mac) && !isset($check_s) && isset($check_d) && !isset($check_i_d) && !isset($check_i_s))
        { 
            $destination = $this->request->getVar("destination");
            try{
                if($destination == "")
                    throw new Exception("destination empty");

                try{
                    if(!isIP($destination) && !isURL($destination))    
                        throw new Exception("incorrect destination structur");
                    
                    
                    $command = $command  . "-d " . $destination . " ";   

                }catch(Exception $e){
                    error($e->getMessage());
                    return null;
                }

                        
            }catch(Exception $e){
                error($e->getMessage());
                return null;
            }
        }
    
        else
            error("erreur multiCheck destination");
            
        return $command;
    }

    function checkIfaceS($command, $chain, $check_mac, $check_s, $check_d, $check_i_s, $check_i_d)
    {
        
        if(!isset($check_mac) && !isset($check_s) && !isset($check_d) && !isset($check_i_d) && isset($check_i_s))
        {
            $interface_source = $this->request->getVar("interface_source");
            if(isset($interface_source))
                $command = $command  . "-i " . $interface_source . " ";
            else
                error("source iface empty");
        }
        else
            error("erreur multiCheck iface source");
        
        return $command;
    }

    function checkIfaceD($command, $chain, $check_mac, $check_s, $check_d, $check_i_s, $check_i_d)
    {
        if(!isset($check_mac) && !isset($check_s) && !isset($check_d) && isset($check_i_d) && !isset($check_i_s))
        {
            $interface_destination = $this->request->getVar("interface_destination");
            if(isset($interface_destination))
                $command = $command  . "-o " . $interface_destination . " ";
            else
                error("destination iface empty");
        }
        else
            error("erreur multiCheck iface destination");   

        return $command;
    }

    function multiPort($port)
    {
        if(strpos($port,','))
            return true;        

        return false;
    }

    function macStruct($mac)        
    {

        $char = str_split($mac);

        if(count($char) != 17)              // 17 caracters
            return false;
        if($char[2]!=':' || $char[5]!=':' || $char[8]!=':' || $char[11]!=':' || $char[14]!=':')
            return false;

        return true;
    }

    function isIP($source)
    {
        $octet = explode(".", $source);
        $oct = array();

        if(count($octet) != 4)
            return false;
        
        foreach($octet as $value){
            if($value == "")
                return false;
        }
        foreach($octet as $value){
            $char = str_split($value);
            foreach($char as $seed){
                if($seed != "0" && $seed != "1" && $seed != "2" && $seed != "3" && $seed != "4" && $seed != "5" && $seed != "6" && $seed != "7" && $seed != "8" && $seed != "9" )
                    return false;
            }
        }
    

        foreach($octet as $value){
            $oct[] = intval($value);            // conversion en entier
        }

        foreach($oct as $value){
            if($value < 0 || $value > 255 )
                return false;
        }

        return true;
    }

    function isURL($source)
    {
        if(!strpos($source, '.'))
            return false;

        $domain = explode(".", $source);
        
        foreach($domain as $value){
                if($value == "")
                    return false;
        }

        if(count($domain) == 2)
        {
            if($domain[1]!="com" && $domain[1]!="fr" && $domain[1]!="pm" && $domain[1]!="mg")
                return false;
        }
            
        if(count($domain) == 3)
        {
            if($domain[2]!="com" && $domain[2]!="fr" && $domain[2]!="pm" && $domain[2]!="mg")
                return false;
        }
        
        if(count($domain) == 4)
        {
            if($domain[3]!="com" && $domain[3]!="fr" && $domain[3]!="pm" && $domain[3]!="mg")
                return false;
        }

        if($domain[count($domain)-1] == "")
            return false;
        


        return true;
    }

    ################################
    # Pour le changement de police #
    ################################
    public function changePolice(): void {
        $input = $this->request->getVar("input");
        if(isset($input)) {
            $command_input = "sudo iptables -P INPUT " . $input;
            exec($command_input);
        }

        $forward = $this->request->getVar("forward");
        if(isset($forward)) {
            $command_forward = "sudo iptables -P FORWARD " . $forward;
            exec($command_forward);
        }

        $output = $this->request->getVar("output");
        if(isset($output)) {
            $command_output = "sudo iptables -P OUTPUT " . $output;
            exec($command_output);
        }
    }
}
