"use strict";

/* tooltip */
const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

/* popover  */
const popoverTriggerList = document.querySelectorAll(
  '[data-bs-toggle="popover"]'
);
const popoverList = [...popoverTriggerList].map(
  (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
);

/* Choices JS */
document.addEventListener("DOMContentLoaded", function () {
  var genericExamples = document.querySelectorAll("[data-trigger]");
  for (let i = 0; i < genericExamples.length; ++i) {
    var element = genericExamples[i];
    new Choices(element, {
      allowHTML: true,
      placeholderValue: "This is a placeholder set in the config",
      searchPlaceholderValue: "Search",
    });
  }
});
/* Choices JS */

/*------swipter-js-----*/

//switcher color pickers
const pickrContainerPrimary = document.querySelector(
  ".pickr-container-primary"
);
const themeContainerPrimary = document.querySelector(
  ".theme-container-primary"
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
          default: "rgb(103, 93, 176)",
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
      updateColors();
    });
  });

  themeContainerPrimary.appendChild(button);
}
nanoButtons[0].click();
/* for theme primary */

let mainContent;
(function () {
  let html = document.querySelector("html");
  mainContent = document.querySelector(".main-content");

  localStorageBackup();
  switcherClick();
  checkOptions();
  /* LTR to RTL */
  // html.setAttribute("dir" , "rtl") // for rtl version
})();

