!function(n){function t(o){if(e[o])return e[o].exports;var r=e[o]={i:o,l:!1,exports:{}};return n[o].call(r.exports,r,r.exports,t),r.l=!0,r.exports}var e={};t.m=n,t.c=e,t.d=function(n,e,o){t.o(n,e)||Object.defineProperty(n,e,{configurable:!1,enumerable:!0,get:o})},t.n=function(n){var e=n&&n.__esModule?function(){return n.default}:function(){return n};return t.d(e,"a",e),e},t.o=function(n,t){return Object.prototype.hasOwnProperty.call(n,t)},t.p="/build/",t(t.s="SGwB")}({SGwB:/*!*********************************!*\
  !*** ./web/assets/js/vendor.js ***!
  \*********************************/
/*! no static exports found */
/*! all exports used */
function(n,t,e){e(/*! offline-plugin/runtime */"t8iB").install()},t8iB:/*!************************************************!*\
  !*** ./node_modules/offline-plugin/runtime.js ***!
  \************************************************/
/*! no static exports found */
/*! all exports used */
function(n,t){function e(){return"serviceWorker"in navigator&&(window.fetch||"imageRendering"in document.documentElement.style)&&("https:"===window.location.protocol||"localhost"===window.location.hostname||0===window.location.hostname.indexOf("127."))}function o(n){if(n||(n={}),e()){navigator.serviceWorker.register("/sw.js",{scope:"/"})}else;}function r(n,t){}function i(){e()&&navigator.serviceWorker.getRegistration().then(function(n){if(n)return n.update()})}t.install=o,t.applyUpdate=r,t.update=i}});