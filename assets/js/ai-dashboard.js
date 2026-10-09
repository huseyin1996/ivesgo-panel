
/* Start Ai Js Code */

const langValues  = [
    {
      value: "1",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/us_flag.jpg" alt=""> <span class="mx-1">United States</span>',
      id: 1,
      selected: true
    },
    {
      value: "2",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/spain_flag.jpg"  alt=""> <span class="ms-1">Spain</span>',
      id: 2,
    },
    {
      value: "3",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/french_flag.jpg" alt=""> <span class="ms-1">France</span>',
      id: 3,
    },
    {
      value: "4",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/germany_flag.jpg" alt=""> <span class="ms-1">Germany</span>',
      id: 4,
    },
    {
      value: "5",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/italy_flag.jpg" alt=""> <span class="ms-1">Italy</span>',
      id: 5,
    },
    {
      value: "6",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/russia_flag.jpg" alt=""> <span class="ms-1">Netherlands</span>',
      id: 6,
    },
    {
      value: "7",
      label:
        '<img class="avatar avatar-xs avatar-rounded" src="../assets/images/flags/argentina_flag.jpg" alt=""> <span class="ms-1">Argentina</span>',
      id: 7,
    },
  ];
  var langChoices = new Choices(document.querySelector('.choices-images'), {
    choices: langValues,
    allowHTML: true,
    searchEnabled: false,
    searchPlaceholderValue: 'Search language…',
    itemSelectText: '',
    shouldSort: false,
    placeholder: true,
    placeholderValue: 'Select a language'
  });
  const themeValues  = [
    {
      value: "1",
      label:
        '<span class="avatar avatar-xs avatar-rounded bg-light text-dark"><i class="ri-sun-line fs-16"></i></span> <span class="mx-1">Light Theme</span>',
      id: 1,
      selected: true
    },
    {
      value: "2",
      label:
        '<span class="avatar avatar-xs avatar-rounded bg-light text-dark"><i class="ri-moon-line fs-16"></i></span> <span class="ms-1">Dark Theme</span>',
      id: 2,
    },
    // {
    //   value: "3",
    //   label:
    //     '<span class="avatar avatar-xs avatar-rounded bg-light text-dark"><i class="ri-macbook-line fs-16"></i></span> <span class="ms-1">System Default</span>',
    //   id: 3,
    // },
  ];
  var themeChoices = new Choices(document.querySelector('.theme-sel'), {
    choices: themeValues,
    allowHTML: true,
    searchEnabled: false,
    searchPlaceholderValue: 'Search Theme',
    itemSelectText: '',
    shouldSort: false,
    placeholder: true,
    placeholderValue: 'Select a theme'
  });
  const styleValues  = [
    {
      value: "1",
      label:
        '<span class="avatar avatar-xs avatar-rounded bg-light text-dark"><i class="ri-scales-3-line fs-16"></i></span><span class="mx-1">Neutral</span>',
      id: 1,
      selected: true
    },
    {
      value: "2",
      label:
        '<span class="avatar avatar-xs avatar-rounded bg-light text-dark"><i class="ri-flashlight-line fs-16"></i></span><span class="ms-1">Concise</span>',
      id: 2,
    },
    {
      value: "3",
      label:
        '<span class="avatar avatar-xs avatar-rounded bg-light text-dark"><i class="ri-book-open-line fs-16"></i></span><span class="ms-1">Deatiled</span>',
      id: 3,
    },
  ];
  var styleChoices = new Choices(document.querySelector('.style-sel'), {
    choices: styleValues,
    allowHTML: true,
    searchEnabled: false,
    searchPlaceholderValue: 'Search style',
    itemSelectText: '',
    shouldSort: false,
    placeholder: true,
    placeholderValue: 'Select a style'
  });
function now() {
    return new Date().toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
}
  
function setDots(s) {
['dot1','dot2','dot3'].forEach(function(id, i) {
    document.getElementById(id).className = 'sdot' + (i < s ? ' active' : '');
});
}

function showScreen(n) {
document.querySelectorAll('.screen').forEach(function(el) { el.classList.remove('active'); });
document.getElementById('screen' + n).classList.add('active');
setDots(n);
}
function goStep(n) {
showScreen(n);
}
function savePrefs() {
var alert = document.getElementById('save-alert');
alert.classList.add('show');
setTimeout(function() {
    alert.classList.remove('show');
    setTimeout(function() { showScreen(3); }, 200);
}, 1200);
}

