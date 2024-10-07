document.addEventListener("DOMContentLoaded", function () {
  // Initialize elements
  const viewSwitch = document.getElementById("view-switch");
  const eventsTab = document.getElementById("events-tab");
  const venuesTab = document.getElementById("venues-tab");
  const eventsSection = document.getElementById("events-section");
  const venuesSection = document.getElementById("venues-section");
  const usersTab = document.getElementById("users-tab");
  const usersSection = document.getElementById("users-section");

  window.showSection = function (section) {
    eventsSection.classList.add("hidden");
    venuesSection.classList.add("hidden");
    usersSection.classList.add("hidden");
    eventsTab.classList.remove("active");
    venuesTab.classList.remove("active");
    usersTab.classList.remove("active");

    if (section === "events") {
      eventsSection.classList.remove("hidden");
      eventsTab.classList.add("active");
    } else if (section === "venues") {
      venuesSection.classList.remove("hidden");
      venuesTab.classList.add("active");
    } else if (section === "users") {
      usersSection.classList.remove("hidden");
      usersTab.classList.add("active");
    }
  };

  // Events is shown by default
  showSection("events");

  // Function to toggle between card and table views
  window.toggleView = function () {
    const isTableView = viewSwitch.checked;

    document
      .getElementById("events-card-view")
      .classList.toggle("hidden", isTableView);
    document
      .getElementById("events-table-view")
      .classList.toggle("hidden", !isTableView);

    document
      .getElementById("venues-card-view")
      .classList.toggle("hidden", isTableView);
    document
      .getElementById("venues-table-view")
      .classList.toggle("hidden", !isTableView);

    document
      .getElementById("users-card-view")
      .classList.toggle("hidden", isTableView);
    document
      .getElementById("users-table-view")
      .classList.toggle("hidden", !isTableView);
  };

  // Event listeners
  viewSwitch.addEventListener("change", toggleView);
  eventsTab.addEventListener("click", function () {
    showSection("events");
  });
  venuesTab.addEventListener("click", function () {
    showSection("venues");
  });
  usersTab.addEventListener("click", function () {
    showSection("users");
  });

  window.toggleAttendeeList = function (eventId) {
    const attendeeList = document.getElementById(`attendees-list-${eventId}`);
    if (attendeeList) {
      attendeeList.classList.toggle("hidden");
    } else {
      console.error(`Attendee list for event ID ${eventId} not found.`);
    }
  };

  window.confirmDelete = function (itemType) {
    return confirm(
      `Are you sure you want to delete this ${itemType}? This action will also delete all related items.`
    );
  };

  window.showAddForm = function (type) {
    const form = document.getElementById(`new-${type}-form`);
    if (form) {
      form.classList.remove("hidden");
      window.scrollTo({ top: form.offsetTop, behavior: "smooth" });
    }
  };

  window.hideAddForm = function (type) {
    const form = document.getElementById(`new-${type}-form`);
    if (form) {
      form.classList.add("hidden");
    }
  };

  window.showEditForm = function (type, id) {
    if (typeof id !== "number") {
      console.error(
        `Invalid ID for ${type}: expected a number, received ${typeof id}`,
        id
      );
      return;
    }

    const editForm = document.getElementById(`edit-${type}-${id}`);
    if (editForm) {
      editForm.classList.remove("hidden");
      window.scrollTo({ top: editForm.offsetTop, behavior: "smooth" });
    } else {
      console.error(`Edit form for ${type} with ID ${id} not found.`);
    }
  };

  window.hideEditForm = function (type, id) {
    const editForm = document.getElementById(`edit-${type}-${id}`);
    if (editForm) {
      editForm.classList.add("hidden");
    } else {
      console.error(`Edit form for ${type} with ID ${id} not found.`);
    }
  };
});
