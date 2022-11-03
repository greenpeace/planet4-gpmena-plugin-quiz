( function( $ ) {
    
       
        class SlickCarousel {
            
            constructor() {
                this.initiateCarousel();        
            }
            
            initiateCarousel() {
                console.log(window.innerWidth)
            $(".posts-carousel").slick({
                autoplay: false,
                autoplaySpeed: 1000,
                slidesToShow: window.innerWidth <= 600 ? 1 : 3,
                slidesToScroll: 1,
                infinite: false
            } );
        }
    }

new SlickCarousel();    

} )( jQuery );
