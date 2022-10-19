<?php

namespace Drupal\galicloud_plugins;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
//IMPORTANTE
//use Drupal\galicloud_plugins\Annotation\GalicloudPlugins;

/**
 * GalicloudPlugins plugin manager.
 */
class GalicloudPluginsPluginManager extends DefaultPluginManager {

  /**
   * Constructs GalicloudPluginsPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/GalicloudPlugins',
      $namespaces,
      $module_handler,
      'Drupal\galicloud_plugins\GalicloudPluginsInterface',
      'Drupal\galicloud_plugins\Annotation\GalicloudPlugins'
    );
    $this->alterInfo('galicloud_plugins_gipsum');
    $this->setCacheBackend($cache_backend, 'galicloud_plugins_gipsum');
  }

}
