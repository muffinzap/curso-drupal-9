<?php

namespace Drupal\galicloud_plugins;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for galicloud_plugins plugins.
 */
abstract class GalicloudPluginsPluginBase extends PluginBase implements GalicloudPluginsInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  public function description() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['description'];
  }

  abstract function generate($length);


}
