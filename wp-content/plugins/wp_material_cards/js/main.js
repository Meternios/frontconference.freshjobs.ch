jQuery(document).ready( function($) {
    var currentIndex = 0;
    var cardPerIndex = $('.material_cards-container > .material-card');
    var waitHandler = [];

    flyCardInRight();

    function flyCardInRight() {
        cardPerIndex.eq(currentIndex).addClass('material_cards-flyInRight');
        waitHandler[1] = setTimeout(flyCardOutLeft, 7000);
    }

    function flyCardOutLeft() {
        cardPerIndex.eq(currentIndex).addClass('material_cards-flyOutLeft');
        waitHandler[2] = setTimeout(resetAnimationAndIncrease, 1000);
    }

    function flyCardInLeft() {
        cardPerIndex.eq(currentIndex).addClass('material_cards-flyInLeft');
        waitHandler[1] = setTimeout(flyCardOutLeft, 7000);
    }

    function flyCardOutRight() {
        cardPerIndex.eq(currentIndex).addClass('material_cards-flyOutRight');
        waitHandler[2] = setTimeout(resetAnimationAndDecrease, 1000);
    }

    function resetAnimationAndIncrease() {
        cardPerIndex.eq(currentIndex).removeClass('material_cards-flyInLeft material_cards-flyOutRight material_cards-flyInRight material_cards-flyOutLeft');
        currentIndex++;
        if( currentIndex >= $('.material_cards-container > .material-card').length ) {
            currentIndex = 0;
        }
    }

    function resetAnimationAndDecrease() {
        cardPerIndex.eq(currentIndex).removeClass('material_cards-flyInRight material_cards-flyOutLeft material_cards-flyInLeft material_cards-flyOutRight');
        if( currentIndex <= 0 ){
            currentIndex = $('.material_cards-container > .material-card').length;
        }
        currentIndex--;
    }

    waitHandler[3] = setInterval( function () {
        flyCardInRight();
    }, 10000);

    var start = null;
    $('.material_cards-container').on( 'touchstart',function() {
      if( event.touches.length === 1 ){
         // just one finger touched
         start = event.touches.item(0).clientX;
       }else{
         // a second finger hit the screen, abort the touch
         start = null;
       }
    });

    $('.material_cards-container').on( 'touchend',function() {
        var offset = 100; //at least 100px are a swipe
        if(start){
          // the only finger that hit the screen left it
          var end = event.changedTouches.item(0).clientX;
    
          if( end > start + offset ){
            // a left -> right swipe
            waitHandler.forEach( clearTimeout );
            flyCardOutRight();
            setTimeout( flyCardInLeft, 1000 );

            waitHandler[3] = setInterval( function () {
                flyCardInRight();
            }, 10000);
          }
          if( end < start - offset ) {
               //a right -> left swipe
               waitHandler.forEach( clearTimeout );
            flyCardOutLeft();
            setTimeout( flyCardInRight, 1000 );

            waitHandler[3] = setInterval( function () {
                flyCardInRight();
            }, 10000);
          }
        }
    });
});