import "./bootstrap";

import "./icon-picker";
import "./charts";
import "./blog";
import "./about";

import Quill from "quill";
import "quill/dist/quill.snow.css";
window.Quill = Quill;

import Alpine from "alpinejs";
window.Alpine = Alpine;

window.contactForm = function (initialMessage = '') {
    return {
        message: initialMessage,
        submitting: false,
    };
};

Alpine.start();
