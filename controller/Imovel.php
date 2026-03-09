<?php
require_once(__DIR__ . "/../model/Imovel.php");
require_once(__DIR__ . "/../model/FotoImovel.php");
session_start();


function criarSlug($titulo)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));
}

// Verifica se a variavel POST foi setada e se o form foi enviado por este método
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // MAPEAMENTO DO OBJETO IMOVEL COM AS INFORMAÇÕES DO FRONT-END

        $imovel = new Imovel(
            id: 0, // 0 para novos cadastros
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
            status: $_POST['status'] ?? 'disponivel',
            id_corretor: (int)($_POST['id_corretor'] ?? 0),
            possui_piscina: $_POST['possui_piscina'] ?? false,
            possui_churrasqueira: $_POST['possui_churrasqueira'] ?? false,
            slug: criarSlug($_POST['titulo'] ?? 'imovel')
        );


        if ($imovel->salvar()) {

            // Sucesso !!
            // LÓGICA PARA CADASTRAR AS IMAGENS
            $idImovel = $imovel->id;
            echo "<pre>";
            echo print_r($_POST);

            if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {

                echo "DEU CERTO!";

                // Manipulação dos arquivos
                $diretorio = "../uploads/imoveis/$idImovel/";
                if (!is_dir($diretorio)) mkdir($diretorio, 0777, true);

                foreach ($_FILES['fotos']['tmp_name'] as $index => $tmpName) {
                    $nomeArquivo = time() . "-" . $_FILES['fotos']['name'][$index];
                    $caminhoFinal = $diretorio . $nomeArquivo;

                    if (move_uploaded_file($tmpName, $caminhoFinal)) {
                        $principal = ((int)$_POST['index_principal'] === $index);

                        $foto = new FotoImovel(
                            id_imovel: $idImovel,
                            caminho: $caminhoFinal,
                            destaque: $principal,
                            ordem: $index + 1
                        );

                        $foto->salvar();
                    }
                }
            }                        

            $_SESSION['mensagem'] = "Imóvel cadastrado com sucesso!!";
            $_SESSION['tipo_alerta'] = 'success';

            header("Location: ../view/painelAdmin.php");
            exit;
        } else {
            throw new Exception("Erro ao gravar no banco de dados");
        }
    } catch (Exception $e) {
        die("Erro? " . $e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Excluir imoveis
    if (isset($_GET['excluir_id'])) {

        $idImovel = (int)$_GET['excluir_id'];
        $diretorio = "../uploads/imoveis/$idImovel/";

        // Apaga o banco de dados
        $imovel = new Imovel(id: $idImovel);
        if ($imovel->excluir()) {
            // Apaga o diretório

            if (is_dir($diretorio)) {
                array_map('unlink', glob("$diretorio/*.*"));
                rmdir($diretorio);
            }
            
            $_SESSION['mensagem'] = "Imovel excluído com sucesso";
            $_SESSION['tipo_alerta'] = 'danger';
            
            header("Location: ../view/painelAdmin.php");
            exit();
        }
    } // FIM EXCLUIR //

    $filtros = [
        'status'        => 'Disponível',
        // 'tipo'          => 'Casa',
        'localizacao'   => 'São Paulo',
    ];

    if(isset($_GET['filtro'])){
        Imovel::listarComFiltros($filtros);
    
    }
}








// try {

// $imovel = new Imovel(
//     id: 1,
//     titulo: "Casa de Luxo",
//     tipo: "Casa",
//     tipo_negocio: "venda",
//     descricao: "Maravilhosa casa localizada no do Pq do Carmo",
//     preco: 10000000.50,
//     valor_condominio: 00,
//     valor_iptu: 1200.00,
//     cep: "08450-000",
//     cidade: "São Paulo",
//     bairro: "Itaquera",
//     estado: "SP",
//     endereco: "Rua Avenida Travessa Itaquera",
//     quartos: 4,
//     banheiros: 2,
//     vagas: 2,
//     area: 350.50,
//     status: "Disponível",
//     id_corretor: 1,
//     possui_piscina: true,
//     possui_churrasqueira: true,
//     slug: "casa-pq-do-carmo"
// );

//     echo $imovel->salvar();
// } catch (Exception $e) {
//     echo $e->getMessage();
// }









echo "<pre>";
print_r($_POST);

echo "<hr>";
print_r($_FILES);
