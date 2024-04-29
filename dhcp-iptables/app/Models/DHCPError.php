<?php

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

?>