//  Chat //
var botReplies = [
"That's a great question! Based on your current tab, here's what I found — let me know if you'd like me to go deeper.",
"Sure! Let me look that up for you. Based on the page content, here's a quick summary.",
"Interesting! Here are the key points I found from the current page and my knowledge.",
"On it! Give me a moment… Here's what I think you'll find useful.",
"I can help with that. Could you share a bit more context so I can give you the best answer?",
"Great question. From what I can see on this page, the main idea seems to be about improving your workflow.",
"Based on the content here, I'd suggest looking at the highlighted sections — want me to summarise them?"
];
  
function addMsg(text, type) {
    var log = document.getElementById('chat-log');
    var div = document.createElement('div');
    div.className = 'msg ' + type;
    div.innerHTML = text + '<div class="msg-time">' + now() + '</div>';
    log.appendChild(div);
    log.scrollTop = log.scrollHeight;
    return div;
}
  
function sendMsg() {
    var inp = document.getElementById('chat-input');
    var val = inp.value.trim();
    var hasAttachments = document.getElementById('attach-preview').children.length > 0;
    if (!val && !hasAttachments) return;

// Build user message//
        var msgHTML = '';
        if (hasAttachments) {

        var chips = document.querySelectorAll('.attach-chip');

        chips.forEach(function(chip) {

            var img = chip.querySelector('img');
            var fileName = chip.querySelector('.chip-name').textContent;

            // IMAGE FILE//
            if (img) {

            msgHTML += `
                <div style="margin-bottom:6px;">
                <img src="${img.src}" width="40" height="40"
                        style="border-radius:6px;object-fit:cover;">
                </div>
            `;

            } else {

            // OTHER FILES
            var icon = chip.querySelector('.chip-icon');

            msgHTML += `
                <div class="msg-attach file-attach"
                    style="display:flex;align-items:center;gap:6px;margin-bottom:6px;">

                <i class="${icon.className}"></i>

                <span class="msg-file-name">
                    ${fileName}
                </span>

                </div>
            `;
            }

        });
        }
        if (val) msgHTML += val;
        addMsg(msgHTML, 'user');

        inp.value = '';
        inp.style.height = 'auto';
        document.getElementById('attach-preview').innerHTML = '';
        document.getElementById('quick-prompts').style.display = 'none';
        updateSendBtn();

        var typing = addMsg('<i class="ri ri-more-line"></i> Thinking', 'bot typing');
        setTimeout(function() {
        typing.remove();
        var reply = botReplies[Math.floor(Math.random() * botReplies.length)];
        addMsg(reply, 'bot');
        }, 900 + Math.random() * 600);
}
  
