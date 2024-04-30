<?php

class DHCPError
{
    public function __construct()
    {

    }

    public function test_mac($mac)
    {
        $tab = explode(":",$mac);
        $tab_final = [];
        if(count($tab)!=6)
        {
            return 0;
        }
        else
        {
            foreach($tab as $element)
            {
                printf("%s -> %d\n",$element,hexdec($element));
            }
        }
    }

    public function test_ip($ip)
    {
        $tab = explode(".",$ip);
        $tab_final = [];
        foreach($tab as $element)
        {
            if($element!="")
                $tab_final[] = $element;
        }
        if(count($tab_final) != 4)
        {
            return 0;
        }
        else
        {
            $tab = [];
            foreach($tab_final as $element)
            {
                if($element >= 0 && $element <= 255)
                {
                    $tab[] = $element;
                }
            }
        }
        if(count($tab) == 4)
        {
            return 1;
        }
        else
        {
            return 0;
        }
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
$ip = new DHCPError();
$ip->test_mac("08:00:07:26:c0:ff");
?>