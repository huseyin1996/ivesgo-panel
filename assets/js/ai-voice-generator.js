document.addEventListener("DOMContentLoaded", () => {
  const voiceText = document.getElementById("voiceText");
  const generateVoiceBtn = document.getElementById("generateVoiceBtn");
  const voiceResultWrapper = document.getElementById("voiceResultWrapper");

  const languageSelect = document.getElementById("languageSelect");
  const formatSelect = document.getElementById("formatSelect");
  const qualitySelect = document.getElementById("qualitySelect");

  const speedRange = document.getElementById("speedRange");
  const pitchRange = document.getElementById("pitchRange");
  const speedValue = document.getElementById("speedValue");
  const pitchValue = document.getElementById("pitchValue");

  let currentSpeed = 1;
  let currentPitch = 1;

  if (typeof noUiSlider !== "undefined" && speedRange && !speedRange.noUiSlider) {
    noUiSlider.create(speedRange, {
      start: 1,
      step: 0.1,
      connect: "lower",
      range: { min: 0.5, max: 2 }
    });

    speedRange.noUiSlider.on("update", values => {
      currentSpeed = Number(values[0]);
      if (speedValue) speedValue.textContent = `${currentSpeed.toFixed(1)}x`;
    });
  }

  if (typeof noUiSlider !== "undefined" && pitchRange && !pitchRange.noUiSlider) {
    noUiSlider.create(pitchRange, {
      start: 1,
      step: 0.1,
      connect: "lower",
      range: { min: 0.5, max: 2 }
    });

    pitchRange.noUiSlider.on("update", values => {
      currentPitch = Number(values[0]);
      if (pitchValue) pitchValue.textContent = currentPitch.toFixed(1);
    });
  }

  document.querySelectorAll(".voice-type-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      document.querySelectorAll(".voice-type-btn").forEach(item => item.classList.remove("active"));
      btn.classList.add("active");
    });
  });

  function getActiveVoice() {
    return document.querySelector(".voice-type-btn.active")?.dataset.voice || "Female Voice";
  }

  function getSelectText(select, fallback) {
    return select?.options[select.selectedIndex]?.text || fallback;
  }

  function formatTime(seconds) {
    seconds = Math.max(0, Math.floor(seconds));
    const h = String(Math.floor(seconds / 3600)).padStart(2, "0");
    const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, "0");
    const s = String(seconds % 60).padStart(2, "0");
    return `${h}:${m}:${s}`;
  }

  function getDuration(text) {
    return Math.max(8, Math.ceil(text.length / 10));
  }

  function createWaveBars() {
    return Array.from({ length: 25 }, () => "<span></span>").join("");
  }

  function getProgressPercent(section) {
    const progress = section.querySelector(".progress");
    const progressBar = section.querySelector(".progress-bar");

    let percent = parseFloat(progress?.getAttribute("aria-valuenow"));

    if (isNaN(percent)) {
      percent = parseFloat(progressBar?.style.width || "0");
    }

    return isNaN(percent) ? 0 : percent;
  }

  function setPlayerProgress(section, percent) {
    const text = section.querySelector(".voice-result-title")?.textContent.trim() || "";
    const totalSeconds = getDuration(text);
    const currentSeconds = Math.round((percent / 100) * totalSeconds);

    const progress = section.querySelector(".progress");
    const progressBar = section.querySelector(".progress-bar");
    const timer = section.querySelector(".voice-info p");

    if (progressBar) progressBar.style.width = `${percent}%`;
    if (progress) progress.setAttribute("aria-valuenow", Math.round(percent));
    if (timer) timer.textContent = `${formatTime(currentSeconds)} / ${formatTime(totalSeconds)}`;

    section.dataset.currentSeconds = currentSeconds;
  }

  function pausePlayer(section) {
    clearInterval(section.voiceTimer);
    speechSynthesis.cancel();

    section.dataset.playing = "false";

    section.querySelector(".play-btn i")?.classList.remove("bi-pause-fill");
    section.querySelector(".play-btn i")?.classList.add("bi-play-fill");
    section.querySelector(".voice-wave")?.classList.remove("active");
  }

  function stopOtherPlayers(activeSection) {
    document.querySelectorAll(".voice-result-section").forEach(section => {
      if (section !== activeSection) pausePlayer(section);
    });
  }

  function resetPlayer(section) {
    clearInterval(section.voiceTimer);

    section.dataset.playing = "false";
    section.dataset.currentSeconds = "0";

    const text = section.querySelector(".voice-result-title")?.textContent.trim() || "";
    const progress = section.querySelector(".progress");
    const progressBar = section.querySelector(".progress-bar");
    const timer = section.querySelector(".voice-info p");
    const playIcon = section.querySelector(".play-btn i");
    const wave = section.querySelector(".voice-wave");

    if (progressBar) progressBar.style.width = "0%";
    if (progress) progress.setAttribute("aria-valuenow", "0");
    if (timer) timer.textContent = `00:00:00 / ${formatTime(getDuration(text))}`;
    if (playIcon) playIcon.className = "bi bi-play-fill";
    if (wave) wave.classList.remove("active");
  }

  function playVoice(section) {
    const text = section.querySelector(".voice-result-title")?.textContent.trim();
    if (!text) return;

    const totalSeconds = getDuration(text);

    stopOtherPlayers(section);
    clearInterval(section.voiceTimer);
    speechSynthesis.cancel();

    let currentSeconds = Number(section.dataset.currentSeconds || 0);

    if (!currentSeconds) {
      const startPercent = getProgressPercent(section);
      currentSeconds = Math.round((startPercent / 100) * totalSeconds);
    }

    const progress = section.querySelector(".progress");
    const progressBar = section.querySelector(".progress-bar");
    const timer = section.querySelector(".voice-info p");
    const playIcon = section.querySelector(".play-btn i");
    const wave = section.querySelector(".voice-wave");

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.rate = currentSpeed;
    utterance.pitch = currentPitch;
    utterance.lang = "en-US";

    section.dataset.playing = "true";

    if (playIcon) playIcon.className = "bi bi-pause-fill";
    if (wave) wave.classList.add("active");

    section.voiceTimer = setInterval(() => {
      currentSeconds++;

      const percent = Math.min((currentSeconds / totalSeconds) * 100, 100);

      section.dataset.currentSeconds = currentSeconds;

      if (progressBar) progressBar.style.width = `${percent}%`;
      if (progress) progress.setAttribute("aria-valuenow", Math.round(percent));
      if (timer) timer.textContent = `${formatTime(currentSeconds)} / ${formatTime(totalSeconds)}`;

      if (percent >= 100) resetPlayer(section);
    }, 1000);

    utterance.onend = () => resetPlayer(section);
    utterance.onerror = () => resetPlayer(section);

    speechSynthesis.speak(utterance);
  }

  generateVoiceBtn?.addEventListener("click", () => {
    const text = voiceText?.value.trim();

    if (!text) {
      alert("Please enter text to generate audio");
      return;
    }

    const activeVoice = getActiveVoice();
    const language = getSelectText(languageSelect, "English");
    const format = getSelectText(formatSelect, "MP3");
    const quality = getSelectText(qualitySelect, "High");
    const duration = getDuration(text);

    voiceResultWrapper.insertAdjacentHTML("afterbegin", `
      <section class="voice-result-section" data-current-seconds="0" data-playing="false">
        <div class="voice-result-top">
          <div>
            <p class="voice-result-title">${text}</p>
            <span class="voice-result-meta">
              Voice: ${activeVoice} · Language: ${language} · Format: ${format} · Quality: ${quality} · Speed: ${currentSpeed.toFixed(1)}x · Pitch: ${currentPitch.toFixed(1)}
            </span>
          </div>

          <div class="voice-actions">
            <button type="button" class="btn btn-icon btn-white border play-generated-voice">
              <i class="ri-volume-up-line"></i>
            </button>
            <button type="button" class="btn btn-icon btn-white border">
              <i class="ri-loop-left-line"></i>
            </button>
            <button type="button" class="btn btn-icon btn-white border">
              <i class="ri-download-2-line"></i>
            </button>
          </div>
        </div>

        <div class="voice-player-card">
          <div class="voice-icon">
            <i class="ri-chat-voice-line"></i>
          </div>

          <div class="voice-wave">
            ${createWaveBars()}
          </div>

          <div class="flex-grow-1 voice-progress me-sm-5">
            <div class="d-flex align-items-center gap-3">
              <button type="button" class="btn btn-sm btn-icon rounded-circle border btn-light">
                <i class="ri-skip-back-line fs-5"></i>
              </button>

              <div class="progress progress-xs flex-grow-1 bg-primary-transparent progress-custom progress-animate"
                role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%"></div>
              </div>

              <button type="button" class="btn btn-sm btn-icon rounded-circle border btn-light">
                <i class="ri-skip-forward-line fs-5"></i>
              </button>
            </div>
          </div>

          <div class="voice-info ps-3">
            <h5>${activeVoice}</h5>
            <p>00:00:00 / ${formatTime(duration)}</p>
          </div>

          <button type="button" class="play-btn">
            <i class="bi bi-play-fill"></i>
          </button>
        </div>
      </section>
    `);

    voiceText.value = "";
  });

  document.querySelectorAll(".voice-result-section").forEach(section => {
    const percent = getProgressPercent(section);
    setPlayerProgress(section, percent);
    section.dataset.playing = "false";
  });

  document.addEventListener("click", e => {
    const playBtn = e.target.closest(".play-btn, .play-generated-voice");
    if (!playBtn) return;

    const section = playBtn.closest(".voice-result-section");
    if (!section) return;

    if (section.dataset.playing === "true") {
      pausePlayer(section);
    } else {
      playVoice(section);
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const sidebarToggle = document.getElementById('sidebarToggle');
  const chatSidebar = document.getElementById('chatSidebar');
  const sidebarMobToggle = document.getElementById("sidebar-mob-Toggle");

  console.log('sidebarToggle:', sidebarToggle);
  console.log('chatSidebar:', chatSidebar);

  if (sidebarToggle && chatSidebar) {
      sidebarToggle.addEventListener('click', () => {
          console.log('clicked');
          chatSidebar.classList.toggle('show');
      });

        // Always close
        sidebarMobToggle?.addEventListener("click", () => {
          chatSidebar.classList.remove("show");
        });
  }
});