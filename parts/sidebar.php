<aside class="app-sidebar sticky" id="sidebar">

    <div class="main-sidebar-header">
        <a href="index" class="header-logo">

            <?php if (resimVarmi('logo/', $ayar['koyu_logo'])): ?>
                <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-logo">
                <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-white">
            <?php endif ?>
            <?php if (resimVarmi('favicon/', $ayar['favicon'])): ?>
                <img src="<?=resimGetir('favicon/', $ayar['favicon'])?>" alt="logo" class="toggle-dark">
            <?php endif ?>
            <?php if (resimVarmi('logo/', $ayar['logo'])): ?>
                <img src="<?=resimGetir('logo/', $ayar['logo'])?>" alt="logo" class="desktop-dark">
                <img src="<?=resimGetir('logo/', $ayar['logo'])?>" alt="logo" class="toggle-logo">
            <?php endif ?>
        </a>
        <a aria-label="Hide Sidebar" class="sidemenu-toggle horizontal-navtoggle" id="menuToggleBtn" data-bs-toggle="sidebar" href="javascript:void(0);">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-close-icon lucide-panel-left-close open-sidemenu-toggle"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m16 15-3-3 3-3"/></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left-open-icon lucide-panel-left-open close-sidemenu-toggle"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m14 9 3 3-3 3"/></svg>
        </a>
    </div>

    <div class="main-sidebar" id="sidebar-scroll">

        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                <li class="slide__category"><span class="category-name">Hoşgeldiniz</span></li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-airplay-icon lucide-airplay side-menu__icon"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"/><path d="m12 15 5 6H7Z"/></svg>
                        <span class="side-menu__label">Anasayfa</span>
                        <span class="side-menu__angle">
                            <i class="ri-add-line side-menu__angle_open"></i>
                            <i class="ri-subtract-line side-menu__angle_close"></i>
                        </span> 
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Anasayfa</a>
                        </li>
                        <li class="slide">
                            <a href="index" class="side-menu__item"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-dollar-sign-icon lucide-badge-dollar-sign side-menu-doublemenu__icon"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                                Anasayfa</a>
                        </li>
                        <li class="slide">
                            <a href="kullanma-klavuzu" class="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-pie-icon lucide-chart-pie side-menu-doublemenu__icon"><path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"/><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/></svg>
                                Kullanma Kılavuzu</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="slide__category"><span class="category-name">Sayfalar</span></li>
                <?php if (modulAktifMi($db, 'sayfa') && (yetkisiVarMi("sayfalar", 'goruntule') || yetkisiVarMi("sayfalar", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open side-menu__icon"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg>
                            <span class="side-menu__label">Sayfalar</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Sayfalar</a></li>
                            <?php if (yetkisiVarMi("sayfalar", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="sayfalar" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Sayfalar
                                    </a>
                                </li>
                            <?php endif ?>
                            
                            <?php if (yetkisiVarMi("sayfalar", 'ekle')): ?>
                                <li class="slide">
                                    <a href="sayfa-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Sayfa Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                            
                        </ul>
                    </li>
                <?php endif ?>


                <?php if (modulAktifMi($db, 'blog') && (yetkisiVarMi("blog", 'goruntule') || yetkisiVarMi("blog", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rocket-icon lucide-rocket side-menu__icon"><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09"/><path d="M9 12a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.4 22.4 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 .05 5 .05"/></svg>
                            <span class="side-menu__label">Bloglar</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Bloglar</a></li>
                            <?php if (yetkisiVarMi("blog", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="bloglar" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Bloglar
                                    </a>
                                </li>
                            <?php endif ?>
                            
                            <?php if (yetkisiVarMi("blog", 'ekle')): ?>
                                <li class="slide">
                                    <a href="blog-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Blog Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                            
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'slider') && (yetkisiVarMi("slider", 'goruntule') || yetkisiVarMi("slider", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers side-menu__icon"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
                            <span class="side-menu__label">Sliderler</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Sliderler</a></li>
                            <?php if (yetkisiVarMi("slider", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="sliderler" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Sliderler
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("slider", 'ekle')): ?>
                                <li class="slide">
                                    <a href="slider-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Slider Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'sss') && (yetkisiVarMi("sss", 'goruntule') && yetkisiVarMi("sss", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-boxes-icon lucide-boxes side-menu__icon"><path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"/><path d="m7 16.5-4.74-2.85"/><path d="m7 16.5 5-3"/><path d="M7 16.5v5.17"/><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"/><path d="m17 16.5-5-3"/><path d="m17 16.5 4.74-2.85"/><path d="M17 16.5v5.17"/><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"/><path d="M12 8 7.26 5.15"/><path d="m12 8 4.74-2.85"/><path d="M12 13.5V8"/></svg>
                            <span class="side-menu__label">SSS </span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">SSS </a></li>
                            <?php if (yetkisiVarMi("sss", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="sss" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Sorular
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("sss", 'ekle')): ?>
                                <li class="slide">
                                    <a href="sss-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>SSS Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'yorumlar') && (yetkisiVarMi("yorumlar", 'goruntule') && yetkisiVarMi("yorumlar", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-boxes-icon lucide-boxes side-menu__icon"><path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"/><path d="m7 16.5-4.74-2.85"/><path d="m7 16.5 5-3"/><path d="M7 16.5v5.17"/><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"/><path d="m17 16.5-5-3"/><path d="m17 16.5 4.74-2.85"/><path d="M17 16.5v5.17"/><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"/><path d="M12 8 7.26 5.15"/><path d="m12 8 4.74-2.85"/><path d="M12 13.5V8"/></svg>
                            <span class="side-menu__label">Yorumlar </span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Yorumlar </a></li>
                            <?php if (yetkisiVarMi("yorumlar", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="yorumlar" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Yorumlar
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("yorumlar", 'ekle')): ?>
                                <li class="slide">
                                    <a href="yorum-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Yorum Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'ekibimiz') && (yetkisiVarMi("ekibimiz", 'goruntule') && yetkisiVarMi("ekibimiz", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-table2-icon lucide-table-2 side-menu__icon"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"></path></svg>
                            <span class="side-menu__label">Ekibimiz </span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Ekibimiz </a></li>
                            <?php if (yetkisiVarMi("ekibimiz", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="ekibimiz" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Ekibimiz
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("ekibimiz", 'ekle')): ?>
                                <li class="slide">
                                    <a href="ekip-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Ekip Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'galeri') && (yetkisiVarMi("galeri", 'goruntule') && yetkisiVarMi("galeri", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shapes-icon lucide-shapes side-menu__icon"><path d="M8.3 10a.7.7 0 0 1-.626-1.079L11.4 3a.7.7 0 0 1 1.198-.043L16.3 8.9a.7.7 0 0 1-.572 1.1Z"></path><rect x="3" y="14" width="7" height="7" rx="1"></rect><circle cx="17.5" cy="17.5" r="3.5"></circle></svg>
                            <span class="side-menu__label">Galeri </span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Galeri </a></li>
                            <?php if (yetkisiVarMi("galeri", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="galeri" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Resimler
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("galeri", 'ekle')): ?>
                                <li class="slide">
                                    <a href="galeri-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Resim Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-component-icon lucide-component side-menu__icon"><path d="M15.536 11.293a1 1 0 0 0 0 1.414l2.376 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z"></path><path d="M2.297 11.293a1 1 0 0 0 0 1.414l2.377 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414L6.088 8.916a1 1 0 0 0-1.414 0z"></path><path d="M8.916 17.912a1 1 0 0 0 0 1.415l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.415l-2.377-2.376a1 1 0 0 0-1.414 0z"></path><path d="M8.916 4.674a1 1 0 0 0 0 1.414l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z"></path></svg>
                        <span class="side-menu__label">Ürünler</span>
                        <span class="side-menu__angle">
                            <i class="ri-add-line side-menu__angle_open"></i>
                            <i class="ri-subtract-line side-menu__angle_close"></i>
                        </span>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Ürünler</a></li>
                        <?php if (modulAktifMi($db, 'urunler')): ?>
                            <?php if (yetkisiVarMi("urunler", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="urunler" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Ürünler
                                    </a>
                                </li>
                            <?php endif ?>

                            <?php if (yetkisiVarMi("urunler", 'ekle')): ?>
                                <li class="slide">
                                    <a href="urun-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Ürün Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        <?php endif ?>

                        <?php if (modulAktifMi($db, 'kategoriler')): ?>
                            <?php if (yetkisiVarMi("kategoriler", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="kategoriler" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Kategoriler
                                    </a>
                                </li>
                            <?php endif ?>

                            <?php if (yetkisiVarMi("kategoriler", 'ekle')): ?>
                                <li class="slide">
                                    <a href="kategori-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Kategori Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        <?php endif ?>

                        <?php if (yetkisiVarMi("markalar", 'goruntule')): ?>
                            <li class="slide">
                                <a href="markalar" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Markalar
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if (yetkisiVarMi("markalar", 'ekle')): ?>
                            <li class="slide">
                                <a href="marka-ekle" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Marka Ekle
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if (modulAktifMi($db, 'kampanya_kupon')): ?>

                            <?php if (yetkisiVarMi("kampanyalar", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="kampanyalar" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Kampanyalar
                                    </a>
                                </li>
                            <?php endif ?>

                            <?php if (yetkisiVarMi("kampanyalar", 'ekle')): ?>
                                <li class="slide">
                                    <a href="kampanya-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Kampanya Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        <?php endif ?>
                        
                    </ul>
                </li>

                <?php if (modulAktifMi($db, 'siparisler') && (yetkisiVarMi("siparisler", 'goruntule') || yetkisiVarMi("siparisler", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-aperture-icon lucide-aperture side-menu__icon"><circle cx="12" cy="12" r="10"></circle><path d="m14.31 8 5.74 9.94"></path><path d="M9.69 8h11.48"></path><path d="m7.38 12 5.74-9.94"></path><path d="M9.69 16 3.95 6.06"></path><path d="M14.31 16H2.83"></path><path d="m16.62 12-5.74 9.94"></path></svg>
                            <span class="side-menu__label">Siparişler</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Siparişler</a></li>

                            <?php if (yetkisiVarMi("siparisler", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="siparisler" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Siparişler
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("siparisler", 'ekle')): ?>
                                <li class="slide">
                                    <a href="siparis-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Sipariş Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'menu') && (yetkisiVarMi("menuler", 'goruntule') && yetkisiVarMi("menuler", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-boxes-icon lucide-boxes side-menu__icon"><path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"/><path d="m7 16.5-4.74-2.85"/><path d="m7 16.5 5-3"/><path d="M7 16.5v5.17"/><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"/><path d="m17 16.5-5-3"/><path d="m17 16.5 4.74-2.85"/><path d="M17 16.5v5.17"/><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"/><path d="M12 8 7.26 5.15"/><path d="m12 8 4.74-2.85"/><path d="M12 13.5V8"/></svg>
                            <span class="side-menu__label">Menüler </span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Menüler </a></li>
                            <?php if (yetkisiVarMi("menuler", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="menuler" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Menüler
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("menuler", 'ekle')): ?>
                                <li class="slide">
                                    <a href="menu-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Menü Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'sabit-sayfa') && (yetkisiVarMi("seo-sayfa", 'goruntule') && yetkisiVarMi("seo-sayfa", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open side-menu__icon"><path d="M12 7v14"></path><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path></svg>
                            <span class="side-menu__label">Sabit Sayfalar</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Sabit Sayfalar </a></li>
                            <?php if (yetkisiVarMi("seo-sayfa", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="sabit-sayfalar" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Sayfalar
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("seo-sayfa", 'ekle')): ?>
                                <li class="slide">
                                    <a href="sabit-sayfa-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Sayfa Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (modulAktifMi($db, 'sabit-resim') && (yetkisiVarMi("sabit-resim", 'goruntule') && yetkisiVarMi("sabit-resim", 'ekle'))): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shapes-icon lucide-shapes side-menu__icon"><path d="M8.3 10a.7.7 0 0 1-.626-1.079L11.4 3a.7.7 0 0 1 1.198-.043L16.3 8.9a.7.7 0 0 1-.572 1.1Z"></path><rect x="3" y="14" width="7" height="7" rx="1"></rect><circle cx="17.5" cy="17.5" r="3.5"></circle></svg>
                            <span class="side-menu__label">Sabit Resimler</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Sabit Resimler </a></li>
                            <?php if (yetkisiVarMi("sabit-resim", 'goruntule')): ?>
                                <li class="slide">
                                    <a href="sabit-resimler" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Resimler
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (yetkisiVarMi("sabit-resim", 'ekle')): ?>
                                <li class="slide">
                                    <a href="sabit-resim-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Resim Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>


                <?php if (yetkisiVarMi("personeller", 'goruntule') || yetkisiVarMi("personeller", 'ekle')): ?>

                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole side-menu__icon"><circle cx="12" cy="16" r="1"/><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                            <span class="side-menu__label">Personeller</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Tüm Personeller</a></li>
                            <?php if (yetkisiVarMi("personeller", 'ekle')): ?>
                                <li class="slide">
                                    <a href="personeller" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Tüm Personeller
                                    </a>
                                </li>
                            <?php endif ?>

                            <?php if (yetkisiVarMi("personeller", 'ekle')): ?>
                                <li class="slide">
                                    <a href="personel-ekle" class="side-menu__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Personel Ekle
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>


                <?php if (modulAktifMi($db, 'raporlar') && yetkisiVarMi("raporlar", 'goruntule')): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-pie-icon lucide-chart-pie side-menu__icon"><path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"></path><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path></svg>
                            <span class="side-menu__label">Raporlar</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Raporlar</a></li>
                            <li class="slide">
                                <a href="raporlar" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Raporlar
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (yetkisiVarMi("ayarlar", 'goruntule') || yetkisiVarMi("ayarlar", 'duzenle')): ?>
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shapes-icon lucide-shapes side-menu__icon"><path d="M8.3 10a.7.7 0 0 1-.626-1.079L11.4 3a.7.7 0 0 1 1.198-.043L16.3 8.9a.7.7 0 0 1-.572 1.1Z"></path><rect x="3" y="14" width="7" height="7" rx="1"></rect><circle cx="17.5" cy="17.5" r="3.5"></circle></svg>
                            <span class="side-menu__label">Ayarlar</span>
                            <span class="side-menu__angle">
                                <i class="ri-add-line side-menu__angle_open"></i>
                                <i class="ri-subtract-line side-menu__angle_close"></i>
                            </span>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">Ayarlar</a></li>
                            <li class="slide">
                                <a href="ayarlar" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text-icon lucide-message-square-text side-menu-doublemenu__icon"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M7 7h8"/></svg>Ayarlar
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
                
            </ul>
            <div class="doublemenu_bottom-menu ">
                <ul class="main-menu mb-0 border-top py-2">
                    
                    <li class="slide">
                        <a href="javascript:void(0);" class="side-menu__item layout-setting">
                            <span class="light-layout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-moon-icon lucide-cloud-moon side-menu__icon"><path d="M13 16a3 3 0 0 1 0 6H7a5 5 0 1 1 4.9-6z"/><path d="M18.376 14.512a6 6 0 0 0 3.461-4.127c.148-.625-.659-.97-1.248-.714a4 4 0 0 1-5.259-5.26c.255-.589-.09-1.395-.716-1.248a6 6 0 0 0-4.594 5.36"/></svg>
                            </span>
                            <span class="dark-layout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-sun-icon lucide-cloud-sun side-menu__icon"><path d="M12 2v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="M20 12h2"/><path d="m19.07 4.93-1.41 1.41"/><path d="M15.947 12.65a4 4 0 0 0-5.925-4.128"/><path d="M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z"/></svg>
                            </span>
                            <span class="side-menu__label">Açık/Koyu Mod</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="cikis" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out side-menu__icon"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                            <span class="side-menu__label">Çıkış Yap</span>
                        </a>
                    </li>
                </ul>
                <ul class="main-menu mb-0 border-top  py-2 d-sm-block d-none">
                    <li class="slide">
                        <div class="dropend profile-drop">
                            <a href="javascript:void(0);" class="side-menu__item dropdown-toggle" id="mainProfile" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar avatar-sm side-menu__icon">
                                    <img src="<?=$avatar_yol ?>" alt="">
                                </div>
                                <div class="side-menu__label d-block flex-fill"> 
                                    <span class="d-block fw-semibold mb-1 fs-14"><?=$giris_cek['uye_ad_soyad']?></span>
                                    <span class="fs-12 d-block op-8"><?=$giris_cek['uye_eposta']?></span>
                                </div>
                            </a>
                
                            <div class="dropdown-menu p-1 overflow-hidden sidemenu-profile-dropdown">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="profil/">
                                            <i class="ti ti-user-circle me-2 fs-18"></i>Profilim
                                        </a>
                                    </li>
                                    <?php if (!empty($ayar['api_token'])): ?>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="https://ivesgo.com/autologin.php?token=<?=$ayar['api_token']?>" target="_blank">
                                                <i class="ti ti-user-circle me-2 fs-18"></i>İvesgo Hesabım
                                            </a>
                                        </li>
                                    <?php endif ?>
                                    <?php if (modulAktifMi($db, 'raporlar') && yetkisiVarMi("raporlar", 'goruntule')): ?>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="raporlar/">
                                            <i class="ti ti-antenna-bars-5 me-2 fs-18"></i>Raporlar
                                        </a>
                                    </li>
                                    <?php endif ?>
                                    <?php if (yetkisiVarMi("logs", 'goruntule')): ?>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="logs/">
                                                <i class="ti ti-settings me-2 fs-18"></i>Sistem Logları
                                            </a>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>

    </div>

</aside>