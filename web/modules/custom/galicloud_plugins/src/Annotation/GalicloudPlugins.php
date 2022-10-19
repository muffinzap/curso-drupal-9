<?php

namespace Drupal\galicloud_plugins\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines galicloud_plugins annotation object.
 *
 * @Annotation
 */
class GalicloudPlugins extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $title;

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