function usePrompt(btn) {
    var inp = document.getElementById('chat-input');
    inp.value = btn.textContent;
    inp.focus();
    autoResize(inp);
    updateSendBtn();
}
  
  // Auto-resize textarea//
  function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
  }
  
  // Enable //
  function updateSendBtn() {
    var inp = document.getElementById('chat-input');
    var btn = document.getElementById('send-btn');
    var hasText = inp.value.trim().length > 0;
    var hasFiles = document.getElementById('attach-preview').children.length > 0;
    if (hasText || hasFiles) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  }
  
  document.getElementById('chat-input').addEventListener('input', function() {
    autoResize(this);
    updateSendBtn();
  });
  
  document.getElementById('chat-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMsg();
    }
  });
  
  //  Attach menu toggle//
  document.getElementById('attach-trigger').addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('attach-menu').classList.toggle('open');
    document.getElementById('speed-menu').classList.remove('open');
  });
  
  //  Speed menu toggle//
  document.getElementById('speed-btn').addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('speed-menu').classList.toggle('open');
    document.getElementById('attach-menu').classList.remove('open');
  });
  
  function setSpeed(btn, label) {
    document.querySelectorAll('.speed-opt').forEach(function(o) { o.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('speed-btn').innerHTML = label + ' <i class="ri-arrow-down-s-line" style="font-size:10px;"></i>';
    document.getElementById('speed-menu').classList.remove('open');
  }
  
  // Close menus on outside click//
  document.addEventListener('click', function() {
    document.getElementById('attach-menu').classList.remove('open');
    document.getElementById('speed-menu').classList.remove('open');
  });
  
  //  File upload  //
  function triggerFileUpload(type) {
    document.getElementById('attach-menu').classList.remove('open');
    document.getElementById('file-' + type).click();
  }
  
  function handleFiles(input, type) {
    var preview = document.getElementById('attach-preview');
    Array.from(input.files).forEach(function(file) {
      var chip = document.createElement('div');
      chip.className = 'attach-chip';
  
      var isImage = file.type.startsWith('image/');
      if (isImage) {
        var img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        chip.appendChild(img);
      } else {
        var icon = document.createElement('i');
        var ext = file.name.split('.').pop().toLowerCase();
        var iconMap = { pdf:'ri-file-pdf-2-line', doc:'ri-file-word-line', docx:'ri-file-word-line',
          xls:'ri-file-excel-line', xlsx:'ri-file-excel-line', ppt:'ri-file-ppt-line', pptx:'ri-file-ppt-line',
          txt:'ri-file-text-line', csv:'ri-file-excel-line' };
        icon.className = 'ri ' + (iconMap[ext] || 'ri-file-3-line') + ' chip-icon';
        chip.appendChild(icon);
      }
  
      var name = document.createElement('span');
      name.className = 'chip-name';
      name.title = file.name;
      name.textContent = file.name;
      chip.appendChild(name);
  
      var rm = document.createElement('button');
      rm.className = 'chip-remove';
      rm.innerHTML = '<i class="ri-close-line"></i>';
      rm.onclick = function() { chip.remove(); updateSendBtn(); };
      chip.appendChild(rm);
  
      preview.appendChild(chip);
    });
    input.value = '';
    updateSendBtn();
  }
  
  //  Mic toggle  //
  var isRecording = false;
  function toggleMic() {
    isRecording = !isRecording;
    var btn = document.getElementById('mic-btn');
    if (isRecording) {
      btn.classList.add('recording');
      btn.title = 'Stop recording';
      btn.querySelector('i').className = 'ri ri-mic-fill';
    } else {
      btn.classList.remove('recording');
      btn.title = 'Voice input';
      btn.querySelector('i').className = 'ri ri-mic-line';
    }
  }
  document.getElementById('init-time').textContent = now();
  
  document.getElementById('aiPanel').addEventListener('show.bs.offcanvas', function() {
    showScreen(1);
    document.getElementById('chat-log').innerHTML =
      '<div class="msg bot">👋 Hi there! I\'m your AI assistant. Ask me anything about this page or any topic!<div class="msg-time">' + now() + '</div></div>';
    document.getElementById('quick-prompts').style.display = 'flex';
  });
  
  document.addEventListener("DOMContentLoaded", function () {
    const aiBtn = document.querySelector(".header-ai .open-btn");
  
    if (aiBtn) {
        const tooltip = new bootstrap.Tooltip(aiBtn);
  
        aiBtn.addEventListener("click", function () {
            tooltip.hide();
        });
    }
  });
  
  /* End Ai Js Code */
  


  // AI Usage & Cost Analytics//

var options = {
    series: [
        {
            name: "AI Usage",
            data: [60, 70, 35, 42, 53, 99, 62, 36, 51, 63, 15, 32],
            type: "area",
        },
        {
            name: "Cost Analytics",
            data: [80, 51, 63, 55, 32, 55, 45, 64, 50, 38, 58, 56],
            type: "line",
        }
    ],
    chart: {
        type: "line",
        height: 350,
        toolbar: {
            show: false
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 7,
            left: 0,
            blur: 1,
            color: ["var(--primary-color)", "rgba(var(--secondary-rgb),1)"],
            opacity: 0.05,
        },
    },
    colors: [
        "var(--primary-color)",
        "rgba(var(--secondary-rgb),1)"
    ],
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: true,
        position: "top",
        offsetX: 0,
        offsetY: 8,
        markers: {
            size: 4,
            strokeWidth: 0,
            strokeColor: '#fff',
            fillColors: undefined,
            radius: 12,
            customHTML: undefined,
            onClick: undefined,
            offsetX: 0,
            offsetY: 0
        },
    },
    stroke: {
        curve: 'smooth',
        width: [1.5, 2],
        lineCap: 'round',
        dashArray: [0, 4],
    },
    fill: {
        type: ['gradient', 'solid'],
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            stops: [0, 90, 100],
            colorStops: [
                [
                    {
                        offset: 0,
                        color: "var(--primary01)",
                        opacity: 0.1
                    },
                    {
                        offset: 75,
                        color: "var(--primary01)",
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: 'var(--primary02)',
                        opacity: 1
                    }
                ],
                [
                    {
                        offset: 0,
                        color: 'rgba(var(--secondary-rgb),1)',
                        opacity: 1
                    },
                    {
                        offset: 75,
                        color: 'rgba(var(--secondary-rgb),1)',
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: 'rgba(var(--secondary-rgb),1)',
                        opacity: 1
                    }
                ],
            ]
        }
    },
    grid: {
        borderColor: "#f1f1f1",
        strokeDashArray: 2,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        }
    },
    yaxis: {
        show: true,
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        }
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        show: false,
        axisBorder: {
            show: false,
            color: 'rgba(119, 119, 142, 0.05)',
            offsetX: 0,
            offsetY: 0,
        },
        axisTicks: {
            show: false,
            borderType: 'solid',
            color: 'rgba(119, 119, 142, 0.05)',
            width: 6,
            offsetX: 0,
            offsetY: 0
        },
        labels: {
            rotate: -90,
        }
    },
};
var chart4 = new ApexCharts(document.querySelector("#ai-usage-analytics"), options);
chart4.render();

