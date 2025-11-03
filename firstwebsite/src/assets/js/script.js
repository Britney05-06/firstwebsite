document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll("section, h5, .card-panel, .collection-item");

  // Ajouter les classes "hidden" à tout le contenu animé
  sections.forEach((el) => el.classList.add("hidden"));

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    },
    { threshold: 0.2 }
  );

  // Observer chaque section
  sections.forEach((el) => observer.observe(el));

  window.addEventListener("load", () => {
    sections.forEach((el) => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight * 0.8) {
        el.classList.add("visible");
      }
    });
  });
});

// --- Effet sur les boutons ---
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("btn") || e.target.classList.contains("btn-small")) {
    e.target.classList.add("clicked");
    setTimeout(() => e.target.classList.remove("clicked"), 200);
  }
});

// message après ajout/suppression
const forms = document.querySelectorAll("form");
forms.forEach(form => {
  form.addEventListener("submit", () => {
    const msg = document.createElement("div");
    msg.textContent = "✅ Action enregistrée !";
    msg.className = "toast";
    document.body.appendChild(msg);
    setTimeout(() => msg.remove(), 1500);
  });
});

