/* ====================================================

	CO-OPP THEME
	scripts

==================================================== */

(function($){
	$(function(){

/* ====================================================

	BIG STACK
	VIEW MEMBERS STACKING

==================================================== */

	$(".stackedMembers.hasMembers").click(function(e){
		// Stop right there, criminal scum!
		e.preventDefault();
		// toggle display state of the .stackedMembersList div
		$(this).next(".stackedMembersList").stop().slideToggle();
		// toggle the "open" class on this div
		$(this).toggleClass("open");
	});

/* ====================================================

	COMMENTS TABS
	switch between pre-stack comments and post-stack
	coments

==================================================== */
	
	// Hide all comments OLs
	function hideCommentTabs(){
		$(".commentlist").hide();
	}
	function showCommentTab(stack){
		$(stack).show();
	}

	// Tab clicks
	$(".commentsTabs h2").click(function(){
		// Hide all tabs
		hideCommentTabs();
		// Class swappin'
		$(this).addClass("active").siblings().removeClass("active");
		// Get this tab data-comments and show the related comments OL
		var thisTab = $(this).attr("data-comments") + "stack";
		showCommentTab("."+thisTab);
	});

	// Show active tab by default
	$(".commentsTabs h2.active").click();

/* ====================================================

	TOOLTIPS

==================================================== */

	$(".userinfo a, #item-buttons a").tipsy({gravity: 'n'});
	$(".stack-short .stackLink a").tipsy({gravity: 'e'});
	$(".commenticon").tipsy({gravity: 'n'});

	/* End jQuery */
	});
})(jQuery);