function switcherClick() {
  let ltrBtn,
    rtlBtn,
    theme1Btn, theme2Btn, theme3Btn, theme4Btn, theme5Btn, theme6Btn, theme7Btn, theme8Btn, theme9Btn, theme10Btn, theme11Btn, theme12Btn, theme13Btn, theme14Btn,
    lightBtn,
    darkBtn,
    primaryDefaultColor1Btn,
    primaryDefaultColor2Btn,
    primaryDefaultColor3Btn,
    primaryDefaultColor4Btn,
    primaryDefaultColor5Btn,
    ResetAll;
  let html = document.querySelector("html");
  theme1Btn = document.querySelector('#switcher-default-theme');
  theme2Btn = document.querySelector('#switcher-fusion-theme');
  theme3Btn = document.querySelector('#switcher-modern-theme');
  theme4Btn = document.querySelector('#switcher-saas-theme');
  theme5Btn = document.querySelector('#switcher-neon-theme');
  theme6Btn = document.querySelector('#switcher-galaxy-theme');
  theme7Btn = document.querySelector('#switcher-elegant-theme');
  theme8Btn = document.querySelector('#switcher-flat-theme');
  theme9Btn = document.querySelector('#switcher-prism-theme');
  theme10Btn = document.querySelector('#switcher-retro-theme');
  theme11Btn = document.querySelector('#switcher-frost-theme');
  theme12Btn = document.querySelector('#switcher-nova-theme');
  theme13Btn = document.querySelector('#switcher-nexus-theme');
  theme14Btn = document.querySelector('#switcher-slate-theme');
  lightBtn = document.querySelector("#switcher-light-theme");
  darkBtn = document.querySelector("#switcher-dark-theme");
  ltrBtn = document.querySelector("#switcher-ltr");
  rtlBtn = document.querySelector("#switcher-rtl");
  primaryDefaultColor1Btn = document.querySelector("#switcher-primary");
  primaryDefaultColor2Btn = document.querySelector("#switcher-primary1");
  primaryDefaultColor3Btn = document.querySelector("#switcher-primary2");
  primaryDefaultColor4Btn = document.querySelector("#switcher-primary3");
  primaryDefaultColor5Btn = document.querySelector("#switcher-primary4");
  ResetAll = document.querySelector("#reset-all");


function themeTemplateSwitcher() {
  const html = document.documentElement;

  // first load only
  if (!localStorage.getItem("nilovaThemeTemplate")) {
      localStorage.setItem(
          "nilovaThemeTemplate",
          html.getAttribute("data-theme-template") || "default"
      );
  }
  const themes = {
      default: { btn: theme1Btn, menu: "dark", header: "light", mode: "light",  },
      fusion: { btn: theme2Btn, menu: "light", header: "transparent", mode: "light",  },
      modern: { btn: theme3Btn, menu: "light", header: "gradient", mode: "light",  },
      saas: { btn: theme4Btn, menu: "dark", header: "transparent", mode: "light",  },
      neon: { btn: theme5Btn, menu: "dark", header: "transparent", mode: "light", },
      galaxy: { btn: theme6Btn, menu: "dark", header: "dark", mode: "dark",  },
      elegant: { btn: theme7Btn, menu: "dark", header: "transparent", mode: "light",  },
      flat: { btn: theme8Btn, menu: "light", header: "light", mode: "light" },
      prism: { btn: theme9Btn, menu: "transparent", header: "transparent", mode: "light",  },
      retro: { btn: theme10Btn, menu: "dark", header: "transparent", mode: "light",},
      frost: { btn: theme11Btn, menu: "gradient", header: "transparent", mode: "light",  },
      nova: { btn: theme12Btn, menu: "dark", header: "light", mode: "light",  },
      nexus: { btn: theme13Btn, menu: "dark", header: "light", mode: "light",  },
      slate: { btn: theme14Btn, menu: "transparent", header: "transparent", mode: "light",  }
  };

  const safeCheck = (selector, checked = true) => {
      const el = document.querySelector(selector);
      if (el) el.checked = checked;
  };

  const getThemeStyles = (themeName, mode) => {

      if (mode === "dark") {

          if (themeName === "fusion") {
              return { header: "transparent", menu: "dark" };
          }

          if (themeName === "modern") {
              return { header: "gradient", menu: "dark" };
          }

          if (themeName === "flat") {
              return { header: "dark", menu: "dark" };
          }

          if (themeName === "prism") {
              return { header: "transparent", menu: "transparent" };
          }

          if (themeName === "slate") {
              return { header: "transparent", menu: "transparent" };
          }

          if (themeName === "frost") {
              return { header: "transparent", menu: "gradient" };
          }

          if (
              themeName === "saas" ||
              themeName === "neon" ||
              themeName === "elegant" ||
              themeName === "nexus" ||
              themeName === "retro"
          ) {
              return { header: "transparent", menu: "dark" };
          }

          return { header: "dark", menu: "dark" };
      }

      // LIGHT MODE

      if (themeName === "fusion") {
          return { header: "transparent", menu: "light" };
      }

      if (themeName === "modern") {
          return { header: "gradient", menu: "light" };
      }

      if (themeName === "flat") {
          return { header: "light", menu: "light" };
      }

      if (themeName === "prism") {
          return { header: "transparent", menu: "transparent" };
      }

      if (themeName === "slate") {
          return { header: "transparent", menu: "transparent" };
      }

      if (themeName === "frost") {
          return { header: "transparent", menu: "gradient" };
      }

      if (
          themeName === "saas" ||
          themeName === "neon" ||
          themeName === "elegant" ||
          themeName === "nexus" ||
          themeName === "retro"
      ) {
          return { header: "transparent", menu: "dark" };
      }

      if (themeName === "galaxy") {
          return { header: "light", menu: "dark" };
      }

      return { header: "light", menu: "dark" };
  };

  const applyHeaderMenu = (themeName, useStored = false) => {

      const mode = html.getAttribute("data-theme-mode") || "light";

      let styles = getThemeStyles(themeName, mode);

      if (useStored) {
          styles.header = localStorage.getItem("nilovaHeader") || styles.header;
          styles.menu = localStorage.getItem("nilovaMenu") || styles.menu;
      }

      html.setAttribute("data-header-styles", styles.header);
      html.setAttribute("data-menu-styles", styles.menu);

      safeCheck(`#switcher-header-${styles.header}`);
      safeCheck(`#switcher-menu-${styles.menu === "color" ? "primary" : styles.menu}`);
  };

  const updateSwitcherChecks = () => {

      const theme =
          localStorage.getItem("nilovaThemeTemplate") ||
          html.getAttribute("data-theme-template") ||
          "default";

      const mode = html.getAttribute("data-theme-mode");

      safeCheck(`#switcher-${theme}-theme`);
      safeCheck(mode === "dark"
          ? "#switcher-dark-theme"
          : "#switcher-light-theme");

      applyHeaderMenu(theme, true);

      if (typeof checkOptions === "function") {

          checkOptions();

      }

      safeCheck("#switcher-vertical");

      const uncheckHorizontalMenuStyles = () => {
          [
              "#switcher-menu-click",
              "#switcher-menu-hover",
              "#switcher-icon-click",
              "#switcher-icon-hover"
          ].forEach((selector) => {
              const el = document.querySelector(selector);
              if (el) el.checked = false;
          });
      };
      uncheckHorizontalMenuStyles();
      const currentLayout = localStorage.getItem("nilovalayout");

      if (currentLayout === "horizontal") {
          safeCheck("#switcher-horizontal");
      }
  };

  const applyTheme = (themeName, fromUrl = false) => {

      const theme = themes[themeName];

      if (!theme) return;

      html.setAttribute("data-theme-template", themeName);
      

      if (!fromUrl) {
          localStorage.setItem("nilovaThemeTemplate", themeName);
      }

      const isDark =
      localStorage.getItem("nilovaUserMode") === "dark" ||
      localStorage.getItem("nilovadarktheme") === "true";
      
      html.setAttribute("data-theme-mode", isDark ? "dark" : "light");
      
      if (isDark) {
          localStorage.setItem("nilovadarktheme", "true");
          safeCheck("#switcher-dark-theme");
      } else {
          localStorage.removeItem("nilovadarktheme");
          safeCheck("#switcher-light-theme");
      }

      // SAVE THEME DEFAULTS ONLY WHEN MANUAL THEME CLICK

      if (!fromUrl) {

          const styles = getThemeStyles(
              themeName,
              html.getAttribute("data-theme-mode")
          );

          localStorage.setItem("nilovaHeader", styles.header);
          localStorage.setItem("nilovaMenu", styles.menu);
          
          if (themeName === "default") {
              html.removeAttribute("data-theme-template");
              localStorage.removeItem("nilovaThemeTemplate");
              window.history.replaceState({}, "", window.location.pathname);
          } else {
              localStorage.setItem("nilovaThemeTemplate", themeName);
              window.history.replaceState({}, "", `${window.location.pathname}?${themeName}`);
          }
      }

      applyHeaderMenu(themeName, true);

      updateSwitcherChecks();

      setTimeout(() => {
          applyHeaderMenu(themeName, true);
      }, 300);

      if (!fromUrl) {

          if (themeName === "default") {
              window.history.replaceState({}, "", window.location.pathname);
          } else {
              window.history.replaceState(
                  {},
                  "",
                  `${window.location.pathname}?${themeName}`
              );
          }
      }
  };

  const getUrlTheme = () => {

      const queryTheme =
          window.location.search.replace("?", "").split("&")[0];

      return themes[queryTheme] ? queryTheme : null;
  };

  Object.keys(themes).forEach((themeName) => {

      const btn = themes[themeName].btn;

      if (btn) {
          btn.addEventListener("click", () => {
              applyTheme(themeName, false);
          });
      }
  });

  const urlTheme = getUrlTheme();

  if (urlTheme) {

      applyTheme(urlTheme, true);

  }  else {
      const savedTheme = localStorage.getItem("nilovaThemeTemplate");
  
      if (savedTheme && savedTheme !== "default" && themes[savedTheme]) {
          html.setAttribute("data-theme-template", savedTheme);
  
          applyHeaderMenu(savedTheme, true);
          updateSwitcherChecks();
      } else {
          html.removeAttribute("data-theme-template");
  
          localStorage.removeItem("nilovaThemeTemplate");
          localStorage.removeItem("nilovaHeader");
          localStorage.removeItem("nilovaMenu");
      }
  

      window.history.replaceState({}, "", window.location.pathname);
  }

}

themeTemplateSwitcher();


  /* Light Layout Start */
  let lightThemeVar = lightBtn.addEventListener("click", () => {
    lightFn();
    localStorage.setItem("nilovaHeader", "light");
    localStorage.setItem("nilovaMenu", "light");
  });
  /* Light Layout End */

  /* Dark Layout Start */
  let darkThemeVar = darkBtn.addEventListener("click", () => {
    darkFn();
    localStorage.setItem("nilovaMenu", "dark");
    localStorage.setItem("nilovaHeader", "dark");
  });
  /* Dark Layout End */

  // primary theme
  let primaryColor1Var = primaryDefaultColor1Btn.addEventListener(
    "click",
    () => {
      localStorage.setItem("primaryRGB", "75, 82, 186");
      html.style.setProperty("--primary-rgb", `75, 82, 186`);
      updateColors();
    }
  );
  if (localStorage.primaryRGB == "75, 82, 186") {
    document.querySelector('#switcher-primary').checked = true;
  }
  let primaryColor2Var = primaryDefaultColor2Btn.addEventListener(
    "click",
    () => {
      localStorage.setItem("primaryRGB", "148, 59, 163");
      html.style.setProperty("--primary-rgb", `148, 59, 163`);
      updateColors();
    }
  );
  if (localStorage.primaryRGB == "148, 59, 163") {
    document.querySelector('#switcher-primary1').checked = true;
  }
  let primaryColor3Var = primaryDefaultColor3Btn.addEventListener(
    "click",
    () => {
      localStorage.setItem("primaryRGB", "53, 113, 125");
      html.style.setProperty("--primary-rgb", `53, 113, 125`);
      updateColors();
    }
  );
  if (localStorage.primaryRGB == "53, 113, 125") {
    document.querySelector('#switcher-primary2').checked = true;
  }
  let primaryColor4Var = primaryDefaultColor4Btn.addEventListener(
    "click",
    () => {
      localStorage.setItem("primaryRGB", "158, 120, 59");
      html.style.setProperty("--primary-rgb", `158, 120, 59`);
      updateColors();
    }
  );
  if (localStorage.primaryRGB == "158, 120, 59") {
    document.querySelector('#switcher-primary3').checked = true;
  }
  let primaryColor5Var = primaryDefaultColor5Btn.addEventListener(
    "click",
    () => {
      localStorage.setItem("primaryRGB", "114, 128, 38");
      html.style.setProperty("--primary-rgb", `114, 128, 38`);
      updateColors();
    }
  );
  if (localStorage.primaryRGB == "114, 128, 38") {
    document.querySelector('#switcher-primary4').checked = true;
  }

  /* rtl start */
  let rtlVar = rtlBtn.addEventListener("click", () => {
    localStorage.setItem("nilovartl", true);
    localStorage.removeItem("nilovaltr");
    rtlFn();
  });
  /* rtl end */

  /* ltr start */
  let ltrVar = ltrBtn.addEventListener("click", () => {
    //    local storage
    localStorage.setItem("nilovaltr", true);
    localStorage.removeItem("nilovartl");
    ltrFn();
  });
  /* ltr end */

  function ResetThemeTemplateOnly() {
    const html = document.documentElement;

    localStorage.removeItem("nilovadarktheme");
    localStorage.removeItem("nilovaDarkFromTheme");
    localStorage.removeItem("bodyBgRGB");
    localStorage.removeItem("bodylightRGB");

    localStorage.setItem("nilovaThemeTemplate", "default");
    localStorage.setItem("nilovaHeader", "light");
    localStorage.setItem("nilovaMenu", "dark");

    html.setAttribute("data-theme-template", "default");
    html.setAttribute("data-theme-mode", "light");
    html.setAttribute("data-header-styles", "light");
    html.setAttribute("data-menu-styles", "dark");

    html.removeAttribute("data-bg-theme");

    html.style.removeProperty("--body-bg-rgb");
    html.style.removeProperty("--body-bg-rgb2");
    html.style.removeProperty("--light-rgb");
    html.style.removeProperty("--form-control-bg");
    html.style.removeProperty("--input-border");
    html.style.removeProperty("--gray-3");

    document.querySelector("#switcher-default-theme").checked = true;
    document.querySelector("#switcher-light-theme").checked = true;

    window.history.replaceState({}, "", window.location.pathname);
}

  // reset all start
  let resetVar = ResetAll.addEventListener("click", () => {
    // clear primary & bg color
    html.style.removeProperty(`--primary-rgb`);

    ResetThemeTemplateOnly();

    setTimeout(() => {
        ResetThemeTemplateOnly();
    }, 100);

    // clear rtl
    html.removeAttribute("dir", "rtl");
    html.setAttribute("dir", "ltr");
    html.setAttribute("data-theme-template", "default");

     // reset theme template radio button
     document.querySelector('#switcher-default-theme').checked = true;

    // update URL also like: /dashboard-crm.html?default
    const newUrl = `${window.location.pathname}`;
    window.history.replaceState({}, '', newUrl);

    ResetAllFn();
  });
  // reset all start
}

