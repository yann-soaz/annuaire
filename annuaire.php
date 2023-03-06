<?php
/**
 * @package Yann-Soaz
 */

use YannSoaz\Annuaire\AnnuaireTools;
use YannSoaz\YsCpt\YS_PostTypeManager;

/*
Plugin Name: Annuaire de site
Plugin URI: https://yann-soaz.fr/
Description: Plugin permettant de créer un annuaire de site internet avec screenshot automatique.
Version: 5.0.1
Requires at least: 5.0
Requires PHP: 8.0
Author: Yann-Soaz
Author URI: https://yann-soaz.fr/
License: GPLv2 or later
Text Domain: ys_annuaire

*/

require 'vendor/autoload.php';
define('ANNUAIRE_PATH', __DIR__);
define('ANNUAIRE_PUBLIC_PATH', plugins_url('', __FILE__));
require 'src/AnnuaireBlocks.php';

$manager = YS_PostTypeManager::get();

// création du ctp fiche_site
$fiche = $manager->addPostType('fiche')
                 ->generateLabels('Fiche de site', 'Fiches de site', true)
                 ->menuAfter('posts');

// création de la taxonomy de catégorie
$themes = $manager->addTaxonomy('thematique')
                  ->generateLabels('Thématique', 'Thématiques', true)
                  ->addPostTypes($fiche->getslug());

AnnuaireTools::loadStyle();