 $('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
  });

  $('.carousel.carousel-multi-item.v-2 .carousel-item').each(function(){
	var next = $(this).next();
	if (!next.length) {
		next = $(this).siblings(':first');
	}
	next.children(':first-child').clone().appendTo($(this));

	for (var i=0;i<3;i++) {
		next=next.next();
	if (!next.length) {
	  	next = $(this).siblings(':first');
	}
		next.children(':first-child').clone().appendTo($(this));
	}
});

$(document).ready(function() {
  	var owl = $("#carousel");
 
	owl.owlCarousel({
	  autoplay: false,
	  rewind: false, /* use rewind if you don't want loop */
	  margin: 20,
	   /*
	  animateOut: 'fadeOut',
	  animateIn: 'fadeIn',
	  */
	  responsiveClass: true,
	  autoHeight: true,
	  autoplayTimeout: 7000,
	  smartSpeed: 800,
	  nav: true,
	  animateIn: 'fadeIn',
		animateOut: 'fadeOut',
	  transitionStyle:"fade",
    singleItem: true,
    center:true,
	  dots: false,
	  loop:true,
	  responsive: {
	    0: {
	      items: 1
	    },

	    600: {
	      items: 3
	    },

	    1024: {
	      items: 4
	    },

	    1366: {
	      items: 4
	    }
	  }
	});


 $(".next").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev").click(function(){
    owl.trigger('owl.prev');
  })



var owl = $("#carouselthree");
 
	owl.owlCarousel({
	  autoplay: false,
	  rewind: false, /* use rewind if you don't want loop */
	  margin: 20,
	   /*
	  animateOut: 'fadeOut',
	  animateIn: 'fadeIn',
	  */
	  responsiveClass: true,
	  autoHeight: true,
	  autoplayTimeout: 7000,
	  smartSpeed: 800,
	  nav: true,
	  animateIn: 'fadeIn',
		animateOut: 'fadeOut',
	  transitionStyle:"fade",
    singleItem: true,
    center:true,
	  dots: false,
	  loop:true,
	  responsive: {
	    0: {
	      items: 1
	    },

	    600: {
	      items: 3
	    },

	    1024: {
	      items: 4
	    },

	    1366: {
	      items: 4
	    }
	  }
	});


 $(".next").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev").click(function(){
    owl.trigger('owl.prev');
  })




  	var owl = $("#carouseltwo");
 
	owl.owlCarousel({
	  autoplay: false,
	  rewind: false, /* use rewind if you don't want loop */
	  margin: 20,
	   /*
	  animateOut: 'fadeOut',
	  animateIn: 'fadeIn',
	  */
	  responsiveClass: true,
	  autoHeight: true,
	  autoplayTimeout: 7000,
	  smartSpeed: 800,
	  nav: true,
	  animateIn: 'fadeIn',
		animateOut: 'fadeOut',
	  transitionStyle:"fade",
    singleItem: true,
    center:true,
	  dots: false,
	  loop:true,
	  responsive: {
	    0: {
	      items: 1
	    },

	    600: {
	      items: 4
	    },

	    1024: {
	      items: 5
	    },

	    1366: {
	      items: 5
	    }
	  }
	});


 $(".next").click(function(){
    owl.trigger('owl.next');
  })
  $(".prev").click(function(){
    owl.trigger('owl.prev');
  })
});