function ltrFn() {
  let html = document.querySelector("html");
  document
    .querySelector("#style")
    ?.setAttribute("href", "../assets/libs/bootstrap/css/bootstrap.min.css");
  html.setAttribute("dir", "ltr");
  document.querySelector("#switcher-ltr").checked = true;
  checkOptions();
}

function rtlFn() {
  let html = document.querySelector("html");
  html.setAttribute("dir", "rtl");
  document
    .querySelector("#style")
    ?.setAttribute(
      "href",
      "../assets/libs/bootstrap/css/bootstrap.rtl.min.css"
    );
  checkOptions();
}

if (localStorage.nilovartl) {
  rtlFn();
}

function lightFn() {
  const html = document.documentElement;

  html.setAttribute("data-theme-mode", "light");

  localStorage.setItem("nilovaUserMode", "light");   // <-- important
  localStorage.removeItem("nilovadarktheme");

  updateColors();
  checkOptions();
}

function darkFn() {
  let html = document.documentElement;

  html.setAttribute("data-theme-mode", "dark");

  localStorage.setItem("nilovaUserMode", "dark");
  localStorage.setItem("nilovadarktheme", "true");
  localStorage.removeItem("nilovalighttheme");

  document.querySelector("#switcher-dark-theme").checked = true;

  updateColors();
  checkOptions();
}

