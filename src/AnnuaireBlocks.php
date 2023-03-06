<?php

use YannSoaz\Annuaire\AnnuaireTools;

$blocks = [
  'ys-annuaire/site-url' => 'site_url',
  'ys-annuaire/thematiques' => 'thematiques',
];

foreach ($blocks as $block => $path) {
  if (file_exists(ANNUAIRE_PATH.'/blocks/'.$path.'/'.$path.'.php')) {
    include ANNUAIRE_PATH.'/blocks/'.$path.'/'.$path.'.php';
  }
}

add_filter( 'block_categories_all' , function( $categories ) {
  // Adding a new category.
  $categories[] = array(
    'slug'  => 'ys_annuaire',
    'title' => 'Annuaire'
  );
  return $categories;
} );

add_filter( 'default_content', 'get_default_fiche_pattern', 10, 2 );


function get_default_fiche_pattern ($content, $post) {
  if ( $post->post_type === 'fiche' ) {
    $template = AnnuaireTools::buildTemplate();
    if (!empty($template)) {
      return $template;
    }
  }
  return $content;
}