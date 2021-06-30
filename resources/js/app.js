/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

/**
 * A small and simple free dependency to add helpers I daily used in vue js
 * https://www.npmjs.com/package/dw-js-helpers
 */
const jsHelpers = require("dw-js-helpers");
jsHelpers.vueMix.bindInit();
jsHelpers.vueMix.setup();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "PaginationLinks",
    require("./components/PaginationLinks.vue").default
);
