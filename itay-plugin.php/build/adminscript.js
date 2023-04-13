/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/admin/js/myscript.js":
/*!**********************************!*\
  !*** ./src/admin/js/myscript.js ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_mystyle_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/mystyle.scss */ "./src/admin/scss/mystyle.scss");

window.addEventListener("DOMContentLoaded", function () {
  // store tabs variables
  // const tabs = document.querySelectorAll("ul.nav-tabs>li");
  // tabs.forEach((tab) => {
  //   tab.addEventListener("click", function (e) {
  //     e.preventDefault();
  //     tabs.forEach((tabb) => tabb.classList.remove("active"));
  //     tab.classList.add("active");
  //     const target = e.target;
  //     const targetPaneID = target.getAttribute('href');
  //   });
  // });

  const navTabContainer = document.querySelector(".nav.nav-tabs");
  navTabContainer.addEventListener("click", function (e) {
    e.preventDefault();
    const target = e.target.closest("li");
    if (!target) return;
    const targetPaneID = target.firstElementChild.getAttribute("href");
    const navTabs = document.querySelectorAll(".nav.nav-tabs > li");
    navTabs.forEach(navTab => navTab.classList.remove("active"));
    const tabs = document.querySelectorAll(".tab-pane");
    tabs.forEach(tab => tab.classList.remove("active"));
    const clickedTab = document.querySelector(targetPaneID);
    target.classList.add("active");
    clickedTab.classList.add("active");
  });
});

/***/ }),

/***/ "./src/admin/scss/mystyle.scss":
/*!*************************************!*\
  !*** ./src/admin/scss/mystyle.scss ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************************!*\
  !*** ./src/admin/adminscript.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_myscript_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/myscript.js */ "./src/admin/js/myscript.js");
/* harmony import */ var _admin_scss_mystyle_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../admin/scss/mystyle.scss */ "./src/admin/scss/mystyle.scss");


}();
/******/ })()
;
//# sourceMappingURL=adminscript.js.map