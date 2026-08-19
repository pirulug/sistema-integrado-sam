import Alpine from 'alpinejs';
import feather from 'feather-icons';

window.Alpine = Alpine;
window.feather = feather;

document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
});

window.addEventListener('feather:replace', () => {
    feather.replace();
});

Alpine.start();
