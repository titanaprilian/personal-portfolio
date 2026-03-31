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

document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {
        on: localStorage.getItem('darkMode') === 'true' ||
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggle() {
            this.on = !this.on;
            localStorage.setItem('darkMode', this.on);
            document.documentElement.classList.toggle('dark', this.on);
        },
        init() {
            document.documentElement.classList.toggle('dark', this.on);
        }
    });
});

window.contactForm = function (initialMessage = '') {
    return {
        message: initialMessage,
        submitting: false,
    };
};

Alpine.start();
