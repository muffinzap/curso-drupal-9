<?php

namespace Drupal\galicloud_plugins\Plugin\GalicloudPlugins;

use Drupal\galicloud_plugins\GalicloudPluginsPluginBase;

/**
 * Plugin implementation of the galicloud_plugins.
 *
 * @GalicloudPlugins(
 *   id = "galicloud_ipsum",
 *   label = @Translation("Galicloud Ipsum"),
 *   description = @Translation("Galicloud Ipsum description.")
 * )
 */
class Galicloud extends GalicloudPluginsPluginBase
{

  function generate($length)
  {
    $content = preg_replace('#<[^>]+>#', ' ', file_get_contents('https://www.galicloud.com'));
    $content = preg_replace('/\s+/', ' ', $content);
    $content = preg_replace('/[0-9\,\(\)]+/', '', $content);
    $content_array = explode(' ', $content);
    shuffle($content_array);
    return 'Galicloud ipsum ' . substr(implode(' ', $content_array), 0, $length) . '.';
  }

}
