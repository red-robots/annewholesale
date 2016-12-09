<?php
/**
 * The header for theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ACStarter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="mastheadlogin" class="site-header" role="banner">
		<div class="row-1">
					<a href="<?php bloginfo( 'url' ); ?>">
						<img src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt="logo">
					</a>
			</div><!--.row-1-->
	</header><!-- #masthead -->
