<?php

namespace YannSoaz\Annuaire;


class FicheForm {
  
  protected $message = [];

  protected FicheFormSanitizer $formContent;

  public function __construct () {
    $this->formContent = new FicheFormSanitizer();

    if ($this->formContent->is_received() && $this->formContent->is_valid_post()) {
      $this->savePost();
    }
  }

  protected function savePost () {
    $post = wp_insert_post($this->formContent->get_builded_args());
    if (is_wp_error($post)) {
      $this->message = [
        'content' => 'Un problème à eu lieu lors de l\'enregistrement de votre contenu. Veuillez reessayer plus tard !',
        'type' => 'error'
      ];
    } else {
      if (ANNUAIRE_FORM_REDIRECT) {
        wp_safe_redirect($url);
        exit;
      } else {
        $this->formContent->empty_post();
        $this->message = [
          'content' => 'Nous avons bien enregistré votre recommandation et vous remercions de votre proposition, un administrateur décidera de sa publication prochainement !',
          'type' => 'success'
        ];
      }
    }
  }

  protected function nonce () {
    return $this->formContent->get_nonce();
  }

  protected function old ($input_name) {
    return $this->formContent->get_value($input_name);
  }

  protected function themes () {
    return $this->formContent->getTerms();
  }

  protected function error ($input_name) {
    $error = $this->formContent->get_error($input_name);
    if (!empty($error)) {
      $output = '<p class="field_error">';
      foreach ($error as $err) {
        $output .= '<span>'.$err.'</span>';
      }
      $output .= '</p>';
      return $output;
    }
    return null;
  }

  public function render () {
    ob_start();
    ?> 
      <?php if (!empty($this->message)) {
        ?>
          <p class="ys_form_message ys_<?= $this->message['type'] ?>">
            <?= $this->message['content'] ?>
          </p>
        <?php
      }
      ?>
      <form method="post" id="ys_fiche_form">
        <div class="ys_form_field ys_name_field">
          <label for="site_name">Titre du site</label>
          <input type="text" name="site_name" id="site_name" required value="<?= $this->old('site_name') ?>">
          <?= $this->error('site_name') ?>
        </div>
        <div class="ys_form_field ys_url_field">
          <label for="site_url">URL du site</label>
          <input type="url" name="site_url" id="site_url" required value="<?= $this->old('site_url') ?>">
          <?= $this->error('site_url') ?>
        </div>
        <div class="ys_form_field ys_cat_field">
          <label for="site_category">URL du site</label>
          <select name="site_category" id="site_category" required>
            <option value="">Selectionnez une thématique</option>
            <?php
              foreach ($this->themes() as $id => $name) {
                ?>
                  <option value="<?= $id ?>" <?php if($this->old('site_category') === $id) { echo 'selected'; } ?> ><?= $name ?></option>
                <?php
              }
            ?>
          </select>
          <?= $this->error('site_category') ?>
        </div>
        <div class="ys_form_field ys_desc_field">
          <label for="site_description">Description du site</label>
          <textarea name="site_description" id="site_description"></textarea>
          <?= $this->error('site_description') ?>
        </div>

        <input type="submit" value="Envoyer">
        <?= $this->nonce() ?>

      </form>
    <?php
    $form = ob_get_clean();
    return $form;
  }


}