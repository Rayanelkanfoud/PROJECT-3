<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitForFun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="<?= URLROOT; ?>/public/img/favicon.ico" type="image/x-icon">
    <style>
      :root { --ff-green: #2c7a4b; --ff-dark: #1a4d30; }
      body { background: #f0f4f8; }
      .navbar { background: var(--ff-green) !important; }
      .navbar-brand { font-weight: 800; font-size: 1.4rem; letter-spacing: 1px; }
      .nav-link { font-weight: 600; }
      .nav-link:hover, .nav-link.active { background: rgba(255,255,255,.15); border-radius: 6px; }
      .page-title { color: var(--ff-green); font-weight: 800; }
      .btn-fitforfun { background: var(--ff-green); color: white; border: none; }
      .btn-fitforfun:hover { background: var(--ff-dark); color: white; }
      .table thead { background: #eaf6ef; }
      .badge-actief   { background: #d1fae5; color: #065f46; }
      .badge-inactief { background: #fee2e2; color: #991b1b; }
      .badge-beheerder  { background: #fef3c7; color: #92400e; }
      .badge-medewerker { background: #dbeafe; color: #1e40af; }
      .badge-lid        { background: #f3f4f6; color: #374151; }
      .badge-beginner   { background: #d1fae5; color: #065f46; }
      .badge-gemiddeld  { background: #fef3c7; color: #92400e; }
      .badge-gevorderd  { background: #fee2e2; color: #991b1b; }
    </style>
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand text-white" href="<?= URLROOT; ?>/home/index">
        <i class="bi bi-lightning-fill"></i> FitForFun
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link text-white <?= (strpos($_SERVER['REQUEST_URI'], '/home') !== false || $_SERVER['REQUEST_URI'] === '/') ? 'active' : '' ?>"
               href="<?= URLROOT; ?>/home/index">
              <i class="bi bi-house-fill"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], '/lid') !== false ? 'active' : '' ?>"
               href="<?= URLROOT; ?>/lid/index">
              <i class="bi bi-people-fill"></i> Leden
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], '/les') !== false ? 'active' : '' ?>"
               href="<?= URLROOT; ?>/les/index">
              <i class="bi bi-calendar-week-fill"></i> Lessen
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], '/reservering') !== false ? 'active' : '' ?>"
               href="<?= URLROOT; ?>/reservering/index">
              <i class="bi bi-clipboard-check-fill"></i> Reserveringen
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], '/medewerker') !== false ? 'active' : '' ?>"
               href="<?= URLROOT; ?>/medewerker/index">
              <i class="bi bi-person-badge-fill"></i> Medewerkers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], '/account') !== false ? 'active' : '' ?>"
               href="<?= URLROOT; ?>/account/index">
              <i class="bi bi-person-circle"></i> Accounts
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
