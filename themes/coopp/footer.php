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

	<?php // NON-PRIOIRITY SCRIPTS ?>

	<script src="<?php bloginfo("template_url"); ?>/js/plugins.js"></script>
	<script src="<?php bloginfo("template_url"); ?>/js/script.js"></script>
	<script src="<?php bloginfo("template_url"); ?>/js/buddypress.global.js"></script>
	<?php wp_footer(); ?>

</body>
</html>