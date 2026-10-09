(function () {
  "use strict";

  /* page loader */
  function hideLoader() {
    const loader = document.getElementById("loader");
    loader.classList.add("d-none")
  }
  window.addEventListener("load", hideLoader);
  /* page loader */

  /* tooltip */
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  /* popover  */
  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
  const popoverList = [...popoverTriggerList].map(
    (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
  );

  //switcher color pickers
  const pickrContainerPrimary = document.querySelector(
    ".pickr-container-primary"
  );
  const themeContainerPrimary = document.querySelector(
    ".theme-container-primary"
  );
  const pickrContainerBackground = document.querySelector(
    ".pickr-container-background"
  );
  const themeContainerBackground = document.querySelector(
    ".theme-container-background"
  );

  /* for theme primary */
  const nanoThemes = [
    [
      "nano",
      {
        defaultRepresentation: "RGB",
        components: {
          preview: true,
          opacity: false,
          hue: true,

          interaction: {
            hex: false,
            rgba: true,
            hsva: false,
            input: true,
            clear: false,
            save: false,
          },
        },
      },
    ],
  ];
  const nanoButtons = [];
  let nanoPickr = null;
  for (const [theme, config] of nanoThemes) {
    const button = document.createElement("button");
    button.innerHTML = theme;
    nanoButtons.push(button);

    button.addEventListener("click", () => {
      const el = document.createElement("p");
      pickrContainerPrimary.appendChild(el);

      /* Delete previous instance */
      if (nanoPickr) {
        nanoPickr.destroyAndRemove();
      }

      /* Apply active class */
      for (const btn of nanoButtons) {
        btn.classList[btn === button ? "add" : "remove"]("active");
      }

      /* Create fresh instance */
      nanoPickr = new Pickr(
        Object.assign(
          {
            el,
            theme,
            default: "#675db0",
          },
          config
        )
      );

      /* Set events */
      nanoPickr.on("changestop", (source, instance) => {
        let color = instance.getColor().toRGBA();
        let html = document.querySelector("html");
        html.style.setProperty(
          "--primary-rgb",
          `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(
            color[2]
          )}`
        );
        /* theme color picker */
        localStorage.setItem(
          "primaryRGB",
          `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(
            color[2]
          )}`
        );
        // updateColors();
      });
    });

    themeContainerPrimary.appendChild(button);
  }
  nanoButtons[0].click();
  /* for theme primary */

  /* for theme background */
  const nanoThemes1 = [
    [
      "nano",
      {
        defaultRepresentation: "RGB",
        components: {
          preview: true,
          opacity: false,
          hue: true,

          interaction: {
            hex: false,
            rgba: true,
            hsva: false,
            input: true,
            clear: false,
            save: false,
          },
        },
      },
    ],
  ];
  const nanoButtons1 = [];
  let nanoPickr1 = null;
  for (const [theme, config] of nanoThemes1) {
    const button = document.createElement("button");
    button.innerHTML = theme;
    nanoButtons1.push(button);

    button.addEventListener("click", () => {
      const el = document.createElement("p");
      pickrContainerBackground.appendChild(el);

      /* Delete previous instance */
      if (nanoPickr1) {
        nanoPickr1.destroyAndRemove();
      }

      /* Apply active class */
      for (const btn of nanoButtons) {
        btn.classList[btn === button ? "add" : "remove"]("active");
      }

      /* Create fresh instance */
      nanoPickr1 = new Pickr(
        Object.assign(
          {
            el,
            theme,
            default: "#675db0",
          },
          config
        )
      );

      /* Set events */
      nanoPickr1.on("changestop", (source, instance) => {
        let color = instance.getColor().toRGBA();
        let html = document.querySelector("html");
        html.style.setProperty(
          "--body-bg-rgb",
          `${color[0]}, ${color[1]}, ${color[2]}`
        );
        document
          .querySelector("html")
          .style.setProperty(
            "--body-bg-rgb2",
            `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
          );
        document
          .querySelector("html")
          .style.setProperty(
            "--light-rgb",
            `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
          );
        document
          .querySelector("html")
          .style.setProperty(
            "--form-control-bg",
            `rgb(${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14})`
          );
        document
          .querySelector("html")
          .style.setProperty(
            "--gray-3",
            `rgb(${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14})`
          );
        localStorage.removeItem("bgtheme");
        // updateColors();
        html.setAttribute("data-theme-mode", "dark");
        html.setAttribute("data-menu-styles", "dark");
        html.setAttribute("data-header-styles", "dark");
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        document.querySelector("#switcher-dark-theme").checked = true;
        localStorage.setItem(
          "bodyBgRGB",
          `${color[0]}, ${color[1]}, ${color[2]}`
        );
        localStorage.setItem(
          "bodylightRGB",
          `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
        );
      });
    });
    themeContainerBackground.appendChild(button);
  }
  nanoButtons1[0].click();
  /* for theme background */

  /* header theme toggle */
  
  // function toggleTheme() {
  //   let html = document.querySelector("html");
  //   if (html.getAttribute("data-theme-mode") === "dark") {
  //     html.setAttribute("data-theme-mode", "light");
  //     html.setAttribute("data-header-styles", "light");
  //     html.setAttribute("data-menu-styles", "dark");
  //     if (!localStorage.getItem("primaryRGB")) {
  //       html.setAttribute("style", "");
  //     }
  //     html.removeAttribute("data-bg-theme");
  //     document.querySelector("#switcher-light-theme").checked = true;
  //     document.querySelector("#switcher-menu-dark").checked = true;
  //     document.querySelector("html").style.removeProperty("--body-bg-rgb", localStorage.bodyBgRGB);
  //     checkOptions();
  //     html.style.removeProperty("--body-bg-rgb2");
  //     html.style.removeProperty("--light-rgb");
  //     html.style.removeProperty("--form-control-bg");
  //     html.style.removeProperty("--input-border");
  //     document.querySelector("#switcher-header-light").checked = true;
  //     document.querySelector("#switcher-background4").checked = false;
  //     document.querySelector("#switcher-background3").checked = false;
  //     document.querySelector("#switcher-background2").checked = false;
  //     document.querySelector("#switcher-background1").checked = false;
  //     document.querySelector("#switcher-background").checked = false;
  //     localStorage.removeItem("nilovadarktheme");
  //     localStorage.removeItem("nilovaMenu");
  //     localStorage.removeItem("nilovaHeader");
  //     localStorage.removeItem("bodylightRGB");
  //     localStorage.removeItem("bodyBgRGB");
  //     html.setAttribute("data-header-styles", "light");
  //   } else {
  //     html.setAttribute("data-theme-mode", "dark");
  //     html.setAttribute("data-header-styles", "dark");
  //     if (!localStorage.getItem("primaryRGB")) {
  //       html.setAttribute("style", "");
  //     }
  //     html.setAttribute("data-menu-styles", "dark");
  //     document.querySelector("#switcher-dark-theme").checked = true;
  //     document.querySelector("#switcher-menu-dark").checked = true;
  //     document.querySelector("#switcher-header-dark").checked = true;
  //     checkOptions();
  //     document.querySelector("#switcher-background4").checked = false;
  //     document.querySelector("#switcher-background3").checked = false;
  //     document.querySelector("#switcher-background2").checked = false;
  //     document.querySelector("#switcher-background1").checked = false;
  //     document.querySelector("#switcher-background").checked = false;
  //     localStorage.setItem("nilovadarktheme", "true");
  //     localStorage.setItem("nilovaMenu", "dark");
  //     localStorage.setItem("nilovaHeader", "dark");
  //     localStorage.removeItem("bodylightRGB");
  //     localStorage.removeItem("bodyBgRGB");
  //   }
  // }
  // let layoutSetting = document.querySelector(".layout-setting");
  // layoutSetting.addEventListener("click", toggleTheme);
  /* header theme toggle */

  /* Choices JS */
  document.addEventListener("DOMContentLoaded", function () {
    var genericExamples = document.querySelectorAll("[data-trigger]");
    for (let i = 0; i < genericExamples.length; ++i) {
      var element = genericExamples[i];
      new Choices(element, {
        allowHTML: true,
        placeholderValue: "Search",
        searchPlaceholderValue: "Search",
      });
    }
  });
  /* Choices JS */

  /* footer year */
  document.getElementById("year").innerHTML = new Date().getFullYear();
  /* footer year */

  /* node waves */
  Waves.attach(".btn-wave", ["waves-light"]);
  Waves.init();
  /* node waves */

  /* card with close button */
  let DIV_CARD = ".card";
  let cardRemoveBtn = document.querySelectorAll(
    '[data-bs-toggle="card-remove"]'
  );
  cardRemoveBtn.forEach((ele) => {
    ele.addEventListener("click", function (e) {
      e.preventDefault();
      let $this = this;
      let card = $this.closest(DIV_CARD);
      card.remove();
      return false;
    });
  });
  /* card with close button */

  /* card with fullscreen */
  let cardFullscreenBtn = document.querySelectorAll(
    '[data-bs-toggle="card-fullscreen"]'
  );
  cardFullscreenBtn.forEach((ele) => {
    ele.addEventListener("click", function (e) {
      let $this = this;
      let card = $this.closest(DIV_CARD);
      card.classList.toggle("card-fullscreen");
      card.classList.remove("card-collapsed");
      e.preventDefault();
      return false;
    });
  });
  /* card with fullscreen */

  /* count-up */
  var i = 1;
  setInterval(() => {
    document.querySelectorAll(".count-up").forEach((ele) => {
      if (ele.getAttribute("data-count") >= i) {
        i = i + 1;
        ele.innerText = i;
      }
    });
  }, 10);
  /* count-up */

  /* Progressbar Top */
  window.addEventListener('scroll', () => {
    var widnowScroll = document.body.scrollTop || document.documentElement.scrollTop,
      height = document.documentElement.scrollHeight - document.documentElement.clientHeight,
      scrollAmount = (widnowScroll / height) * 100;
    document.querySelector(".progress-top-bar").style.width = scrollAmount + "%";
  })
  /* Progressbar Top */

})();

/* full screen */
var elem = document.documentElement;
function openFullscreen() {
  let open = document.querySelector(".full-screen-open");
  let close = document.querySelector(".full-screen-close");

  if (
    !document.fullscreenElement &&
    !document.webkitFullscreenElement &&
    !document.msFullscreenElement
  ) {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) {
      /* Safari */
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      /* IE11 */
      elem.msRequestFullscreen();
    }
    close.classList.add("d-block");
    close.classList.remove("d-none");
    open.classList.add("d-none");
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      /* Safari */
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      /* IE11 */
      document.msExitFullscreen();
    }
    close.classList.remove("d-block");
    open.classList.remove("d-none");
    close.classList.add("d-none");
    open.classList.add("d-block");
  }
}
/* full screen */

/* toggle switches */
let customSwitch = document.querySelectorAll(".toggle");
customSwitch.forEach((e) =>
  e.addEventListener("click", () => {
    e.classList.toggle("on");
  })
);
/* toggle switches */


/* back to top */
const scrollToTop = document.querySelector(".scrollToTop");
const $rootElement = document.documentElement;
const $body = document.body;
window.onscroll = () => {
  const scrollTop = window.scrollY || window.pageYOffset;
  const clientHt = $rootElement.scrollHeight - $rootElement.clientHeight;
  if (window.scrollY > 100) {
    scrollToTop.style.display = "flex";
  } else {
    scrollToTop.style.display = "none";
  }
};
scrollToTop.onclick = () => {
  window.scrollTo(0, 0);
};
/* back to top */



/* Search Keyboard Code */

const SEARCH_ITEMS = [
  { icon: "ri-dashboard-2-line", label: "Anasayfa", desc: "Genel bakış ve istatistikler", category: "Genel", url: "index" },
  { icon: "ri-shopping-cart-line", label: "Siparişler", desc: "Sipariş yönetimi ve kargo takipleri", category: "Yönetim", url: "siparisler" },
  { icon: "ri-user-shared-line", label: "Müşteriler", desc: "Müşteri listesi ve detay profilleri", category: "Yönetim", url: "musteriler" },
  { icon: "ri-box-3-line", label: "Ürünler", desc: "Ürün kataloğu, fiyat ve stok yönetimi", category: "Yönetim", url: "urunler" },
  { icon: "ri-percent-line", label: "Kampanyalar", desc: "İndirim ve promosyon yönetimi", category: "Yönetim", url: "kampanyalar" },
  { icon: "ri-file-list-3-line", label: "Kategoriler", desc: "Ürün kategorilerinizi yönetimi", category: "İçerik", url: "kategoriler" },
  { icon: "ri-camera-lens-line", label: "Canlı İzleme", desc: "Kameralı yüz tanıma ve hızlı satış paneli", category: "Modüller", url: "canli-izleme" },
  { icon: "ri-pie-chart-line", label: "Raporlar", desc: "Gelişmiş raporlar istatisliklerini inceleyin", category: "Raporlar", url: "raporlar" },
  { icon: "ri-settings-3-line", label: "Sistem Ayarları", desc: "SMS, logo, favicon ve modül ayarları", category: "Ayarlar", url: "ayarlar" }
];

let activeIndex = 0;
let filteredItems = [];

/* Open Modal */
function openSearchModal() {
  const overlay = document.getElementById("searchOverlay");
  const input = document.getElementById("searchInput");

  if (!overlay || !input) return;

  overlay.classList.add("show");
  document.body.style.overflow = "hidden";

  setTimeout(() => {
      input.value = "";
      input.focus();
      renderResults("");
  }, 50);
}

/* Close Modal */
function closeSearchModal() {
  const overlay = document.getElementById("searchOverlay");

  if (!overlay) return;

  overlay.classList.remove("show");
  document.body.style.overflow = "";
  activeIndex = 0;
}

/* Required because your HTML uses onclick="handleOverlayClick(event)" */
function handleOverlayClick(event) {
  if (event.target.id === "searchOverlay") {
      closeSearchModal();
  }
}

/* Search Button Click */
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".responsive-search").forEach((btn) => {
      btn.addEventListener("click", function (e) {
          e.preventDefault();
          openSearchModal();
      });
  });
});

/* Keyboard Shortcut */
document.addEventListener("keydown", function (e) {
  const isMac = /Mac|iPhone|iPad|iPod/i.test(navigator.platform);

  const isSearchShortcut = isMac
      ? e.metaKey && e.key.toLowerCase() === "k"
      : e.ctrlKey && e.key.toLowerCase() === "k";

  if (isSearchShortcut) {
      e.preventDefault();

      const overlay = document.getElementById("searchOverlay");

      if (overlay && overlay.classList.contains("show")) {
          closeSearchModal();
      } else {
          openSearchModal();
      }
  }

  if (e.key === "Escape") {
      closeSearchModal();
  }
});

/* Input Search */
function onSearchInput(query) {
  activeIndex = 0;
  renderResults(query);
}

/* Keyboard Navigation */
function onSearchKey(e) {
  if (!filteredItems.length) return;

  if (e.key === "ArrowDown") {
      e.preventDefault();
      activeIndex = Math.min(activeIndex + 1, filteredItems.length - 1);
      renderResults(document.getElementById("searchInput").value);
      scrollActiveIntoView();
  }

  if (e.key === "ArrowUp") {
      e.preventDefault();
      activeIndex = Math.max(activeIndex - 1, 0);
      renderResults(document.getElementById("searchInput").value);
      scrollActiveIntoView();
  }

  if (e.key === "Enter") {
      e.preventDefault();

      const item = filteredItems[activeIndex];

      if (item && item.url) {
          window.location.href = item.url;
      }
  }

  if (e.key === "Escape") {
      closeSearchModal();
  }
}

/* Scroll Active Result */
function scrollActiveIntoView() {
  const el = document.querySelector(".sm-item.active");

  if (el) {
      el.scrollIntoView({ block: "nearest" });
  }
}

/* Render Results */
function renderResults(query) {
  const q = query.trim().toLowerCase();
  const container = document.getElementById("searchResults");
  const countEl = document.getElementById("resultCount");

  if (!container || !countEl) return;

  filteredItems = q
      ? SEARCH_ITEMS.filter((item) =>
          item.label.toLowerCase().includes(q) ||
          item.desc.toLowerCase().includes(q) ||
          item.category.toLowerCase().includes(q)
      )
      : [...SEARCH_ITEMS];

  if (!filteredItems.length) {
      countEl.textContent = "";
      container.innerHTML = `
          <div class="sm-empty">
              <i class="ri-search-line"></i>
              No results for "<strong>${escapeHtml(query)}</strong>"
          </div>
      `;
      return;
  }

  countEl.textContent = filteredItems.length + " result" + (filteredItems.length !== 1 ? "s" : "");

  const groups = {};

  filteredItems.forEach((item) => {
      if (!groups[item.category]) {
          groups[item.category] = [];
      }

      groups[item.category].push(item);
  });

  let html = "";

  Object.entries(groups).forEach(([category, items]) => {
      html += `<div class="sm-category">${escapeHtml(category)}</div>`;

      items.forEach((item) => {
          const idx = filteredItems.indexOf(item);
          const isActive = idx === activeIndex;

          html += `
              <a class="sm-item ${isActive ? "active" : ""}"
                 href="${escapeHtml(item.url)}"
                 role="option"
                 aria-selected="${isActive}"
                 onmouseenter="setActive(${idx})">
                  <div class="sm-icon">
                      <i class="ri ${escapeHtml(item.icon)}"></i>
                  </div>
                  <div>
                      <div class="sm-label">${highlight(escapeHtml(item.label), query)}</div>
                      <div class="sm-desc">${highlight(escapeHtml(item.desc), query)}</div>
                  </div>
                  <i class="ri ri-arrow-right-line sm-arrow"></i>
              </a>
          `;
      });
  });

  container.innerHTML = html;
}

/* Mouse Active */
function setActive(idx) {
  activeIndex = idx;

  document.querySelectorAll(".sm-item").forEach((item, index) => {
      item.classList.toggle("active", index === idx);
  });
}

/* Highlight Keyword */
function highlight(text, query) {
  if (!query) return text;

  const safe = query.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");

  return text.replace(new RegExp(`(${safe})`, "gi"), "<mark>$1</mark>");
}

/* Escape HTML */
function escapeHtml(str) {
  return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#39;");
}

/* Search Keyboard Code */

const AVATAR_COLORS = [
  { bg: '#eef2ff', text: '#4f46e5' },
  { bg: '#fdf2f8', text: '#be185d' },
  { bg: '#ecfdf5', text: '#059669' },
  { bg: '#fff7ed', text: '#c2410c' },
  { bg: '#eff6ff', text: '#1d4ed8' },
  { bg: '#faf5ff', text: '#7c3aed' },
  { bg: '#fff1f2', text: '#be123c' },
  { bg: '#f0fdfa', text: '#0f766e' },
];

function colorFor(name) {
  return AVATAR_COLORS[name.charCodeAt(0) % AVATAR_COLORS.length];
}
function initials(name) {
  return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
}

// Sayfa yüklendiğinde veritabanından bildirimleri çeken ana fonksiyon
function loadNotifications() {
    fetch('request/notifications', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ postType: 'getBildirimler',csrf_token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderNotifications(data.bildirimler, data.okunmamis);
        }
    })
    .catch(err => console.error('Bildirimler yüklenirken hata oluştu:', err));
}

// Baş harfleri üretmek için yardımcı fonksiyon
function initials(name) {
    if (!name) return 'CRM';
    return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
}

// İsimden dinamik renk üretici
function colorFor(name) {
    let hash = 0;
    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }
    let color = Math.abs(hash).toString(16).substring(0, 6);
    while (color.length < 6) { color += '0'; }
    return { bg: '#' + color, text: '#ffffff' };
}

function buildAvatar(n) {
    let name = n.baslik || 'Sistem';
    const c = colorFor(name);
    // Eğer özel bir avatar/resim varsa göster, yoksa harf bazlı şık rozet bas
    if (n.avatar) {
        return `<div class="notify-avatar">
            <img class="avatar avtar-sm avatar-rounded" src="${n.avatar}" alt="${name}" onerror="this.parentElement.innerHTML='<span style=color:${c.text};font-size:13px;font-weight:600;>${initials(name)}</span>';this.parentElement.style.background='${c.bg}';" />
        </div>`;
    }
    return `<div class="notify-avatar avatar avtar-sm avatar-rounded d-flex align-items-center justify-content-center" style="background:${c.bg}; color:${c.text}; width:35px; height:35px; font-weight:600; font-size:12px;">${initials(name)}</div>`;
}

function buildItem(n) {
    let isRead = Number(n.okundu) === 1;
    return `
        <li class="notify-item ${isRead ? '' : 'unread'}" onclick="markRead(${n.id}, '${n.link || 'javascript:void(0);'}')">
            ${buildAvatar(n)}
            <div class="notify-body flex-fill ms-2">
                <div class="notify-text"><strong>${n.baslik}</strong>: ${n.mesaj}</div>
                <div class="notify-time text-muted fs-11 mt-1">${n.tarih}</div>
            </div>
            ${!isRead ? '<div class="unread-dot"></div>' : '<div class="dot-spacer"></div>'}
        </li>`;
}

const emptyHTML = `
    <div class="notify-empty text-center p-4 text-muted">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-ring-icon lucide-bell-ring mb-2"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M22 8c0-2.3-.8-4.3-2-6"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/><path d="M4 2C2.8 3.7 2 5.7 2 8"/></svg>
        <p class="mb-0 fs-13">Bildirim bulunmuyor</p>
    </div>`;

function renderNotifications(notificationsArray, unreadCount) {
    const all = notificationsArray;
    const unread = notificationsArray.filter(n => Number(n.okundu) === 0);

    // Tümünü listele
    const listAllElem = document.getElementById('list-all');
    if (listAllElem) {
        listAllElem.innerHTML = all.length ? all.map(buildItem).join('') : emptyHTML;
    }

    // Okunmamışları listele
    const listUnreadElem = document.getElementById('list-unread');
    if (listUnreadElem) {
        listUnreadElem.innerHTML = unread.length ? unread.map(buildItem).join('') : emptyHTML;
    }

    // Badge sayacını güncelle
    const badgeElem = document.getElementById('unread-badge');
    if (badgeElem) {
        badgeElem.textContent = unreadCount > 9 ? '9+' : unreadCount;
    }
}

// Tek bir bildirimi okundu olarak işaretle
function markRead(id, link) {
    fetch('request/notifications', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ postType: 'okunduIsaretle', id: id,csrf_token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications(); // Listeyi ve sayaçları yenile
            if (link && link !== 'javascript:void(0);') {
                window.location.href = link;
            }
        }
    })
    .catch(err => console.error('Hata:', err));
}

// Tüm bildirimleri okundu olarak işaretle
function markAllRead() {
    fetch('request/notifications', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ postType: 'okunduIsaretle',csrf_token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }) // ID göndermezsek tümünü okundu yapar
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
        }
    })
    .catch(err => console.error('Hata:', err));
}

// Sayfa yüklendiğinde ve her 60 saniyede bir otomatik arka plan kontrolü
document.addEventListener('DOMContentLoaded', function () {
    loadNotifications();
    setInterval(loadNotifications, 60000); // 1 dakikada bir yeni bildirimleri kontrol et
});

const LIVE_AVATARS = [
  'assets/images/faces/12.jpg',
  'assets/images/faces/5.jpg',
  null,
  'assets/images/faces/8.jpg',
  'assets/images/faces/7.jpg',
  null,
  'assets/images/faces/3.jpg',
  'assets/images/faces/8.jpg',
  null,
  'assets/images/faces/2.jpg',
  'assets/images/faces/3.jpg',
  null,
];

function addLiveNotification() {
  const name   = LIVE_NAMES[nameIdx % LIVE_NAMES.length];
  const action = LIVE_ACTIONS[Math.floor(Math.random() * LIVE_ACTIONS.length)];
  const avatar = LIVE_AVATARS[nameIdx % LIVE_AVATARS.length];
  nameIdx++;
  const notif = { id: nextId++, name, action, time: 'just now', read: false, fresh: true, avatar };
  notifications.unshift(notif);

  // Append new item to the top of #list-all
  const listAll = document.getElementById('list-all');
  const tempAll = document.createElement('div');
  tempAll.innerHTML = buildItem(notif);
  const newItemAll = tempAll.firstElementChild;
  listAll.prepend(newItemAll);

  // Append new item to the top of #list-unread
  const listUnread = document.getElementById('list-unread');

  // Remove empty state if present
  const empty = listUnread.querySelector('.notify-empty');
  
  if (empty) {
    empty.remove();
  }

  const tempUnread = document.createElement('li');
  tempUnread.innerHTML = buildItem(notif);
  const newItemUnread = tempUnread.firstElementChild;
  listUnread.prepend(newItemUnread);

  // Remove animation class after it plays
  setTimeout(() => {
    newItemAll.classList.remove('fresh');
    newItemUnread.classList.remove('fresh');
    notif.fresh = false;
  }, 500);

  // Trim excess items from DOM if over limit
  if (notifications.length > 10) {
    notifications.pop();
    const allItems = listAll.querySelectorAll('.notify-item');
    if (allItems.length > 10) allItems[allItems.length - 1].remove();
    const unreadItems = listUnread.querySelectorAll('.notify-item');
    if (unreadItems.length > 10) unreadItems[unreadItems.length - 1].remove();
  }

  // Update unread badge count
  const uc = notifications.filter(n => !n.read).length;
  document.getElementById('unread-badge').textContent = uc > 9 ? '9+' : uc;
}

render();
setInterval(addLiveNotification, 5000);