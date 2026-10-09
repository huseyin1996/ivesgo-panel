const generateBtn = document.getElementById("generateBtn");
const promptInput = document.getElementById("promptInput");
const negativeInput = document.getElementById("negativeInput");
const resultWrapper = document.getElementById("resultWrapper");
const guidanceRange = document.getElementById("guidanceRange");


document.querySelectorAll(".count-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".count-btn").forEach(item => item.classList.remove("active"));
    btn.classList.add("active");
  });
});

generateBtn.addEventListener("click", () => {
  const prompt = promptInput.value.trim();
  const negative = negativeInput.value.trim();
  const count = Number(document.querySelector(".count-btn.active").dataset.count);
  const guidance = guidanceValue.textContent;

  if (!prompt) {
    alert("Please enter image prompt");
    return;
  }

  let images = "";

  for (let i = 1; i <= count; i++) {
    images += `
      <div class="image-card">
        <img src="https://picsum.photos/600/600?random=${Date.now() + i}">
        <div class="image-hover">
          <button><i class="bi bi-download"></i></button>
          <button><i class="bi bi-arrows-fullscreen"></i></button>
        </div>
      </div>
    `;
  }

  resultWrapper.insertAdjacentHTML("afterbegin", `
    <section class="result-section">
      <div class="result-top">
        <div>
          <p class="result-title mb-2">Negative prompt: ${prompt}</p>  

          <div class="d-flex gap-2 flex-wrap">
          <a href="javascript:void(0);" class="badge bg-white border border-opacity-50 border-primary fs-14 text-default">
            Imaginative
          </a>

          <a href="javascript:void(0);" class="badge bg-white border border-opacity-50 border-primary fs-14 text-default">
            Vertical 3:4
          </a>

          <a href="javascript:void(0);" class="badge bg-white border border-opacity-50 border-primary fs-14 text-default">
            Guidance ${guidance}
          </a>
        </div>
        </div>

         <div class="result-actions">
          <button class="btn btn-icon btn-white border">
            <i class="ri-file-copy-line"></i>
          </button>

          <button class="btn btn-icon btn-white border">
            <i class="ri-share-line"></i>
          </button>

          <button class="btn btn-icon btn-white border">
            <i class="ri-download-line"></i>
          </button>
        </div>
      </div>

      <div class="image-result-grid">
        ${images}
      </div>
    </section>
  `);

  promptInput.value = "";
});

const guidanceSlider = document.getElementById('guidanceSlider');
const guidanceValue = document.getElementById('guidanceValue');

noUiSlider.create(guidanceSlider, {
  start: [13],
  connect: [true, false],
  step: 1,
  range: {
    min: 1,
    max: 20
  },
  format: {
    to: value => Math.round(value),
    from: value => Number(value)
  }
});

guidanceSlider.noUiSlider.on('update', function (values) {
  guidanceValue.textContent = values[0];
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