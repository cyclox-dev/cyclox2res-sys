/*==============================
Page Top
==============================*/
$(function(){
	$(".pagetop a").click(function(){
	$('html,body').animate({ scrollTop: $($(this).attr("href")).offset().top }, '300','swing');
	return false;
	})
});

/*==============================
MouseOver
==============================*/
$(function(){
	$('a.mo img').hover(function(){
        $(this).attr('src', $(this).attr('src').replace('_off', '_on'));
		}, function(){
        	if (!$(this).hasClass('currentPage')) {
        	$(this).attr('src', $(this).attr('src').replace('_on', '_off'));
        }
   });
});

/*==============================
LinkOut
==============================*/
$(function(){
	$("a.out").attr("target","_blank");
});