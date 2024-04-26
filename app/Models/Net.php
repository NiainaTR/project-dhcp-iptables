<?php 

namespace App\Models;
class Net{

    public function __construct(){

    }


public function getSubnet(){
    //ACCESS AU DONNES
    // echo $element[0]["nom"];//acceder au cle nom dans le tableau
    // echo $element[0]["subnet"]."\n";
    // echo $element[0]["netmask"]."\n";
    // echo $element[0]["range"][0]."\n";
    // echo $element[0]["range"][1]."\n";
    $element = [];

    $dhcp = fopen("/etc/dhcp/dhcpd.conf","r");
    $tmp = "";
    while($row = fgets($dhcp)){
        if(strstr($row,"subnet") && !strstr($row[0],"#")){
            $p1 = $row;
            $p2 = fgets($dhcp);
                // echo $tmp;
                // echo $p1;
                // echo $p2;
            $tableau = [
                "nom" => str_replace("#","",$tmp),
                "subnet" => explode(" ",$p1)[1],
                "netmask" => explode(" ",$p1)[3],
                "range" => [
                                explode(" ",$p2)[3],
                                str_replace(";","",explode(" ",$p2)[4])
                            ],
            ];
            $element[] = $tableau;
        }
        $tmp = $row;
    }
    fclose($dhcp);
    return $element;
}

public function getHosts(){
    $element = [];
    $fichier = fopen("/etc/dhcp/dhcpd.conf","r");
    while($row = fgets($fichier)){
        if($row[0]!='#' && strstr($row,"host")){
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
        //ACCES AUX ELEMENTS
        // echo $element[0]["nom_hosts"]."\n";
        // echo $element[0]["mac"]."\n";
        // print_r($element);
    return $element;
}
// echo "Liste des hosts\n";
// print_r(getHosts());
// echo "###################################\n";
// echo "Liste des subnet\n";
// print_r(getSubnet());


public function supprimerHosts($nom_fichier,$element){
    $num_ligne = 1;
    $fichier = fopen($nom_fichier,"r");
    while($row = fgets($fichier)){
        if(strstr($row,$element)){
            break;
        }
        $num_ligne++;
    }
    fclose($fichier);
    for($i = 0;$i < 4;$i++)
    {
        $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
        shell_exec($commande);
        //echo $commande."\n";
    }
}

public function supprimerSubnet($nom_fichier,$nom){
    $num_ligne = 1;
    $fichier = fopen($nom_fichier,"r");
    while($row = fgets($fichier)){
        if(strstr($row,$nom)){
            break;
        }
        $num_ligne++;
    }
    fclose($fichier);
    for($i = 0;$i < 5;$i++)
    {
        $commande = "sudo sed -i '".$num_ligne."d' $nom_fichier";
        shell_exec($commande);
    }
}

}