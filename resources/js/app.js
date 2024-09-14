import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
import Swiper from 'swiper';
import { Autoplay, EffectCards } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-cards';

// Initialize Swiper
new Swiper('.swiper-container', {
    modules: [EffectCards],
    effect: 'cards',
    grabCursor: true,
});
