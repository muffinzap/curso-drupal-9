<?php

namespace Drupal\galicloud_ajax\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Galicloud ajax form.
 */
class AutocompleteForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'galicloud_ajax_autocomplete';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['user'] = [
      '#type' => 'textfield',
      '#title' => 'Username',
      '#autocomplete_route_name' => 'galicloud_ajax.autocomplete_user',
    ];


    //entity_autocomplete
    $form['selected_node'] = [
      '#type' => 'entity_autocomplete',
      '#title' => 'Select a content',
      '#target_type' => 'node',
      '#selection_handler' => 'default',
      '#selection_settings' => [
        'target_bundles' => ['article', 'page'],
      ],
    ];


    //entity_autocomplete con autocreate
    $form['tags'] = [
      '#title' => 'Category',
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#autocreate' => [
        'bundle' => 'tags',
      ],
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
//    if (mb_strlen($form_state->getValue('message')) < 10) {
//      $form_state->setErrorByName('message', $this->t('Message should be at least 10 characters.'));
//    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    //Create taxonomy term on submit
    $tag = $form_state->getValue('tags');
    if (empty($tag)) {
      $this->messenger()->addStatus("Tag is empty, nothing to do");
    }
    elseif (is_string($tag)) {
      $this->messenger()->addStatus("A term selected, tid = $tag");
    }
    elseif (isset($tag['entity']) && ($tag['entity'] instanceof \Drupal\taxonomy\Entity\Term)) {
      $entity = $tag['entity'];
      $entity->save();
      $this->messenger()->addStatus("A new term : " . $entity->id() . " : " . $entity->label());
    }

    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
