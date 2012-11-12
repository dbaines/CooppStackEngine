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

					<div class="stacks-calendar-key">
						Key
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
									<select name="month">
										<option>months</option>
									</select>
									<select name="year">
										<option>years</option>
									</select>
									<button>Update</button>
								</form>
							</div>
							<div class="calendar-nextprev">
								<div class="calendar-last-month"><a href="<?php echo "?month=".$prev_month."&year=".$prev_year; ?>">Previous Year</a></div>
								<div class="calendar-next-month"><a href="<?php echo "?month=".$next_month."&year=".$next_year; ?>">Next Year</a></div>
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
							for ($i=0; $i<($maxday+$startday); $i++) {
							    if(($i % 7) == 0 ) echo "<tr class='date-row'>";
							    if($i < $startday) echo "<td class='date-none'></td>";
							    else if (($i - $startday + 1) == $cDay) echo "<td class='date-today'>". ($i - $startday + 1) . "</td>";
							    else echo "<td class='date'>". ($i - $startday + 1) . "</td>";
							    if(($i % 7) == 6 ) echo "</tr>";
							}
							?>

						</table>
					</div>


					<?php
					do_action( 'bp_after_member_body' ) ?>

					<div class="calendar-footer">
						<a href="#">Download iCal</a> | <a href="#">Import to Google Calendar</a>
					</div>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar( 'buddypress' ) ?>

<?php get_footer( 'buddypress' ) ?>