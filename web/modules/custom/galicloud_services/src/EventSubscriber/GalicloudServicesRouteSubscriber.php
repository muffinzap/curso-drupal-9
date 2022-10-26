<?php

namespace Drupal\galicloud_services\EventSubscriber;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Route subscriber.
 */
class GalicloudServicesRouteSubscriber extends RouteSubscriberBase
{

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection)
  {
    foreach ($collection->all() as $route) {
      // Hide taxonomy pages from unprivileged users.
      if (strpos($route->getPath(), '/taxonomy/term') === 0) {
        $route->setRequirement('_role', 'administrator');
      }

      // Cambia la ruta '/user/login' a '/private'.
//      if ($route = $collection->get('user.login')) {
//        $route->setPath('/private');
//      }
//      // Deniega el acceso a la página de perfil de usuario
//      if ($route = $collection->get('entity.user.canonical')) {
//        $route->setRequirement('_access', 'FALSE');
//      }

    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents()
  {
    $events = parent::getSubscribedEvents();

    // Use a lower priority than \Drupal\views\EventSubscriber\RouteSubscriber
    // to ensure the requirement will be added to its routes.
    $events[RoutingEvents::ALTER] = ['onAlterRoutes', -300];

    return $events;
  }

}
