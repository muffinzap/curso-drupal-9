<?php

namespace Drupal\galicloud_entities\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\galicloud_entities\MessageInterface;
use Drupal\user\EntityOwnerTrait;
use Drupal\user\UserInterface;

/**
 * Defines the message entity class.
 *
 * @ContentEntityType(
 *   id = "message",
 *   label = @Translation("Message"),
 *   label_collection = @Translation("Messages"),
 *   label_singular = @Translation("message"),
 *   label_plural = @Translation("messages"),
 *   label_count = @PluralTranslation(
 *     singular = "@count messages",
 *     plural = "@count messages",
 *   ),
 *   bundle_label = @Translation("Message type"),
 *   handlers = {
 *     "list_builder" = "Drupal\galicloud_entities\MessageListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\galicloud_entities\Form\MessageForm",
 *       "edit" = "Drupal\galicloud_entities\Form\MessageForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "message",
 *   admin_permission = "administer message types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "subject",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/message",
 *     "add-form" = "/message/add/{message_type}",
 *     "add-page" = "/message/add",
 *     "canonical" = "/message/{message}",
 *     "edit-form" = "/message/{message}/edit",
 *     "delete-form" = "/message/{message}/delete",
 *   },
 *   bundle_entity_type = "message_type",
 *   field_ui_base_route = "entity.message_type.edit_form",
 * )
 */
class Message extends ContentEntityBase implements MessageInterface
{

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage)
  {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  public function getType()
  {
    return $this->bundle();
  }

  public function getSubject()
  {
    return $this->get('subject')->value;
  }

  public function setSubject($subject)
  {
    $this->set('subject', $subject);
    return $this;
  }

  public function getCreatedTime()
  {
    return $this->get('created')->value;
  }

  public function setCreatedTime($timestamp)
  {
    $this->set('created', $timestamp);
    return $this;
  }

  public function getOwner()
  {
    return $this->get('user_id')->entity;
  }

  public function getOwnerId()
  {
    return $this->get('user_id')->target_id;
  }

  public function setOwnerId($uid)
  {
    $this->set('user_id', $uid);
    return $this;
  }

  public function setOwner(UserInterface $account)
  {
    $this->set('user_id', $account->id());
    return $this;
  }

  public function isPublished()
  {
    return (bool)$this->getEntityKey('status');
  }

  public function setPublished($published)
  {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  public function getUserToId()
  {
    return $this->get('user_to')->target_id;
  }

  public function setUserToId($uid)
  {
    $this->set('user_to', $uid);
    return $this;
  }

  public function getUserTo()
  {
    return $this->get('user_to')->entity;
  }

  public function setUserTo(UserInterface $account)
  {
    $this->set('user_to', $account->id());
    return $this;
  }

  public function getContent()
  {
    return $this->get('content')->value;
  }

  public function setContent($content)
  {
    $this->set('content', $content);
    return $this;
  }

  public function isRead()
  {
    return (bool)$this->getEntityKey('is_read');
  }

  public function setRead($read)
  {
    $this->set('is_read', $read ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
  {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Message entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['user_to'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('To'))
      ->setDescription(t('The user ID of the Message recipient.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'To',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['subject'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Subject'))
      ->setDescription(t('The subject of the Message entity.'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['content'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Content'))
      ->setDescription(t('The content of the Message'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', ['type' => 'text_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['is_read'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Read'))
      ->setDescription(t('A boolean indicating whether the Message is read.'))
      ->setDefaultValue(FALSE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Message is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));



//    $fields['label'] = BaseFieldDefinition::create('string')
//      ->setLabel(t('Label'))
//      ->setRequired(TRUE)
//      ->setSetting('max_length', 255)
//      ->setDisplayOptions('form', [
//        'type' => 'string_textfield',
//        'weight' => -5,
//      ])
//      ->setDisplayConfigurable('form', TRUE)
//      ->setDisplayOptions('view', [
//        'label' => 'hidden',
//        'type' => 'string',
//        'weight' => -5,
//      ])
//      ->setDisplayConfigurable('view', TRUE);
//
//    $fields['status'] = BaseFieldDefinition::create('boolean')
//      ->setLabel(t('Status'))
//      ->setDefaultValue(TRUE)
//      ->setSetting('on_label', 'Enabled')
//      ->setDisplayOptions('form', [
//        'type' => 'boolean_checkbox',
//        'settings' => [
//          'display_label' => FALSE,
//        ],
//        'weight' => 0,
//      ])
//      ->setDisplayConfigurable('form', TRUE)
//      ->setDisplayOptions('view', [
//        'type' => 'boolean',
//        'label' => 'above',
//        'weight' => 0,
//        'settings' => [
//          'format' => 'enabled-disabled',
//        ],
//      ])
//      ->setDisplayConfigurable('view', TRUE);
//
//    $fields['description'] = BaseFieldDefinition::create('text_long')
//      ->setLabel(t('Description'))
//      ->setDisplayOptions('form', [
//        'type' => 'text_textarea',
//        'weight' => 10,
//      ])
//      ->setDisplayConfigurable('form', TRUE)
//      ->setDisplayOptions('view', [
//        'type' => 'text_default',
//        'label' => 'above',
//        'weight' => 10,
//      ])
//      ->setDisplayConfigurable('view', TRUE);
//
//    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
//      ->setLabel(t('Author'))
//      ->setSetting('target_type', 'user')
//      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
//      ->setDisplayOptions('form', [
//        'type' => 'entity_reference_autocomplete',
//        'settings' => [
//          'match_operator' => 'CONTAINS',
//          'size' => 60,
//          'placeholder' => '',
//        ],
//        'weight' => 15,
//      ])
//      ->setDisplayConfigurable('form', TRUE)
//      ->setDisplayOptions('view', [
//        'label' => 'above',
//        'type' => 'author',
//        'weight' => 15,
//      ])
//      ->setDisplayConfigurable('view', TRUE);
//
//    $fields['created'] = BaseFieldDefinition::create('created')
//      ->setLabel(t('Authored on'))
//      ->setDescription(t('The time that the message was created.'))
//      ->setDisplayOptions('view', [
//        'label' => 'above',
//        'type' => 'timestamp',
//        'weight' => 20,
//      ])
//      ->setDisplayConfigurable('form', TRUE)
//      ->setDisplayOptions('form', [
//        'type' => 'datetime_timestamp',
//        'weight' => 20,
//      ])
//      ->setDisplayConfigurable('view', TRUE);
//
//    $fields['changed'] = BaseFieldDefinition::create('changed')
//      ->setLabel(t('Changed'))
//      ->setDescription(t('The time that the message was last edited.'));

    return $fields;
  }

}
