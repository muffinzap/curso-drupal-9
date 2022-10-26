<?php

namespace Drupal\galicloud_custom;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a galicloud custom entity entity type.
 */
interface GalicloudCustomEntityInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
