<?php
/**
 * Plugin Name:       Site Url
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       site_url
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

function create_block_site_url_block_init() {
	$register = register_block_type( __DIR__ . '/build', [
		'render_callback' => 'site_url_render'
	] );
	register_post_meta( 'fiche', 'site_url', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
	) );
	add_action( 'admin_enqueue_scripts', 'add_api_key' );
 
}
add_action( 'init', 'create_block_site_url_block_init' );

function add_api_key() {
	$key = (defined('SCREENSHOT_API_KEY')) ? SCREENSHOT_API_KEY : '2a8d81';
	global $post_type;
	if ('fiche' == $post_type) {
		wp_register_script( 'api_key', '' );
		wp_enqueue_script( 'api_key' );
		wp_add_inline_script( 'api_key', 'window.apiKey ="' . $key . '";' );
	}
}

function site_url_render () {
	$url = get_post_meta( get_the_ID(), 'site_url', true );
	return site_url_html($url);
}

if (!function_exists('site_url_html')) {
	function site_url_html ($url) {
		return '<a href="'.$url.'" class="annuaire_url">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link" viewBox="0 0 16 16">
				<path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z"/>
				<path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z"/>
			</svg>'
			.$url
		.'</a>';
	}
}