<?php 

namespace App\Models;

class DHCPError
{
    public function __construct()
    {

    }

    public function test_mac($mac)
    {
        //verifier si tout les champs d une addresse mac sont tout des hexadecimales
        $tab_hex = explode(":",$mac);
        if(count($tab_hex) != 6)
        {
            return 0;
        }
        foreach($tab_hex as $element)
        {
            if(!($this->sumAscii($element) >= 96 && $this->sumAscii($element) <= 204))
            {
                return 0;
            }
        }
        return 1;
    }

    public function test_ip($ip)
    {
        $tab_ip = explode(".",$ip);
        if(count($tab_ip) != 4)
        {
            return 0;
        }
        foreach($tab_ip as $element)
        {
            //156
            if(!($this->sumAscii($element) >= 48 && $this->sumAscii($element) <= 156))
            {
                return 0;
            }
        }
        return 1;
    }

    public function sumAscii($chaine)
    {
        $sum = 0;
        for($i = 0;$i < strlen($chaine);$i++)
        {
            $sum += ord($chaine[$i]);
        }
        return $sum;
    }

    public function test_subnet($subnet,$netmask,$min,$max)
    {
        $sum = 0;
        $sum += $this->test_ip($subnet);
        $sum += $this->test_ip($netmask);
        $sum += $this->test_ip($min);
        $sum += $this->test_ip($max);
        return $sum == 4?1:0;
    }
}

class Net
{
    public function __construct()
    {

    }

    public function verification_fichier($nom_fichier)
    {
        if(is_file($nom_fichier))
        {
            echo "le fichier existe\n";
            return true;
        }
        else{
            echo "fichier introuvable\n";
            return false;
        }
    }

