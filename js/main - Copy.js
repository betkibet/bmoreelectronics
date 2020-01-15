$(document).ready(function(){
	
	$(".scroll_top").click(function() {

		 $("html, body").animate({ scrollTop: 0 }, "slow");

		 return false;

	  });


	
	
	  $(window).scroll(function(){
		var sticky = $('#header'),
		  scroll = $(window).scrollTop();
		if (scroll >= 100) {
		  sticky.addClass('fixed');
		  //$('body').addClass('bodymargin');
		} else {
		  sticky.removeClass('fixed');
		 // $('body').removeClass('bodymargin');
		}
	  });
	  
	$(".ico-search ").click(function(){
		$(".searchfield").slideToggle();
	});
	
	$(".menuicon").click(function(){
		$("#nav").toggleClass("active-nav");
		$("#wrapper").toggleClass("active");
		$("#nav").after('<span id="overlybody"></span>');
		
	});
	
	/*$(".myaccount").hover(function(){
		$(".adroupdown").toggle(0);
	});*/
	
	$("#nav ul li.submenu > a").click(function(){
		$(this).toggleClass("active");
		$(this).next('ul').toggleClass("active");
		
	});
	
	$(".closebtn").click(function(){
		$("#overlybody").remove();
	});
	
	
	/* Sale Review page start*/
	
	$(".description_link").click(function(){
		$(".more_discript_box").toggleClass("active");
		$(this).toggleClass("active");
	});
	
	
	$(".bank_transfer_head").click(function(){
		$(this).toggleClass("active");
		$(".paypal_head").removeClass("active");
		$(".cheque_head").removeClass("active");
	});
	
	$(".paypal_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".cheque_head").removeClass("active");
	});
	
	$(".cheque_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".paypal_head").removeClass("active");
	});
	
	
	$(".paypal_head").click(function(){
		$('.paypal_detail').addClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".cheque_detail").removeClass("active");
	});
	
	$(".bank_transfer_head").click(function(){
		$('.bank_transfer_detail').toggleClass("active");
		$(".paypal_detail").removeClass("active");
		$(".cheque_detail").removeClass("active");
	});
	
	
	
	$(".cheque_head").click(function(){
		$('.cheque_detail').addClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".paypal_detail").removeClass("active");
	});
	
	
	
	$(".bank_transfer_head.active").click(function(){
		$('.bank_transfer_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".paypal_head.active").click(function(){
		$('.paypal_detail').addClass("active");
		$(this).addClass("active");
	});
	
	
	$(".cheque_head.active").click(function(){
		$('.cheque_detail').addClass("active");
		$(this).addClass("active");
	});
	
	
	/* Sale Review page end*/
	
	
	
	
	$('#user_profile_sec').each(function(){       
      // Cache the highest
      var highestBox = 0;     
      // Select and loop the elements you want to equalise
      $('.ecolumn', this).each(function(){       
        // If this box is higher than the cached highest then store it
        if($(this).height() > highestBox) {
          highestBox = $(this).height(); 
        }    
      });             
      // Set the height of all those children to whichever was highest 
      $('.ecolumn',this).height(highestBox);                   
    }); 

	
	
	
	
	$(window).resize(function(){
		if ( $(window).width() > 1024) {
			$("#nav").width(490);
			$("#overlybody").remove();
			
		}
		else {
			$("#nav").width(0);
		}
	});
	
	

  
  
   // Slideshow 2
      $("#slider").responsiveSlides({
        auto: true,
        pager: true,
        speed: 300
        //maxwidth: 540
      });
	  
	  
	  $(".scroll_top").on("click", function() {
			$("body").scrollTop(0);
		});
  
	  
	
	
	  $('#review_slider, #findmodal_slider, #whychooseus_slider, #sellbrand_slider').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
			responsive: {
			  0: {
				items: 1,
				nav: true,
				loop: false
			  },
			  600: {
				items: 2,
				nav: true,
				loop: false
			  },
			  1000: {
				items: 3,
				nav: true,
				loop: false,
				margin: 20
			  }
			}
		  });
 	
          
			$('#howitwork_slider').owlCarousel({
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20,
					
                  }
                }
              });
			  
			  
			  
			  $('#device_slider').owlCarousel({
                responsive: {
                  0: {
                    items: 2,
                    nav: true
                  },
                  600: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 0,
					
                  }
                }
              });
			  
			  
			  
			  $('#browsecategory_slider').owlCarousel({
                responsive: {
                  0: {
                    items: 2,
                    nav: true
                  },
                  600: {
                    items: 4,
                    nav: false
                  },
                  1000: {
                    items: 5,
                    nav: true,
                    loop: false,
                    margin: 0,
					
                  }
                }
              });
		  
		
  
  
			  if ( $(window).width() < 768) {
				
				  
				$('#selectbrand_slider').addClass('owl-carousel');
			  
				$('#selectbrand_slider').owlCarousel({
					responsive: {
					  0: {
						items: 1,
						nav: true
					  },
					  600: {
						items: 2,
						nav: true
					  }
					}
				  });
			  
			  }
			  
			  
			  /*accordion*/
			  $( function() {
				$( "#accordion" ).accordion({
				  heightStyle: "content"
				});
				
			  } );
			  
			    

			  

			  
			  $('.closebtn').click(
				function(){
					$('input.searchbox:text').val('');
				});
			  
			  
			  
			
  
});



$( function() {
var list_of_model = [
{value:'Apple', url:'http://apple.com'},
{value:'iPhone', url:'http://apple.com'},
{value:'Android', url:'http://apple.com'},
{value:'ipad', url:'http://apple.com'},
{value:'iPhone6s', url:'http://apple.com'},
{value:'Autocomplete', url:'http://autocomplete.com'},
{value:'1234567890', url:'http://123.com'},
{value:'iPhone7', url:'http://apple.com'},
];
		$('.srch_list_of_model').autocomplete({
			lookup: list_of_model,
			onSelect: function (suggestion) {
			  window.location.href = suggestion.url;
			}
		});
} );

