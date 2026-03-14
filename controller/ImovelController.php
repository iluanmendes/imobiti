<?php

class ImovelController
{

    /**
     * Lista os imóveis no painel administrativo
     * Rota: index.php?url=imovel/index
     */
    public function index()
    {
        // Captura os filtros vindos da URL (via GET)
        $filtros = [
            'tipo'    => $_GET['fTipo'] ?? '',
            'status'  => $_GET['fStatus'] ?? '',
            'busca'   => $_GET['fBusca'] ?? ''
        ];

        // Chama o Model para buscar os dados filtrados
        $imoveis = Imovel::listarComFiltros($filtros);

        // Carrega a view. As variáveis $imoveis e $filtros estarão disponíveis nela.
        include "view/painelAdmin.php";
    }

    /**
     * Exibe o formulário de novo cadastro
     * Rota: index.php?url=imovel/criar
     */
    public function criar()
    {
        include "view/painelCadImoveis.php";
    }

    /**
     * Processa o recebimento dos dados do formulário (POST)
     * Rota: index.php?url=imovel/salvar
     */
    public function salvar()
    {
        // Verifica se a requisição é do tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Instancia o Model Imovel com os dados recebidos via $_POST
                $imovel = new Imovel(
                    id: 0,
                    titulo: $_POST['titulo'] ?? '',
                    tipo: $_POST['tipo'] ?? '',
                    tipo_negocio: $_POST['tipo_negocio'] ?? '',
                    descricao: $_POST['descricao'] ?? '',
                    preco: (float)($_POST['preco'] ?? 0),
                    valor_condominio: (float)($_POST['valor_condominio'] ?? 0),
                    valor_iptu: (float)($_POST['valor_iptu'] ?? 0),
                    cep: $_POST['cep'] ?? '',
                    cidade: $_POST['cidade'] ?? '',
                    bairro: $_POST['bairro'] ?? '',
                    estado: $_POST['estado'] ?? '',
                    endereco: $_POST['endereco'] ?? '',
                    quartos: (int)($_POST['quartos'] ?? 0),
                    banheiros: (int)($_POST['banheiros'] ?? 0),
                    vagas: (int)($_POST['vagas'] ?? 0),
                    area: (float)($_POST['area'] ?? 0),
                    status: $_POST['status'] ?? 'Disponível',
                    id_corretor: (int)($_POST['id_corretor'] ?? 0),
                    possui_piscina: isset($_POST['possui_piscina']),
                    possui_churrasqueira: isset($_POST['possui_churrasqueira']),
                    slug: $this->gerarSlug($_POST['titulo'] ?? 'imovel')
                );

                // Tenta salvar no banco de dados
                if ($imovel->salvar()) {
                    // Após salvar o imóvel, processa o upload das fotos se houver
                    $this->processarUploadFotos($imovel->id);

                    $_SESSION['mensagem'] = "Imóvel cadastrado com sucesso!";
                    $_SESSION['tipo_alerta'] = "success";

                    // Redireciona para a listagem usando a nova rota
                    header("Location: index.php?url=imovel/index");
                    exit;
                }
            } catch (Exception $e) {
                die("Erro ao salvar imóvel: " . $e->getMessage());
            }
        }
    }

    /**
     * Remove um imóvel e seus arquivos
     * Rota: index.php?url=imovel/excluir&id=X
     */
    public function excluir()
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $imovel = new Imovel(id: $id);
            if ($imovel->excluir()) { //
                // Remove a pasta de fotos do servidor
                $this->removerPastaImovel($id);

                $_SESSION['mensagem'] = "Imóvel removido com sucesso!";
                $_SESSION['tipo_alerta'] = "danger";
            }
        }
        header("Location: index.php?url=imovel/index");
        exit;
    }

    // Métodos Auxiliares Privados

    private function gerarSlug($titulo)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));
    }


    
    private function processarUploadFotos($idImovel) {
    if (isset($_FILES['fotos'])) {
        // Caminho relativo à raiz (onde está o index.php)
        $diretorioDestino = "uploads/imoveis/{$idImovel}/"; 
        
        // Caminho absoluto para o PHP conseguir mover o arquivo
        $diretorioAbsoluto = __DIR__ . "/../" . $diretorioDestino;

        if (!is_dir($diretorioAbsoluto)) mkdir($diretorioAbsoluto, 0777, true);

        foreach ($_FILES['fotos']['tmp_name'] as $index => $tmpName) {
            $nomeArquivo = time() . "-" . $_FILES['fotos']['name'][$index];
            
            if (move_uploaded_file($tmpName, $diretorioAbsoluto . $nomeArquivo)) {
                $foto = new FotoImovel(
                    id_imovel: $idImovel,
                    caminho: $diretorioDestino . $nomeArquivo, // SALVA SEM "../"
                    destaque: (isset($_POST['index_principal']) && (int)$_POST['index_principal'] === $index),
                    ordem: $index + 1
                );
                $foto->salvar();
            }
        }
    }
}

    private function removerPastaImovel($id)
    {
        $diretorio = "uploads/imoveis/{$id}/";
        if (is_dir($diretorio)) {
            array_map('unlink', glob("{$diretorio}*.*"));
            rmdir($diretorio);
        }
    }
}
