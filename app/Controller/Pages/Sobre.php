<?php

namespace App\Controller\Pages;

use  App\Utils\View;
use App\Model\Entity\Organization;

class Sobre extends Page
{
    public static function getSobre(){
       
        $obOrganization = new Organization;

        
        $content = View::render("page/Sobre",[
            'name' => $obOrganization->Home,
            'idade' => $obOrganization->idade,
            'site' => "www.valmyrtavares.com"

        ]);
        return parent::getPage('SOBRE', $content);

    }
}