	<?php 

		$ip=$_SERVER['REMOTE_ADDR'];
		if ($ip !== "60.242.71.28") : ?>

			<!doctype html>
			<html class="no-js">
				<title>Co-Opp</title>
				<script>
				/* Modernizr 2.6.2 (Custom Build) | MIT & BSD
				 * Build: http://modernizr.com/download/#-flexbox-cssclasses-testprop-testallprops-domprefixes
				 */
				;window.Modernizr=function(a,b,c){function x(a){j.cssText=a}function y(a,b){return x(prefixes.join(a+";")+(b||""))}function z(a,b){return typeof a===b}function A(a,b){return!!~(""+a).indexOf(b)}function B(a,b){for(var d in a){var e=a[d];if(!A(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function C(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:z(f,"function")?f.bind(d||b):f}return!1}function D(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+n.join(d+" ")+d).split(" ");return z(b,"string")||z(b,"undefined")?B(e,b):(e=(a+" "+o.join(d+" ")+d).split(" "),C(e,b,c))}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m="Webkit Moz O ms",n=m.split(" "),o=m.toLowerCase().split(" "),p={},q={},r={},s=[],t=s.slice,u,v={}.hasOwnProperty,w;!z(v,"undefined")&&!z(v.call,"undefined")?w=function(a,b){return v.call(a,b)}:w=function(a,b){return b in a&&z(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=t.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(t.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(t.call(arguments)))};return e}),p.flexbox=function(){return D("flexWrap")};for(var E in p)w(p,E)&&(u=E.toLowerCase(),e[u]=p[E](),s.push((e[u]?"":"no-")+u));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)w(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},x(""),i=k=null,e._version=d,e._domPrefixes=o,e._cssomPrefixes=n,e.testProp=function(a){return B([a])},e.testAllProps=D,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+s.join(" "):""),e}(this,this.document);
				</script>
				<style>
					html, body {height: 100%; margin: 0;}
					body {background: url("comingsoon/background.gif") top left repeat; 
						display: -webkit-flex;
						display: -moz-flex;
						display: -o-flex;
						display: flex;
					}
					.logo {background: url("comingsoon/logo.png") top left no-repeat; margin: auto; width: 414px; height: 166px; text-indent: -9999px; outline: none;}
					.no-flexbox .logo {margin-top: 200px;}
				</style>
				<body>

					<!--

						Co-Opp
						A completely open-source Wordpress plugin that supports event management
						both in online games as well as IRL events. 

						Want to learn more?
						https://github.com/dbaines/CooppStackEngine

					-->

					<h1 class="logo">Co-Opp</h1>

				</body>
			</html>


	<?php else : ?>


<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */
get_header(); ?>

		<div class="nextStack clearfix">

			<h2 class="sectionHead">Next Stack</h2>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php // get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		<?php else : ?>

			<span class="noresults">Sorry, no results</span>

		<?php endif; ?>

			<a href="#" class="ctaBlue"><?php $options = get_option('coopp_text'); echo $options['stack_upcoming']; ?></a>

		</div>

		<div class="pastStacks clearfix">

			<h2 class="sectionHead">Past Stacks</h2>
			<?php // include("stacks/shortstack.php"); ?>
			<a href="#" class="ctaBlue"><?php $options = get_option('coopp_text'); echo $options['stack_archive']; ?></a>

		</div>
		
<?php get_footer(); ?>

<?php endif; // End development code ?>