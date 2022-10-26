<?php

namespace Drupal\galicloud_services\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Defines a theme negotiator that deals with the active theme on example page.
 */
class GalicloudServicesNegotiator implements ThemeNegotiatorInterface {
  protected AccountInterface $currentUser;


  /**
   * Constructs a new GalicloudServicesNegotiator.
   *
   *
   *   The request stack used to retrieve the current request.
   */
  public function __construct(AccountInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
//    return $route_match->getRouteName() == 'galicloud_services.example';
    return $this->currentUser->isAnonymous();

  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    // Allow users to pass theme name through 'theme' query parameter.
//    $theme = $this->requestStack->getCurrentRequest()->query->get('theme');
//    if (is_string($theme)) {
//      return $theme;
//    }
    return 'bartik';
  }

}
