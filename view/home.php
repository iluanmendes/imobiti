<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Imobiliária Modelo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fb;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,.55), rgba(0,0,0,.55)),
            url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1974') center/cover no-repeat;
            height: 75vh;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }

        .hero h1 {
            letter-spacing: -0.5px;
        }

        .search-box {
            margin-top: -60px;
            z-index: 2;
            position: relative;
            border-radius: 18px;
        }

        .search-box .card {
            border: none;
            border-radius: 18px;
        }

        .property-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .property-card img {
            height: 210px;
            object-fit: cover;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 700;
        }

        footer {
            background: #111;
            color: #bbb;
            padding: 50px 0 30px;
            margin-top: 40px;
        }

        footer small {
            color: #777;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="#">Imobiliária Modelo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Imóveis</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>
        <li class="nav-item ms-lg-3">
            <a class="btn btn-warning px-4 fw-semibold" href="#">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="container">
        <h1 class="display-5 fw-bold">Encontre o imóvel ideal</h1>
        <p class="lead mb-4">Casas, apartamentos e salas comerciais nas melhores regiões</p>
        <a href="#" class="btn btn-warning btn-lg px-4 fw-semibold">Ver imóveis</a>
    </div>
</section>

<!-- Busca -->
<section class="container search-box">
    <div class="card shadow-lg p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control form-control-lg" placeholder="Cidade ou bairro">
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-lg">
                    <option>Tipo de imóvel</option>
                    <option>Casa</option>
                    <option>Apartamento</option>
                    <option>Comercial</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-lg">
                    <option>Faixa de preço</option>
                    <option>Até R$200 mil</option>
                    <option>R$200 mil - R$500 mil</option>
                    <option>Acima de R$500 mil</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-dark btn-lg">Buscar</button>
            </div>
        </div>
    </div>
</section>

<!-- Imóveis -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-semibold">Imóveis em destaque</h2>
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card property-card shadow-sm">
                    <img src="https://images.unsplash.com/photo-1572120360610-d971b9b639c9?q=80&w=2070" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">Venda</span>
                        <h5 class="card-title">Casa moderna</h5>
                        <p class="text-muted small">3 quartos • 2 vagas • 180m²</p>
                        <p class="price text-primary">R$ 650.000</p>
                        <a href="#" class="btn btn-outline-dark w-100">Ver detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card property-card shadow-sm">
                    <img src="https://images.unsplash.com/photo-1560184897-ae75f418493e?q=80&w=1974" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">Venda</span>
                        <h5 class="card-title">Apartamento central</h5>
                        <p class="text-muted small">2 quartos • 1 vaga • 75m²</p>
                        <p class="price text-primary">R$ 380.000</p>
                        <a href="#" class="btn btn-outline-dark w-100">Ver detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card property-card shadow-sm">
                    <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?q=80&w=2070" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">Venda</span>
                        <h5 class="card-title">Sala comercial</h5>
                        <p class="text-muted small">Centro • 45m²</p>
                        <p class="price text-primary">R$ 220.000</p>
                        <a href="#" class="btn btn-outline-dark w-100">Ver detalhes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row text-center text-md-start">
            
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Imobiliária Modelo</h5>
                <p class="small">
                    Especializada na intermediação de compra, venda e locação de imóveis residenciais e comerciais. 
                    Atendendo com transparência, segurança jurídica e foco nas melhores oportunidades do mercado.
                </p>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="mb-3">Contato</h6>
                <p class="small mb-1">📍 Av. Exemplo, 123 - Centro</p>
                <p class="small mb-1">📞 (11) 99999-9999</p>
                <p class="small mb-1">✉ contato@imobiliaria.com</p>
                <p class="small">🕒 Seg–Sex: 9h às 18h</p>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="mb-3">Links úteis</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-decoration-none text-light">Sobre a empresa</a></li>
                    <li><a href="#" class="text-decoration-none text-light">Política de privacidade</a></li>
                    <li><a href="#" class="text-decoration-none text-light">Termos de uso</a></li>
                    <li><a href="#" class="text-decoration-none text-light">Trabalhe conosco</a></li>
                </ul>
            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center small">
            © 2026 Imobiliária Modelo • CNPJ 00.000.000/0001-00 • CRECI 00000-J
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
