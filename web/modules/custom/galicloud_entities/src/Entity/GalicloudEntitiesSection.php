<?php

namespace Drupal\galicloud_entities\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\galicloud_entities\GalicloudEntitiesSectionInterface;

/**
 * Defines the galicloud entities section entity type.
 *
 * @ConfigEntityType(
 *   id = "galicloud_entities_section",
 *   label = @Translation("Galicloud Entities Section"),
 *   label_collection = @Translation("Galicloud Entities Sections"),
 *   label_singular = @Translation("galicloud entities section"),
 *   label_plural = @Translation("galicloud entities sections"),
 *   label_count = @PluralTranslation(
 *     singular = "@count galicloud entities section",
 *     plural = "@count galicloud entities sections",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\galicloud_entities\GalicloudEntitiesSectionListBuilder",
 *     "form" = {
 *       "add" = "Drupal\galicloud_entities\Form\GalicloudEntitiesSectionForm",
 *       "edit" = "Drupal\galicloud_entities\Form\GalicloudEntitiesSectionForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "galicloud_entities_section",
 *   admin_permission = "administer galicloud_entities_section",
 *   links = {
 *     "collection" = "/admin/structure/galicloud-entities-section",
 *     "add-form" = "/admin/structure/galicloud-entities-section/add",
 *     "edit-form" = "/admin/structure/galicloud-entities-section/{galicloud_entities_section}",
 *     "delete-form" = "/admin/structure/galicloud-entities-section/{galicloud_entities_section}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *     "urlPattern",
 *     "color"
 *   }
 * )
 */
class GalicloudEntitiesSection extends ConfigEntityBase implements GalicloudEntitiesSectionInterface {

  /**
   * The galicloud entities section ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The galicloud entities section label.
   *
   * @var string
   */
  protected $label;

  /**
   * The galicloud entities section status.
   *
   * @var string
   */
  protected $urlPattern;

  /**
   * The galicloud_entities_section description.
   *
   * @var string
   */
  protected $color;


  public function getUrlPattern()
  {
    return $this->urlPattern;
  }


  public function setUrlPattern($pattern)
  {
    $this->urlPattern = $pattern;
  }

  /**
   * @return string
   */
  public function getColor()
  {
    return $this->color;
  }

  /**
   * @param string $color
   */
  public function setColor($color)
  {
    $this->color = $color;
  }


}
