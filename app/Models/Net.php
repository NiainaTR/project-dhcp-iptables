<?php 

namespace App\Models;
class Net{

    public function __construct(){

    }


    public function getSubnet()
    {
        $dhcp = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($dhcp)){
            if(strstr($row,"subnet") && !strstr($row[0],"#")){
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

    public function supprimerSubnet($nom_fichier)
    {
        $num_ligne = 1;
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

    public function getHosts()
    {
        $element = [];
        $fichier = fopen("/etc/dhcp/dhcpd.conf","r");
        while($row = fgets($fichier)){
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
        return $element;
    }

    public function supprimerHosts($nom_fichier,$element){
        $num_ligne = 1;
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

    public function addSubnet($subnet,$netmask,$min,$max)
    {
        supprimerSubnet("/etc/dhcp/dhcpd.conf");
        $ligne1 = "subnet $subnet netmask $netmask {\n";
        $ligne2 = "  range $min $max\n";
        $ligne3 = "  option routers rtr-239-0-1.example.org, rtr-239-0-2.example.org;\n}\n";
        $cmd = $ligne1.$ligne2.$ligne3;
        $fichier = fopen("/etc/dhcp/dhcpd.conf","a");
        fputs($fichier,$cmd);
        fclose($fichier);
    }

    public function modifierSubnet($subnet,$netmask,$min,$max)
    {
        supprimerSubnet("/etc/dhcp/dhcpd.conf");
        addSubnet($subnet,$netmask,$min,$max);
    }

}
