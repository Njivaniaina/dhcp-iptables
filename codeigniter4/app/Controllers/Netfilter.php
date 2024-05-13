<?php

namespace App\Controllers;

use App\Models\Iptables;

class Netfilter extends BaseController
{
    # Pour le page d'accueil
    public function index(): string
    {
        if(!$this->check_init()) {
            shell_exec("./script/initialistaion.sh");
        }
        return view('netfilter');
    }

    public function check_init(): bool {
        $plages  = [
            "192.168.1.1-192.168.1.32", 
            "192.168.1.34-192.168.1.62", 
            "192.168.1.64-192.168.1.96",
            "192.168.1.98-192.168.1.130",
            "192.168.1.132-192.168.1.164"
        ];

        for($i=1;$i<6;$i++) {
            exec("sudo iptables -S INPUT $i", $result1[$i]);
        }
        for($i=1;$i<6;$i++) {
            if(!empty($result1[$i])){
                $plage1 = explode(" ", $result1[$i][0]);
                if($plage1[5] !== $plages[$i-1]) {
                    return false;
                }
            }else{
                return false;
            }
        }

        for($i=1;$i<6;$i++) {
            exec("sudo iptables -S OUTPUT $i", $result2[$i]);
        }
        for($i=1;$i<6;$i++) {
            if(!empty($result2[$i])){
                $plage2 = explode(" ", $result2[$i][0]);
                if($plage2[5] !== $plages[$i-1])
                    return false;
            }else{
                return false;
            }
        }

        for($i=1;$i<6;$i++) {
            exec("sudo iptables -S FORWARD $i", $result3[$i]);
        }
        for($i=1;$i<6;$i++) {
            if(!empty($result3[$i])){
                $plage3 = explode(" ", $result3[$i][0]);
                if($plage3[5] !== $plages[$i-1])
                    return false;
            }else{
                return false;
            }
        }

        return true;
    }

    public function error($msg): string {
        //$this->request->getVar("");
        $data["msg"] = $msg;
        return view('error', $data);
    }
    
    # Pour le page list
    public function list(): string {
        if(!$this->check_init()) {
            shell_exec("./script/initialistaion.sh");
        }

        $tables  = new Iptables();  

        $page  = (int)$this->request->getVar('page');

        $save  = $this->request->getVar('save');
        if(isset($save) && $save === "t") {
            $this->saveTables();
        }

        $delete = $this->request->getVar('delete');
        $line = $this->request->getVar('line');
        if(isset($delete) && isset($line)) {
            $tables->deleteRules($delete, $line);
            return view('netfilter_cache');
        }

        $data = $tables->get_table_csv();
        if(!empty($page))
            $d['page'] = $page;
        else 
            $d['page'] = 1;

        $d['rules'] =  $data;
        $d['rules_c'] =  $this->verify_in($data, $page);

        # print_r($data);
        return view('netfilter_list', $d);
    }

    # Pour le page d'ajout
    public function add(): string{
        if(!$this->check_init()) {
            shell_exec("./script/initialistaion.sh");
        }

        $tables  = new Iptables();

        $data = $tables->get_interface_csv();
        //$this->addData("/netfilter/list");
        $d['interface_iptables'] = $data;

        return view('netfilter_add', $d);
    }

    # Pour la page a propos 
    public function police(): string {
        if(!$this->check_init()) {
            shell_exec("./script/initialistaion.sh");
        }

        $tables  = new Iptables();
        $level = $this->request->getVar("level");
        
        if($level == "all")
            $this->changePolice();                  // Global  iptables -P
        if($level == "l1")
            $this->changePoliceL1();
        if($level == "l2")
            $this->changePoliceL2();
        if($level == "l3")
            $this->changePoliceL3();
        if($level == "m1")
            $this->changePoliceM1();
        if($level == "m2")
            $this->changePoliceM2();
        
        $data = $tables->get_table_csv();
        $d['rules'] = $data;

        return view('netfilter_police', $d);
    }

