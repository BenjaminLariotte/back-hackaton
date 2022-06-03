<?php


class Controller
{
    var $vars = array();

    public function __construct()
    {
        if (isset($_POST))
        {
            $this->input = $_POST;
        }

        if (isset($_FILES))
        {
            $this->files = $_FILES;
        }
    }

    function set($d)
    {
        $this->vars = array_merge($this->vars, $d);
    }

    public function loadDao($daoName)
    {
        require_once ("back/dao/".$daoName.".php");
        $this->$daoName = new $daoName();
    }

    // Méthode pour charger une vue
    function render($controller, $viewFile, $param = null)
    {
        // Extraction de $vars
        // permet le passage de $d['maVar'] = value (côté controlleur) à $maVar = value (côté vue)
        extract($this->vars);
        // Démarrage de la mémoire tampon
        ob_start();
        require_once('view/' . $controller . '/' . $viewFile . '.php');
        // Vide la mémoire tampon et affecte le contenu dans $content
        $content = ob_get_clean();

        echo $content;
        // Execution de saveUrl
        $this->saveUrl($controller, $viewFile, $param);
    }
}
