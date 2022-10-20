<?php

namespace Drupal\galicloud_jquery\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Galicloud jquery routes.
 */
class GalicloudJqueryController extends ControllerBase
{

  /**
   * Builds the response.
   */
  public function build()
  {

    $build['text'] = [
      '#markup' => '<p>' . $this->t('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tristique enim
       lorem, quis imperdiet ante luctus non. Phasellus sapien neque, placerat sed odio ut, efficitur tincidunt dui.')
        . '</p>',
    ];

    $build['temp_text'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#attributes' => [
        'class' => 'fadeout',
      ],
      '#value' => $this->t('This text will disappear in 5 seconds...'),
      '#attached' => [
        'library' => [
          'forcontu_jquery/forcontu_jquery.fadeout',
        ],
      ],
    ];
    return $build;
  }

}
