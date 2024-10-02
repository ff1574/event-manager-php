document.addEventListener("DOMContentLoaded", function () {
  const toggleViewButtons = document.querySelectorAll(".toggle-view");
  const sections = document.querySelectorAll(".section-toggle");

  // Function to toggle between card and table views
  toggleViewButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const target = this.dataset.target;
      const view = this.dataset.view;
      const targetSection = document.getElementById(target);

      if (view === "table") {
        targetSection.classList.remove("card-view");
        targetSection.classList.add("table-view");
      } else {
        targetSection.classList.remove("table-view");
        targetSection.classList.add("card-view");
      }
    });
  });

  // Function to toggle between sections (Venues, Events, Attendees)
  sections.forEach((sectionButton) => {
    sectionButton.addEventListener("click", function () {
      const target = this.dataset.target;

      document.querySelectorAll(".section").forEach((section) => {
        section.style.display = "none";
      });

      document.getElementById(target).style.display = "block";
    });
  });

  // Set default view for venues
  document.getElementById("venues-section").style.display = "block";
});
