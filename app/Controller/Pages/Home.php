<?php

namespace App\Controller\Pages;

use  \App\Utils\View;
use App\Model\Entity\Organization;

class Home extends Page
{
    public static function getHome(){
        $obOrganization = new Organization;

        
        $content = View::render("page/home",[
            'name' => $obOrganization->Home,
            'idade' => $obOrganization->idade,
            'site' => "www.valmyrtavares.com"

        ]);
        return parent::getPage('WDEV', $content);

    }
}