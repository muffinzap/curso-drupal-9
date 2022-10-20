<?php

namespace Drupal\galicloud_entities;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Link;

/**
 * Provides a list controller for the message entity type.
 */
class MessageListBuilder extends EntityListBuilder
{


  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new MessageListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter)
  {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type)
  {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function render()
  {
    $build['table'] = parent::render();

    $total = $this->getStorage()
      ->getQuery()
      ->accessCheck(FALSE)
      ->count()
      ->execute();

    $build['summary']['#markup'] = $this->t('Total messages: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader()
  {
    $header['id'] = $this->t('ID');
    $header['from'] = $this->t('From');
    $header['to'] = $this->t('To');
    $header['subject'] = $this->t('Subject');
    $header['created'] = $this->t('Created');
//    $header['label'] = $this->t('Label');
//    $header['status'] = $this->t('Status');
//    $header['uid'] = $this->t('Author');
//    $header['created'] = $this->t('Created');
//    $header['changed'] = $this->t('Updated');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {
    /** @var \Drupal\galicloud_entities\MessageInterface $entity */
    $row['id'] = $entity->id();
    $row['from'] = $entity->getOwner()->getAccountName();
    $row['to'] = $entity->getUserTo()->getAccountName();

    $link = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.message.edit_form', [
          'message' => $entity->id(),
        ]
      )
    );
    $row['subject'] = $link;
    $row['created'] = $this->dateFormatter->format($entity->getCreatedTime(), 'short');
//    $row['label'] = $entity->toLink();
//    $row['status'] = $entity->get('status')->value ? $this->t('Enabled') : $this->t('Disabled');
//    $row['uid']['data'] = [
//      '#theme' => 'username',
//      '#account' => $entity->getOwner(),
//    ];
//    $row['created'] = $this->dateFormatter->format($entity->get('created')->value);
//    $row['changed'] = $this->dateFormatter->format($entity->getChangedTime());
    return $row + parent::buildRow($entity);
  }

}
