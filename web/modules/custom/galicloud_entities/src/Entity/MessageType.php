<?php

namespace Drupal\galicloud_entities\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Message type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "message_type",
 *   label = @Translation("Message type"),
 *   label_collection = @Translation("Message types"),
 *   label_singular = @Translation("message type"),
 *   label_plural = @Translation("messages types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count messages type",
 *     plural = "@count messages types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\galicloud_entities\Form\MessageTypeForm",
 *       "edit" = "Drupal\galicloud_entities\Form\MessageTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\galicloud_entities\MessageTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer message types",
 *   bundle_of = "message",
 *   config_prefix = "message_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/message_types/add",
 *     "edit-form" = "/admin/structure/message_types/manage/{message_type}",
 *     "delete-form" = "/admin/structure/message_types/manage/{message_type}/delete",
 *     "collection" = "/admin/structure/message_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class MessageType extends ConfigEntityBundleBase {

  /**
   * The machine name of this message type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the message type.
   *
   * @var string
   */
  protected $label;

}