function ResetAllFn() {
  let html = document.querySelector("html");
  checkOptions();

  // clearing localstorage
  localStorage.clear();

  // reseting chart colors
  updateColors();

  // reseting rtl
  ltrFn();

  // reseting dark theme
  lightFn();

  // resetting theme primary
  document.querySelector("#switcher-primary").checked = false
  document.querySelector("#switcher-primary1").checked = false
  document.querySelector("#switcher-primary2").checked = false
  document.querySelector("#switcher-primary3").checked = false
  document.querySelector("#switcher-primary4").checked = false
}

function checkOptions() {
  // dark
  if (localStorage.getItem("nilovadarktheme")) {
    document.querySelector("#switcher-dark-theme").checked = true;
  }

  //RTL
  if (localStorage.getItem("nilovartl")) {
    document.querySelector("#switcher-rtl").checked = true;
  }
}

// chart colors
let myVarVal, primaryRGB;
function updateColors() {
  "use strict";
  primaryRGB = getComputedStyle(document.documentElement)
    .getPropertyValue("--primary-rgb")
    .trim();
}
updateColors();

function localStorageBackup() {
  if (localStorage.primaryRGB) {
    if (document.querySelector(".theme-container-primary")) {
      document.querySelector(".theme-container-primary").value =
        localStorage.primaryRGB;
    }
    document
      .querySelector("html")
      .style.setProperty("--primary-rgb", localStorage.primaryRGB);
  }
  if (localStorage.nilovadarktheme) {
    let html = document.querySelector("html");
    html.setAttribute("data-theme-mode", "dark");
  }

  if (localStorage.nilovartl) {
    let html = document.querySelector("html");
    html.setAttribute("dir", "rtl");
  }
  if (localStorage.nilovalayout) {
    let html = document.querySelector("html");
    let layoutValue = localStorage.getItem("nilovalayout");
    html.setAttribute("data-nav-layout", "horizontal");
  }
}
/*------swipter-js-----*/

