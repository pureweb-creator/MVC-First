<?php

namespace views;

class View
{
    private bool $cache;
    private bool $debug;

    public function __construct($cache, $debug)
    {
        $this->cache = $cache;
        $this->debug = $debug;
    }

    public function render($filename, $args){
        $loader = new \Twig_Loader_Filesystem('static/templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => $this->cache,
            'debug' => $this->debug
        ));

        try {
            $tpl = $twig->load($filename);
            echo $twig->render($filename, $args);

        } catch (\Twig\Error\LoaderError | \Twig\Error\RuntimeError | \Twig\Error\SyntaxError $e) {
            echo '<b>Error</b> ' . $e->getMessage() . '<br>';
            echo '<b>On line</b> ' . $e->getLine() . '<br>';
            echo '<b>In</b> ' . $e->getFile() . '<br>';
        }
    }
}