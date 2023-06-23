const nav = document.querySelector("nav");
const nav_button = document.getElementById("nav_button");

nav_button.onclick = function (e) {
  if (e.target.id !== "nav_button") {
    nav.classList.add("bg-dark", "shadow");
  } else {
    nav.classList.remove("bg-dark", "shadow");
  }
};

window.addEventListener("scroll", function () {
  if (window.scrollY > 100) {
    nav.classList.add("bg-dark", "shadow");
  } else {
    nav.classList.remove("bg-dark", "shadow");
  }
});
