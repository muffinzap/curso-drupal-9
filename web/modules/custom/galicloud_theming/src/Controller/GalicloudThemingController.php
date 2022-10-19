<?php

namespace Drupal\galicloud_theming\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Galicloud Theming routes.
 */
class GalicloudThemingController extends ControllerBase
{

  /**
   * Builds the response.
   */
  public function build()
  {
    //Ej 1
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];
    //EJ 2: table
    $header = ["Col 1", "Col2", "Col 3"];
    $rows[] = ["A", "B", "C"];
    $rows[] = ["D", "E", "F"];

    $build['galicloud_theming_table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    //Example 3: list
    $list = ['Item 1', 'Item 2', 'Item 3'];
    $build['galicloud_theming_list'] = [
      '#theme' => 'item_list',
      '#title' => $this->t('List of items'),
      '#list_type' => 'ol',
      '#items' => $list,
    ];

    //Example 4: elementos hijos
//    $list2 = ['Item 4', 'Item 5', 'Item 6'];
//    $build = [
//      'container' => [
//        '#prefix' => '<div id="container">',
//        '#suffix' => '</div>',
//        '#markup' => $this->t('This is a container div'),
//        'list' => [
//          '#theme' => 'item_list',
//          '#title' => $this->t('List of items'),
//          '#list_type' => 'ol',
//          '#items' => $list2,
//        ],
//      ],
//    ];

    #Example 5: custom tempplate
    $build['item_dimensions'] = [
      '#theme' => 'galicloud_theming_dimensions',
      '#length' => 12,
      '#width' => 8,
      '#height' => 24,
      '#attached' => [
        'library' => [
          'galicloud_theming/global',
        ],
      ],
    ];

    return $build;
  }

}
