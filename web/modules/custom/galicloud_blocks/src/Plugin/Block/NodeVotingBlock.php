<?php

namespace Drupal\galicloud_blocks\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a nodevotingblock block.
 *
 * @Block(
 *   id = "galicloud_blocks_nodevotingblock",
 *   admin_label = @Translation("NodeVotingBlock"),
 *   category = @Translation("Custom")
 * )
 */
class NodeVotingBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  protected RouteMatchInterface $currentRouteMatch;
  protected FormBuilderInterface $formBuilder;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $current_route_match, FormBuilderInterface $form_builder)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentRouteMatch = $current_route_match;
    $this->formBuilder = $form_builder;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get('form_builder')
    );
  }

  protected function blockAccess(AccountInterface $account)
  {
    $node = $this->currentRouteMatch->getParameter('node');
    if ($node && $account->isAuthenticated()) {
      return AccessResult::allowed();
    } else {
      return AccessResult::forbidden();
    }

  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form = $this->formBuilder->getForm('Drupal\galicloud_blocks\Form\NodeVotingForm');
    return $form;
  }

}
