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
	$(".search-field-filters .filter input").tipsy({gravity: 'n'});
	$(".calendar-nextprev a").tipsy({gravity: "n"});

/* ====================================================

	SEARCH TOGGLES & FILTERS
	toggles the visibility of the search fields
	sets the form actions based on filter clicks

==================================================== */

	var searchAnchor = $(".search-anchor"),
		searchField = $(".search-field"),
		cancelSearch = $(".search-field-cancel"),
		// filter buttons
		searchFilterStacks = $(".search-filter-stacks"),
		searchFilterForum = $(".search-filter-forum"),
		searchFilterMembers = $(".search-filter-members"),
		searchFilterGroups = $(".search-filter-groups");

	// Clicking the anchor shows the search field
	searchAnchor.click(function(){
		// hide the menu if mobile-visible
		if ( $(".menu").hasClass("mobile-visible") ) {
			$(".menu").removeClass("mobile-visible");
		}
		// if it has the class 'search-field-visible' already, hide the search field instead
		if( searchAnchor.hasClass('search-field-visible') ) {
			searchField.removeClass('search-field-visible');
			searchAnchor.removeClass('search-field-visible');
		} else {
			searchAnchor.addClass('search-field-visible');
			searchField.addClass('search-field-visible');
		}
	});
	cancelSearch.click(function(){
		searchField.removeClass('search-field-visible');
		searchAnchor.removeClass('search-field-visible');
	});

/* ====================================================

	MOBILE MENU & ACCOUNT TOGGLES

==================================================== */

	var menuhitbox = $(".mobile-menu-hitbox"),
		menu = $(".menu"),
		accounthitbox = $(".account-hitbox"),
		accountinfo = $(".userinfo");

	menuhitbox.click(function(e){
		e.preventDefault();
		// hide search/account
		searchField.removeClass('search-field-visible');
		searchAnchor.removeClass('search-field-visible');
		accountinfo.removeClass("mobile-visible");
		menu.toggleClass("mobile-visible");
	});

	accounthitbox.click(function(e){
		e.preventDefault();
		// hide search/menu
		searchField.removeClass('search-field-visible');
		searchAnchor.removeClass('search-field-visible');
		menu.removeClass("mobile-visible");
		accountinfo.toggleClass("mobile-visible");
	});

/* ====================================================

	SEARCH FILTERS

==================================================== */

	$(".search-field-filters .filter").each(function(){
		var filter = $(this),
			input = filter.find("input"),
			aclass = "active";

		// switch state on click
		filter.click(function(e){
			filter.addClass(aclass).siblings().removeClass(aclass);
			input.prop("checked",true);
		});

		// listen for existing states
		if(input.prop("checked") == true) {
			filter.addClass(aclass).siblings().removeClass(aclass);
		}

	});

	/* End jQuery */
	});

})(jQuery);