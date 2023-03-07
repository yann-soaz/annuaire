# YS - Annuaire

  

Plugin permettant de créer un annuaire de site dans wordpress.

Autheur : yann-soaz (https://yann-soaz.fr)

  

## Utilisation

Installer le plugin mettra à disposition le type de contenu "fiche" et la taxonomie "thematiques".

Plusieurs blocks Gutenberg sont disponibles dans la catégorie "annuaire" :

- "url du site"

- affiche un champs d'url et un bouton "screenshot", une fois l'url remplie, cliquer sur le bouton génèrera un screenshot du site et l'enregistrera comme image mise en avant dans le contenu.

- "thématiques" affichera tous les termes de taxonomie "thematique" lié au contenu en cours d'édition

  

## personnalisation

### clé api
Créer un compte sur [screenshotmachine](https://www.screenshotmachine.com/)
Récupérer votre ***Customer API key*** sur le dashboard.
Dans votre function.php ajouter la ligne suivante (en remplaçant votre-clef-api par la valeur récupéré ci dessus) :

    define('SCREENSHOT_API_KEY', 'votre-clef-api');

### personnalisation de rendu 

Les personnalisations de rendu pour les blocks Gutenberg se font avec la création de fonctions php dans votre function.php ou la création de fichiers dans un dossier "annuaire" à la racine de vote thème.
Les fonctions de rendu HTML doivent retourner un contenu texte, sans avoir recours aux fonctions "print" ou "echo";

#### pour personnaliser le rendu du block "thematique" :
pour l'affichage des thématiques (quand elles sont disponibles) :

    function  thematique_html  ($terms)  {
	    $content =  '';
	    $content .=  '<ul class="thematique_list">';
	    foreach  ($terms as  $term)  {
		    $content .=  '<li class="thematique_item">
			    <a class="thematique_link" href="'.$term->permalink.'">
				    '.$term->name.'
			    </a>
		    </li>';
	    }
	    $content .=  '</ul>';
	    return  $content;
    }

L'affichage dans le cas ou aucune thematique n'a été trouvée pour le contenu :

    function  thematique_empty_html  ()  {
	    return  '<p class="thematique_empty">Aucune thématique selectionnée.</p>';
    }

#### pour personnaliser le rendu du block site url :

    function  site_url_html  ($url)  {
	    return  '<a href="'.$url.'" class="annuaire_url">
		    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link" viewBox="0 0 16 16">
			    <path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z"/>
			    <path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z"/>
		    </svg>'
		    .$url
	    .'</a>';
    }

#### personnaliser le style

dans un dossier "annuaire" dans votre thème vous pouvez créer le fichier "annuaire-style.css" dans lequel insérer votre style pour les différent blocks. Ce style sera inclue dans le front-end et l'éditeur Gutenberg.

#### personnaliser le template de base du contenu "fiche"

- commencez par créer votre mise en page de base dans l'éditeur Gutenberg.
- une fois la mise en page finalisé : cliquez sur le menu en haut a droite de l'éditeur (trois points verticaux) puis sélectionnez "copier tout les blocks".
- dans le dossier "annuaire" de votre thème vous pouvez créer le fichier "content-fiche.html" et coller le contenu copié dans l'éditeur.
- inclure le code "{{site_description}}" à l'endroit du template ou sera rédiger le contenu (pour le formulaire front-end)

#### redirection après validation du formulaire

pour la redirection après validation du formulaire en front-end, le plugin utilise une constante 'ANNUAIRE_FORM_REDIRECT', qui peut être définie dans votre thème.
par défaut elle est sur "false" mais peut contenir l'url de la page vers laquelle l'utilisateur doit être redirigé.

    define('ANNUAIRE_FORM_REDIRECT', '/remerciement');
