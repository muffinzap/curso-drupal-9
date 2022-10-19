<?php

namespace Drupal\galicloud_plugins\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\galicloud_plugins\GalicloudPluginsPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for galicloud Plugins routes.
 */
class GalicloudPluginsController extends ControllerBase {

  protected GalicloudPluginsPluginManager $fipsum;

  public function __construct(GalicloudPluginsPluginManager $fipsum)
  {
    $this->fipsum = $fipsum;

  }

  public static function create(ContainerInterface $container)
  {
    return new static($container->get('plugin.manager.gipsum'));
  }

  /**
   * Builds the response.
   */
//  public function build() {
//
//    $build['content'] = [
//      '#type' => 'item',
//      '#markup' => $this->t('It works!'),
//    ];
//
//    return $build;
//  }

  public function gipsum()
  {
    $lorem_ipsum = $this->fipsum->createInstance('lorem_ipsum');
    $build['fipsum_lorem_ipsum_title'] = [
      '#markup' => '<h2>' . $lorem_ipsum->description() . '</h2>',
    ];
    $build['fipsum_lorem_ipsum_text'] = [
      '#markup' => '<p>' . $lorem_ipsum->generate(300) . '</p>',
    ];
    $galicloud_ipsum = $this->fipsum->createInstance('galicloud_ipsum');
    $build['fipsum_galicloud_ipsum_title'] = [
      '#markup' => '<h2>' . $galicloud_ipsum->description() . '</h2>',
    ];
    $build['fipsum_galicloud_ipsum_text'] = [
      '#markup' => '<p>' . $galicloud_ipsum->generate(600) . '</p>',
    ];
    return $build;
  }

}
