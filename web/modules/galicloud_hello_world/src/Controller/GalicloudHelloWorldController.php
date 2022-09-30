<?php

namespace Drupal\galicloud_hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for galicloud hello world routes.
 */
class GalicloudHelloWorldController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
