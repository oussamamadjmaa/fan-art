$(function(){
    if($("#heroSlider").length){
        $('#heroSlider').owlCarousel({
            rtl:GLOBAL['IS_RTL'],
            loop:true,
            items:1,
            autoplay:true,
            autoplayTimeout:4500,
            animateOut: 'fadeOut',
            autoplayHoverPause: true
        })
    }


    if($("#artistsSlider").length){
        $('#artistsSlider').owlCarousel({
            rtl:GLOBAL['IS_RTL'],
            loop:false,
            dots:false,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                500:{
                    items:3
                },
                768:{
                    items:4
                },
                1000:{
                    items:6
                },
                1600:{
                    items:8
                }
            }
        })
    }

    if($("#storesSlider").length){
        $('#storesSlider').owlCarousel({
            rtl:GLOBAL['IS_RTL'],
            loop:false,
            dots:false,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                500:{
                    items:3
                },
                768:{
                    items:4
                },
                1000:{
                    items:6
                },
                1600:{
                    items:8
                }
            }
        })
    }

    if($('.countdown-timer').length){
        // Update the count down every 1 second
        var x = setInterval(function() {
        if($('.countdown-timer').length == 0) clearInterval(x);
        $(".countdown-timer").each(function(i){

            var date = $(this).data('date');
            // Set the date we're counting down to
            var countDownDate = new Date(date).getTime();

            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;


            if(distance < 0){
                $(this).removeClass('countdown-timer');
                days = hours = minutes = seconds = 0;
            }else{
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            }
            var old_days = $(this).find('.days').text();var old_hours = $(this).find('.hours').text();var old_minutes = $(this).find('.minutes').text();var old_seconds = $(this).find('.seconds').text();
            // If the count down is finished, write some text
            if(old_days != days) $(this).find('.days').text(days);
            if(old_hours != hours) $(this).find('.hours').text(hours);
            if(old_minutes != minutes) $(this).find('.minutes').text(minutes);
            if(old_seconds != seconds) $(this).find('.seconds').text(seconds);
        })
        }, 1000);
    }
})