// Model Performance//
var options = {
  series: [4289, 3565, 2964],
  labels: ["Vision Pro AI", "Speed Gen", "Eco AI"],
  chart: {
      height: 210,
      type: 'donut',
  },
  dataLabels: {
      enabled: false,
  },
  legend: {
      show: false,
      position: 'bottom',
      markers: {
          size: 4,
          shape: 'circle',
      },
  },
  stroke: {
      show: true,
      curve: 'smooth',
      lineCap: 'round',
      colors: "#fff",
      width: 0,
      dashArray: 0,
  },
  plotOptions: {
      pie: {
          expandOnClick: false,
          donut: {
              size: '80%',
              background: 'transparent',
              labels: {
                  show: true,
                  name: {
                      show: true,
                      fontSize: '20px',
                      color: '#495057',
                      fontFamily: "Montserrat, sans-serif",
                      offsetY: -5
                  },
                  value: {
                      show: true,
                      fontSize: '22px',
                      color: undefined,
                      offsetY: 5,
                      fontWeight: 600,
                      fontFamily: "Montserrat, sans-serif",
                      formatter: function (val) {
                          return val + "%"
                      }
                  },
                  total: {
                      show: true,
                      showAlways: true,
                      label: 'Total Visitors',
                      fontSize: '14px',
                      fontWeight: 400,
                      color: '#495057',
                  }
              }
          }
      }
  },
  colors: ["var(--primary-color)", "rgba(var(--secondary-rgb))", "rgba(var(--light-rgb))", ],
};
var chart = new ApexCharts(document.querySelector("#modal-performance"), options);
chart.render();

//panel open js//

document.addEventListener("DOMContentLoaded", function () {
    const aiPanel = document.getElementById("aiPanel");
    const mainContent = document.querySelector(".gen-ai-main-content-wrapper");
    const html = document.documentElement; // <html>

    if (!aiPanel || !mainContent) return;

    function updateMainContentWidth() {
        const isPanelOpen = aiPanel.classList.contains("show");

        if (isPanelOpen) {
            // Panel visible
            mainContent.classList.remove("col-xxl-12");
            mainContent.classList.add("col-xxl-9");

            mainContent.style.width = "";
            mainContent.style.maxWidth = "";
        } else {
            // Panel hidden
            mainContent.classList.remove("col-xxl-9");
            mainContent.classList.add("col-xxl-12");

            mainContent.style.width = "100%";
            mainContent.style.maxWidth = "100%";
        }
    }

    // Initial check
    updateMainContentWidth();

    // Bootstrap offcanvas events
    aiPanel.addEventListener("shown.bs.offcanvas", updateMainContentWidth);
    aiPanel.addEventListener("hidden.bs.offcanvas", updateMainContentWidth);

    // Watch for class changes on offcanvas
    const panelObserver = new MutationObserver(updateMainContentWidth);
    panelObserver.observe(aiPanel, {
        attributes: true,
        attributeFilter: ["class"]
    });

    // Watch for data-width changes on <html>
    const htmlObserver = new MutationObserver(updateMainContentWidth);
    htmlObserver.observe(html, {
        attributes: true,
        attributeFilter: ["data-width"]
    });
});
