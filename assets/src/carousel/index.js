( function( $ ) {
    
       
        class SlickCarousel {
            
            constructor() {
                this.initiateCarousel();        
            }
            
            initiateCarousel() {
            $(".posts-carousel").not('.slick-initialized').slick( {
                autoplay: false,
                autoplaySpeed: 1000,
                slidesToShow: screen.width <= 600 ? 1 : 3,
                slidesToScroll: 1,
                infinite: false
            } );
        }
    }

new SlickCarousel();    

} )( jQuery );
