<?php

namespace Drupal\galicloud_plugins;

/**
 * Interface for galicloud_plugins plugins.
 */
interface GalicloudPluginsInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

  public function description();

  public function generate($length);

}
