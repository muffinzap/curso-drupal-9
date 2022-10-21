<?php

namespace Drupal\galicloud_ajax\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns responses for Galicloud ajax routes.
 */
class GalicloudAjaxAutocompleteController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(Request $request) {

    $string = $request->query->get('q');
    $users = [ 'admin', 'foo', 'foobar', 'foobaz' ];
    $matches = preg_grep("/$string/i", $users);
    return new JsonResponse(array_values($matches));

  }

}
