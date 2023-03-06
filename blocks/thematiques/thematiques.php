<?php
/**
 * Plugin Name:       Thematiques
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       thematiques
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
function create_block_thematiques_block_init() {
	register_block_type( __DIR__ . '/build', [
		'render_callback' => 'thematique_render'
	] );
}
add_action( 'init', 'create_block_thematiques_block_init' );


function thematique_render () {
	$taxonomy = 'thematique';
	$terms = get_the_terms( get_the_ID(), $taxonomy );
	if (!empty($terms)) {
		foreach($terms as $term) {
			$term->permalink = get_term_link($term, $taxonomy);
		}
		return thematique_html($terms);
	}
	return thematique_empty_html($terms);
}


if (!function_exists('thematique_html')) {
	function thematique_html ($terms) {
		$content = '';
			$content .= '<ul class="thematique_list">';
			foreach ($terms as $term) {
				$content .= '<li class="thematique_item">
					<a class="thematique_link" href="'.$term->permalink.'">
						'.$term->name.'
					</a>
				</li>';
			}
			$content .= '</ul>';
			return $content;
	}
}

if (!function_exists('thematique_empty_html')) {
	function thematique_empty_html () {
		return '<p class="thematique_empty">Aucune thématique selectionnée.</p>';
	}
}