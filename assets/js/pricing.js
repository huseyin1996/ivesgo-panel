(function () {
    "use strict";

    var checkbox = document.querySelector(".switcher-pricing input[type='checkbox']");
    var yearly1 = document.getElementById("yearly1");
    var monthly1 = document.getElementById("monthly1");

    checkbox.addEventListener("change", function () {
        if (checkbox.checked) {
            // Show Yearly tab, hide Monthly tab
            yearly1.classList.add("show");
            monthly1.classList.remove("show");
        } else {
            // Show Monthly tab, hide Yearly tab
            monthly1.classList.add("show");
            yearly1.classList.remove("show");
        }
    });

})();