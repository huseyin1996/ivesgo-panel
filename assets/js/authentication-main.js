(function () {
    "use strict";

    const html = document.documentElement;

    /*----------------------------------------------------------
     Restore Theme Template
    ----------------------------------------------------------*/

    const themeTemplate =
        localStorage.getItem("nilovaThemeTemplate") || "default";

    if (themeTemplate !== "default") {
        html.setAttribute("data-theme-template", themeTemplate);
    } else {
        html.removeAttribute("data-theme-template");
    }

    /*----------------------------------------------------------
     Restore Theme Mode
    ----------------------------------------------------------*/

    if (localStorage.getItem("nilovadarktheme")) {
        html.setAttribute("data-theme-mode", "dark");
    } else {
        html.setAttribute("data-theme-mode", "light");
    }

    /*----------------------------------------------------------
     Restore Header Style
    ----------------------------------------------------------*/

    html.setAttribute(
        "data-header-styles",
        localStorage.getItem("nilovaHeader") || "light"
    );

    /*----------------------------------------------------------
     Restore Menu Style
    ----------------------------------------------------------*/

    html.setAttribute(
        "data-menu-styles",
        localStorage.getItem("nilovaMenu") || "dark"
    );

    /*----------------------------------------------------------
     Restore Layout
    ----------------------------------------------------------*/

    const layout = localStorage.getItem("nilovalayout");

    if (layout === "horizontal") {
        html.setAttribute("data-nav-layout", "horizontal");
    } else {
        html.setAttribute("data-nav-layout", "vertical");

        html.setAttribute(
            "data-vertical-style",
            localStorage.getItem("nilovaverticalstyles") || "default"
        );
    }

    /*----------------------------------------------------------
     Restore RTL
    ----------------------------------------------------------*/

    if (localStorage.getItem("nilovartl")) {
        html.setAttribute("dir", "rtl");

        document
            .querySelector("#style")
            ?.setAttribute(
                "href",
                "../assets/libs/bootstrap/css/bootstrap.rtl.min.css"
            );
    } else {
        html.setAttribute("dir", "ltr");

        document
            .querySelector("#style")
            ?.setAttribute(
                "href",
                "../assets/libs/bootstrap/css/bootstrap.min.css"
            );
    }

    /*----------------------------------------------------------
     Restore Background Colors
    ----------------------------------------------------------*/

    if (localStorage.bodyBgRGB && localStorage.bodylightRGB) {

        switch (localStorage.bodyBgRGB) {

            case "34, 28, 77":
                document.querySelector("#switcher-background") &&
                    (document.querySelector("#switcher-background").checked = true);
                break;

            case "73, 33, 98":
                document.querySelector("#switcher-background1") &&
                    (document.querySelector("#switcher-background1").checked = true);
                break;

            case "38, 72, 73":
                document.querySelector("#switcher-background2") &&
                    (document.querySelector("#switcher-background2").checked = true);
                break;

            case "73, 59, 21":
                document.querySelector("#switcher-background3") &&
                    (document.querySelector("#switcher-background3").checked = true);
                break;

            case "44, 54, 26":
                document.querySelector("#switcher-background4") &&
                    (document.querySelector("#switcher-background4").checked = true);
                break;
        }
    }

    /*----------------------------------------------------------
     Restore Primary Colors
    ----------------------------------------------------------*/

    if (localStorage.primaryRGB) {

        switch (localStorage.primaryRGB) {

            case "75, 82, 186":
                document.querySelector("#switcher-primary") &&
                    (document.querySelector("#switcher-primary").checked = true);
                break;

            case "148, 59, 163":
                document.querySelector("#switcher-primary1") &&
                    (document.querySelector("#switcher-primary1").checked = true);
                break;

            case "53, 113, 125":
                document.querySelector("#switcher-primary2") &&
                    (document.querySelector("#switcher-primary2").checked = true);
                break;

            case "158, 120, 59":
                document.querySelector("#switcher-primary3") &&
                    (document.querySelector("#switcher-primary3").checked = true);
                break;

            case "114, 128, 38":
                document.querySelector("#switcher-primary4") &&
                    (document.querySelector("#switcher-primary4").checked = true);
                break;
        }
    }

})();

function ltrFn() {

    const html = document.documentElement;

    html.setAttribute("dir", "ltr");

    document
        .querySelector("#style")
        ?.setAttribute(
            "href",
            "../assets/libs/bootstrap/css/bootstrap.min.css"
        );
}

function rtlFn() {

    const html = document.documentElement;

    html.setAttribute("dir", "rtl");

    document
        .querySelector("#style")
        ?.setAttribute(
            "href",
            "../assets/libs/bootstrap/css/bootstrap.rtl.min.css"
        );
}