
	<article class="stack stack-full">

		<div class="stackArt clearfix">
			<img src="<?php echo stack_art_large() ?>" alt="" title="" />
			<?php if(stack_type() == "irl"){ ?>
			<div class="stackIRL">IRL Stack!</div>
			<?php } ?>
			<hgroup class="stackInfo">
				<h2><?php echo the_title(); ?></h2>
				<h3><?php
					echo date( 'l, jS F Y', strtotime( stack_date() ) ) . " at " . stack_time();
				?></h3>
			</hgroup>
		</div>
		<div class="stackDetails clearfix">
			<div class="stackDetailsLeft">
				<?php if( stack_location() != "" ){ ?>
				<div class="stackLocation iconLocation">
					<?php echo stack_location(); ?>
				</div>
				<?php } ?>
				<div class="stackText">
					<?php echo the_content(); ?>
				</div>
				<div class="stackTextMeta">
					<a href="<?php echo the_permalink(); ?>#comments" class="comments">Comments (<?php echo get_comments_number() ?>)</a>
					<a href="<?php echo the_permalink(); ?>" class="perma">Permalink</a>
					<?php edit_post_link('Edit Stack', '<span class="edit">', '</span>'); ?>
				</div>
			</div>
			<div class="stackDetailsRight">
				<?php if ( is_user_logged_in() ) { ?>
					<?php if ( !is_past_stack() ) { ?>
						<?php if( stack_going() ){ ?>
							<a href="?action=leave_stack&amp;event=<?php echo get_the_ID() ?>" class="stackThis"><span>I'm stacking!</span>I don't want to stack any more</a>
						<?php } else { ?>
							<a href="?action=join&amp;event=<?php echo get_the_ID() ?>" class="stackThis">I'm in!</a>
						<?php } ?>
						<?php if ( stack_links_number() > 0 ) { ?>
						<div class="linkList">
							<h3>Links</h3>
							<?php echo stack_link_display(); ?>
						</div>
						<?php } ?>
					<?php } ?>
				<?php } else { ?>
					<div class="stackThisDisabled">Please login to join stack</div>
				<?php } ?>
			</div>
		</div>
		<?php if( stack_memberstotal() == 0 ){ ?>
		<div class="stackedMembers noMembers">
			<span class='nobody'>Nobody is stacking yet :(</span>
		</div>
		<?php } else { ?>
		<div class="stackedMembers hasMembers">
			<?php echo coopp_membercount(); ?> Find out who
		</div>
		<?php } ?>
		<div class="stackedMembersList">
			<ul class="memberlist clearfix">
			<?php
				$memberlist = stack_memberlist();
				foreach($memberlist as $memberid){
					// Look up member details
					$avatar = get_avatar( $memberid, '20' );
					$membername = get_user_meta( $memberid, 'nickname', true );
					$class = "member";
					if( $memberid == stack_requested_by() ) {
						$class .= " requested";
					}
					if( $memberid == get_the_author_meta( 'ID' ) ) {
						$class .= " poster";
					}
					if( $memberid == get_current_user_id() ) {
						$class .= " currentuser";
					}
					//echo $class;
					echo "<li class='clearfix ".$class."'>";
					echo "<a href='".bp_core_get_user_domain( $memberid )."' class='clearfix'>";
					echo $avatar;
					echo "<span>".$membername."</span>";
					echo "</a>";
					echo "</li>";
				}
			?>
			</ul>
		</div>
		<div class="stackPosters clearfix">
			<?php if(stack_requested()) { ?>
			<div class="stackRequested">
				<?php 
					$memberid = stack_requested_by();
					$avatar = get_avatar( $memberid, '20' );
					$membername = get_user_meta( $memberid, 'nickname', true );
					$profilelink = bp_core_get_user_domain( $memberid );
				?>
				<a href="<?php echo $profilelink ?>">
					<?php echo $avatar; ?>
					<span>Requested by <?php echo $membername; ?></span>
				</a>
			</div>
			<?php } ?>
			<div class="stackPosted">
				<a href="<?php echo bp_core_get_user_domain( get_the_author_ID() ) ?>">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), '20' ); ?>
					<span>Posted by <?php the_author(); ?></span>
				</a>
			</div>
		</div>

	</article>