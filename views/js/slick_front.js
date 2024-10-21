$(document).ready(function(){
    var sliderConfig = {
        slidesToShow: slickConfig.slidesToShow,
        slidesToScroll: slickConfig.slidesToScroll,
        mobileFirst: true,
        dots: slickConfig.showDots,
        arrows: slickConfig.showArrow,
        rows: 0,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: slickConfig.slidesToShow,
                    slidesToScroll: slickConfig.slidesToScroll,
                    dots: slickConfig.showDots,
                    arrows: slickConfig.showArrow,
                }
            },
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: slickConfig.showDots,
                    arrows: slickConfig.showArrow,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: slickConfig.showDots,
                    arrows: slickConfig.showArrow,
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: slickConfig.showDots,
                    arrows: slickConfig.showArrow
                }
            }
        ]
    };

    $('.products-slick').slick(sliderConfig);
});
