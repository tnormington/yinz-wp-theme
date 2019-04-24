import $ from 'jquery'
import 'slick-carousel'

const $heroSliderRoot = $('#hero-slider-root');

if ($heroSliderRoot) {
  $heroSliderRoot.slick({
    autoplay: true,

  });
}