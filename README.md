Co-Opp Stack Engine
===================

This is very much **in development** and by no means ready for use.

## What on Earth is a stack engine?

It's essentially a very specific type of events plugin.

Co-Opp.net is a community of like-minded gamers that stack on to random game servers. It used to be fairly unorganised, using forum posts to get stacks going.

With this plugin you can list games that you want to stack, when to stack them and also include any other information such as the steam store page or a mod download page for example.

Co-Opp also occasionally does "IRL" stacks for drinks nights, birthday parties or even just a general outing. With this plugin you can specify if the stack is an "online" stack or an "IRL" stack.

## What's included?

* A new custom post type: Stack
* Meta boxes for the stack post type:
	* Date and Time of stack
	* Steam ID of game we're stacking
	* Types of stack: Online or IRL
	* Location (of IRL stack)
	* Requested by field that pulls in all users as a select element and saves as a user id
	* Links for the stack with the ability to add or delete links
* Users can join or leave a stack at any time before the stack date.
* Dozens of template functions to expose your stack information (see template functions section)
* Dashboard information for the stack post type
* Request a stack form - allows users to fill in a form that then creates a draft post and sends an email to all admins informing them of the new stack request.
* Team management - everyone who has joined a stack is randomised then assigned to a user-specified number of teams. Teams are then posted on the public-facing stack post.

## Template Functions

**stack_requested_by()** | string
Returns the user_id of the member that requested the stack
eg. Requested by <?php echo stack_requested_by(); ?>

**stack_requested()** | boolean
Checks if this stack has been requested.
eg. if( stack_requested() ){ echo "This stack was requested"; } else { echo "This stack was not requested"; }

**stack_date()** | string
The date of the stack

**stack_time()** | string
The time of the stack

**stack_datetime()** | string
An alias of <?php echo stack_date() . " at " . stack_time(); ?>

**stack_location()** | string
The location of the stack

**stack_type()** | string
Returns the type of stack the author has set

**stack_steamid()** | string
The steamid of the stack

**stack_memberstotal()** | integer
Returns the number of members that have signed up to stack
eg. <?php if( stack_memberstotal() > 3 ) {echo "More than three people are going.";} ?>

**stack_memberlist()** | array
Returns an array of memberids that have signed up to stack

**stack_links_array()** | array
Returns a complete array of all links and titles

**stack_links_number()** | number
Returns the number of links associated with the stack

**stack_link_text($id)** | string
Returns the text of a specific link for this stack

**stack_link_url($id)** | string
Returns the URL of a specific link for this stack

**stack_link_display()** | string
Returns a pre-made template of links in a list format

**is_past_stack()** | boolean
Checks if the stack_date() is older than today's date

**stack_feed_url()** | string
Returns the URL of the stack feed

**stack_feed()** | string
Returns a pre-made link element with the feed URL already in place

**stack_art_large()** | string
Returns the URL of the featured image using the bigstack image size

**stack_art_small()** | string
Returns the URL of the featured image using the shortstack image size

**stack_going()** | boolean
Returns true if the currently logged in user is attending the stack
eg. <?php if( stack_going() ) {echo "You are going";} else {echo "You are not going";} ?>

## Template

This plugin comes with a default theme, aptly named "Co-Opp".

Requires
* Buddypress
* BBPress

The template comes with several nicities:
* Responsive design
* Font icons
* Buddypress profile plugins for:
	* Stacks joined
	* Stacks requested
	* Stacks in Calendar format
	* Forum posts
	* Stack comments
	* Social website links
* bbPress plugins for:
	* New posts are highlighted by an icon in both forum list and topic list views
	* Button to mark all posts in a topic as read
	* Show gaming name under real name
	* Forum search results

## Credits

* Co-Opp.net is founded and branded by Ben White (d3v1ant)
* Any snippets of code have been attributed with commented links to the source
* You? Feel free to fork and pull! That's why it's here at Github :)