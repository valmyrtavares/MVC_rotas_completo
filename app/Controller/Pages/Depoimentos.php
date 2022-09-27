<?php

namespace App\Controller\Pages;
use  \App\Utils\View;
use  \App\Model\Entity\Depoimento;


class Depoimentos extends Page
{

    private static function getDepoimentoItens(){
        $itens = '';
        $results = Depoimento::getDepoimentos(null, 'id DESC');

        //RENDERIZA ITEM
        while($obDepoimento = $results->fetchObject(Depoimento::class)){
            $itens .= View::render("page/depoimento/item",[
                'nome' => $obDepoimento->nome,
                'mensagem' => $obDepoimento->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obDepoimento->data))
            ]);
        }

        return $itens;
    }

    public static function getDepoimentos(){
        $content = View::render("page/depoimentos",[
         'itens' => self::getDepoimentoItens()
        ]);
        return parent::getPage('Depoimentos', $content);

    }
    
//Cadastra um novo depoimento
    public static function insertDepoimentos($request){
        $postVars = $request->getPostVars();
       //Nova instancia de depoimento
       $obDepoimento = new Depoimento;
       $obDepoimento->nome = $postVars['nome'];
       $obDepoimento->mensagem = $postVars['mensagem'];
       $obDepoimento->cadastrar();
        return self::getDepoimentos();
    }
}