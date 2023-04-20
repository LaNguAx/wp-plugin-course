/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/user/js/form.js":
/*!*****************************!*\
  !*** ./src/user/js/form.js ***!
  \*****************************/
/***/ (function() {

window.addEventListener("DOMContentLoaded", function (e) {
  const testimonialForm = document.querySelector("#itay-testimonial-form");
  testimonialForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // reset the form messages
    resetMessages();

    // collect all the data of the form
    let data = {
      name: testimonialForm.querySelector("#name").value.replaceAll(" ", ""),
      email: testimonialForm.querySelector("#email").value.replaceAll(" ", ""),
      message: testimonialForm.querySelector("#message").value
    };
    // validate the fields
    if (!data.name) {
      testimonialForm.querySelector('[data-error="invalidName"]').classList.add("show");
      return;
    }
    let params = new FormData(testimonialForm);
    const url = testimonialForm.dataset.url;
    console.log(url);
  });
});
function resetMessages() {
  document.querySelectorAll(".field-msg").forEach(element => element.classList.remove("show"));
}

/***/ }),

/***/ "./src/user/scss/userstyle.scss":
/*!**************************************!*\
  !*** ./src/user/scss/userstyle.scss ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!*******************************!*\
  !*** ./src/user/userstyle.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_form_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/form.js */ "./src/user/js/form.js");
/* harmony import */ var _js_form_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_js_form_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _scss_userstyle_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scss/userstyle.scss */ "./src/user/scss/userstyle.scss");


}();
/******/ })()
;
//# sourceMappingURL=userstyle.js.map