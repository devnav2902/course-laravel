(function ($) {
  $(".latest-courses .list-courses").slick(
    slide(".latest-courses .btnLeft", ".latest-courses .btnRight")
  );

  $(".featured_course .list-courses").slick(
    slide(".featured_course .btnLeft", ".featured_course .btnRight")
  );
  $(".bestseller_course .list-courses").slick(
    slide(".bestseller_course .btnLeft", ".bestseller_course .btnRight")
  );

  $(".authors .author-box").slick({
    infinite: true,
    slidesToShow: 5,
    arrows: true,
    slidesToScroll: 1,
    prevArrow: $(".authors .btnLeft"),
    nextArrow: $(".authors .btnRight"),
  });
})(jQuery);

function slide(btnLeft, btnRight) {
  return {
    // dots: true,
    infinite: false,
    speed: 300,
    arrows: true,
    prevArrow: $(btnLeft),
    nextArrow: $(btnRight),
    slidesToShow: 5,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ],
  };
}
