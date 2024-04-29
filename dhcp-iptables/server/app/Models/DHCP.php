<?php
include_once("DHCPError.php");
// public function getSubnet()
// public function supprimerSubnet()
// public function getHost()
// public function supprimerHost($element)
// public function modifierSubnet($subnet,$netmask,$min,$max)
// public function supprimerSubnet_s()
// public function getLinesSubnet()
// public function removeSubnetWithLines()
// public function addSubnet($subnet,$netmask,$min,$max)
// public function getLinesHost()
// public function removeHostWithLines()
// public function addHost($nom,$mac)
class DHCP
{
    public function __construct()
    {

    }

    public function getSubnet()
    {
        //retourne un tableau concernant tout les subnet trouve dans le fichier
        $dhcp = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($dhcp))
        {
            if(strstr($row,"subnet") && !strstr($row[0],"#"))
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
                $mac = str_replace(";","",explode(" ethernet ",$row)[1]);
                $tableau = [
                    "nom_hosts" => $nom_hote,
                    "mac" => $mac
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
        $error = new DHCPError();
        if($error->test_subnet($subnet,$netmask,$min,$max))
        {
            $this->addSubnet($subnet,$netmask,$min,$max);
        }
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
        $error = new DHCPError();
        if($error->test_subnet($subnet,$netmask,$min,$max))
        {
            $ligne1 = "subnet $subnet netmask $netmask {\n";
            $ligne2 = "  range $min $max\n";
            $ligne3 = "  option routers rtr-239-0-1.example.org, rtr-239-0-2.example.org;\n}\n";
            $cmd = $ligne1.$ligne2.$ligne3;
            $fichier = fopen("/etc/dhcp/dhcpd.conf","a");
            fputs($fichier,$cmd);
        }
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

    public function addHost($nom,$mac)
    {
        $fichier = fopen("/etc/dhcp/dhcpd.conf","a");
        $error = new DHCPError();
        if($error->test_mac($mac) && strlen($nom) > 0)
        {
            $host = "host $nom {\n  hardware ethernet $mac;\n  fixed-address fantasia.example.com;\n}\n";
            fputs($fichier,$host);
        }
        else
        {
            return "donnees non satisfaisantes!\n";
        }
        fclose($fichier);
    }

}

?>