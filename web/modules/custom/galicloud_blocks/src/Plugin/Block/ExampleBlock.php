<?php

namespace Drupal\galicloud_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "galicloud_blocks_example",
 *   admin_label = @Translation("Custom Block Example"),
 *   category = @Translation("Custom")
 * )
 */
class ExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
//    $user = \Drupal::currentUser();
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
