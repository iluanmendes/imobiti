<?php
/**
 * index.php - Front Controller
 * Ponto de entrada único.
 */

session_start();

// 1. Autoload de Classes (Model, Controller, Config)
spl_autoload_register(function ($classe) {
    $diretorios = ['model', 'controller', 'config'];
    foreach ($diretorios as $dir) {
        $arquivo = __DIR__ . "/{$dir}/{$classe}.php";
        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});

/**
 * 2. Captura da URL e Definição da Rota Padrão
 * Se $_GET['url'] estiver vazio (acesso ao localhost:8080), 
 * ele assume explicitamente 'home'.
 */
$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/'); // Remove barras extras no final
$rota = explode('/', $url);

/**
 * 3. Mapeamento de Rotas
 * Aqui decidimos qual controlador será chamado.
 */
switch ($rota[0]) {
    
    // Se a URL for 'admin', carregamos a gestão de imóveis
    case 'admin':
        $controllerNome = "ImovelController";
        $acao = "index";
        break;

    // Se a URL for 'home' ou estiver VAZIA, carregamos a página pública
    case 'home':
    case '':
        $controllerNome = "HomeController";
        $acao = "index";
        break;

    // Rota dinâmica para outros controladores (ex: usuario, corretor)
    default:
        $controllerNome = ucfirst($rota[0]) . "Controller";
        $acao = $rota[1] ?? 'index';
        break;
}

/**
 * 4. Execução (Dispatcher)
 */
try {
    if (class_exists($controllerNome)) {
        $controller = new $controllerNome();

        if (method_exists($controller, $acao)) {
            $controller->$acao();
        } else {
            http_response_code(404);
            echo "Ação '{$acao}' não encontrada no controlador '{$controllerNome}'.";
        }
    } else {
        http_response_code(404);
        echo "Controlador '{$controllerNome}' não encontrado. Verifique se o arquivo existe em /controller.";
    }
} catch (Exception $e) {
    echo "Erro no sistema: " . $e->getMessage();
}