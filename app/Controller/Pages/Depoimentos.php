<?php

namespace App\Controller\Pages;
use  \App\Utils\View;
use  \App\Model\Entity\Depoimento;
use \App\Paginando\Pagination;


class Depoimentos extends Page
{

    private static function getDepoimentoItens($request, &$obPagination){//referencia de momória pesquisar
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadetotal = Depoimento::getDepoimentos(null,null, null,' COUNT(*) as qtd ')->fetchObject()->qtd;

      //PAGINA ATUAL CHMANDO O GETQUERYPARAMS

      $queryParams = $request->getQueryParams();
      $paginaAtual = $queryParams['page'] ?? 1;

      //INSTANCIA DE PÁGINAÇÃO
      $obPagination = new Pagination($quantidadetotal, $paginaAtual, 4); 
    

        $results = Depoimento::getDepoimentos(null, 'id DESC', $obPagination->getLimit() );

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

     public static function getDepoimentos($request){
        $content = View::render("page/depoimentos",[
         'itens' => self::getDepoimentoItens($request, $obPagination),
         'pagination' => parent::getPagination($request,$obPagination)


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
       //Retorna a página de listagem de pepoimentos
        return self::getDepoimentos($request);
    }
}