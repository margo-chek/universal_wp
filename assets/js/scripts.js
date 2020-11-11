var mySwiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,

  autoplay: {
    delay: 5000,
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
//   navigation: {
//     nextEl: '.swiper-button-next',
//     prevEl: '.swiper-button-prev',
//   },
})

let menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function(event) {
  event.preventDefault();
  $('.header-nav').slideToggle(200);
})
