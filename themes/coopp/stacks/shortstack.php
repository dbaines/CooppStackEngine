
	<article class="stack stack-short clearfix">

		<div class="stackArt">
			<img src="<?php echo stack_art_small() ?>" alt="" title="" />
			<?php if(stack_type() == "irl"){ ?>
				<div class="stackIRL">IRL Stack!</div>
			<?php } ?>
		</div>
		<div class="stackDetails">
			<hgroup class="stackInfo">
				<h2><?php echo the_title(); ?></h2>
				<h3><?php echo date( 'l, jS F Y', strtotime( stack_date() ) ) . " at " . stack_time(); ?></h3>
			</hgroup>
			<div class="stackMembers">
				<?php echo coopp_membercount(); ?>
			</div>
			<div class="stackTextMeta">
				<a href="<?php echo the_permalink(); ?>#comments" class="comments">Comments (<?php echo get_comments_number() ?>)</a>
				<?php edit_post_link('Edit Stack', '<span class="edit">', '</span>'); ?>
			</div>
		</div>
		<div class="stackLink">
			<a href="<?php echo the_permalink(); ?>" class="ir" title="View Full Stack Details">View Stack</a>
		</div>

	</article>