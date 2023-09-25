/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const tokenElement = document.head.querySelector('meta[name="csrf-token"]');

if (tokenElement) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = tokenElement.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

/**
 * Next we will create base url as a global constant so that
 * we can access base url in javascript files.
 */

const baseUrlElement = document.head.querySelector('meta[name="base-url"]');

if (baseUrlElement) {
    window.baseURL = baseUrlElement.content;
}
