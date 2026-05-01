document.addEventListener("DOMContentLoaded", () => {
  console.log("✅ index.js loaded");

  const detailButtons = document.querySelectorAll(".btn-detail");
  console.log(`🔍 Found ${detailButtons.length} detail buttons`);

  detailButtons.forEach((button) => {
    button.addEventListener("click", function () {
      console.log("🖱️ Detail button clicked");
      document.getElementById("detailTitle").innerText = this.dataset.title;
      document.getElementById("detailDescription").innerText =
        this.dataset.description;
      document.getElementById("detailDeadline").innerText =
        this.dataset.deadline;
      document.getElementById("detailPriority").innerText =
        this.dataset.priority;
      document.getElementById("detailStatus").innerText = this.dataset.status;
    });
  });

  //Button Update
  document.addEventListener("click", function (e) {
    if (e.target.closest(".done-btn")) {
      const button = e.target.closest(".done-btn");
      const card = button.closest(".card");
      const todoId = card.dataset.todoId;
      const todoTitle = card.querySelector(".card-title").innerText;

      console.log(`✅ Done clicked for: ${todoTitle} (ID: ${todoId})`);

      if (confirm(`Tandai "${todoTitle}" sebagai selesai?`)) {
        const formData = new FormData();
        formData.append("id", todoId);

        fetch("./src/todolist-update.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => {
            console.log("Server response:", data);
            if (data.trim() === "success") {
              card.closest(".col").style.transition = "opacity 0.3s ease";
              card.closest(".col").style.opacity = "0";
              setTimeout(() => {
                card.closest(".col").remove();
                alert("✅ Todo ditandai selesai!");
              }, 300);
            } else {
              alert("❌ Error: " + data);
            }
          })
          .catch((error) => {
            console.error("Fetch error:", error);
            alert("Terjadi kesalahan jaringan");
          });
      }
    }

    //Button Delete
    if (e.target.closest(".delete-btn")) {
      const button = e.target.closest(".delete-btn");
      const card = button.closest(".card");
      const todoId = card.dataset.todoId;
      const todoTitle = card.querySelector(".card-title").innerText;

      console.log(`🗑️ Delete clicked for: ${todoTitle} (ID: ${todoId})`);

      if (confirm(`Hapus "${todoTitle}" secara permanen?`)) {
        const formData = new FormData();
        formData.append("id", todoId);

        fetch("./src/todolist-delete.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => {
            console.log("Server response:", data);
            if (data.trim() === "success") {
              card.closest(".col").style.transition = "opacity 0.3s ease";
              card.closest(".col").style.opacity = "0";
              setTimeout(() => {
                card.closest(".col").remove();
                alert("🗑️ Todo berhasil dihapus!");
              }, 300);
            } else {
              alert("❌ Error: " + data);
            }
          })
          .catch((error) => {
            console.error("Fetch error:", error);
            alert("Terjadi kesalahan jaringan");
          });
      }
    }
  });
});
