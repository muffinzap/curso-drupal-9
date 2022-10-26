<?php

namespace Drupal\galicloud_custom\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Galicloud custom entity type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "galicloud_custom_entity_type",
 *   label = @Translation("Galicloud custom entity type"),
 *   label_collection = @Translation("Galicloud custom entity types"),
 *   label_singular = @Translation("galicloud custom entity type"),
 *   label_plural = @Translation("galicloud custom entities types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count galicloud custom entities type",
 *     plural = "@count galicloud custom entities types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\galicloud_custom\Form\GalicloudCustomEntityTypeForm",
 *       "edit" = "Drupal\galicloud_custom\Form\GalicloudCustomEntityTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\galicloud_custom\GalicloudCustomEntityTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer galicloud custom entity types",
 *   bundle_of = "galicloud_custom_entity",
 *   config_prefix = "galicloud_custom_entity_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/galicloud_custom_entity_types/add",
 *     "edit-form" = "/admin/structure/galicloud_custom_entity_types/manage/{galicloud_custom_entity_type}",
 *     "delete-form" = "/admin/structure/galicloud_custom_entity_types/manage/{galicloud_custom_entity_type}/delete",
 *     "collection" = "/admin/structure/galicloud_custom_entity_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class GalicloudCustomEntityType extends ConfigEntityBundleBase {

  /**
   * The machine name of this galicloud custom entity type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the galicloud custom entity type.
   *
   * @var string
   */
  protected $label;

}
