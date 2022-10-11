<?php

namespace Drupal\galicloud_blocks\Plugin\Block;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a highlightedcontentblock block.
 *
 * @Block(
 *   id = "galicloud_blocks_highlightedcontentblock",
 *   admin_label = @Translation("HighlightedContentBlock"),
 *   category = @Translation("Custom")
 * )
 */
class HighlightedcontentblockBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  protected AccountInterface $currentUser;
  protected Connection $database;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $currentUser, Connection $database)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
    $this->database = $database;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('database'),

    );
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {

    $node_number = $this->configuration['node_number'];
    $block_message = $this->configuration['block_message'];

    $build[] = [
      '#markup' => '<h3>' . $block_message . '</h3>',
    ];

    $result = $this->database->select('galicloud_node_highlighted', 'f')
      ->fields('f', ['nid'])
      ->condition('highlighted', 1)
      ->orderBy('nid', 'DESC')
      ->range(0, $node_number)
      ->execute();

    $list = [];

    $node_storage = \Drupal::entityTypeManager()->getStorage('node');


    foreach ($result as $record) {
      $node = $node_storage->load($record->nid);
      $list[] = $node->toLink($node->getTitle())->toRenderable();
    }
    if (empty($list)) {
      $build[] = [
        '#markup' => '<h3>' . $this->t('No results found') . '</h3>',
      ];
    } else {

      $build[] = [
        '#theme' => 'item_list',
        '#items' => $list,
        '#cache' => ['max-age' => 0],
      ];
    }


    return $build;
  }

  public function blockForm($form, FormStateInterface $form_state)
  {
    $form['galicloud_blocks_block_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Display message'),
      '#default_value' => $this->configuration['block_message'],
    ];
    $range = range(1, 10);
    $form['galicloud_blocks_node_number'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of nodes'),
      '#default_value' => $this->configuration['node_number'],
      '#options' => array_combine($range, $range),
    ];
    return $form;

  }

  public function blockValidate($form, FormStateInterface $form_state)
  {
    if (strlen($form_state->getValue('galicloud_blocks_block_message')) < 5) {
      $form_state->setErrorByName('galicloud_blocks_block_message',
        $this->t('The text must be at least 5 characters long'));
    }
  }

  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $this->configuration['block_message'] = $form_state->getValue('galicloud_blocks_block_message');
    $this->configuration['node_number'] = $form_state->getValue('galicloud_blocks_node_number');
  }

  public function defaultConfiguration()
  {
    return [
      'block_message' => 'List of highlighted nodes',
      'node_number' => 5,
    ];
  }

  protected function blockAccess(AccountInterface $account)
  {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

}
