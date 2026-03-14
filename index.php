<?php
/**
 * index.php - Front Controller
 * Este arquivo centraliza todas as requisições do sistema.
 */

// 1. Inicia a sessão para mensagens de alerta e login
session_start();

// 2. Autoload Simplificado
// Registra uma função que carrega automaticamente os arquivos das classes
spl_autoload_register(function ($classe) {
    // Busca nas pastas 'model' e 'controller'
    $diretorios = ['model', 'controller'];
    
    foreach ($diretorios as $dir) {
        $arquivo = __DIR__ . "/{$dir}/{$classe}.php";
        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});

// 3. Captura a Rota (URL)
// Exemplo esperado: index.php?url=imovel/index
$url = $_GET['url'] ?? 'imovel/index'; // Rota padrão caso nenhuma seja informada
$rota = explode('/', $url);

// Define o nome do Controller e da Ação (método)
$controllerNome = ucfirst($rota[0] ?? 'Imovel') . "Controller"; 
$acao = $rota[1] ?? 'index';

// 4. Sistema de Roteamento Didático
try {
    // Verifica se a classe do controlador existe (carregada pelo autoload)
    if (class_exists($controllerNome)) {
        $controller = new $controllerNome();

        // Verifica se o método solicitado existe dentro da classe
        if (method_exists($controller, $acao)) {
            // Executa a ação (ex: index, criar, salvar, excluir)
            $controller->$acao();
        } else {
            // Erro caso o método não exista no controlador
            http_response_code(404);
            echo "<h1>Erro 404</h1>";
            echo "A ação <strong>'{$acao}'</strong> não foi encontrada no controlador <strong>'{$controllerNome}'</strong>.";
        }
    } else {
        // Erro caso o arquivo do controlador não exista
        http_response_code(404);
        echo "<h1>Erro 404</h1>";
        echo "O controlador <strong>'{$controllerNome}'</strong> não existe.";
    }
} catch (Exception $e) {
    // Captura erros inesperados para não expor detalhes sensíveis em produção
    echo "Ocorreu um erro no sistema: " . $e->getMessage();
}