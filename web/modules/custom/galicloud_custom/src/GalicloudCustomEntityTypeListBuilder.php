<?php

namespace Drupal\galicloud_custom;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of galicloud custom entity type entities.
 *
 * @see \Drupal\galicloud_custom\Entity\GalicloudCustomEntityType
 */
class GalicloudCustomEntityTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No galicloud custom entity types available. <a href=":link">Add galicloud custom entity type</a>.',
      [':link' => Url::fromRoute('entity.galicloud_custom_entity_type.add_form')->toString()]
    );

    return $build;
  }

}
