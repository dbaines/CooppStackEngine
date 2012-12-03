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
	$("td.has-stack").tipsy({gravity: "n"});

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
		$(".menu").removeClass("mobile-visible");
		$(".userinfo").removeClass("mobile-visible");
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
		accounthitbox = $(".mobile-account-hitbox"),
		accountinfo = $(".userinfo"),
		loginhitbox = $(".mobile-login-hitbox"),
		logininfo = $(".login");

	menuhitbox.click(function(e){
		e.preventDefault();
		// hide search/account
		searchField.removeClass('search-field-visible');
		searchAnchor.removeClass('search-field-visible');
		accountinfo.removeClass("mobile-visible");
		logininfo.removeClass("mobile-visible");
		// show menu
		menu.toggleClass("mobile-visible");
	});

	accounthitbox.click(function(e){
		e.preventDefault();
		// hide search/account
		searchField.removeClass('search-field-visible');
		searchAnchor.removeClass('search-field-visible');
		menu.removeClass("mobile-visible");
		logininfo.removeClass("mobile-visible");
		// show account
		accountinfo.toggleClass("mobile-visible");
	});

	loginhitbox.click(function(e){
		e.preventDefault();
		// hide search/account
		searchField.removeClass('search-field-visible');
		searchAnchor.removeClass('search-field-visible');
		menu.removeClass("mobile-visible");
		accountinfo.removeClass("mobile-visible");
		// show account
		logininfo.toggleClass("mobile-visible");
	});

/* ====================================================

	SEARCH FILTERS

==================================================== */

	var globalsearch = $("#search"),
			globalsearch_originalaction = globalsearch.attr("action");

	$(".search-field-filters .filter").each(function(){
		var filter = $(this),
			input = filter.find("input"),
			aclass = "active";

		// switch state on click
		filter.click(function(e){
			filter.addClass(aclass).siblings().removeClass(aclass);
			input.prop("checked",true);
			updateSearchAction(input.val());
		});

		// listen for existing states
		if(input.prop("checked") == true) {
			filter.addClass(aclass).siblings().removeClass(aclass);
		}

		// updateSearchAction(val)
		// updates the search action URL based on what the user clicks
		function updateSearchAction(val){

			// remove any post_type definitions
			globalsearch.find("input[type=hidden]").remove();

			//console.log(val);
			switch(val) {
				case "forum":
					var action = globalsearch_originalaction;
					globalsearch.attr("action",action);
					$("<input type='hidden' name='post_type' value='' />").attr("value","forum").appendTo(globalsearch);
					break;
				case "member":
					var action = globalsearch_originalaction + "/members";
					globalsearch.attr("action",action);
					break;
				case "group":
					var action = globalsearch_originalaction + "/groups";
					globalsearch.attr("action",action);
					break;
				case "stack":
					var action = globalsearch_originalaction;
					globalsearch.attr("action",action);
					$("<input type='hidden' name='post_type' value='' />").attr("value","stack").appendTo(globalsearch);
					break;
			}
		}

	});

/* ====================================================

	SETTING SEARCH FILTERS BASED ON WHAT PAGE YOU'RE ON

==================================================== */

	// forum
	if( $("body").hasClass("bbPress") ) {
		$(".filter.filter-forum").click();

	// users
	} else if( $("body").hasClass("members") || $("body").hasClass("bp-user") ) {
		$(".filter.filter-members").click();

	// groups
	} else if( $("body").hasClass("groups") ) {
		$(".filter.filter-group").click();

	// fallback - stacks
	} else {
		$(".filter.filter-stacks").click();

	}

	/* End jQuery */
	});

})(jQuery);