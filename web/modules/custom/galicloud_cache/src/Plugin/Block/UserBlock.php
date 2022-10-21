<?php

namespace Drupal\galicloud_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an user block.
 *
 * @Block(
 *   id = "galicloud_cache_user",
 *   admin_label = @Translation("User"),
 *   category = @Translation("Custom")
 * )
 */
class UserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected AccountInterface $currentUser;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $currentUser)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser= $currentUser;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $name = $this->currentUser->getAccountName();
    $email = $this->currentUser->getEmail();
    $build['block_content'] = [
      '#theme' => 'galicloud_cache_user_block',
      '#cache' => ['contexts' => ['user']],
      '#name' => $name,
      '#email' => $email,
    ];
    return $build;
  }

}
