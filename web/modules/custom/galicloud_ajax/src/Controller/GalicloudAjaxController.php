<?php

namespace Drupal\galicloud_ajax\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Returns responses for Galicloud ajax routes.
 */
class GalicloudAjaxController extends ControllerBase
{

  /**
   * Builds the response.
   */
  public function link()
  {

    $build['text'] = [
      '#markup' => '<p>' . $this->t('Click the link to get the updated time from server.') . '</p>',
    ];
    $build['time'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => date("H:i:s"),
      '#attributes' => [
        'id' => 'time',
      ],
    ];
    $build['refresh_time'] = [
      '#title' => $this->t('Refresh time'),
      '#type' => 'link',
      '#url' => Url::fromRoute('galicloud_ajax.link_callback'),
      '#attributes' => [
        'class' => 'use-ajax',
      ],
    ];
    return $build;
  }

  /**
   * Builds the response.
   */
  public function linkCallback()
  {
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand(
      '#time',
      '<div id="time">' . date("H:i:s") . ' (' . $this->t("via AJAX") . ')</div>')
    );
    return $response;
  }

}
