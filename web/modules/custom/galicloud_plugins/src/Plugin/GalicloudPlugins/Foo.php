<?php

namespace Drupal\galicloud_plugins\Plugin\GalicloudPlugins;

use Drupal\galicloud_plugins\GalicloudPluginsPluginBase;

/**
 * Plugin implementation of the galicloud_plugins.
 *
 * @GalicloudPlugins(
 *   id = "lorem_ipsum",
 *   label = @Translation("Lorem Ipsum"),
 *   description = @Translation("Lorem Ipsum description.")
 * )
 */
class Foo extends GalicloudPluginsPluginBase {

  function generate($length)
  {
    return
      substr(file_get_contents('http://loripsum.net/api/1/verylong/plaintext'), 0, $length) . '.';
  }

}
