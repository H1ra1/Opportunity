/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/gutenberg.js":
/*!**************************!*\
  !*** ./src/gutenberg.js ***!
  \**************************/
/***/ (() => {

eval("/**\r\n * WordPress Dependencies\r\n */\nvar $ = window.jQuery;\nvar GutenbergIntegration = {\n  init: function init() {\n    var self = this;\n    wp.data.subscribe(function () {\n      setTimeout(function () {\n        self.addButtons();\n      }, 100);\n    });\n  },\n  addButtons: function addButtons() {\n    var _document$getElementB;\n    var buttonWrapperMarkup = (_document$getElementB = document.getElementById(\"zionbuilder-gutenberg-panel\")) === null || _document$getElementB === void 0 ? void 0 : _document$getElementB.innerHTML;\n    var editorHeader = document.querySelector(\".edit-post-header-toolbar\");\n    if (editorHeader && !editorHeader.querySelector(\".zn_pb_buttons\")) {\n      editorHeader.insertAdjacentHTML(\"beforeend\", buttonWrapperMarkup);\n    }\n  }\n};\nGutenbergIntegration.init();\n\n//# sourceURL=webpack://zion-builder/./src/gutenberg.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/gutenberg.js"]();
/******/ 	
/******/ })()
;