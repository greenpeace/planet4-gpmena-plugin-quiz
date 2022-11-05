( function( $ ) {
    
       
        class SlickCarousel {
            
            constructor() {
                this.initiateCarousel();        
            }
            
            initiateCarousel() {
                var slidesToShow=3;
                var slidesToScroll=3;
                if (window.matchMedia('screen and (max-width: 600px)').matches) {
                    slidesToShow = 1
                    slidesToScroll = 1
                }else{
                    slidesToShow = 3
                    slidesToScroll = 3
                }
                console.log(slidesToShow)

            $(".posts-carousel").slick({
                autoplay: false,
                autoplaySpeed: 1000,
                slidesToShow: slidesToShow,
                slidesToScroll: slidesToScroll,
                infinite: false
            } );
        }
    }

new SlickCarousel();    

} )( jQuery );
