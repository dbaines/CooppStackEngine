<?php 
	$options = get_option('coopp_announcements'); 
	if($options['display']) :
?>
<article class="announcement">
	<div class="cFull">
		<h2><?php $options = get_option('coopp_announcements'); echo $options['heading']; ?></h2>
		<p><?php $options = get_option('coopp_announcements'); echo $options['content']; ?></p>
	</div>
</article>
<?php endif; ?>