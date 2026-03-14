<?php

spl_autoload_register(function ($classe) {
    // Converte o nome da classe em um caminho de arquivo
    // Ex: Model\Imovel vira model/Imovel.php
    $caminho = __DIR__ . "/../" . str_replace("\\", "/", $classe) . ".php";

    if (file_exists($caminho)) {
        require_once $caminho;
    }
});

