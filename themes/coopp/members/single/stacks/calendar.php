<?php get_header( 'buddypress' ) ?>

	<div id="content" class="page-container">
		<div class="padder">

			<?php do_action( 'bp_before_member_home_content' ) ?>

			<div id="item-header" role="complementary">
				<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>
			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>
						<?php do_action( 'bp_member_options_nav' ) ?>
					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">
				<?php do_action( 'bp_before_member_body' );

					global $bp;
					?>

					<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
						<ul>

							<?php bp_get_options_nav(); ?>

						</ul>
					</div>

					<?php

					// Set up our custom query of all stacks this member is going to
					$memberid =  $bp->displayed_user->id;
					$query_args = array(
						'post_type' => 'stack',
						'meta_key' => 'stack_users',
						'meta_value' => $memberid,
						'meta_compare' => 'IN',
						'orderby' => 'stack_date',
						'order' => 'DESC'
					);
					$query = new WP_Query($query_args);

					// output
					// http://www.phpjabbers.com/how-to-make-a-php-calendar-php26.html
					$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
					// check for URL params being set already
					if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
					if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
					// 
					$cMonth = $_REQUEST["month"];
					$cYear = $_REQUEST["year"];
					$cDay = date("d");
					//
					$prev_year = $cYear;
					$next_year = $cYear;
					$prev_month = $cMonth-1;
					$next_month = $cMonth+1;
					//
					if ($prev_month == 0 ) {
						$prev_month = 12;
						$prev_year = $cYear-1;
					}
					if ($next_month == 13 ) {
						$next_month = 1;
						$next_year = $cYear + 1;
					}
					?>

					<div class="stack-calendar-view">
						<div class="stack-calendar-navigation">
							<div class="celendar-selectors">
								<form>
									<div class="select">
										<select name="month">
											<?php for ($i=0; $i<12; $i++) {
												$m = $i+1;
												$month = date("F", mktime(0,0,0,$m,1,2000));
												if( $cMonth == $m ) {
													echo "<option value='".$m."' selected='selected'>".$month."</a>";
												} else {
											    	echo "<option value='".$m."'>".$month."</a>";
												}
											} ?>
										</select>
									</div>
									<div class="select">
										<select name="year">
											<?php 
												$minyear = "2012";
												$maxyear = date("Y") + 2;
												for ($i=$minyear; $i<$maxyear; $i++) {
													if( $cYear == $i ) {
											    		echo "<option value='".$i."' selected='selected'>".$i."</a>";
											    	} else {
											    		echo "<option value='".$i."'>".$i."</a>";
											    	}
												} 
											?>
										</select>
									</div>
									<div class="submit">
										<button>Update</button>
									</div>
								</form>
							</div>
							<div class="calendar-nextprev">
								<div class="calendar-last-month"><a href="<?php echo "?month=".$prev_month."&year=".$prev_year; ?>" title="Previous Month">Previous Month</a></div>
								<div class="calendar-next-month"><a href="<?php echo "?month=".$next_month."&year=".$next_year; ?>" title="Next Month">Next Month</a></div>
							</div>
						</div>
						<table border="0" cellspacing="0" cellpadding="0">
							<tr class="days">
								<th title="Sunday">S</th>
								<th title="Monday">M</th>
								<th title="Tuesday">T</th>
								<th title="Wendesday">W</th>
								<th title="Thursday">T</th>
								<th title="Friday">F</th>
								<th title="Saturday">S</th>
							</tr>

							<?php 
							$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
							echo $todaydate;
							$maxday = date("t",$timestamp);
							$thismonth = getdate ($timestamp);
							$startday = $thismonth['wday'];

							// Add a zero to this months number if required
							if (strlen($cMonth)==1){
								$thisMonth = "0".$cMonth;
							} else {
								$thisMonth = $cMonth;
							}
							// Get all stacks for this month
							$query_args = array(
								'post_type' => 'stack',
								'meta_key' => 'stack_date',
								'meta_value' => array($cYear.'-'.$thisMonth.'-01', $cYear.'-'.$thisMonth.'-'.$maxday),
								'meta_compare' => 'BETWEEN'
							);
							$query = new WP_Query($query_args);

							// create a new empty array for stacksthismonth
							$stacksthismonth = array();

							// Run through stacks and insert in to an array
							if( $query->have_posts() ) :
								while ( $query->have_posts() ) : $query->the_post();

									// create a nested array of post information
									$thisstack = array(
										"id" => get_the_ID(),
										"date" => stack_date(),
										"time" => stack_time(),
										"name" => get_the_title(),
										"url" => get_permalink(),
										"type" => stack_type()
									);

									// add to array using key value pair of stack_date
									// potential issue with this is that this will not allow for the display of more than one stack per day :(
									$stacksthismonth[stack_date()] = $thisstack;
								endwhile;
								// debug
								//print_r($stacksthismonth);
							else :
								//echo "no stacks this month :(";
							endif;


							for ($i=0; $i<($maxday+$startday); $i++) {
							    if(($i % 7) == 0 ) echo "<tr class='date-row'>";
							    if($i < $startday) echo "<td class='date-none'></td>";
							    else if ($i > $maxday+$startday) echo "<td class='date-none'></td>";
							    else if ( (($i - $startday + 1) == $cDay ) and ( date("n") == $cMonth) and (date("Y") == $cYear) ) {
							    	echo "<td class='date-today'>". ($i - $startday + 1) . "</td>";
							    }
							    else {

							    	// Look up date
							    	$lookupdate = $cYear."-".$thisMonth."-".($i - $startday + 1);

							    	// Look for this date in the $stacksthismonth array
							    	if( array_key_exists( $lookupdate, $stacksthismonth ) ) {
							    		$stackdetails = $stacksthismonth[$lookupdate];
							    		if($stackdetails['type']=="irl"){
							    			echo "<td class='date has-stack has-irl' title='".$stackdetails['name']." at ".$stackdetails['time']."'>";	
							    		} else {
							    			echo "<td class='date has-stack' title='".$stackdetails['name']." at ".$stackdetails['time']."'>";
							    		}
							    		echo "<a href='".$stackdetails['url']."'>".($i - $startday + 1)."</a>";
							    		#echo "<div class='stack-details'>";
							    		#	echo "<h3>".$stackdetails['name']."</h3>";
							    		#	echo "<h4>".$stackdetails['date']." at ".$stackdetails['time']."</h4>";
							    		#echo "</div>";
							    		echo "</td>";
							    	} else {
							    		echo "<td class='date'>";
							    		echo ($i - $startday + 1);
							    		echo "</td>";
							    	}
							    }
							    if(($i % 7) == 6 ) echo "</tr>";
							}
							?>

						</table>
					</div>

					<div class="stacks-calendar-key">
						<span class="key"><i class="keybox has-stack"></i> Stack</span>
						<span class="key"><i class="keybox has-irl"></i> IRL Stack</span>
						<span class="key"><i class="keybox today"></i> Today</span>
					</div>

					<div class="stacks-calendar-downloads">
						<strong>Download:</strong> <a href="<?php echo get_feed_link('calendar-event'); ?>">ical (my stacks)</a> <a href="<?php echo get_feed_link('calendar-event'); ?>?scope=all">ical (all stacks)</a>
					</div>

					<?php do_action( 'bp_after_member_body' ) ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar( 'buddypress' ) ?>

<?php get_footer( 'buddypress' ) ?>