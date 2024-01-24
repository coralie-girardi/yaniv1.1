//windows DOMContentLoaded , to make function wait the page is completely charged to get data

window.addEventListener("DOMContentLoaded", (event) => {
  let cards = document.getElementById("card");

  cards.addEventListener("dblclick", function (event) {
    // WINDOWS PROMPT HIDDEN IN LOGO IMG
    window.alert(
      "Ecouteur d'évenement n*1 Avec pour but d'inclure du Javascript dans le projet"
    );
    event.preventDefault();
  });
  // FUNCTION DARKMODE
  let title = document.getElementById("title");
  //  Burger menu
  const menu = document.getElementById("menu");

  const CmdMenu = document.getElementById("CmdMenu");
  const openMenu = document.getElementById("openMenu");
  const closeMenu = document.getElementById("closeMenu");
  // display none on click
  openMenu.addEventListener("click", function () {
    if (menu.style.display == "none") {
      menu.style.display = "flex";
    }
    closeMenu.style.display = "block";
  });
  closeMenu.addEventListener("click", function () {
    if (menu.style.display == "flex") {
      menu.style.display = "none";
    }
    closeMenu.style.display = "none";
  });
});
window.onload = function () {
  let width = window.innerWidth;
  if (width < 800) {
    menu.style.display = "none";
  } else {
    menu.style.display = "flex";
  }
  if (width > 800) {
    CmdMenu.style.display = "none";
  } else {
    CmdMenu.style.display = "flex";
  }
};
window.onresize = function () {
  var width = window.innerWidth;
  if (width < 800) {
    menu.style.display = "none";
  } else {
    menu.style.display = "flex";
  }
  if (width > 800) {
    CmdMenu.style.display = "none";
  } else {
    CmdMenu.style.display = "flex";
  }
};