    public function getSubnet()
    {
        //retourne un tableau concernant tout les subnet trouve dans le fichier
        $dhcp = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($dhcp))
        {
            if(strstr($row,"subnet") && $row[0]!="#")
            {
                $p1 = $row;
                $p2 = fgets($dhcp);
                $tableau = [
                    "subnet" => explode(" ",$p1)[1],
                    "netmask" => explode(" ",$p1)[3],
                    "range" => [
                                    explode(" ",$p2)[3],
                                    str_replace(";","",explode(" ",$p2)[4])
                                ],
                ];
                fclose($dhcp);
                return $tableau;
            }
        }
        $this->addSubnet("10.254.239.0","255.255.255.224","10.254.239.10","10.254.239.20");
        $dhcp = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($dhcp))
        {
            if(strstr($row,"subnet") && $row[0]!="#")
            {
                $p1 = $row;
                $p2 = fgets($dhcp);
                $tableau = [
                    "subnet" => explode(" ",$p1)[1],
                    "netmask" => explode(" ",$p1)[3],
                    "range" => [
                                    explode(" ",$p2)[3],
                                    str_replace(";","",explode(" ",$p2)[4])
                                ],
                ];
                fclose($dhcp);
                return $tableau;
            }
        }
    }

    public function supprimerSubnet()
    {
        //supprime le premier subnet trouve dans le fichier
        $num_ligne = 1;
        $nom_fichier = "/etc/dhcp/dhcpd.conf";
        $fichier = fopen($nom_fichier,"r");
        while($row = fgets($fichier))
        {
            if(strstr($row,"subnet") && $row[0]!='#')
            {
                break;
            }
            $num_ligne++;
        }
        fclose($fichier);
        for($i = 0;$i < 4;$i++)
        {
            $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
            shell_exec($commande);
        }
    }

    public function getHost()
    {
        //retourne un tableau concernant tout les hosts trouves
        $element = [];
        $fichier = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($fichier))
        {
            if($row[0]!='#' && strstr($row,"host"))
            {
                $nom_hote = explode(" ",$row)[1];
                $row = fgets($fichier);
                $mac = str_replace("\n","",str_replace(";","",explode(" ethernet ",$row)[1]));
                $row = fgets($fichier);
                $ip = explode(";",explode(" ",$row)[3])[0];
                $tableau = [
                    "nom_hosts" => $nom_hote,
                    "mac" => $mac,
                    "ip" => $ip
                ];
                $element[] = $tableau;
            }
        }
        fclose($fichier);
        return $element;
    }

    public function supprimerHost($element)
    {
        //supprime un hosts specifique en passant son nom
        $num_ligne = 1;
        $nom_fichier = "/etc/dhcp/dhcpd.conf";
        $fichier = fopen($nom_fichier,"r");
        while($row = fgets($fichier))
        {
            if(strstr($row,$element))
            {
                break;
            }
            $num_ligne++;
        }
        fclose($fichier);
        for($i = 0;$i < 4;$i++)
        {
            $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
            shell_exec($commande);
        }
    }

    public function modifierSubnet($subnet,$netmask,$min,$max)
    {
        //pour la modification
        // $error = new DHCPError();
        // $this->removeSubnetWithLines();
        // $this->supprimerSubnet();
        // if($error->test_subnet($subnet,$netmask,$min,$max))
        // {
        if(strlen($subnet) && strlen($netmask) && strlen($min) && strlen($max))
            $this->addSubnet($subnet,$netmask,$min,$max);
        // }$this->removeSubnetWithLines();
        // $this->supprimerSubnet();
    }

    public function supprimerSubnet_s()
    {
        //supprime le debut comme priorite
        $fichier = fopen("/etc/dhcp/dhcpd.conf","r");
        $cpt = 0;
        while($row = fgets($fichier))
        {
            if($row[0]!="#" && strstr($row,"subnet"))
            {
                $cpt++;
            }
        }
        fclose($fichier);
        for($nb = 0;$nb < $cpt-1;$nb++)
        {
            $this->supprimerSubnet();
        }
    }

    public function getLinesSubnet()
    {
        //reourne un tableau contenant les numeros de ligne contenant subnet comme premier mot
        $nom_fichier = "/etc/dhcp/dhcpd.conf";
        $tab= [];
        $fichier = fopen($nom_fichier,"r");
        $num_ligne = 1;
        while($row = fgets($fichier))
        {
            if($row[0]!="#" && strstr($row,"subnet"))
            {
                $tab[] = $num_ligne;
            }
            $num_ligne++;
        }
        fclose($fichier);
        return $tab;
    }

    public function removeSubnetWithLines()
    {
        //garde le permier subnet trouver et supprime les autres
        $tab = $this->getLinesSubnet();
        if(count($tab)>1)
        {
            // echo "<pre>";
            // print_r($tab);
            // echo "</pre>";
            $nom_fichier = "/etc/dhcp/dhcpd.conf";
            array_splice($tab,0,1);
            foreach($tab as $num_ligne)
            {
                for($i = 0;$i < 4;$i++)
                {
                    $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
                    shell_exec($commande);
                }
                $this->removeSubnetWithLines();
            }
        }
    }

    public function addSubnet($subnet,$netmask,$min,$max)
    {
    //ajoute un subnet dans le fichier , il est necessaire de savoir
    //que cette fonction supprime d abord tout les subnet existantes
        $this->removeSubnetWithLines();
        $this->supprimerSubnet();
            $ligne1 = "subnet $subnet netmask $netmask {\n";
            $ligne2 = "  range $min $max\n";
            $ligne3 = "  option routers rtr-239-0-1.example.org, rtr-239-0-2.example.org;\n}\n";
            $cmd = $ligne1.$ligne2.$ligne3;
            $fichier = fopen("/etc/dhcp/dhcpd.conf","a");
            fputs($fichier,$cmd);
            fclose($fichier);
    }

    public function getLinesHost()
    {
        //retoune le numero de ligne de tout les hosts
        $tab = [];
        $fichier = fopen("/etc/dhcp/dhcpd.conf","r");
        $num_ligne = 1;
        while($row = fgets($fichier))
        {
            if(strstr($row,"host") && $row[0]!="#")
            {
                $tab[] = $num_ligne;
            }
            $num_ligne++;
        }
        fclose($fichier);
        return $tab;
    }

    public function removeHostWithLines()
    {
        $tab = $this->getLinesHost();
        $nom_fichier = "/etc/dhcp/dhcpd.conf";
        if(count($tab) > 0)
        {
            $num_ligne = $tab[0];
            for($i = 0;$i < 4;$i++)
            {
                $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
                shell_exec($commande);
            }
            $this->removeHostWithLines();
        }
    }

    public function addHost($nom,$mac,$ip)
    {
        $fichier = fopen("/etc/dhcp/dhcpd.conf","a");
            if($nom!="" && $mac!="" && $ip!="")
            {
                $host = "host $nom {\n  hardware ethernet $mac;\n  fixed-address $ip;\n}\n";
                fputs($fichier,$host);
            }

        fclose($fichier);
    }

    public function getLigneHost($nom)
    {
        $num_ligne = 1;
        $fichier = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($fichier))
        {
            if(strstr($row,$nom) && $row[0]!="#")
            {
                return $num_ligne;
            }
            $num_ligne++;
        }
    }

    public function modifHost($nom,$mac,$ip)
    {
        $this->supprimerHost($nom);
        $this->addHost($nom,$mac,$ip);
        $this->range();
    }

    public function range()
    {
        $subnet = $this->getSubnet();
        $host = $this->getHost();
        $this->removeHostWithLines();
        $this->supprimerSubnet();
        $fichier = fopen("/etc/dhcp/dhcpd.conf","a");
        $p = str_replace("\n","",$subnet["subnet"]);
        $s = str_replace("\n","",$subnet["netmask"]);
        $m = str_replace("\n","",$subnet["range"][0]);
        $max = str_replace("\n","",$subnet["range"][1]);
        $this->addSubnet($p,$s,$m,$max);
        foreach($host as $h)
        {
            $nom = str_replace("\n","",$h['nom_hosts']);
            $mac = str_replace("\n","",$h['mac']);
            // $ip = explode(";",$h['ip'][3])[0];
            $ip = $h["ip"];
            $this->addHost($nom,$mac,$ip);
        }
        fclose($fichier);
    }

    public function delHostWithLines($num_ligne)
    {
        $nom_fichier = "/etc/dhcp/dhcpd.conf";
        for($i = 0;$i < 4;$i++)
        {
            $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
            shell_exec($commande);
        }
    }

    public function modif_host_lines($l,$nom,$mac,$ip)//pour modifier une personne a une ligne specifie
    {//il restera sur le meme ligne si tout les host sont alignes !
        $l--;
        $num_ligne = $this->getLigneHost($nom);
        $tab = $this->getHost();
        $ligne = $this->getLinesHost();
        $tab[$l]['nom_hosts'] = $nom;
        $tab[$l]['mac'] = $mac;
        $tab[$l]['ip'] = $ip;
        $this->removeHostWithLines();
        foreach($tab as $h)
        {
            $this->addHost($h['nom_hosts'],$h['mac'],$h['ip']);
        }
        $this->range();
    }

    public function getHostWithLines($num_ligne)
    {
        $tab = $this->getHost();
        return $tab[$num_ligne-1];
    }
}
// $n = new Net();
// $n->verification_fichier("/etc/dhcp/dhcpd.conf");
// $n->modif_host_lines(1,"junior","467543","123");
// $n->removeHostWithLines();
// $n->addSubnet("mille","467543","123","hello");
// $n->removeSubnetWithLines();
// $n->range();
?>
