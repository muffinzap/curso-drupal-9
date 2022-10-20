<?php

namespace Drupal\galicloud_entities;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of galicloud entities sections.
 */
class GalicloudEntitiesSectionListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Label');
    $header['id'] = $this->t('Machine name');
//    $header['status'] = $this->t('Status');
    $header['urlPattern'] = $this->t('URL  Pattern');
    $header['color'] = $this->t('color');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\galicloud_entities\GalicloudEntitiesSectionInterface $entity */
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
//    $row['status'] = $entity->status() ? $this->t('Enabled') : $this->t('Disabled');
    $row['urlPattern'] = $entity->getUrlPattern();
    $row['color'] = $entity->getColor();
    return $row + parent::buildRow($entity);
  }

}
