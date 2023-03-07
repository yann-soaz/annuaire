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

use YannSoaz\Annuaire\FicheForm;

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

function create_block_site_form_block_init() {
	$register = register_block_type( __DIR__ . '/build', [
		'render_callback' => 'site_form_render'
	] );
}
add_action( 'init', 'create_block_site_form_block_init' );


function site_form_render () {
	return (new FicheForm())->render();
}