/* footer year */
document.getElementById("year").innerHTML = new Date().getFullYear();
/* footer year */


// section menu active
function onScroll() {
  const menuItems = document.querySelectorAll(".side-menu__item");

  const scrollPos =
      window.pageYOffset ||
      document.documentElement.scrollTop ||
      document.body.scrollTop;

  // Remove active from all menu items
  document.querySelectorAll(".side-menu__item.active").forEach(item => {
      item.classList.remove("active");
  });

  // Remove active from all parent menu toggles
  document.querySelectorAll(".has-sub.active").forEach(item => {
      item.classList.remove("active");
  });

  menuItems.forEach((elem) => {
      const href = elem.getAttribute("href");

      if (!href || href === "#" || href === "javascript:void(0);") return;

      const section = document.querySelector(href);
      if (!section) return;

      const scrollTopMinus = scrollPos + 73;

      if (
          section.offsetTop <= scrollTopMinus &&
          section.offsetTop + section.offsetHeight > scrollTopMinus
      ) {
          // Current item
          elem.classList.add("active");

          // Parent submenu
          const child = elem.closest(".child1");
          if (child) {
              const parentToggle = child.previousElementSibling;
              if (parentToggle) {
                  parentToggle.classList.add("active");
              }

              const grandParent = child.parentElement?.parentElement?.children[0];
              if (grandParent) {
                  grandParent.classList.add("active");
              }
          }
      }
  });
}

