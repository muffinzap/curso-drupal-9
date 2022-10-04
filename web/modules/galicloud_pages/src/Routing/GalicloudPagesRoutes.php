<?php

namespace Drupal\galicloud_pages\Routing;

use Symfony\Component\Routing\Route;

/**
 * Returns responses for Galicloud pages routes.
 */
class GalicloudPagesRoutes
{

  public function routes()
  {
    $routes = [];
    $node_types = \Drupal::entityTypeManager()->getStorage('node_type')->loadMultiple();
    foreach ($node_types as $type) {
      $routes["galicloud_pages.{$type->id()}.help"] = new Route('/galicloud/pages/node/' . $type->id() . '/help',
        [
          '_controller' =>
          '\Drupal\galicloud_pages\Controller\GalicloudPagesController::contentTypeHelpPage',
          '_title' => 'Content Type ' . $type->label(),
        ],
        [
          '_permission' => 'access content',
        ]
      );
    }
    return $routes;
  }

}
