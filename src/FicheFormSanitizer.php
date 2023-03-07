<?php

namespace YannSoaz\Annuaire;

class FicheFormSanitizer {

  protected $secure_code = 'add_fiche_action';

  protected $fillable = [
    'site_name',
    'site_description',
    'site_category',
    'site_url'
  ];

  protected $input_error = [
    'site_name' => [],
    'site_description' => [],
    'site_category' => [],
    'site_url' => [],
  ];

  protected $alowed_terms = [];

  protected $post = [];

  protected bool $has_submission = false;
  protected bool $error = false;

  public function __construct () {
    if (!empty($_POST) && wp_verify_nonce($_POST['_wpnonce'], $this->secure_code)) {
      $this->has_submission = true;
      $this->fillPost();
    }
  }

  public function getTerms () {
    if (empty($this->alowed_terms)) {
      $terms = get_terms( array(
        'taxonomy' => 'thematique',
        'hide_empty' => false,
      ));
      foreach ($terms as $term) {
        $this->alowed_terms[$term->term_id] = $term->name;
      }
    }
    return $this->alowed_terms;
  }

  protected function fillPost () {
    foreach ($this->fillable as $input_name) {
      if ($this->not_empty($input_name)) {
        switch ($input_name) {
          case 'site_name' :
            $_POST[$input_name] = strip_tags($_POST[$input_name]);
          break;
          case 'site_description' :
            $_POST[$input_name] = $this->build_content(strip_tags($_POST[$input_name]));
          break;
          case 'site_url' :
            $this->is_good_url($_POST[$input_name]);
          break;
        }
        $this->post[$input_name] = $_POST[$input_name];
      }
    }
  }

  public function get_nonce () {
    return wp_nonce_field($this->secure_code);
  }

  public function get_builded_args () {
    return array(
      'post_title'   => $this->post['site_name'],
      'post_content' => $this->post['site_description'],
      'post_status'  => 'draft',
      'post_author'  => 1,
      'post_type'	   => 'fiche',
      'tax_input'    => array(
        "thematique" => [$this->post['site_category']] //Video Cateogry is Taxnmony Name and being used as key of array.
      ),
      'meta_input'   => array(
        'site_url' => $this->post['site_url'],
      ),
    );
  }

  public function has_error ($input_name) {
    return !empty($this->input_error[$input_name]);
  }

  public function get_error ($input_name) {
    return $this->input_error[$input_name];
  }

  public function get_value ($input_name) {
    if (!empty($this->post[$input_name])) {
      return $this->post[$input_name];
    }
    return null;
  }

  public function is_received () {
    return $this->has_submission;
  }

  public function is_valid_post () {
    return !$this->error;
  }

  public function empty_post () {
    $this->post = [];
  }

  protected function is_term_correct ($input_name): bool {
    if (
      in_array( $_POST[$input_name], array_keys($this->getTerms()) )
    ) {
      return true;
    }
    $this->setError($input_name, 'La thématique selectionnée semble avoir un problème !');
    return false;
}

  protected function is_good_url (string $url): bool {
    if (!filter_var($url, FILTER_SANITIZE_URL)) {
      $this->setError('site_url', 'L\'url fournie ne semble pas valide !');
      return false;
    }
    if (!checkdnsrr($url)) {
      $this->setError('site_url', 'Le site internet ne semble pas accessible !');
      return false;
    }

    return true;
  }

  protected function build_content (string $text): string {
    if (empty($text))
      return '';

    $paraph_start = '<!-- wp:paragraph {"placeholder":"Saisissez le contenu de la fiche ici."} -->
    <p>';
    $paraph_end = '</p>
    <!-- /wp:paragraph -->';

    $text = str_replace("\n", $paraph_end.$paraph_start, $text);

    return $paraph_start.$text.$paraph_end;
  }

  protected function not_empty (string $field_name): bool {
    if (empty($_POST[$field_name])) {
      if ($field_name === 'site_category') {
        $this->setError($field_name, 'Veuillez selectionner une thématique !');
        return false;
      } else {
        $this->setError($field_name, 'Ce champs est obligatoire !');
        return false;
      }
    }
    return true;
  }

  protected function setError ($input_name, $error_msg) {
    if (!in_array($input_name, $this->fillable))
      return;
    $this->input_error[$input_name][] = $error_msg;
    $this->error = true;
  }

}