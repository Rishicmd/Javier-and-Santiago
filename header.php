<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= SITE_NAME ?> — <?= $page_title ?? 'Enrollment System' ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:       #1D0515;
      --bg2:      #350616;
      --bg3:      #550816;
      --border:   rgba(106, 4, 15, 0.4);
      --border2:  rgba(154, 13, 27, 0.5);
      --accent:   #9A0D1B;
      --accent2:  #c0182a;
      --accent3:  #e03347;
      --danger:   #ff5555;
      --warn:     #e3a020;
      --info:     #5b9bd5;
      --text:     #f5e6e8;
      --muted:    #b08890;
      --card:     #2a0a12;
      --radius:   10px;
    }

    body {
      font-family: 'Sora', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background-image:
        radial-gradient(ellipse at 20% 0%, rgba(106,4,15,0.25) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 100%, rgba(154,13,27,0.15) 0%, transparent 60%);
    }

    nav {
      background: rgba(53, 6, 22, 0.97);
      border-bottom: 1px solid var(--border2);
      padding: 0 2rem;
      display: flex;
      align-items: center;
      gap: 2rem;
      height: 64px;
      position: sticky;
      top: 0;
      z-index: 100;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 1px 20px rgba(154, 13, 27, 0.25);
    }

    .nav-brand {
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 11px;
    }
    .logo-icon {
      width: 38px;
      height: 38px;
      background: linear-gradient(135deg, #9A0D1B 0%, #6A040F 100%);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 2px 14px rgba(154, 13, 27, 0.55);
      border: 1px solid rgba(224, 51, 71, 0.3);
    }
    .logo-icon svg { width: 20px; height: 20px; color: #fff; }
    .logo-text { display: flex; flex-direction: column; line-height: 1; }
    .logo-text .brand-name {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--text);
      letter-spacing: -0.3px;
    }
    .logo-text .brand-name span { color: var(--accent3); }
    .logo-text .brand-sub {
      font-size: 0.61rem;
      color: var(--muted);
      font-weight: 400;
      letter-spacing: 0.9px;
      text-transform: uppercase;
      margin-top: 2px;
    }

    .nav-links { display: flex; gap: 0.3rem; margin-left: auto; }
    .nav-links a {
      color: var(--muted);
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: 6px;
      transition: all 0.15s;
      border: 1px solid transparent;
    }
    .nav-links a:hover { background: var(--bg3); color: var(--text); border-color: var(--border2); }
    .nav-links a.active { background: rgba(154,13,27,0.25); color: var(--accent3); border-color: var(--border2); }

    main { flex: 1; padding: 2rem; max-width: 1100px; margin: 0 auto; width: 100%; }

    .page-header { margin-bottom: 1.8rem; padding-bottom: 1.2rem; border-bottom: 1px solid var(--border); }
    .page-header h1 { font-size: 1.6rem; font-weight: 700; color: var(--text); letter-spacing: -0.5px; }
    .page-header p { color: var(--muted); font-size: 0.9rem; margin-top: 4px; }

    .alert {
      padding: 12px 16px;
      border-radius: var(--radius);
      font-size: 0.875rem;
      margin-bottom: 1.5rem;
      border: 1px solid;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .alert-success { background: rgba(106,4,15,0.2); border-color: var(--accent); color: #e87a8a; }
    .alert-danger  { background: rgba(255,85,85,0.1); border-color: var(--danger); color: #ff9090; }
    .alert-info    { background: rgba(91,155,213,0.1); border-color: var(--info); color: #79c0ff; }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(0,0,0,0.35);
    }
    .card-body { padding: 1.5rem; }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--bg3); }
    th {
      padding: 10px 14px;
      text-align: left;
      font-size: 0.78rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--muted);
      border-bottom: 1px solid var(--border2);
    }
    td { padding: 13px 14px; font-size: 0.875rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: rgba(85,8,22,0.35); }

    .badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      font-family: 'JetBrains Mono', monospace;
    }
    .badge-enrolled  { background: rgba(154,13,27,0.2); color: #e87a8a; border: 1px solid var(--accent); }
    .badge-irregular { background: #1f1a0d; color: #e3b341; border: 1px solid var(--warn); }
    .badge-dropped   { background: rgba(255,85,85,0.1); color: #ff9090; border: 1px solid var(--danger); }
    .badge-leave     { background: rgba(91,155,213,0.1); color: #79c0ff; border: 1px solid var(--info); }
    .badge-graduated { background: #1a0d2e; color: #d2a8ff; border: 1px solid #8957e5; }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 0.875rem;
      font-weight: 600;
      font-family: 'Sora', sans-serif;
      cursor: pointer;
      border: 1px solid transparent;
      text-decoration: none;
      transition: all 0.15s;
      white-space: nowrap;
    }
    .btn-primary { background: var(--accent); border-color: var(--accent2); color: #fff; box-shadow: 0 2px 10px rgba(154,13,27,0.4); }
    .btn-primary:hover { background: var(--accent2); box-shadow: 0 4px 16px rgba(154,13,27,0.55); }
    .btn-danger  { background: transparent; border-color: var(--danger); color: var(--danger); }
    .btn-danger:hover  { background: var(--danger); color: #fff; }
    .btn-edit    { background: transparent; border-color: var(--info); color: var(--info); }
    .btn-edit:hover    { background: var(--info); color: #fff; }
    .btn-ghost   { background: transparent; border-color: var(--border2); color: var(--muted); }
    .btn-ghost:hover   { background: var(--bg3); color: var(--text); }
    .btn-sm { padding: 5px 11px; font-size: 0.8rem; }

    .form-group { margin-bottom: 1.2rem; }
    .form-group label {
      display: block;
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--muted);
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 14px;
      background: var(--bg2);
      border: 1px solid var(--border2);
      border-radius: 6px;
      color: var(--text);
      font-size: 0.9rem;
      font-family: 'Sora', sans-serif;
      transition: border-color 0.15s;
      outline: none;
    }
    .form-group input:focus,
    .form-group select:focus { border-color: var(--accent2); box-shadow: 0 0 0 3px rgba(154,13,27,0.2); }
    .form-group select option { background: var(--bg2); color: var(--text); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1.5rem; }

    .id-chip {
      font-family: 'JetBrains Mono', monospace;
      font-size: 0.78rem;
      color: var(--muted);
      background: var(--bg3);
      padding: 2px 8px;
      border-radius: 4px;
      border: 1px solid var(--border2);
    }

    footer {
      text-align: center;
      padding: 1.2rem;
      color: var(--muted);
      font-size: 0.78rem;
      border-top: 1px solid var(--border);
      background: rgba(53,6,22,0.6);
    }

    .confirm-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.8);
      z-index: 999;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(4px);
    }
    .confirm-overlay.show { display: flex; }
    .confirm-box {
      background: var(--bg2);
      border: 1px solid var(--border2);
      border-radius: var(--radius);
      padding: 2rem;
      max-width: 380px;
      width: 90%;
      text-align: center;
      box-shadow: 0 8px 40px rgba(0,0,0,0.6);
    }
    .confirm-box h3 { margin-bottom: 8px; }
    .confirm-box p { color: var(--muted); font-size: 0.875rem; margin-bottom: 1.5rem; }
    .confirm-actions { display: flex; gap: 10px; justify-content: center; }

    @media (max-width: 650px) {
      .form-grid { grid-template-columns: 1fr; }
      nav { gap: 1rem; padding: 0 1rem; }
      main { padding: 1rem; }
      .logo-text .brand-sub { display: none; }
    }
  </style>
</head>
<body>

<nav>
  <a class="nav-brand" href="index.php">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
      </svg>
    </div>
    <div class="logo-text">
      <span class="brand-name">Scholar<span>MS</span></span>
      <span class="brand-sub">Student Management</span>
    </div>
  </a>
  <div class="nav-links">
    <a href="index.php"  class="<?= $current_page==='index.php'  ? 'active':'' ?>">📋 Students</a>
    <a href="search.php" class="<?= $current_page==='search.php' ? 'active':'' ?>">🔍 Search</a>
  </div>
</nav>