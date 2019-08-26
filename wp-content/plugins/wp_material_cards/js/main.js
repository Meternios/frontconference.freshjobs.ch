jQuery(document).ready(
    function ( $ ) {
		let currentIndex = 0;
		const cardPerIndex = $('.material_cards-container > .material-card');
		let waitHandler = [];
		const funCardColors = [ '#BF2222', '#D0A40C', '#98CA0C' ];

		// generate random color foreach fun card
		$('.fun-card').each(
			function () {
				$(this).css('background-color', funCardColors[ Math.floor(Math.random() * 3) + 0 ]);
			} 
		);

		// Start Animation
		flyCardInRight();

		// Start Intervall
		waitHandler[ 3 ] = setInterval(
			function () {
				flyCardInRight();
			}, 8100 
		);

		//Animation functions
		function flyCardInRight()
		{
			cardPerIndex.eq(currentIndex).addClass('material_cards-flyInRight');
			waitHandler[ 1 ] = setTimeout(flyCardOutLeft, 7000);
		}

		function flyCardOutLeft()
		{
			cardPerIndex.eq(currentIndex).addClass('material_cards-flyOutLeft');
			waitHandler[ 2 ] = setTimeout(resetAnimationAndIncrease, 1000);
		}

		function flyCardInLeft()
		{
			cardPerIndex.eq(currentIndex).addClass('material_cards-flyInLeft');
			waitHandler[ 1 ] = setTimeout(flyCardOutLeft, 7000);
		}

		function flyCardOutRight()
		{
			cardPerIndex.eq(currentIndex).addClass('material_cards-flyOutRight');
			waitHandler[ 2 ] = setTimeout(resetAnimationAndDecrease, 1000);
		}

		function resetAnimationAndIncrease()
		{
			cardPerIndex.eq(currentIndex).removeClass('material_cards-flyInLeft material_cards-flyOutRight material_cards-flyInRight material_cards-flyOutLeft');
			currentIndex++;
			if (currentIndex >= $('.material_cards-container > .material-card').length ) {
				currentIndex = 0;
			}
		}

		function resetAnimationAndDecrease()
		{
			cardPerIndex.eq(currentIndex).removeClass('material_cards-flyInRight material_cards-flyOutLeft material_cards-flyInLeft material_cards-flyOutRight');
			if (currentIndex <= 0 ) {
				currentIndex = $('.material_cards-container > .material-card').length;
			}
			currentIndex--;
		}

		// Swipe Motion
		let start = null;
		$('.material_cards-container').on(
			'touchstart', function () {
				if (event.touches.length === 1 ) {
					// just one finger touched
					start = event.touches.item(0).clientX;
				} else {
					// a second finger hit the screen, abort the touch
					start = null;
				}
			} 
		);

		$('.material_cards-container').on(
			'touchend', function () {
				const offset = 100; //at least 100px are a swipe
				if (start ) {
					// the only finger that hit the screen left it
					const end = event.changedTouches.item(0).clientX;

					if (end > start + offset ) {
							// a left -> right swipe
							waitHandler.forEach(clearTimeout);
							flyCardOutRight();
						setTimeout(
							function () {
								flyCardInLeft();
								waitHandler[ 3 ] = setInterval(
									function () {
										flyCardInRight();
									}, 8100 
								);
							}, 1000 
						);
					}
					if (end < start - offset ) {
						//a right -> left swipe
						waitHandler.forEach(clearTimeout);
						flyCardOutLeft();
						setTimeout(
							function () {
								flyCardInRight();
								waitHandler[ 3 ] = setInterval(
									function () {
										flyCardInRight();
									}, 8100 
								);
							}, 1000 
						);
					}
				}
			} 
		);
    } 
);
