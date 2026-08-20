import Alpine from "alpinejs";
import feather from "feather-icons";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

window.Alpine = Alpine;
window.feather = feather;
window.Toastify = Toastify;

window.showToast = function(message, type = "success") {
    let background = "linear-gradient(135deg, #10b981 0%, #059669 100%)";
    let icon = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';

    if (type === "error") {
        background = "linear-gradient(135deg, #ef4444 0%, #dc2626 100%)";
        icon = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    } else if (type === "warning") {
        background = "linear-gradient(135deg, #f59e0b 0%, #d97706 100%)";
        icon = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
    } else if (type === "info") {
        background = "linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)";
        icon = '<svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    }

    Toastify({
        text: message,
        escapeMarkup: false,
        duration: 4000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: background,
            borderRadius: "0.75rem",
            fontSize: "0.875rem",
            fontWeight: "600",
            padding: "12px 18px",
            boxShadow: "0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.1)"
        }
    }).showToast();
};

document.addEventListener("DOMContentLoaded", () => {
    feather.replace();
});

window.addEventListener("feather:replace", () => {
    feather.replace();
});

Alpine.start();

