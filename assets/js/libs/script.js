$(function(){
	$('.slider')._TMS({
		preset:'diagonalExpand',
		easing:'easeOutQuad',
		duration:800,
		pagination:false,
		slideshow:3000,
		banners:true,
		waitBannerAnimation:false,
		bannerShow:function(banner){
		banner.css({marginRight:-500}).stop().animate({marginRight:0}, 600);
		},
		bannerHide:function(banner){
			  banner.stop().animate({marginRight:-500}, 600);

		}
	})
});
