<?php

namespace Drupal\galicloud_custom\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Galicloud Custom routes.
 */
class GalicloudCustomController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build($id) {

    $entity = \Drupal::entityTypeManager()->getStorage('galicloud_custom_entity')->load($id);
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder('galicloud_custom_entity');
    $render =  $view_builder->view($entity,'default');

    \Drupal::moduleHandler()->alter('galicloud_title', $render);

    return $render;
  }

}
