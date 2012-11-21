<?php //Event ICAL feed
// http://wordpress.stackexchange.com/questions/56187/dynamic-ical-generator-outside-inside-wordpress
class SH_Event_ICAL_Export  {

    public function load() { add_feed('calendar-event8', array(__CLASS__,'export_events')); }

    // Creates an ICAL file of events in the database
    public function export_events(){ 

        //Give the iCal export a filename
        $filename = urlencode( 'event-ical-' . date('Y-m-d') . '.ics' );

        // Get current user info
        $current_user = wp_get_current_user();

        $allstacks = false;
        if ( $_GET['scope'] == "all" ) { $allstacks = true; } else { $allstacks = false; }

        //Collect output 
        ob_start();

        // File header
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".$filename);
        header("Content-type: text/calendar");
        header("Pragma: 0");
        header("Expires: 0");

?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//<?php echo get_bloginfo('name'); ?> //NONSGML <?php if($allstacks == true){ echo "All Stacks"; } else { echo "My Stacks"; } ?> //EN
CALSCALE:GREGORIAN
X-WR-CALNAME:<?php echo get_bloginfo('name');?>: <?php if($allstacks == true){ echo "All Stacks"; } else { echo "My Stacks"; } ?> 
<?php // Query for events


        // check if scope is set
        // if it is set to "all", export all stacks
        if( $allstacks == true ){
            $events = new WP_Query(array(
                'post_type' => 'stack',
                'orderby' => 'stack_date',
                'order' => 'DESC'
            ));
        // if it isn't set, or isn't set to "all", export only the stacks
        // for the current user
        } else {
            $events = new WP_Query(array(
                'post_type' => 'stack',
                'meta_key' => 'stack_users',
                'meta_value' => $current_user->ID,
                'meta_compare' => 'IN',
                'orderby' => 'stack_date',
                'order' => 'DESC'
            ));
        }

    if($events->have_posts()) : while($events->have_posts()) : $events->the_post();
        $uid = get_the_ID(); // Universal unique ID
        //$dtstamp = date_i18n('Ymd\THis\Z',time(), true); // Date stamp for now.
        //$created_date = get_post_time('Ymd\THis\Z', true, get_the_ID() ); // Time event created
        $stackDate = stack_date() . stack_time();
        $stackDateEnd = ;
        $stackDescription = the_title() . " - " . the_post();
        $stackLocation = stack_location();
        $stackURL = the_permalink();
        // Other pieces of "get_post_custom_values()" that make up for the StartDate, EndDate, EventOrganiser, Location, etc.
        // I also had a DeadlineDate which I included into the BEGIN:VALARM
        // Other notes I found while trying to figure this out was for All-Day events, you just need the date("Ymd"), assuming that Apple iCal is your main focus, and not Outlook, or others which I haven't tested :]
?>
BEGIN:VEVENT

UID:<?php echo $uid;?> 

DTSTART;VALUE=DATE:<?php echo $stackDate ; ?> 

DTEND;VALUE=DATE:<?php echo $stackDateEnd; ?>

LOCATION:<?php echo $stackLocation;?>

TRANSP:OPAQUE 

SUMMARY:<?php echo $stackDescription; ?>

URL;VALUE=URI:<?php echo $stackURL; ?>

<?php /*
CREATED:<?php echo $created_date;?>

UID:<?php echo $uid;?>

DTEND;VALUE=DATE:<?php echo $end_date; ?>

TRANSP:OPAQUE
SUMMARY:<?php echo $organiser; ?>

DTSTART;VALUE=DATE:<?php echo $start_date ; ?>

DTSTAMP:<?php echo $dtstamp;?>

LOCATION:<?php echo $location;?>

ORGANIZER:<?php echo $organiser;?>

URL;VALUE=URI:<?php echo "http://".$url; ?>

BEGIN:VALARM
ACTION:DISPLAY
TRIGGER;VALUE=DATE-TIME:<?php echo $dLine; ?>

DESCRIPTION:Closing submission day of films for <?php echo $organiser; ?>! Enter quickly!
END:VALARM
*/ ?>
END:VEVENT

<?php endwhile; endif; ?>
END:VCALENDAR
<?php //Collect output and echo 
    $eventsical = ob_get_contents();
    ob_end_clean();
    echo $eventsical;
    exit();
    }   

} // end class
SH_Event_ICAL_Export::load();
?>