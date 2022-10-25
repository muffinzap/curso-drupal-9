<?php

namespace Drupal\galicloud_crud\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Galicloud Crud form.
 */
class PeopleForm extends FormBase
{

//  protected Connection $database;
//  protected $currentUser;
//  public function __construct(Connection $database, AccountInterface $currentUser)
//  {
//    $this->database = $database;
//    $this->currentUser = $this->currentUser;
//  }
//
//  public static function create(ContainerInterface $container)
//  {
//    return new static(
//      $container->get('database'),
//      $container->get('current_user'),
//    );
//  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'galicloud_crud_people';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = null, $name = '', $age = '')
  {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $name,
      '#required' => TRUE,
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Age'),
      '#default_value' => $age,
      '#required' => TRUE,
    ];

    $form['id'] = array(
      '#type' => 'hidden',
      '#value' => $id,
    );


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
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if (empty($form_state->getValue('name'))) {
      $form_state->setErrorByName('name', $this->t('Write name'));
    }
    if (empty($form_state->getValue('age'))) {
      $form_state->setErrorByName('age', $this->t('Write age'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    //TODO inyectar database y current user
//    \Drupal::database()->insert('galicloud_people')->fields(['uid','name', 'age'])->values([
//      \Drupal::currentUser()->id(),
//      $form_state->getValue('name'),
//      $form_state->getValue('age')
//    ])->execute();


    \Drupal::database()->upsert('galicloud_people')
      ->key('id')
      ->fields(['id', 'uid', 'name', 'age'])->values([
        $form_state->getValue('id'),
        \Drupal::currentUser()->id(),
        $form_state->getValue('name'),
        $form_state->getValue('age')
      ])->execute();


    $this->messenger()->addStatus($this->t('Created people.'));
    $form_state->setRedirect('galicloud_crud.crud');
  }

}
