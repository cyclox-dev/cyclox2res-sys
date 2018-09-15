
/*==============================
Box List
==============================*/
	if (window.matchMedia('(min-width: 800px)').matches) {
$(function($) {

//	var timer = false;
//	var prewidth = $(window).width();
//	$(window).resize(function() {
//		if (timer !== false) {
//			clearTimeout(timer);
//		}
//		timer = setTimeout(function() {
//			var nowWidth = $(window).width();
//			if(prewidth !== nowWidth){
//				location.reload();
//			}
//			prewidth = nowWidth;
//		}, 100);
//	});

	$(document).ready(function() {
		$('.tile_box_entryinfo').tile(3);
		$('.tile_box_abuot').tile(4);
		$('.tile_box_news').tile(4);
		$('.tile_box_partnerinfo_outer').tile(4);
		$('.tile_box_partnerinfo').tile(4);
		$('.tile_box_topics').tile(4);
	});

});
	}

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

/*==============================
News : Entry : Result
==============================*/
$(function(){
	$(".entry-result > ol > li:nth-child(odd)").attr("class","odd");
});

/*==============================
Smooth Scroll
==============================*/
$(function(){
   $('a[href^="#"]').click(function() {
      var speed = 400; // ミリ秒
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});



/*==============================
for SmartPhone : Hide Addressbar
==============================*/
function hideAddBar(){
	setTimeout("scrollTo(0, 1)", 1);
}
(function(){
	$(window).bind('load', function() {
		hideAddBar();
	}).bind('orientationchange', function() {
		hideAddBar();
	});
});

/*==============================
MENU
==============================*/
$(function($) {
	$(document).ready(function() {


		$('#headerMenu').click(function(){ 
			$('#headerMenuMain').animate({height:'toggle'} , 'slow');
			$(window).resize(function(){
				var w = $(window).width();
				var x = 800;
				if (w > x) {
					$('#headerMenuMain').css({'display':'block'});
				} else {
					$('#headerMenuMain').css({'display':'none'});
				}
			});
		});
		

		$('li.rankings').click(function(){ 
			$('li.rankings ul').animate({height:'toggle'} , 'slow');
			$(this).toggleClass('subOpen_sp');
			$('#hdr').toggleClass('subOpen')
		});
		
		
		$(function(){
			$('.sp-rankings a').click(function(){ 
				$('#headerMenuMain').animate({height:'hide'} , 'slow');
				$(window).resize(function(){
					var w = $(window).width();
					var x = 800;
					if (w > x) {
						$('#headerMenuMain').css({'display':'block'});
					} else {
						$('#headerMenuMain').css({'display':'none'});
					}
				});
			});
		});

	});
});


/*----------------------------------------------------
for SmartPhone : Navi
----------------------------------------------------*/
$(function() {
    $(window).scroll(function(){
        var scrollTop = $(window).scrollTop();
        if(scrollTop != 0)
          $('#headerMenuMain').addClass('fix'); //スクロール時
      });
 });
 

/*============================================================
■サイドバー共通Topics
============================================================*/
function SideTopicsListItem(){
document.write('<div id="topics">');
document.write('<h2 class="topics-title">TOPICS</h2>');
document.write('<div class="topics-list"><div class="topics-list-inr clearfix">');
document.write('<div class="topics-list-item tile_box_topics"><div class="topics-list-item-inr"><div class="topics-date">2018.04.01</div><h3 class="topics-entry"><a href="http://www.cyclocross.jp/news/2018/04/2018-2019calendar.html">2018-2019シーズン カレンダー公開</a></h3></div></div>');
document.write('<div class="topics-list-item tile_box_topics"><div class="topics-list-item-inr"><div class="topics-date">2018.01.24</div><h3 class="topics-entry"><a href="http://www.cyclocross.jp/news/2018/01/WK01.html">世界選手権に向けて日本代表選手団が出発しました</a></h3></div></div>');
document.write('<div class="topics-list-item tile_box_topics"><div class="topics-list-item-inr"><div class="topics-date">2017.11.15</div><h3 class="topics-entry"><a href="http://www.cyclocross.jp/news/2017/11/23rd-CN.html">第23回 シクロクロス全日本選手権大会 要項</a></h3></div></div>');
document.write('<div class="topics-list-item tile_box_topics"><div class="topics-list-item-inr"><div class="topics-date">2017.11.06</div><h3 class="topics-entry"><a href="http://www.cyclocross.jp/news/2017/11/2018-jcf.html">2018年（平成30年） JCF競技者登録について</a></h3></div></div>');
document.write('<div class="topics-list-item tile_box_topics"><div class="topics-list-item-inr"><div class="topics-date">2017.04.01</div><h3 class="topics-entry"><a href="http://www.cyclocross.jp/news/2018/04/2018-2019calendar.html">2018-2019シーズン カレンダー公開</a></h3></div></div>');
document.write('<div class="topics-list-item tile_box_topics"><div class="topics-list-item-inr"><div class="topics-date">2017.04.01</div><h3 class="topics-entry"><a href="http://www.cyclocross.jp/news/2018/04/2018-2019calendar.html">2018-2019シーズン カレンダー公開</a></h3></div></div>');
document.write('</div></div></div>');
}

/*============================================================
■サイドバー共通Partners
============================================================*/
function SidePartnersListItem(){
document.write('<div class="partners">');
document.write('<h2 class="partners-title"><a href="http://www.cyclocross.jp/partners/">OFFICIAL AJOCC PARTNERS</a></h2>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<ul class="partners-list clearfix">');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">Santa Cruz Bicycles</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2017/santa-cruz-bicycles.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2017/11/thumb-thumb-320x240-5831.jpg" alt="Santa Cruz Bicycles -Stigmata-" /></span>');
document.write('');
document.write('<span class="entry-title">Santa Cruz Bicycles -Stigmata-</span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#santa_cruz_bicycles"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">東京サンエス</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2017/tsss2017.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2017/10/thumb-thumb-320x240-5176.jpg" alt="「辻浦！池本！丸山！の本気のシクロクロス合宿」レポート" /></span>');
document.write('');
document.write('<span class="entry-title">「辻浦！池本！丸山！の本気のシクロクロス合宿」レポート</span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#tsss"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">Canyon</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2017/canyon02.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2017/08/thumb02-thumb-320x214-4902.jpg" alt="Canyon 新型カーボンシクロクロス INFLITE（インフライト）CF SLX発表会 in ベルギー" /></span>');
document.write('');
document.write('<span class="entry-title">Canyon 新型カーボンシクロクロス INFLITE（インフライト）CF SLX発表会 in ベルギー</span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#canyon"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">Champion System Japan</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2017/championsystem03.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2017/03/pic03-thumb-960x640-4890.jpg" alt="ウェアは機材― チャンピオンシステムの豊富なアイテムでシクロクロスシーズンを走る ―" /></span>');
document.write('');
document.write('<span class="entry-title">ウェアは機材<span class="sub">― チャンピオンシステムの豊富なアイテムでシクロクロスシーズンを走る ―</span></span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#champion_system_japan"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">IRC</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2016/irc02.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2016/12/pic02-thumb-960x640-4197.jpg" alt="クロスガード (X-Guard) で走りのバリエーションが広がる" /></span>');
document.write('');
document.write('<span class="entry-title">クロスガード (X-Guard) で走りのバリエーションが広がる</span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#irc"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">TREK</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2016/trek03.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2016/11/pic01-thumb-960x696-3868.jpg" alt="TREKが開く多様なフィールドへの扉" /></span>');
document.write('');
document.write('<span class="entry-title">TREKが開く多様なフィールドへの扉</span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#trek"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('');
document.write('<li>');
document.write('<span class="p_name">Rapha</span>');
document.write('<span class="p_entry">');
document.write('<a href="http://www.cyclocross.jp/partners/2015/rapha01.html" class="clear-fix">');
document.write('');
document.write('<span class="entry-pic"><img src="http://www.cyclocross.jp/assets_c/2017/09/thumb-thumb-320x213-4927.jpg" alt="Raphaとシクロクロス" /></span>');
document.write('');
document.write('<span class="entry-title">Raphaとシクロクロス</span>');
document.write('</a>');
document.write('</span>');
document.write('<span class="p_intro"><a href="/partners/#rapha"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Other Stories</a></span>');
document.write('</li>');
document.write('');
document.write('');
document.write('</ul>');
document.write('');
document.write('</div>');
}


/*================================================

Banner

================================================*/
$(document).ready(function(){
	$('.owl-carousel').owlCarousel({
		items: 10,
		autoplay: true,
		autoplayTimeout: 4000,
		loop: true,
		nav: false,
		dots: false,
		rewind: false,
		lazyLoad: true,
		scrollPerPage: true,
		responsive: {
			0: {items:3},
			567: {items:4},
			768: {items:6},
			1024: {items:8}
		}
	});
});