    ################################
    #   Pour l'list  d'une regle   # 
    ################################

    public function verify_in($data, $page) {
        $result["chain"] = $data["chain"];
        $chain = $data["chain"];
        $rule = $data["rules"];

        foreach($chain as $c) {
            $result["rules"][$c[0]] = []; 
        }

        foreach($chain as $c) {
            foreach($rule[$c[0]] as $k => $r) {
                $ip1 = explode('.', $r[3]);
                $ip2 = explode('.', $r[4]);

                if(!empty($ip1[3]) || !empty($ip2[3])) {
                    if(!empty($ip1[3]))
                        $ip_tab1 = $ip1[3]+0;
                    if(!empty($ip2[3]))
                        $ip_tab2 = $ip2[3]+0;
                }

                if($page === 2) {
                    if(!empty($ip1[3])) {
                        if(($ip_tab1 >= 1 && $ip_tab1 <= 32)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                    if(!empty($ip2[3])) {
                        if(($ip_tab2 >= 1 && $ip_tab2 <= 32)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                }
                else if($page === 3) {
                    if(!empty($ip1[3])) {
                        if(($ip_tab1 >= 34 && $ip_tab1 <= 62) ) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                    if(!empty($ip2[3])) {
                        if(($ip_tab2 >= 34 && $ip_tab2 <= 62)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                }
                else if($page === 4) {
                    if(!empty($ip1[3])) {
                        if(($ip_tab1>=64 && $ip_tab1<=96)) {
                            $result["rules"][$c[0]][] = $r;
                        }
                    }
                    if(!empty($ip2[3])) {
                        if(($ip_tab2>=64 && $ip_tab2<=96)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                }
                else if($page === 5) {
                    if(!empty($ip1[3])) {
                        if(($ip_tab1>=98 && $ip_tab1<=130)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                    if(!empty($ip2[3])) {
                        if(($ip_tab2>=98 && $ip_tab2<=130)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                }
                else if($page === 6) {
                    if(!empty($ip1[3])) {
                        if(($ip_tab1>=132 && $ip_tab1<=164)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                    if(!empty($ip2[3])) {
                        if(($ip_tab2>=132 && $ip_tab2<=164)) {
                            $result["rules"][$c[0]][] =  $r;
                        }
                    }
                }
                else {
                    $result = $data;
                }
            }
        }

        return $result;
    } 


    ################################
    #   Pour l'ajout d'une regle   # 
    ################################
    public function addData(): string{
        $command = "sudo iptables -A ";                 # Pour la commande finale
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
        
        if(isset($protocole)){
            $p = $this->request->getVar("prot");
            if(isset($p))
                $command = $command  . "-p " . $p . " ";
        }
     
        if(isset($port)){
            $po = $this->request->getVar("p");
            if($po != ""){
                if($this->multiPort($po))          // verify the chaine structure
                {
                    $command = $command  . "-m multiport --ports " . $po . " ";
                }                
                else{
                    $command = $command  . "--dport " . $po . " ";        
                }
            }
            else{    
                return $this->error("port empty");
            }
        }
    /* --------------------------------------------check error ------------------------------------- */ 
    
    
        if(isset($check_mac)){

            if($chain != "INPUT")
                return $this->error("can not be OUTPUT or FORWARD");

            if(isset($check_mac) && !isset($check_source) && !isset($check_destination) && !isset($check_interface_destination) && !isset($check_interface_source))
            {
                $mac = $this->request->getVar("mac");
                
                if($mac != "")
                    if($this->macStruct($mac))
                        $command = $command  . "-m mac --mac-source " . $mac . " ";
                    else{
                        return $this->error("mac incorrect structure");
                    }
                else{
                    return $this->error("mac empty");      
                } 
            }
            else{
                return $this->error("erreur multiCheck mac");
            }
        }

        if(isset($check_source)){
            //$command = $this->checkS($command, $chain, $check_mac, $check_sourceource, $check_destinationestination, $check_interface_source, $check_interface_destination);
            
            // if($chain != "INPUT")
            //     return $this->error("can not be OUTPUT or FORWARD");

            // $chain == "INPUT" &&
            if(!isset($check_mac) && isset($check_source) && !isset($check_destination) && !isset($check_interface_destination) && !isset($check_interface_source))
            {
                $source = $this->request->getVar("source");
                try{
                    if($source == "")
                        throw new \Exception("source empty");

                    try{
                        if(!$this->isIP($source) && !$this->isURL($source))    
                            throw new \Exception("incorrect source structur");
                        
                        
                        $command = $command  . "-s " . $source . " ";   

                    }catch(\Exception $e){
                        return $this->error($e->getMessage());
                    }

                            
                }catch(\Exception $e){
                    return $this->error($e->getMessage());
                }
                
            }
            else{ 
                return $this->error("erreur multiCheck source");
            }
    
        }

        if(isset($check_destination)){
            //$command = $this->checkD($command, $chain, $check_mac, $check_sourceource, $check_destinationestination, $check_interface_source, $check_interface_destination);
         
            // if($chain != "OUTPUT")
            //     return $this->error("can not be INPUT or FORWARD");

            // $chain == "OUTPUT" &&
            if(!isset($check_mac) && !isset($check_source) && isset($check_destination) && !isset($check_interface_destination) && !isset($check_interface_source))
            { 
                $destination = $this->request->getVar("destination");
                try{
                    if($destination == "")
                        throw new \Exception("destination empty");

                    try{
                        if(!$this->isIP($destination) && !$this->isURL($destination))    
                            throw new \Exception("incorrect destination structur");
                        
                        
                        $command = $command  . "-d " . $destination . " ";   

                    }catch(\Exception $e){
                        return $this->error($e->getMessage());
                    }

                            
                }catch(\Exception $e){
                    return $this->error($e->getMessage());
                }
            }
        
            else{
                return $this->error("erreur multiCheck destination");
            }
                
        }
    
        if(isset($check_interface_source)){
            //$command = $this->checkIfaceS($command, $chain, $check_mac, $check_sourceource, $check_destinationestination, $check_interface_source, $check_interface_destination);
            if(!isset($check_mac) && !isset($check_source) && !isset($check_destination) && !isset($check_interface_destination) && isset($check_interface_source))
            {
                $interface_source = $this->request->getVar("interface_source");
                if(isset($interface_source))
                    $command = $command  . "-i " . $interface_source . " ";
                else{
                    return $this->error("source iface empty");
                }
            }
            else{
                return $this->error("erreur multiCheck iface source");
            }
        
        }

        if(isset($check_interface_destination)){
            //$command = $this->checkIfaceD($command, $chain, $check_mac, $check_sourceource, $check_destinationestination, $check_interface_source, $check_interface_destination);
            if(!isset($check_mac) && !isset($check_source) && !isset($check_destination) && isset($check_interface_destination) && !isset($check_interface_source))
            {
                $interface_destination = $this->request->getVar("interface_destination");
                if(isset($interface_destination))
                    $command = $command  . "-o " . $interface_destination . " ";
                else{
                    return $this->error("destination iface empty");
            }
            }
            else{
                return $this->error("erreur multiCheck iface destination");   
            }

        }

        if($exist) {
            exec($command);
        }

        $tables  = new Iptables();
        $data = $tables->get_interface_csv();
        $d['interface_iptables'] = $data;

        return view('netfilter_add', $d);
    }
    
    
    /* -------------------------------------function-------------------------------------- */
   
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

    public function changePoliceL1(): void {
        $input = $this->request->getVar("input");
        if(isset($input)) {
            $command_input = "sudo iptables -R INPUT 1 -m iprange --src-range 192.168.1.1-192.168.1.32 -j " . $input;
            exec($command_input);
        }

        $forward = $this->request->getVar("forward");
        if(isset($forward)) {
            $command_forward = "sudo iptables -R FORWARD 1 -m iprange --src-range 192.168.1.1-192.168.1.32 -j " . $forward;
            exec($command_forward);
        }

        $output = $this->request->getVar("output");
        if(isset($output)) {
            $command_output = "sudo iptables -R OUTPUT 1 -m iprange --src-range 192.168.1.1-192.168.1.32 -j " . $output;
            exec($command_output);
        }
    }

    public function changePoliceL2(): void {
        $input = $this->request->getVar("input");
        if(isset($input)) {
            $command_input = "sudo iptables -R INPUT 2 -m iprange --src-range 192.168.1.34-192.168.1.62 -j " . $input;
            exec($command_input);
        }

        $forward = $this->request->getVar("forward");
        if(isset($forward)) {
            $command_forward = "sudo iptables -R FORWARD 2 -m iprange --src-range 192.168.1.34-192.168.1.62 -j " . $forward;
            exec($command_forward);
        }

        $output = $this->request->getVar("output");
        if(isset($output)) {
            $command_output = "sudo iptables -R OUTPUT 2 -m iprange --src-range 192.168.1.34-192.168.1.62 -j " . $output;
            exec($command_output);
        }
    }

    public function changePoliceL3(): void {
        $input = $this->request->getVar("input");
        if(isset($input)) {
            $command_input = "sudo iptables -R INPUT 3 -m iprange --src-range 192.168.1.64-192.168.1.96 -j " . $input;
            exec($command_input);
        }

        $forward = $this->request->getVar("forward");
        if(isset($forward)) {
            $command_forward = "sudo iptables -R FORWARD 3 -m iprange --src-range 192.168.1.64-192.168.1.96 -j " . $forward;
            exec($command_forward);
        }

        $output = $this->request->getVar("output");
        if(isset($output)) {
            $command_output = "sudo iptables -R OUTPUT 3 -m iprange --src-range 192.168.1.64-192.168.1.96 -j " . $output;
            exec($command_output);
        }
    }

    public function changePoliceM1(): void {
        $input = $this->request->getVar("input");
        if(isset($input)) {
            $command_input = "sudo iptables -R INPUT 4 -m iprange --src-range 192.168.1.98-192.168.1.130 -j " . $input;
            exec($command_input);
        }

        $forward = $this->request->getVar("forward");
        if(isset($forward)) {
            $command_forward = "sudo iptables -R FORWARD 4 -m iprange --src-range 192.168.1.98-192.168.1.130 -j " . $forward;
            exec($command_forward);
        }

        $output = $this->request->getVar("output");
        if(isset($output)) {
            $command_output = "sudo iptables -R OUTPUT 4 -m iprange --src-range 192.168.1.98-192.168.1.130 -j " . $output;
            exec($command_output);
        }
    }

    public function changePoliceM2(): void {
        $input = $this->request->getVar("input");
        if(isset($input)) {
            $command_input = "sudo iptables -R INPUT 5 -m iprange --src-range 192.168.1.132-192.168.1.164 -j " . $input;
            exec($command_input);
        }

        $forward = $this->request->getVar("forward");
        if(isset($forward)) {
            $command_forward = "sudo iptables -R FORWARD 5 -m iprange --src-range 192.168.1.132-192.168.1.164 -j " . $forward;
            exec($command_forward);
        }

        $output = $this->request->getVar("output");
        if(isset($output)) {
            $command_output = "sudo iptables -R OUTPUT 5 -m iprange --src-range 192.168.1.132-192.168.1.164 -j " . $output;
            exec($command_output);
        }
    }

    private function saveTables(): void {
        $command = 'sudo iptables-save';
        exec($command);
    }
}
