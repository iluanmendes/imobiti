<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Imóveis - Sistema Imobiti</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f5f6f8; }
        .navbar { box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); }
        .content-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); }
        .img-preview { width: 60px; height: 45px; object-fit: cover; border-radius: 4px; }
        footer { background: #212529; color: white; padding: 40px 0; margin-top: 60px; }
        .badge-status { font-weight: 500; padding: 0.5em 0.8em; }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Painel Imobiliária</a>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php?url=imovel/index">Imóveis</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Usuários</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light ms-3" href="#">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_alerta'] ?> alert-dismissible fade show" role="alert">
                <b><?= $_SESSION['mensagem'] ?></b>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensagem'], $_SESSION['tipo_alerta']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">Gerenciamento de Imóveis</h4>
            <a href="index.php?url=imovel/criar" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo Imóvel
            </a>
        </div>

        <div class="content-card">

            <form method="GET" action="index.php">
                <input type="hidden" name="url" value="imovel/index">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <input type="text" value="<?= $filtros['busca'] ?? '' ?>" name="fBusca" class="form-control" placeholder="Pesquisar por título, bairro...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="fTipo">
                            <option value="">Todos os tipos</option>
                            <?php $tipos = ['Casa', 'Apartamento', 'Sobrado', 'Terreno', 'Comercial']; ?>
                            <?php foreach($tipos as $tipo): ?>
                                <option value="<?= $tipo ?>" <?= ($filtros['tipo'] ?? '') == $tipo ? 'selected' : '' ?>><?= $tipo ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="fStatus">
                            <option value="">Todos os status</option>
                            <option value="Disponível" <?= ($filtros['status'] ?? '') == 'Disponível' ? 'selected' : '' ?>>Disponível</option>
                            <option value="Vendido" <?= ($filtros['status'] ?? '') == 'Vendido' ? 'selected' : '' ?>>Vendido</option>
                            <option value="Alugado" <?= ($filtros['status'] ?? '') == 'Alugado' ? 'selected' : '' ?>>Alugado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-secondary w-100">Filtrar</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Título / Localização</th>
                            <th>Tipo</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($imoveis)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Nenhum imóvel encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($imoveis as $imovel): ?>
                                <tr>
                                    <td>
                                        <img src="/<?= $imovel->foto_principal ?? 'assets/img/sem-foto.jpg' ?>" class="img-preview" alt="Foto">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $imovel->titulo ?></div>
                                        <small class="text-muted">
                                            <?= $imovel->bairro ?> - <?= $imovel->cidade ?>
                                        </small>
                                    </td>
                                    <td><?= ucfirst($imovel->tipo) ?></td>
                                    <td>R$ <?= number_format($imovel->preco, 2, ',', '.') ?></td>
                                    <td>
                                        <?php
                                            $cores = ['Disponível' => 'success', 'Vendido' => 'danger', 'Alugado' => 'warning'];
                                            $corStatus = $cores[$imovel->status] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $corStatus ?> badge-status">
                                            <?= $imovel->status ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="index.php?url=imovel/editar&id=<?= $imovel->id ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="index.php?url=imovel/excluir&id=<?= $imovel->id ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Excluir"
                                               onclick="return confirm('Deseja realmente excluir este imóvel?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p>Painel administrativo da imobiliária</p>
            <small>© 2026 Sistema interno - Gestão de Imóveis</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>