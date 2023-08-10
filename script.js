function startTimer(duration, display) {
  var timer = duration,
    minutes,
    seconds;
  setInterval(function () {
    seconds = parseInt(timer % 60, 10);

    seconds = seconds < 10 ? +seconds : seconds;

    display.textContent = seconds;

    if (--timer < 0) {
      timer = duration;
    }
  }, 1000);
}

window.onload = function () {
  var oneMinute = 59,
    display = document.querySelector("#time");
  startTimer(oneMinute, display);
};

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

const sign_up_button = document.getElementById("sign_up");

sign_up_button.addEventListener("mouseover", function () {
  sign_up_button.classList.add("btn-transparent");
  sign_up_button.classList.remove("btn-primary");
});

sign_up_button.addEventListener("mouseout", function () {
  sign_up_button.classList.add("btn-primary");
  sign_up_button.classList.remove("btn-transparent");
});

function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 20;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
  }
}

function reveal_once() {
  var reveals = document.querySelectorAll(".reveal_once");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 20;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    }
  }
}

window.addEventListener("scroll", reveal);
window.addEventListener("scroll", reveal_once);
