/* ====================================================

	CO-OPP STACK ENGINE
	JQuery plugins

==================================================== */

(function($){

	$(function(){

/* ====================================================

	FILTER MEMBERS
	used when adding or editing a stack
	filters the "requested by" list

==================================================== */

		// When changing the filter field
		$(".filter_requestedby").change(function(){
			var filterText = $(this).val(),
				filterLength = filterText.length,
				target = $("#stack_requestedby");
			// Check if filter text is empty
			if(filterText == ""){
				// Restore all options if empty
				target.find("option").show();
			} else {
				// Go through each <option>
				target.find("option").each(function(){
					// Hide options whose text doesn't match the filterText
					var optionText = $(this).text();
					//if(optionText.substr(0,filterLength) != filterText) {
					if(optionText.search(filterText) < 0) {
						$(this).hide();
					} else {
						$(this).show();
					}
				});
			}
		});

/* ====================================================

	ADD LINK
	Clicking the + Link button adds another link to
	the meta box

==================================================== */

		var linkButton = $(".stack_add_link"),
			linkContainer = $(".links_list"),
			linkTemplate = '<div class="stack_link"><input type="text" name="stack_links_text[]" value="" placeholder="text" />&nbsp;<input type="text" name="stack_links_url[]" value="" placeholder="url" /><span class="stack_link_delete">Delete</span></div>';

		// On +link button press
		linkButton.click(function(e){
			e.preventDefault();
			linkContainer.append(linkTemplate);
		});

		// Add an initial link box for good measure
		linkContainer.append(linkTemplate);

		// Deleting a link
		linkContainer.find(".stack_link_delete").live("click",function(){
			$(this).parent("div").remove();
		});

	/* End jQuery */
	});
})(jQuery);