<!DOCTYPE html>
<html lang="tr" dir="ltr" data-nav-layout="vertical"  data-theme-mode="light" data-header-styles="light" data-width="fullwidth" data-menu-styles="dark" data-toggled="close">
<head>
    <?php $url = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>
    <base href="<?=URL?>">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$seo_cek['title']?></title>
    <meta name="Description" content="<?=$seo_cek['title']?>">
    <meta name="Author" content="İvesgo Web Tasarım | B2B | CRM Hizmetleri">
    <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="assets/js/main.js"></script>
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link href="assets/css/styles.css" rel="stylesheet" >
    <link href="assets/css/icons.css" rel="stylesheet" >
    <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet" > 
    <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">
    <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css">
    <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">

    <link rel="stylesheet" href="assets/libs/sweetalert2/sweetalert2.min.css">
    <?php if (strpos($par[0], 'ekle') === false && strpos($par[0], 'duzenle') === false): ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <?php endif ?>
</head>

<body class="sales-dashboard">
	<div class="progress-top-bar"></div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" >
        <div class="offcanvas-header d-block">
            <div class="d-flex align-items-center justify-content-between pb-3">
                <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Preview Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <nav>
                <div class="nav nav-tabs tab-style-1 nav-justified mb-0" id="switcher-main-tab" role="tablist">
                    <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-home" type="button" role="tab" aria-controls="switcher-home"
                        aria-selected="true">Theme Styles</button>
                    <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-profile" type="button" role="tab" aria-controls="switcher-profile"
                        aria-selected="false">Theme Colors</button>
                </div>
            </nav>
        </div>
        <div class="offcanvas-body">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel"
                aria-labelledby="switcher-home-tab" tabindex="0">

                <!-- Theme Template Mode -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Choose Suitable Theme:</p>
                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-default-theme" checked>

                            <label class="layout-card" for="switcher-default-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/1.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Default</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-fusion-theme">

                            <label class="layout-card" for="switcher-fusion-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/2.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Fusion</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-modern-theme">

                            <label class="layout-card" for="switcher-modern-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/3.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Modern</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-saas-theme">

                            <label class="layout-card" for="switcher-saas-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/4.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">SaaS</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-neon-theme">

                            <label class="layout-card" for="switcher-neon-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/5.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Neon</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-galaxy-theme">

                            <label class="layout-card" for="switcher-galaxy-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/6.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Galaxy</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-elegant-theme">

                            <label class="layout-card" for="switcher-elegant-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/7.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Elegant</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-flat-theme">

                            <label class="layout-card" for="switcher-flat-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/8.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Flat</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-nexus-theme">

                            <label class="layout-card" for="switcher-nexus-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/13.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Nexus</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-prism-theme">

                            <label class="layout-card" for="switcher-prism-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/9.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Prism</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-retro-theme">

                            <label class="layout-card" for="switcher-retro-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/10.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Retro</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-frost-theme">

                            <label class="layout-card" for="switcher-frost-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/11.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Frost</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-nova-theme">

                            <label class="layout-card" for="switcher-nova-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/12.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Nova</span>
                        </li>
                        <li class="col-6 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-template-style" id="switcher-slate-theme">

                            <label class="layout-card" for="switcher-slate-theme">
                                <span class="layout-preview layout-image-preview d-block">
                                    <img src="assets/images/media/themes/14.png" alt="Light Theme Layout" class="img-fluid">
                                </span>
                            </label>
                    
                            <span class="layout-badge">Slate</span>
                        </li>
                    </ul>
                </div>

                <!-- Theme Color Mode -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Theme Color Mode:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-style" id="switcher-light-theme"
                                checked>
                            <label class="layout-card preview-light" for="switcher-light-theme">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Light</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="theme-style" id="switcher-dark-theme">
                            <label class="layout-card preview-dark" for="switcher-dark-theme">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Dark</span>
                        </li>
                    </ul>
                </div>

                <!-- Directions -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Directions:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="direction" id="switcher-ltr" checked>
                            <label class="layout-card" for="switcher-ltr">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">LTR</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="direction" id="switcher-rtl">
                            <label class="layout-card preview-rtl" for="switcher-rtl">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">RTL</span>
                        </li>
                    </ul>
                </div>

                <!-- Navigation Styles -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Navigation Styles:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="navigation-style" id="switcher-vertical"
                                checked>
                            <label class="layout-card" for="switcher-vertical">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Vertical</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="navigation-style"
                                id="switcher-horizontal">
                            <label class="layout-card preview-horizontal" for="switcher-horizontal">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-header">
                                            <span class="header-search"></span>
                                            <span class="header-icons">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="layout-main">
                                            <span class="layout-sidebar">
                                                <span class="sidebar-logo"></span>
                                                <span class="sidebar-line"></span>
                                                <span class="sidebar-line"></span>
                                                <span class="sidebar-line"></span>
                                                <span class="sidebar-line"></span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Horizontal</span>
                        </li>
                    </ul>
                </div>

                <!-- Menu Styles -->
                <div class="switcher-section navigation-menu-styles">
                    <p class="switcher-style-head">Vertical & Horizontal Menu Styles:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="navigation-menu-styles"
                                id="switcher-menu-click">
                            <label class="layout-card preview-menuclick" for="switcher-menu-click">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Menu Click</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="navigation-menu-styles"
                                id="switcher-menu-hover">
                            <label class="layout-card preview-menuhover" for="switcher-menu-hover">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Menu Hover</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="navigation-menu-styles"
                                id="switcher-icon-click">
                            <label class="layout-card preview-iconclick" for="switcher-icon-click">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Icon Click</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="navigation-menu-styles"
                                id="switcher-icon-hover">
                            <label class="layout-card preview-iconhover" for="switcher-icon-hover">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Icon Hover</span>
                        </li>
                    </ul>
                </div>

                <!-- Sidemenu Layout Styles -->
                <div class="switcher-section sidemenu-layout-styles">
                    <p class="switcher-style-head">Sidemenu Layout Styles:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="sidemenu-layout-styles"
                                id="switcher-default-menu" checked>
                            <label class="layout-card" for="switcher-default-menu">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Default</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="sidemenu-layout-styles"
                                id="switcher-closed-menu">
                            <label class="layout-card preview-closed" for="switcher-closed-menu">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Closed</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="sidemenu-layout-styles"
                                id="switcher-icontext-menu">
                            <label class="layout-card preview-icontext" for="switcher-icontext-menu">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Icon Text</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="sidemenu-layout-styles"
                                id="switcher-icon-overlay">
                            <label class="layout-card preview-overlay" for="switcher-icon-overlay">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Overlay</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="sidemenu-layout-styles"
                                id="switcher-detached">
                            <label class="layout-card preview-detached" for="switcher-detached">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-header">
                                            <span class="header-search"></span>
                                            <span class="header-icons">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="layout-main">
                                            <span class="layout-sidebar">
                                                <span class="sidebar-logo"></span>
                                                <span class="sidebar-line"></span>
                                                <span class="sidebar-line"></span>
                                                <span class="sidebar-line"></span>
                                                <span class="sidebar-line"></span>
                                            </span>
                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Detached</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="sidemenu-layout-styles" id="switcher-double-menu">
                            <label class="layout-card preview-double" for="switcher-double-menu">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="d-flex">
                                            <span class="layout-sidebar">
                                                <span>
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                                            </span>
                                            <span class="sidebar-submenu"></span>
                                        </span>
                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Double</span>
                        </li>
                    </ul>
                </div>

                <!-- Page Styles -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Page Styles:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="page-styles" id="switcher-regular"
                                checked>
                            <label class="layout-card" for="switcher-regular">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Regular</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="page-styles" id="switcher-classic">
                            <label class="layout-card preview-classic" for="switcher-classic">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Classic</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="page-styles" id="switcher-modern">
                            <label class="layout-card preview-modern" for="switcher-modern">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Modern</span>
                        </li>
                    </ul>
                </div>

                <!-- Layout Width Styles -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Layout Width Styles:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="layout-width"
                                id="switcher-default-width">
                            <label class="layout-card preview-default-width" for="switcher-default-width">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Default</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="layout-width" id="switcher-full-width"
                                checked>
                            <label class="layout-card" for="switcher-full-width">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Full</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="layout-width" id="switcher-boxed">
                            <label class="layout-card preview-boxed-width" for="switcher-boxed">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Boxed</span>
                        </li>
                    </ul>
                </div>

                <!-- Menu Positions -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Menu Positions:</p>

                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select"> 
                                <label class="form-check-label" for="switcher-menu-fixed"> Fixed </label> 
                                <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-fixed" checked=""> 
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select"> 
                                <label class="form-check-label" for="switcher-menu-scroll"> Scrollable </label> 
                                <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-scroll"> 
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header Positions -->
                <div class="switcher-section">
                    <p class="switcher-style-head">Header Positions:</p>

                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select"> <label class="form-check-label"
                                    for="switcher-header-fixed"> Fixed </label> <input class="form-check-input"
                                    type="radio" name="header-positions" id="switcher-header-fixed" checked="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select"> <label class="form-check-label"
                                    for="switcher-header-scroll"> Scrollable </label> <input
                                    class="form-check-input" type="radio" name="header-positions"
                                    id="switcher-header-scroll"> </div>
                        </div>
                    </div>
                </div>

                <!-- Loader -->
                <div class="switcher-section mb-0">
                    <p class="switcher-style-head">Loader:</p>

                    <ul class="row gx-3 gy-2 layout-card-list">
                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="page-loader" id="switcher-loader-enable">
                            <label class="layout-card preview-loader" for="switcher-loader-enable">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Enable</span>
                        </li>

                        <li class="col-4 layout-card-item">
                            <input class="layout-radio" type="radio" name="page-loader" id="switcher-loader-disable"
                                checked>
                            <label class="layout-card" for="switcher-loader-disable">
                                <span class="layout-preview">
                                    <span class="layout-preview-inner">
                                        <span class="layout-sidebar">
                                            <span class="sidebar-logo"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                            <span class="sidebar-line"></span>
                                        </span>

                                        <span class="layout-main">
                                            <span class="layout-header">
                                                <span class="header-search"></span>
                                                <span class="header-icons">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </span>
                                            </span>

                                            <span class="layout-content">
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                                <span class="content-line"></span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <span class="layout-badge">Disable</span>
                        </li>
                    </ul>
                </div>

               </div>
                <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel"
                    aria-labelledby="switcher-profile-tab" tabindex="0">
                    <div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Menu Colors:</p>
                            <ul class="row gx-3 gy-2 layout-card-list">

                                <!-- Light Menu -->
                                <li class="col-4 layout-card-item active">
                                    <input class="layout-radio" type="radio" name="menu-colors" id="switcher-menu-light">
                                    <label class="layout-card preview-menu-light" for="switcher-menu-light" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Light Menu">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="layout-badge">Light</span>
                                </li>
                        
                                <!-- Dark Menu -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio" type="radio" name="menu-colors" id="switcher-menu-dark" checked>
                                    <label class="layout-card preview-menu-dark" for="switcher-menu-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Dark Menu">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="layout-badge">Dark</span>
                                </li>
                        
                                <!-- Primary Menu -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio" type="radio" name="menu-colors" id="switcher-menu-primary">
                                    <label class="layout-card preview-menu-primary" for="switcher-menu-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Color Menu">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="layout-badge">Color</span>
                                </li>
                        
                                <!-- Gradient Menu -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio" type="radio" name="menu-colors" id="switcher-menu-gradient">
                                    <label class="layout-card preview-menu-gradient" for="switcher-menu-gradient" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Gradient Menu">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="layout-badge">Gradient</span>
                                </li>
                        
                                <!-- Transparent Menu -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio" type="radio" name="menu-colors" id="switcher-menu-transparent">
                                    <label class="layout-card preview-menu-transparent" for="switcher-menu-transparent" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Transparent Menu">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="layout-badge">Transparent</span>
                                </li>
                        
                            </ul>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically change
                                from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Header Colors:</p>
                            <ul class="row gx-3 gy-2 layout-card-list">

                                <!-- Light Header -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio color-input color-white" type="radio" name="header-colors"
                                        id="switcher-header-light" checked>
                        
                                    <label class="layout-card preview-header-light" for="switcher-header-light"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Light Header">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                        
                                    <span class="layout-badge">Light</span>
                                </li>
                        
                                <!-- Dark Header -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio color-input color-dark" type="radio" name="header-colors"
                                        id="switcher-header-dark">
                        
                                    <label class="layout-card preview-header-dark" for="switcher-header-dark"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Dark Header">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                        
                                    <span class="layout-badge">Dark</span>
                                </li>
                        
                                <!-- Primary Header -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio color-input color-primary" type="radio" name="header-colors"
                                        id="switcher-header-primary">
                        
                                    <label class="layout-card preview-header-primary" for="switcher-header-primary"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Color Header">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                        
                                    <span class="layout-badge">Color</span>
                                </li>
                        
                                <!-- Gradient Header -->
                                <li class="col-4 layout-card-item">
                                    <input class="layout-radio color-input color-gradient" type="radio" name="header-colors"
                                        id="switcher-header-gradient">
                        
                                    <label class="layout-card preview-header-gradient" for="switcher-header-gradient"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Gradient Header">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                        
                                    <span class="layout-badge">Gradient</span>
                                </li>
                        
                                <!-- Transparent Header -->
                                <li class="col-4 layout-card-item active">
                                    <input class="layout-radio color-input color-transparent" type="radio" name="header-colors"
                                        id="switcher-header-transparent">
                        
                                    <label class="layout-card preview-header-transparent" for="switcher-header-transparent"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Header">
                                        <span class="layout-preview">
                                            <span class="layout-preview-inner">
                                                <span class="layout-sidebar">
                                                    <span class="sidebar-logo"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                    <span class="sidebar-line"></span>
                                                </span>
                        
                                                <span class="layout-main">
                                                    <span class="layout-header">
                                                        <span class="header-search"></span>
                                                        <span class="header-icons">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </span>
                                                    </span>
                        
                                                    <span class="layout-content">
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                        <span class="content-line"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                        
                                    <span class="layout-badge">Transparent</span>
                                </li>
                        
                            </ul>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically
                                change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Primary:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-1" type="radio"
                                        name="theme-primary" id="switcher-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-2" type="radio"
                                        name="theme-primary" id="switcher-primary1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-3" type="radio"
                                        name="theme-primary" id="switcher-primary2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-4" type="radio"
                                        name="theme-primary" id="switcher-primary3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-5" type="radio"
                                        name="theme-primary" id="switcher-primary4">
                                </div>
                                <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                    <div class="theme-container-primary"></div>
                                    <div class="pickr-container-primary" onchange="updateChartColor(this.value)"></div>
                                </div>
                            </div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Background:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-1" type="radio"
                                        name="theme-background" id="switcher-background">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-2" type="radio"
                                        name="theme-background" id="switcher-background1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-3" type="radio"
                                        name="theme-background" id="switcher-background2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-4" type="radio"
                                        name="theme-background" id="switcher-background3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-5" type="radio"
                                        name="theme-background" id="switcher-background4">
                                </div>
                                <div class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                    <div class="theme-container-background"></div>
                                    <div class="pickr-container-background"></div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-image mb-3">
                            <p class="switcher-style-head">Menu With Background Image:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select menu-img-select m-2">
                                    <input class="form-check-input bgimage-input bg-img1" type="radio"
                                        name="menu-background" id="switcher-bg-img">
                                    <div class="bg-img-container">
                                        <img src="assets/images/menu-bg-images/bg-img1.jpg" alt="">
                                    </div>
                                </div>
                                <div class="form-check switch-select menu-img-select m-2">
                                    <input class="form-check-input bgimage-input bg-img2" type="radio"
                                        name="menu-background" id="switcher-bg-img1">
                                    <div class="bg-img-container">
                                        <img src="assets/images/menu-bg-images/bg-img2.jpg" alt="">
                                    </div>
                                </div>
                                <div class="form-check switch-select menu-img-select m-2">
                                    <input class="form-check-input bgimage-input bg-img3" type="radio"
                                        name="menu-background" id="switcher-bg-img2">
                                    <div class="bg-img-container">
                                        <img src="assets/images/menu-bg-images/bg-img3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="form-check switch-select menu-img-select m-2">
                                    <input class="form-check-input bgimage-input bg-img4" type="radio"
                                        name="menu-background" id="switcher-bg-img3">
                                    <div class="bg-img-container">
                                        <img src="assets/images/menu-bg-images/bg-img4.jpg" alt="">
                                    </div>
                                </div>
                                <div class="form-check switch-select menu-img-select m-2">
                                    <input class="form-check-input bgimage-input bg-img5" type="radio"
                                        name="menu-background" id="switcher-bg-img4">
                                    <div class="bg-img-container">
                                        <img src="assets/images/menu-bg-images/bg-img5.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between canvas-footer flex-wrap"> 
                    <a href="https://themeforest.net/item/nilova-multipurpose-admin-dashboard-template/63753984?s_rank=1" target="_blank" class="btn      btn-primary">Buy Now</a> 
                    <a href="https://themeforest.net/user/spruko/portfolio" target="_blank" class="btn btn-secondary">Our Portfolio</a> 
                    <a href="javascript:void(0);" id="reset-all" class="btn btn-danger">Reset</a> 
                </div>
            </div>
        </div>
    </div>

    <div id="loader" >
        <img src="assets/images/media/loader.svg" alt="">
    </div>
    <div class="page">
        <header class="app-header sticky" id="header">
            <div class="main-header-container container-fluid">

                <div class="header-content-left">

                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="<?=URL?>" class="header-logo">
                                <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                                <img src="assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                                <img src="assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                                <img src="assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                                <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                            </a>
                        </div>
                    </div>
                    <div class="header-element d-lg-none d-flex px-3 header-toggle-btn">
                        <a aria-label="Hide Sidebar" class="sidemenu-toggle horizontal-navtoggle" id="headerToggleBtn" data-bs-toggle="sidebar" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-close-icon lucide-panel-left-close open-sidemenu-toggle"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m16 15-3-3 3-3"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-open-icon lucide-panel-left-open close-sidemenu-toggle"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m14 9 3 3-3 3"/></svg>
                        </a>
                    </div>

                    <div class="header-element header-search header-search-content d-md-flex d-none">
                        <button type="button" class="header-search-bar responsive-search" aria-label="Open search">
                            <span class="btn btn-transparent btn-icon btn-sm header-search-icon rounded-pill border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-search-icon lucide-search">
                                    <path d="m21 21-4.34-4.34" />
                                    <circle cx="11" cy="11" r="8" />
                                </svg>
                            </span>
            
                            <span class="flex-fill op-8 fw-light">Aramak İstediğiniz Kelimeyi Giriniz.</span>
            
                            <span class="shortcut-key">
                                <kbd>⌘k</kbd>
                            </span>
                        </button>
                    </div>

                </div>
                <div class="header-content-right">

                    <div class="header-element d-md-none d-block">
                        <a href="javascript:void(0);" class="header-link responsive-search">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 24 24" width="24" height="24" color="currentColor" fill="none">
                                <path d="M17 17L21 21" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19C15.4183 19 19 15.4183 19 11Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>  
                    </div>

                    <div class="header-element header-theme-mode d-lg-none d-block"> 
                        <a href="javascript:void(0);" class="header-link layout-setting"> 
                            <span class="light-layout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon-icon lucide-moon header-link-icon"><path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"/>
                                </svg>
                            </span> 
                            <span class="dark-layout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun-icon lucide-sun header-link-icon"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                                </svg>
                            </span> 
                        </a> 
                    </div>

                    <div class="header-element notifications-dropdown d-xl-flex d-none dropdown">
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="offcanvas" data-bs-target="#notification-canvas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-ring-icon lucide-bell-ring header-link-icon"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M22 8c0-2.3-.8-4.3-2-6"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/><path d="M4 2C2.8 3.7 2 5.7 2 8"/></svg>
                            <span class="header-icon-pulse bg-secondary rounded pulse pulse-secondary"></span>
                        </a>
                    </div>
                    <?php $avatar_yol = !empty($giris_cek['uye_resim']) ? URL . 'assets/images/user/' . $giris_cek['uye_resim'] : URL . 'assets/images/system/user.jpg'; ?>
                    <div class="header-element dropdown profile-header-drop">
                        <a href="javascript:void(0);" class="dropdown-toggle" id="mainHeaderProfile"  data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm avatar-rounded lh-1">
                                    <img src="<?=$avatar_yol?>" alt="">
                                </div>
                                <div class="d-lg-block d-none">
                                    <span class="d-block fw-semibold lh-1"><?=$giris_cek['uye_ad_soyad'] ?></span>
                                    <span class="op-7 fs-12"><?=$giris_cek['uye_eposta'] ?></span>
                                </div>
                            </div>
                        </a>
                        <div class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown">
                            <div class="p-3">
                                <div class="d-flex align-items-start gap-2">
                                    <div class="lh-1">
                                        <span class="avatar avatar-sm bg-primary-transparent avatar-rounded">
                                            <img src="<?=$avatar_yol?>" alt="">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="d-block fw-semibold lh-1"><?=$giris_cek['uye_ad_soyad']?></span>
                                        <span class="text-muted fs-12"><?=$giris_cek['uye_eposta'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <ul class="list-unstyled mb-0 sub-list">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="profil/"><i class="ti ti-user-circle me-2 fs-16"></i>Hesabım</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="ayarlar/"><i class="ti ti-settings-cog me-2 fs-16"></i>Ayarlar</a>
                                        </li>
                                    </ul>        
                                </li>
                                <li><a class="dropdown-item d-flex align-items-center" href="cikis/"><i class="ti ti-logout me-2 fs-16"></i>Çıkı Yap</a></li>
                            </ul>
                        </div>
                   </div>

                   <div class="header-element">
                        <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal-icon lucide-sliders-horizontal  header-link-icon"><path d="M10 5H3"/><path d="M12 19H3"/><path d="M14 3v4"/><path d="M16 17v4"/><path d="M21 12h-9"/><path d="M21 19h-5"/><path d="M21 5h-7"/><path d="M8 10v4"/><path d="M8 12H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="notification-canvas">
                <div class="offcanvas-header border-bottom">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <h5 class="offcanvas-title flex-fill fw-semibold">Bildirimler</h5>
                        <a href="javascript:void(0);" class="btn-link btn-wave text-primary text-decoration-none fs-13" onclick="markAllRead()">Tümünü Okundu İşaretle</a>
                    </div>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="px-3 pt-3">
                        <div class="nav nav-tabs tab-style-1 nav-justified" id="notificarion-main-tab" role="tablist">
                            <button class="nav-link active" id="notificarion-all-tab" data-bs-toggle="tab" data-bs-target="#notificarion-all" type="button" role="tab" aria-controls="notificarion-all" aria-selected="true">Tümü</button>
                            <button class="nav-link" id="notificarion-inbox-tab" data-bs-toggle="tab" data-bs-target="#notificarion-inbox" type="button" role="tab" aria-controls="notificarion-inbox" aria-selected="false">
                                Okunmamışlar <span class="badge bg-success-transparent ms-2" id="unread-badge">0</span>
                            </button>
                        </div>
                    </div>
                    <div class="tab-content mt-3" id="nav-tabContent1">
                        <div class="tab-pane p-0 fade show active border-0" id="notificarion-all" role="tabpanel" aria-labelledby="notificarion-all-tab" tabindex="0">
                            <ul class="notify-list list-unstyled mb-0" id="list-all">
                                <!-- AJAX ile dinamik yüklenecek -->
                            </ul>
                        </div>
                        <div class="tab-pane p-0 fade border-0" id="notificarion-inbox" role="tabpanel" aria-labelledby="notificarion-inbox-tab" tabindex="0">
                            <ul class="notify-list list-unstyled mb-0" id="list-unread">
                                <!-- AJAX ile dinamik yüklenecek -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php  require_once 'sidebar.php' ?>


        