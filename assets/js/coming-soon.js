
function updateTimer() {
    future = Date.parse("Dec 19, 2026 11:30:00");
    now = new Date();
    diff = future - now;

    days = Math.floor(diff / (1000 * 60 * 60 * 24));
    hours = Math.floor(diff / (1000 * 60 * 60));
    mins = Math.floor(diff / (1000 * 60));
    secs = Math.floor(diff / 1000);

    d = days;
    h = hours - days * 24;
    m = mins - hours * 60;
    s = secs - mins * 60;

    document.getElementById("timer")
        .innerHTML =
        '<div class="text-center auth-timer"><div class=""><h4 class="mb-0 fw-semibold">' + d + '</h4><p class="mb-1 fs-13 fw-medium op-7">Days</p></div></div>' +
        '<div class="text-center auth-timer"><div class=""><h4 class="mb-0 fw-semibold">' + h + '</h4><p class="mb-1 fs-13 fw-medium op-7">Hours</p></div></div>' +
        '<div class="text-center auth-timer"><div class=""><h4 class="mb-0 fw-semibold">' + m + '</h4><p class="mb-1 fs-13 fw-medium op-7">Minutes</p></div></div>' +
        '<div class="text-center auth-timer"><div class=""><h4 class="mb-0 fw-semibold">' + s + '</h4><p class="mb-1 fs-13 fw-medium op-7">Seconds</p></div></div>'
}
setInterval('updateTimer()', 1000);

