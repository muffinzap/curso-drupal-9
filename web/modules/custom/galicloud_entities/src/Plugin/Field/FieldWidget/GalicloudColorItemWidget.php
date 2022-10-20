<?php

namespace Drupal\galicloud_entities\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'galicloud_entities_text' widget.
 *
 * @FieldWidget(
 *   id = "galicloud_entities_text",
 *   module = "galicloud_entities",
 *   label = @Translation("RGB value as #ffffff"),
 *   field_types = {
 *     "galicloud_entities_color"
 *   }
 * )
 */
class GalicloudColorItemWidget extends WidgetBase
{

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '#ffffff';
    $element += [
      '#type' => 'textfield',
      '#default_value' => $value,
      '#size' => 7,
      '#maxlength' => 7,
    ];
    return ['value' => $element];
  }

}
