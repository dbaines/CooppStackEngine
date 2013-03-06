<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	<?php // ENDING CONTENT CONTAINER ?>

		</div>
	</section>

	<?php // FOOTER ?>

	<footer class="footer">
		developed by <a target="_blank" href="http://dbaines.com" title="South Australian Web Developer, David Baines">dbaines</a> | branding by ben white | this theme and the stack engine are both <a href="#" target="_blank" title="Co-Opp.net theme and Stack Engine, open source on Github">available on github</a>!
	</footer>

	<?php // GOOGLE ANALYTICS
		$options = get_option('coopp_seo');
		$uacode = $options['seo'];

		// don't bother loading the GA code if the UA code is empty
		if($uacode) :
	?>

	<script type="text/javascript">
		var _gaq=[['_setAccount','<?php echo $uacode; ?>'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>

	<?php endif; ?>

	<?php // NON-PRIOIRITY SCRIPTS ?>

	<script src="<?php bloginfo("template_url"); ?>/js/plugins.js"></script>
	<script src="<?php bloginfo("template_url"); ?>/js/script.min.js"></script>
	<script src="<?php bloginfo("template_url"); ?>/js/buddypress.global.js"></script>
	<?php wp_footer(); ?>

</body>
</html>