<?php

namespace Drupal\galicloud_pages\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Galicloud pages routes.
 */
class GalicloudPagesController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function simple() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
