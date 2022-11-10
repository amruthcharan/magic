/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
(function () {
  /* ========= sidebar toggle ======== */
  var sidebarNavWrapper = document.querySelector(".sidebar-nav-wrapper");
  var mainWrapper = document.querySelector(".main-wrapper");
  var menuToggleButton = document.querySelector("#menu-toggle");
  var menuToggleButtonIcon = document.querySelector("#menu-toggle i");
  var overlay = document.querySelector(".overlay");
  menuToggleButton.addEventListener("click", function () {
    sidebarNavWrapper.classList.toggle("active");
    overlay.classList.add("active");
    mainWrapper.classList.toggle("active");
    if (document.body.clientWidth > 1200) {
      if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
        menuToggleButtonIcon.classList.remove("lni-chevron-left");
        menuToggleButtonIcon.classList.add("lni-menu");
      } else {
        menuToggleButtonIcon.classList.remove("lni-menu");
        menuToggleButtonIcon.classList.add("lni-chevron-left");
      }
    } else {
      if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
        menuToggleButtonIcon.classList.remove("lni-chevron-left");
        menuToggleButtonIcon.classList.add("lni-menu");
      }
    }
  });
  overlay.addEventListener("click", function () {
    sidebarNavWrapper.classList.remove("active");
    overlay.classList.remove("active");
    mainWrapper.classList.remove("active");
  });
})();
/******/ })()
;