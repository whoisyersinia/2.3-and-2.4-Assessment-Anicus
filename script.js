$(document).ready(function () {
  // On refresh check if there are values selected
  if (localStorage.selectVal) {
    // Select the value stored
    $("#filter").val(localStorage.selectVal);
  }
});

// On change store the value
$("#filter").on("change", function () {
  var currentVal = $(this).val();
  localStorage.setItem("selectVal", currentVal);
});

$(document).ready(function () {
  $(".chosen-select").chosen({
    no_results_text: "Oops, nothing found!",
  });
});

$(".chosen-select").chosen({ max_selected_options: 5 });

$(document).ready(function () {
  var edit = document.getElementById("gedit").value;

  var str_array = edit.split(",");

  for (var i = 0; i < str_array.length; i++) {
    str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
  }

  $(".chosen-select").val(str_array).trigger("chosen:updated");
});

setTimeout(function () {
  bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert")).close();
}, 3000);

let btn_login = document.getElementById("btn_login");

if (btn_login != null) {
  btn_login = document.getElementById("btn_login");
  btn_login.addEventListener("click", function () {
    document.location.href = "login.php";
  });
} else {
  btn_login = null;
}
let btn_register = document.getElementById("btn_register");

if (btn_register != null) {
  btn_register = document.getElementById("btn_register");
  btn_register.addEventListener("click", function () {
    document.location.href = "register.php";
  });
} else {
  btn_register = null;
}

let btn_logout = document.getElementById("btn_logout");

if (btn_logout != null) {
  btn_logout = document.getElementById("btn_logout");
  btn_logout.addEventListener("click", function () {
    document.location.href = "logout.php";
  });
} else {
  btn_logout = null;
}
const animeinfo = () => {
  let val = (id) => document.querySelector(id).value;
  document.location.href = "infoanime.php?id=" + val("#url");
};

window.onload = function () {
  var oneMinute = 59,
    display = document.querySelector("#time");

  if (display != null) {
    function startTimer(duration, display) {
      var timer = duration,
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
    startTimer(oneMinute, display);
  } else {
    display = null;
  }
};

let nav = document.querySelector("nav");
let nav_button = document.getElementById("nav_button");

if (nav_button != null) {
  nav_button.onclick = function (e) {
    if (e.target.id !== "nav_button") {
      nav.classList.add("bg-dark", "shadow");
    } else {
      nav.classList.remove("bg-dark", "shadow");
    }
  };
} else {
  nav_button = null;
}

if (nav != null) {
  window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
      nav.classList.add("bg-dark", "shadow");
    } else {
      nav.classList.remove("bg-dark", "shadow");
    }
  });
} else {
  nav = null;
}

let sign_up_button = document.getElementById("sign_up");

if (sign_up_button != null) {
  sign_up_button.addEventListener("mouseover", function () {
    sign_up_button.classList.add("btn-transparent");
    sign_up_button.classList.remove("btn-primary");
  });

  sign_up_button.addEventListener("mouseout", function () {
    sign_up_button.classList.add("btn-primary");
    sign_up_button.classList.remove("btn-transparent");
  });
}

function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 30;

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
    var elementVisible = 100;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    }
  }
}

window.addEventListener("scroll", reveal);
window.addEventListener("scroll", reveal_once);
