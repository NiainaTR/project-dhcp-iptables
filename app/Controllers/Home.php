<?php

namespace App\Controllers;
use  App\Models\Net;
class Home extends BaseController
{
    public function index(): string
    {

        $n=new Net();
        $data['subnet']=$n->getSubnet();
        return view('subnet',$data);
     }
    public function hote():string
    {
        $n=new Net();
        $data['hosts']=$n->getHosts();
        return view('hosts',$data);
    }
}