window.addEventListener("scroll", onScroll);
window.addEventListener("load", onScroll);
// for menu target scroll on click

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

/* Trusted Clients Swiper */
var swiper = new Swiper(".trusted-clients", {
  loop: true,
  slidesPerView: 6,
  spaceBetween: 30,
  autoplay: {
    delay: 1500,
    disableOnInteraction: false,
  },
  breakpoints: {
    320: {
        slidesPerView: 1,
        spaceBetween: 5,
    },
    640: {
        slidesPerView: 2,
        spaceBetween: 5,
    },
    768: {
        slidesPerView: 4,
        spaceBetween: 5,
    },
    1024: {
        slidesPerView: 6,
        spaceBetween: 20,
    }
},
});
/* Trusted Clients Swiper */

var swiper = new Swiper(".testimonialSwiperService", {
  centeredSlides: true,
  loop: true,
  spaceBetween: 30,

  autoplay: {
      enabled: false,
    delay: 3000,
    disableOnInteraction: false,
  },

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
   coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 100,
    modifier: 4,
    slideShadows: true
  },

  breakpoints: {
    768: {
      slidesPerView: 2,
    },
    992: {
      slidesPerView: 3,
    }
  }
});


const home_slider1 = new Swiper(".nft-banner-swiper", {
  slidesPerView: 5,
  spaceBetween: 0,
  loop: true,
  centeredSlides: true,
  autoplay: {
      delay: 2000,
  },
  breakpoints: {
      0: {
      slidesPerView: 3,
      spaceBetween: 2,
      },
      530: {
      slidesPerView: 3,
      spaceBetween: 0,
      },
      768: {
      slidesPerView: 3,
      spaceBetween: 0,
      },
      992: {
      slidesPerView: 3,
      spaceBetween: 0,
      },
      1000: {
      slidesPerView: 5,
      spaceBetween: 20,
      },
  },
  });

  var swiper = new Swiper(".nft-live-swiper", {
  grabCursor: true,
  spaceBetween: 40,
  loop: true,
  autoplay: {
      delay: 2000,
  },
  breakpoints: {
      576: {
      slidesPerView: 2,
      spaceBetween: 20,
      },
      768: {
      slidesPerView: 3,
      spaceBetween: 20,
      },
      992: {
      slidesPerView: 3,
      spaceBetween: 20,
      },
      1200: {
      slidesPerView: 4,
      spaceBetween: 20,
      },
      1560: {
      slidesPerView: 4,
      spaceBetween: 20,
      },
  },
  });


  new Swiper(".testimonialSwiperjobs",{

    loop:true,


    slidesPerView:"auto",

    spaceBetween:30,

    speed:1200,

    autoplay:{
        delay:2500,
        disableOnInteraction:false,
    },

    grabCursor:true,

    breakpoints:{

        320:{
            slidesPerView:1.15,
        },

        768:{
            slidesPerView:2,
        },

        1200:{
            slidesPerView:"3",
        },
        1500:{
            slidesPerView:"4",
        }

    }

});


