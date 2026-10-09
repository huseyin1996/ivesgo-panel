
document.addEventListener("DOMContentLoaded", () => {
  const promptInput = document.getElementById("promptInput");
  const sendBtn = document.getElementById("sendBtn");
  const chatContent = document.getElementById("chatContent");
  const heroSection = document.getElementById("heroSection");
  const newChatBtn = document.getElementById("newChatBtn");
  const chatSearch = document.getElementById("chatSearch");
  const sidebarToggle = document.getElementById("sidebarToggle");
  const chatSidebar = document.getElementById("chatSidebar");

  const avatars = {
    user: "../assets/images/faces/9.jpg",
    bot: "../assets/images/brand-logos/toggle-logo.png"
  };

  const historyChats = {
    "UI Improvements": [
      {
        type: "user",
        text: "Suggest a cleaner dashboard layout."
      },
      {
        type: "bot",
        text: "Here are several recommendations to improve your dashboard's overall usability and visual appeal:\n\n• Increase spacing between cards and sections to create a cleaner, more organized layout.\n• Apply softer shadows with lower opacity to give components a modern and lightweight appearance.\n• Improve typography hierarchy by using larger headings, better font weights, and consistent spacing.\n• Add smooth hover animations and subtle transitions to buttons, cards, and navigation elements.\n• Use a consistent border radius across all UI components for a cohesive design language.\n• Introduce more white space around charts, tables, and widgets to improve readability.\n• Highlight primary actions with stronger accent colors while keeping secondary actions visually subtle.\n• Improve text and icon contrast to enhance accessibility and readability.\n• Standardize button styles, icon sizes, and spacing throughout the dashboard.\n• Optimize the layout for tablets and mobile devices with responsive grids and proper spacing.\n• Group related content into clearly defined sections with descriptive headings.\n• Add loading skeletons, empty states, and success/error feedback for a better user experience.\n• Use badges and status indicators to communicate information more effectively.\n• Reduce unnecessary visual clutter by removing excessive borders and decorative elements.\n\nThese enhancements will create a cleaner, more professional dashboard that is easier to navigate user experience."
      }
    ],
  
    "Dashboard Analytics": [
      {
        type: "user",
        text: "Review this week's analytics."
      },
      {
        type: "bot",
        text: "I've analyzed your dashboard performance for the past seven days. Overall, the metrics indicate steady growth.\n\n📈 Revenue increased by 12.4% compared to last week.\n👥 Active users grew by 8.7%, with higher daily retention.\n🛒 Orders increased by 15%, driven by returning customers.\n🎯 Conversion rate improved from 3.2% to 3.8%.\n📉 Bounce rate decreased by 5.3%, indicating better landing page engagement.\n⏱ Average session duration increased to 4 minutes 18 seconds.\n📱 Mobile traffic accounted for 67% of all visits, while desktop contributed 31%.\n🌍 Organic search traffic grew by 9%, making it your highest-performing acquisition channel.\n\nRecommendations:\n• Optimize your top-performing landing pages to further improve conversions.\n• Focus marketing efforts on mobile users, as they represent the majority of traffic.\n• Continue investing in organic SEO strategies to sustain long-term growth.\n• Monitor checkout performance to capitalize on the recent increase in completed orders.\n\nOverall, your application is performing well with positive trends across engagement, traffic, and revenue."
      }
    ],
  
    "API Integration": [
      {
        type: "user",
        text: "Help me integrate Stripe."
      },
      {
        type: "bot",
        text: `const stripe = new Stripe(API_KEY);
  
  const session = await stripe.checkout.sessions.create({
      mode: "payment"
  });`
      }
    ],
  
    "Database Optimization": [
      {
        type: "user",
        text: "My SQL queries are slow."
      },
      {
        type: "bot",
        text: "After reviewing your query, I found several opportunities to improve database performance and reduce execution time.\n\n```sql\nEXPLAIN SELECT * FROM users WHERE status = 'active';\n```\n\nRecommendations:\n\n• Avoid using `SELECT *`; retrieve only the columns your application actually needs.\n• Create indexes on frequently filtered or joined columns such as `status`, `email`, and `created_at`.\n• Analyze the execution plan using `EXPLAIN` to identify full table scans and inefficient joins.\n• Use `LIMIT` for paginated results instead of loading large datasets.\n• Replace subqueries with `JOIN`s where appropriate to improve performance.\n• Cache frequently executed queries using Redis or Memcached.\n• Optimize JOIN conditions and ensure foreign keys are properly indexed.\n• Archive or partition very large tables to reduce scan time.\n• Use prepared statements to improve security and execution efficiency.\n• Schedule regular maintenance with `ANALYZE TABLE` and `OPTIMIZE TABLE` to keep indexes efficient.\n\nBy applying these optimizations, you can significantly reduce query execution time, lower database load."
      }
    ],
  
    "Deployment Checklist": [
      {
        type: "user",
        text: "Production deployment checklist."
      },
      {
        type: "bot",
        text: "Before deploying your application to production, complete the following checklist to ensure a secure release:\n\n✅ Build and optimize all frontend assets for production.\n✅ Verify environment variables and API keys are configured correctly.\n✅ Run database migrations and confirm the schema is up to date.\n✅ Create a full database backup before deployment.\n✅ Enable HTTPS/SSL certificates and verify secure connections.\n✅ Test authentication, authorization, and user permissions.\n✅ Validate all API endpoints and third-party integrations.\n✅ Clear application, route, and configuration caches.\n✅ Optimize images, JavaScript, and CSS for better performance.\n✅ Configure logging, monitoring, and error reporting services.\n✅ Perform smoke testing on critical user workflows.\n✅ Verify scheduled jobs, cron tasks, and background workers are running.\n✅ Review security settings, CORS policies, and file permissions.\n✅ Confirm email notifications and payment gateways are functioning correctly.\n\nOnce all checks are completed successfully, your application is ready for a stable and reliable production deployment."
      }
    ],
  
    "Team Meeting Notes": [
      {
        type: "user",
        text: "Summarize today's meeting."
      },
      {
        type: "bot",
        text: `• Dashboard redesign approved
• API deadline Friday
• QA starts Monday
• Sidebar improvements accepted`
      }
    ],
  
    "Code Prompt": [
      {
        type: "user",
        text: "Create a responsive Bootstrap navbar."
      },
      {
        type: "bot",
        text: `<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Logo</a>
  
        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link">Home</a></li>
                <li class="nav-item"><a class="nav-link">About</a></li>
                <li class="nav-item"><a class="nav-link">Contact</a></li>
            </ul>
        </div>
    </div>
  </nav>`
      }
    ]
  };
  
  function escapeHTML(value) {
    return String(value || "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function updateSendState() {
    sendBtn.disabled = promptInput.value.trim() === "";
  }

  function addMessage(text, type = "user") {

    heroSection.style.display = "none";
  
    const avatar =
      type === "user"
        ? "../assets/images/faces/5.jpg"
        : "../assets/images/brand-logos/toggle-logo.png";
  
    const row = document.createElement("div");
    row.className = `message-row ${type}`;
  
    const content =
      type === "bot"
        ? `<pre class="mb-0">${escapeHTML(text)}</pre>`
        : escapeHTML(text);
  
    if (type === "user") {
  
      row.innerHTML = `
          <div class="message user">${content}</div>
          <img class="chat-avatar" src="${avatar}">
      `;
  
    } else {
  
      row.innerHTML = `
          <img class="chat-avatar" src="${avatar}">
          <div class="message bot">${content}</div>
      `;
    }
  
    chatContent.appendChild(row);
  
    chatContent.scrollTop = chatContent.scrollHeight;
  }

  function sendMessage() {
    const value = promptInput.value.trim();
    if (!value) return;

    addMessage(value, "user");
    promptInput.value = "";
    updateSendState();

    setTimeout(() => {
      addMessage("Thanks! I received your prompt. Connect this area with your backend/API response.", "bot");
    }, 500);
  }

  function openHistory(title) {

    chatContent.innerHTML = "";
    heroSection.style.display = "none";
  
    const chat = historyChats[title];
  
    if (!chat) return;
  
    chat.forEach(msg => {
        addMessage(msg.text, msg.type);
    });
  
  }

  document.querySelectorAll(".action-card").forEach(card => {
    card.addEventListener("click", () => {
      promptInput.value = card.dataset.prompt;
      promptInput.focus();
      updateSendState();
    });
  });

  document.querySelectorAll(".tool-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      btn.classList.toggle("active");
    });
  });

  sendBtn.addEventListener("click", sendMessage);

  promptInput.addEventListener("input", updateSendState);

  promptInput.addEventListener("keydown", e => {
    if (e.key === "Enter" && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  newChatBtn.addEventListener("click", () => {
    chatContent.innerHTML = "";
    chatContent.appendChild(heroSection);
    heroSection.style.display = "flex";
    promptInput.value = "";
    updateSendState();
  });

  document.querySelectorAll(".chat-item").forEach(item => {

    item.addEventListener("click", () => {

        document.querySelectorAll(".chat-item")
            .forEach(i => i.classList.remove("active"));

        item.classList.add("active");

        const title =
            item.querySelector("strong").innerText.trim();

        openHistory(title);

    });

});

  chatSearch.addEventListener("input", () => {
    const keyword = chatSearch.value.toLowerCase();

    document.querySelectorAll(".chat-item").forEach(item => {
      item.style.display = item.innerText.toLowerCase().includes(keyword) ? "flex" : "none";
    });
  });

  const sidebarMobToggle = document.getElementById("sidebar-mob-Toggle");
  
  // Toggle open/close
  sidebarToggle?.addEventListener("click", () => {
    chatSidebar.classList.toggle("show");
  });
  
  // Always close
  sidebarMobToggle?.addEventListener("click", () => {
    chatSidebar.classList.remove("show");
  });

  updateSendState();
});
