<?php

namespace Drupal\galicloud_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Returns responses for Galicloud pages routes.
 */
class GalicloudPagesController extends ControllerBase
{

  /**
   * Builds the response.
   */
  public function simple()
  {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works simple!'),
    ];

    return $build;
  }

  /**
   * Builds the response.
   */
  public function calculator($num1, $num2)
  {

    if (!is_numeric($num1) || !is_numeric($num2)) {
      throw new BadRequestHttpException(t('No numeric arguments specified.'));
    }

    $list[] = $this->t("@num1 + @num2 = @sum",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@sum' => $num1 + $num2
      ]
    );
    $list[] = $this->t("@num1 - @num2 = @difference",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@difference' => $num1 - $num2
      ]
    );
    $list[] = $this->t("@num1 x @num2 = @product",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@product' => $num1 * $num2
      ]
    );

    if ($num2 != 0)
      $list[] = $this->t("@num1 / @num2 = @division",
        [
          '@num1' => $num1,
          '@num2' => $num2,
          '@division' => $num1 / $num2
        ]
      );
    else {
      $list[] = $this->t("@num1 / @num2 = undefined (division by zero)",
        array('@num1' => $num1, '@num2' => $num2));
    }

    $output['forcontu_pages_calculator'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Operations:'),
    ];
    return $output;
  }


}