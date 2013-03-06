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

	$(".stackedMembers.hasMembers").live("click",function(e){
		// Stop right there, criminal scum!
		e.preventDefault();
		toggleMemberDrawer($(this));
	});

	function hideMemberDrawer($container) {
		$drawer = $container.find(".stackedMembersList");
		$drawer.each(function(){
			$thisdrawer = $(this);
			// only do it if drawer doesn't have existing data-old-height
			if( !$thisdrawer.attr("data-old-height") ){
				// find height of drawer
				var oldHeight = $thisdrawer.height();
				// add it in to a data attribute
				$thisdrawer.css("height",0).hide().attr("data-old-height",oldHeight);
			}
		});
	}

	function toggleMemberDrawer($container) {
		//console.log("toggle, bitch!");
		// check if the drawer is already open
		var $memberBox = $container.next(".stackedMembersList");
		var memberBoxHeight = $memberBox.attr("data-old-height");

		// check if open
		if ( $memberBox.is(":visible") ) {
			$memberBox.stop().animate({ height: 0 }, { duration: 250, easing: 'easeOutQuad', complete: function(){
					$memberBox.hide();
				}
			});
			$container.removeClass("open");
		} else {
			$memberBox.show().stop().animate({ height: memberBoxHeight }, 250, 'easeOutQuad');
			$container.addClass("open");
			// now that it's open, we're going to recheck the heights in case the
			// window has been resized and gone in or out of responsive changes
			var recheckheight = $memberBox.children(".stackedMembersListWrapper").outerHeight();
			// if it's not matching the existing value, animate to the new height
			if(memberBoxHeight != recheckheight){
				$memberBox.show().stop().animate({ height: recheckheight }, 250, 'easeOutQuad');
			}
		}
	}

	// hide member lists by default
	hideMemberDrawer($(".pagebg"));



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

function tipsify(){
	$(".userinfo a, #item-buttons a").tipsy({gravity: 'n'});
	$(".stack-short .stackLink a").tipsy({gravity: 'e'});
	$(".commenticon").tipsy({gravity: 'n'});
	$(".search-field-filters .filter input").tipsy({gravity: 'n'});
	$(".calendar-nextprev a").tipsy({gravity: "n"});
	$("td.has-stack").tipsy({gravity: "n"});
}
tipsify();

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
			searchField.find("#s").blur();
		} else {
			searchAnchor.addClass('search-field-visible');
			searchField.addClass('search-field-visible');
			searchField.find("#s").focus();
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
					$("<input type='hidden' name='post_type' value='' />").attr("value","forum_search").appendTo(globalsearch);
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

/* ====================================================

	REQUEST-A-STACK FORM
	show/hide fields based on "Type" dropdown

==================================================== */

	// hide IRL values by default
	$(".stack_irl_field").hide();

	// When changing the "type" dropdown
	$("#stack_type").change(function(){
		value = $(this).val();
		// Check value
		if(value == "irl") {
			// IRL fields
			$(".stack_online_field").hide();
			$(".stack_irl_field").show();
		} else {
			// Online fields
			$(".stack_online_field").show();
			$(".stack_irl_field").hide();
		}
	});

/* ====================================================

	BBPRESS MODIFICATIONS
	just for firefox

==================================================== */

	// in firefox, you cannot have position: relative on
	// on a td. So we'll wrap it in a superfluous div
	// instead
	$(".bbp-topic-title, .bbp-forum-info").each(function(){
		$(this).wrapInner("<div class='forum_icon_padding' />").find(".bbpresss_unread_posts_icon").fadeIn('fast');
	});
	//$(".bbp-forum-info").wrapInner("<div class='forum_icon_padding' />");

/* ====================================================

	AJAX LOAD MORE POSTS
	from dbaines.com

==================================================== */

$(".ajax-pagination a").live("click", function(e){
	var button = $(this);

	// stop right there, criminal scum!
	e.preventDefault();

	// check if disabled, return nothing if disabled
	if( button.hasClass("disabled") ) {return false;}

	// get the URL to load
	var linkToGet = button.attr("href");

	// put load more link in to variable in case we need it again later (for error reporting)
	var oldLoadMore = button.html();

	// show a loading message
	$(".ajax-pagination").html("<span class='loading-posts'>Loading...</span>");

	// hide any errors
	$(".load-error").remove();

	// hide the pagination link
	$(".loadmore-pagination").hide();
	$(".loadmore-pagination-links").hide();

	// specify our target element to load content from
	var ajaxTarget = "#primary";

	// loading new content via ajax
	$("<div>").load(linkToGet+' '+ajaxTarget, function(response, status) {

		if (response.readyState = 4){
			if(status == "success") {

				// add page break
				$(".stack-container").append("<div class='page-break'></div>");

				// getting page number
				//var currentPage = $(".wp-pagenavi .pages", this).html();
				//$(".page-break").html("<span class='page'>"+currentPage+"</div>");

				// Appending the html from this div in to content container
				$(".stack-container").append($(this).find(".stack-container").html());

				// Reset memberlist drawers for "big stack" templates
				hideMemberDrawer( $(".stack-container") );

				// Loading new load more link
				var newLoadMore = $(".ajax-pagination",this).html();
				$(".ajax-pagination").html(newLoadMore);

				// Re Tipsy
				tipsify();

				//
			} else {
				// Show the load more button again
				$(".ajax-pagination").html(oldLoadMore);

				// Show error message
				$(".ajax-pagination").before("<span class='load-error'>Error retrieving stacks. Please try again.</span>");

				// Show pagination links
				$(".loadmore-pagination").show();
			}
		}

	});

});

	/* End jQuery */
	});

})(jQuery);