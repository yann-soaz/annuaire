<?php
namespace YannSoaz\Annuaire;

class AnnuaireTools {


  static function isFSE () {
    if ( function_exists( 'wp_is_block_theme' ) ) {
      return (bool) wp_is_block_theme();
    }
    if ( function_exists( 'gutenberg_is_fse_theme' ) ) {
      return (bool) gutenberg_is_fse_theme();
    }
    return false;  
  }

  static function possiblePaths () : array {
    $paths = [
      get_stylesheet_directory().'/annuaire/'
    ];
    $theme = get_template_directory().'/annuaire/';
    if ($theme != $paths[0])
      $paths[] = $theme;
    $paths[] = ANNUAIRE_PATH.'/assets/';
    return $paths;
  }

  static function getAsset (string $file_name, bool $public = false): ?string {
    $possible_paths = static::possiblePaths();
    foreach ($possible_paths as $possibility) {
      if (file_exists($possibility.$file_name)) {
        if ($public)
          return str_replace([
            get_stylesheet_directory().'/annuaire/',
            get_template_directory().'/annuaire/',
            ANNUAIRE_PATH.'/assets/'
          ], [
            get_stylesheet_directory_uri().'/annuaire/',
            get_template_directory_uri().'/annuaire/',
            ANNUAIRE_PUBLIC_PATH.'/assets/'
          ], $possibility).$file_name;
        return $possibility.$file_name;
      }
    }
    return null;
  }

  static function loadStyle (): void {
    $css = static::getAsset('annuaire-style.css', true);
    if ($css) {
      add_action( 'enqueue_block_editor_assets', function () use ($css) {
        wp_enqueue_style( 'annuaire-style', $css );
      } );
      add_action( 'wp_enqueue_scripts', function () use ($css) {
        wp_enqueue_style( 'annuaire-style', $css );
      } );
    }
  }

  static function buildTemplate (string $content = '<!-- wp:paragraph {"placeholder":"Saisissez le contenu de la fiche ici."} -->
    <p></p>
  <!-- /wp:paragraph -->'): string {
    $template = static::getAsset('content-fiche.html');
    if (!$template)
      return false;
    return str_replace('{{site_description}}', $content, file_get_contents($template));
  }

}