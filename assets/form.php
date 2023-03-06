<?php

class AddFicheForm {

  protected $fillable = [
    'site_name',
    'site_description',
    'site_category',
    'site_url'
  ];
  protected $post = [];

  public function __construct () {
    if (isset($_POST) && verify_nonce('add_fiche_action')) {
      $this->fillPost();
    }
  }


  protected function fillPost () {
    foreach ($_POST as $input_name => $input_value) {
      if (!in_array($input_name, $this->fillable))
        continue;
      $this->post[$input_name] = $input_value;
    }
  }

  protected function buildContent () {
    $desc = $this->post['site_description'];

  }

  protected function savePost () {
    $post_arr = array(
      'post_title'   => esc_html($this->post['site_name']),
      'post_content' => $video_description,
      'post_status'  => 'draft',
      'post_author'  => $user_id,
      'post_type'	   => 'videos',
      'tax_input'    => array(
        "video_category" => $this->post['site_category'] //Video Cateogry is Taxnmony Name and being used as key of array.
      ),
      'meta_input'   => array(
        'wc_video_url' => $video_url,
      ),
    );

  }


}