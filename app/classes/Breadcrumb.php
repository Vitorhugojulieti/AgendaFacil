<?php
namespace app\classes;
use app\classes\Uri;

class Breadcrumb{
    public static function get(){

        $pathParts = Uri::uri();
        // URL base (domínio)
        $urlBase = 'http://' . $_SERVER['HTTP_HOST'] . '/';

        // Iniciar o breadcrumb com um link para a página inicial
        $breadcrumb = '<nav aria-label="breadcrumb"><ul class="list-none flex gap-2 items-center">';
        if(count($pathParts) === 1){
            $breadcrumb .= '<li  class="font-Poppins font-semibold  text-principal10 text-xl flex  items-center"><a href="' . $urlBase . '">Página Inicial</a></li> ';
        }else{
            $breadcrumb .= '<li  class="font-Poppins  text-principal10 flex  items-center"><a href="' . $urlBase . '">Página Inicial</a></li>/ ';
        }

        // Montar os links dos breadcrumbs dinamicamente
        $pathAccumulated = '';
        $totalParts = count($pathParts);
        foreach ($pathParts as $key => $part) {
            // Acumular a parte do caminho até o ponto atual
            $pathAccumulated .= $part . '/';

            $partWithoutNumber = preg_replace('/[0-9]+/', '', $part);

            // Capitalizar a primeira letra da parte do caminho (ou substituir por títulos adequados)
            $partName = ucwords(str_replace('-', ' ', $partWithoutNumber));

            // Se não for o último item, criar um link, senão, apenas o nome da página atual
            if ($key != $totalParts - 2) {
                $breadcrumb .= '<li class="font-Poppins  text-principal10 flex  items-center"><a href="' . $urlBase . $pathAccumulated . '">' . $partName . '</a></li> /';
            } else {
                $breadcrumb .= '<li class="font-Poppins font-semibold text-principal10 text-xl flex  items-center">' . $partName . '</li>';
            }
        }

        $breadcrumb .= '</ul></nav>';

        // Exibir o breadcrumb
        return $breadcrumb;
    }

    public static function getForAdmin(){
        $pathParts = Uri::uri();
        $pathParts[0] = '';
        // unset($pathParts[0]);

        // URL base (domínio)
        $urlBase = 'http://' . $_SERVER['HTTP_HOST'] . '/admin';

        // Iniciar o breadcrumb com um link para a página inicial
        $breadcrumb = '<nav aria-label="breadcrumb"><ul class="list-none flex gap-2 ">';
        if(count($pathParts) === 1){
            $breadcrumb .= '<li  class="font-Poppins font-semibold  text-principal10 text-xl flex  items-center"><a href="' . $urlBase . '">Dashboard</a></li> ';
        }else{
            $breadcrumb .= '<li  class="font-Poppins  text-principal10 text-xl flex  items-center"><a href="' . $urlBase . '">Dashboard</a></li>/ ';
        }

        // Montar os links dos breadcrumbs dinamicamente
        $pathAccumulated = '';
        $totalParts = count($pathParts);
        foreach ($pathParts as $key => $part) {
            // Acumular a parte do caminho até o ponto atual
            $pathAccumulated .= $part . '/';

            $partWithoutNumber = preg_replace('/[0-9]+/', '', $part);            

            // Capitalizar a primeira letra da parte do caminho (ou substituir por títulos adequados)
            $partName = ucwords(str_replace('-', ' ', $partWithoutNumber));

            // Se não for o último item, criar um link, senão, apenas o nome da página atual
            if ($key != $totalParts - 2) {
                $breadcrumb .= '<li class="font-Poppins  text-principal10 text-xl flex  items-center"><a href="' . $urlBase . $pathAccumulated . '">' . $partName . '</a></li> /';
            } else {
                $breadcrumb .= '<li class="font-Poppins font-semibold text-principal10 text-xl flex  items-center">' . $partName . '</li>';
            }
        }

        $breadcrumb .= '</ul></nav>';

        // Exibir o breadcrumb
        return $breadcrumb;
    }
}

?>