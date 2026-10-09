<footer class="footer mt-auto py-3 border-top text-center bg-white">
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between flex-wrap align-items-center">
                    <div class="text-muted"> 
                        Copyright © <span id="year"></span> <?=$dil['copyright'] ?> <a href="https://www.ivesgo.com/" class="text-dark fw-medium">İvesgo Web Tasarım</a>.
                    </div>
                </div>
            </div>
        </footer>
        <div class="modal fade" id="header-responsive-search" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="d-inline-flex w-100 p-2 border-bottom border-block-end-dashed">
                            <button class="btn bg-transparent border-0" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                            <input type="text" class="form-control flex-grow-1 border-0" placeholder="Aramak İstediğiniz Kelimeyi Giriniz ..."
                                aria-label="Aramak İstediğiniz Kelimeyi Giriniz ..." aria-describedby="button-addon2">
                            <button class="btn btn-outline-light btn-sm">
                                ESC
                            </button>
                        </div>
                        <div class="p-4">
                            <span class="fs-14 text-muted">Are You Looking For ..!</span>
                            <div class="mt-2 mb-3 pb-3 border-bottom border-block-end-dashed">
                                <span class="search-tags alert"><i class="fe fe-user me-2"></i>People <a href="javascript:void(0)" class="tag-addon ms-1" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                                <span class="search-tags alert"><i class="fe fe-file-text me-2"></i>Pages <a href="javascript:void(0)" class="tag-addon ms-1" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                                <span class="search-tags alert"><i class="fe fe-align-left me-2"></i>Articles <a href="javascript:void(0)" class="tag-addon ms-1" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                                <span class="search-tags alert"><i class="fe fe-server me-2"></i>Tags <a href="javascript:void(0)" class="tag-addon ms-1" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                            </div>
                            <span class="fw-semibold">Quick Actions :</span>
                            <div class="mb-3 pb-3 border-bottom border-block-end-dashed">
                                <div class="mt-3 mb-3">
                                    <div class="d-flex gap-2 align-items-center text-muted mb-2"> 
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M16.5 2V5M7.5 2V5M12 2V5" />
                                                <path d="M13 3.5H11C7.70017 3.5 6.05025 3.5 5.02513 4.52513C4 5.55025 4 7.20017 4 10.5V15C4 18.2998 4 19.9497 5.02513 20.9749C6.05025 22 7.70017 22 11 22H13C16.2998 22 17.9497 22 18.9749 20.9749C20 19.9497 20 18.2998 20 15V10.5C20 7.20017 20 5.55025 18.9749 4.52512C17.9497 3.5 16.2998 3.5 13 3.5Z" />
                                                <path d="M13 3.5H11C7.70017 3.5 6.05025 3.5 5.02513 4.52513C4 5.55025 4 7.20017 4 10.5V12C4 15.2998 4 16.9497 5.02513 17.9749C6.05025 19 7.70017 19 11 19H13C16.2998 19 17.9497 19 18.9749 17.9749C20 16.9497 20 15.2998 20 12V10.5C20 7.20017 20 5.55025 18.9749 4.52512C17.9497 3.5 16.2998 3.5 13 3.5Z" />
                                                <path d="M8 14H12M8 10H16" />
                                            </svg>
                                        </span>
                                        <a href="notifications.html" class="fs-14"><span>Create a New Task</span></a> 
                                    </div>
                                </div>
                                <div class="mt-2 mb-3">
                                    <div class="d-flex gap-2 align-items-center text-muted mb-2"> 
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M16.3083 4.38394C15.7173 4.38394 15.4217 4.38394 15.1525 4.28405C15.1151 4.27017 15.0783 4.25491 15.042 4.23828C14.781 4.11855 14.5721 3.90959 14.1541 3.49167C13.1922 2.52977 12.7113 2.04882 12.1195 2.00447C12.04 1.99851 11.96 1.99851 11.8805 2.00447C11.2887 2.04882 10.8077 2.52977 9.84585 3.49166C9.42793 3.90959 9.21897 4.11855 8.95797 4.23828C8.92172 4.25491 8.88486 4.27017 8.84747 4.28405C8.57825 4.38394 8.28273 4.38394 7.69171 4.38394H7.58269C6.07478 4.38394 5.32083 4.38394 4.85239 4.85239C4.38394 5.32083 4.38394 6.07478 4.38394 7.58269V7.69171C4.38394 8.28273 4.38394 8.57825 4.28405 8.84747C4.27017 8.88486 4.25491 8.92172 4.23828 8.95797C4.11855 9.21897 3.90959 9.42793 3.49166 9.84585C2.52977 10.8077 2.04882 11.2887 2.00447 11.8805C1.99851 11.96 1.99851 12.04 2.00447 12.1195C2.04882 12.7113 2.52977 13.1922 3.49166 14.1541C3.90959 14.5721 4.11855 14.781 4.23828 15.042C4.25491 15.0783 4.27017 15.1151 4.28405 15.1525C4.38394 15.4217 4.38394 15.7173 4.38394 16.3083V16.4173C4.38394 17.9252 4.38394 18.6792 4.85239 19.1476C5.32083 19.6161 6.07478 19.6161 7.58269 19.6161H7.69171C8.28273 19.6161 8.57825 19.6161 8.84747 19.716C8.88486 19.7298 8.92172 19.7451 8.95797 19.7617C9.21897 19.8815 9.42793 20.0904 9.84585 20.5083C10.8077 21.4702 11.2887 21.9512 11.8805 21.9955C11.96 22.0015 12.0399 22.0015 12.1195 21.9955C12.7113 21.9512 13.1922 21.4702 14.1541 20.5083C14.5721 20.0904 14.781 19.8815 15.042 19.7617C15.0783 19.7451 15.1151 19.7298 15.1525 19.716C15.4217 19.6161 15.7173 19.6161 16.3083 19.6161H16.4173C17.9252 19.6161 18.6792 19.6161 19.1476 19.1476C19.6161 18.6792 19.6161 17.9252 19.6161 16.4173V16.3083C19.6161 15.7173 19.6161 15.4217 19.716 15.1525C19.7298 15.1151 19.7451 15.0783 19.7617 15.042C19.8815 14.781 20.0904 14.5721 20.5083 14.1541C21.4702 13.1922 21.9512 12.7113 21.9955 12.1195C22.0015 12.0399 22.0015 11.96 21.9955 11.8805C21.9512 11.2887 21.4702 10.8077 20.5083 9.84585C20.0904 9.42793 19.8815 9.21897 19.7617 8.95797C19.7451 8.92172 19.7298 8.88486 19.716 8.84747C19.6161 8.57825 19.6161 8.28273 19.6161 7.69171V7.58269C19.6161 6.07478 19.6161 5.32083 19.1476 4.85239C18.6792 4.38394 17.9252 4.38394 16.4173 4.38394H16.3083Z" />
                                                <path d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z" />
                                            </svg>
                                        </span>
                                        <a href="notifications.html" class="fs-14"><span>Open Personal Settings</span></a> 
                                    </div>
                                </div>
                                <div class="mt-2 mb-3">
                                    <div class="d-flex gap-2 align-items-center text-muted mb-2"> 
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" />
                                                <path d="M14 14H10C7.23858 14 5 16.2386 5 19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19C19 16.2386 16.7614 14 14 14Z" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <a href="notifications.html" class="fs-14"><span>Add a New User</span></a> 
                                    </div>
                                </div>
                                <div class="mt-2 mb-3">
                                    <div class="d-flex gap-2 align-items-center text-muted mb-2"> 
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M2.5 7.5V13.5C2.5 17.2712 2.5 19.1569 3.67157 20.3284C4.84315 21.5 6.72876 21.5 10.5 21.5H13.5C17.2712 21.5 19.1569 21.5 20.3284 20.3284C21.5 19.1569 21.5 17.2712 21.5 13.5V7.5" />
                                                <path d="M3.86909 5.31461L2.5 7.5H21.5L20.2478 5.41303C19.3941 3.99021 18.9673 3.2788 18.2795 2.8894C17.5918 2.5 16.7621 2.5 15.1029 2.5H8.95371C7.32998 2.5 6.51812 2.5 5.84013 2.8753C5.16215 3.2506 4.73113 3.93861 3.86909 5.31461Z" />
                                                <path d="M12 7.5V2.5" />
                                                <path d="M6 18H11M6 15H9" />
                                            </svg>
                                        </span>
                                        <a href="notifications.html" class="fs-14"><span>Add a New Product</span></a> 
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="d-flex gap-2 align-items-center text-muted mb-2"> 
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                                <path d="M8 13.5H16M8 8.5H12" stroke-linejoin="round" />
                                                <path d="M6.09881 19C4.7987 18.8721 3.82475 18.4816 3.17157 17.8284C2 16.6569 2 14.7712 2 11V10.5C2 6.72876 2 4.84315 3.17157 3.67157C4.34315 2.5 6.22876 2.5 10 2.5H14C17.7712 2.5 19.6569 2.5 20.8284 3.67157C22 4.84315 22 6.72876 22 10.5V11C22 14.7712 22 16.6569 20.8284 17.8284C19.6569 19 17.7712 19 14 19C13.4395 19.0125 12.9931 19.0551 12.5546 19.155C11.3562 19.4309 10.2465 20.0441 9.14987 20.5789C7.58729 21.3408 6.806 21.7218 6.31569 21.3651C5.37769 20.6665 6.29454 18.5019 6.5 17.5" />
                                            </svg>
                                        </span>
                                        <a href="notifications.html" class="fs-14"><span>Send Feedback</span></a> 
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold">Help :</span>
                            <div class="mt-3">
                                <div class="d-flex gap-2 align-items-center text-muted mb-2"> 
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                            <path d="M14.9805 7.01556C14.9805 7.01556 15.4805 7.51556 15.9805 8.51556C15.9805 8.51556 17.5687 6.01556 18.9805 5.51556" stroke-linejoin="round" />
                                            <path d="M9.99491 2.02134C7.49644 1.91556 5.56618 2.20338 5.56618 2.20338C4.34733 2.29053 2.01152 2.97385 2.01154 6.96454C2.01156 10.9213 1.9857 15.7993 2.01154 17.7439C2.01154 18.932 2.74716 21.7033 5.29332 21.8518C8.38816 22.0324 13.9628 22.0708 16.5205 21.8518C17.2052 21.8132 19.4847 21.2757 19.7732 18.7956C20.0721 16.2263 20.0126 14.4407 20.0126 14.0157" stroke-linejoin="round" />
                                            <path d="M21.9999 7.01556C21.9999 9.77698 19.7592 12.0156 16.9951 12.0156C14.231 12.0156 11.9903 9.77698 11.9903 7.01556C11.9903 4.25414 14.231 2.01556 16.9951 2.01556C19.7592 2.01556 21.9999 4.25414 21.9999 7.01556Z" />
                                            <path d="M6.98053 13.0156H10.9805" />
                                            <path d="M6.98053 17.0156H14.9805" />
                                        </svg>
                                    </span>
                                    <a href="notifications.html" class="fs-14"><span>Decumentation</span></a> 
                                </div>
                                <div class="d-flex gap-2 align-items-center text-muted"> 
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21.5 12C21.5 17.2467 17.2467 21.5 12 21.5C10.3719 21.5 8.8394 21.0904 7.5 20.3687C5.63177 19.362 4.37462 20.2979 3.26592 20.4658C3.09774 20.4913 2.93024 20.4302 2.80997 20.31C2.62741 20.1274 2.59266 19.8451 2.6935 19.6074C3.12865 18.5818 3.5282 16.6382 2.98341 15C2.6698 14.057 2.5 13.0483 2.5 12C2.5 6.75329 6.75329 2.5 12 2.5C17.2467 2.5 21.5 6.75329 21.5 12Z" />
                                            <path d="M9.5 9.5C9.5 8.11929 10.6193 7 12 7C13.3807 7 14.5 8.11929 14.5 9.5C14.5 10.3569 14.0689 11.1131 13.4117 11.5636C12.7283 12.0319 12 12.6716 12 13.5" />
                                            <path d="M12.125 16.75H12M12.25 16.75C12.25 16.8881 12.1381 17 12 17C11.8619 17 11.75 16.8881 11.75 16.75C11.75 16.6119 11.8619 16.5 12 16.5C12.1381 16.5 12.25 16.6119 12.25 16.75Z" />
                                        </svg>
                                    </span>
                                    <a href="notifications.html" class="fs-14"><span>Frequently Asked Questions</span></a> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-end justify-content-end">
                         <button class="btn btn-light btn-sm">
                            Search
                         </button>
                         <button class="btn btn-primary btn-sm">
                           Close
                         </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="searchOverlay" role="dialog" aria-modal="true" aria-label="Search" onclick="handleOverlayClick(event)">
            <div id="searchModal">
              <div class="sm-header">
                <i class="bi bi-search"></i>
                <input id="searchInput" type="text" placeholder="Arama Yapınız…" autocomplete="off" oninput="onSearchInput(this.value)" onkeydown="onSearchKey(event)" aria-label="Search">
                <button class="sm-close-btn" onclick="closeSearchModal()" aria-label="Close search">
                  <i class="bi bi-x-lg"></i>
                </button>
              </div>
 
              <div id="searchResults" role="listbox" onmousedown="event.preventDefault()"></div>
 
              <div class="sm-footer">
                <span class="hint">
                  <kbd><i class="ri-arrow-left-up-line"></i></kbd>
                  <kbd><i class="ri-arrow-down-line"></i></kbd> Yönlendirme
                </span>
                <span class="hint"><kbd>Enter</kbd> Seç</span>
                <span class="hint"><kbd>Esc</kbd> Kapat</span>
                <span class="sm-result-count" id="resultCount"></span>
              </div>
 
            </div>
          </div>

    </div>

    
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow lh-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M229.66,114.34l-96-96a8,8,0,0,0-11.32,0l-96,96A8,8,0,0,0,32,128H72v24a8,8,0,0,0,8,8h96a8,8,0,0,0,8-8V128h40a8,8,0,0,0,5.66-13.66ZM176,112a8,8,0,0,0-8,8v24H88V120a8,8,0,0,0-8-8H51.31L128,35.31,204.69,112Zm8,104a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16h96A8,8,0,0,1,184,216Zm0-32a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16h96A8,8,0,0,1,184,184Z"></path></svg>
        </span>
    </div>
    <div id="responsive-overlay"></div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/libs/@popperjs/core/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/defaultmenu.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/js/sticky.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js"></script>
    <script src="assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>
    <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
    <?php if ($par['0'] == "index" || $par['0'] == "raporlar" || $par['0'] == "canli-izleme" || $par['0'] == "musteri-profil" || $par['0'] == "profil"): ?>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <?php endif ?>

    <?php if ($par['0'] == "sayfa-duzenle"): ?>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <?php endif ?>

    <script src="assets/libs/gridjs/gridjs.umd.js"></script>

    <script> var _url = '<?=URL?>';</script>
    <script src="assets/js/script.js"></script>

    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <?php if ($par['0'] == "index" || $par['0'] == "raporlar"): ?>
        <script src="assets/js/sales-dashboard.js"></script>
    <?php endif ?>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/custom-switcher.min.js"></script>
    <?php if (strpos($par[0], 'ekle') !== false || strpos($par[0], 'duzenle') !== false): ?>
        <script type="text/javascript" src="assets/libs/ckeditor/ckeditor.js"></script>
    <?php endif; ?>
    
    <?php if (strpos($par[0], 'ekle') === false && strpos($par[0], 'duzenle') === false): ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

        <script src="assets/js/datatables.js"></script>
    <?php endif ?>

    
    
</body>

</html>