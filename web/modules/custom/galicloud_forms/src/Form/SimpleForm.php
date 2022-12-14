<?php

namespace Drupal\galicloud_forms\Form;

use Drupal\Component\Utility\EmailValidator;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Galicloud forms form.
 */
class SimpleForm extends FormBase
{

  protected AccountInterface $currentUser;
  protected EmailValidator $emailValidator;
  protected Connection $database;

  /**
   * Inyectamos las dependencias que necesitamos
   *
   * @param AccountInterface $current_user
   */
  public function __construct(AccountInterface $current_user, EmailValidator $emailValidator, Connection $databaseConnection)
  {
    $this->currentUser = $current_user;
    $this->emailValidator = $emailValidator;
    $this->database = $databaseConnection;
  }

  /**
   * El método create() se encargará de traer los servicios desde el contenedor de servicios.
   *
   * @param ContainerInterface $container
   * @return SimpleForm|static
   */

  public static function create(ContainerInterface $container)
  {
//    return parent::create($container); // TODO: Change the autogenerated stub
    return new static(
      $container->get('current_user'),
      $container->get('email.validator'),
      $container->get('database')

    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'galicloud_forms_simple';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#description' => $this->t('Your username.'),
      '#default_value' => $this->currentUser->getAccountName(),
      '#required' => TRUE,
    ];

    $form['user_email'] = [
      '#type' => 'email',
      '#title' => $this->t('User email'),
      '#description' => $this->t('Your email.'),
      '#required' => TRUE,
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
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if (mb_strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('message', $this->t('Message should be at least 10 characters.'));
    }

    $email = $form_state->getValue('user_email');
    if (!$this->emailValidator->isValid($email)) {
      $form_state->setErrorByName('user_email', $this->t('%email is not a valid email address.', ['%email' => $email]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->database->insert('galicloud_forms_simple')
      ->fields([
        'message' => $form_state->getValue('message'),
        'username' => $form_state->getValue('username'),
        'email' => $form_state->getValue('user_email'),
        'uid' => $this->currentUser->id(),
        'timestamp' => \Drupal::time()->getRequestTime(),
      ])
      ->execute();

    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $msg = $form_state->getValue('message');
    \Drupal::state()->set("galicloud_form_message", $msg);

    $this->logger('galicloud_forms')->notice('New Simple Form entry from user %username inserted: %message.',
      [
        '%username' => $form_state->getValue('username'),
        '%message' => $form_state->getValue('message'),
      ]);

//    $form_state->setRedirect('<front>');
    $form_state->setRedirect('galicloud_pages.simple');
  }

//  public function access(AccountInterface $account) {
//    return AccessResult::allowedIf($account->hasPermission('galicloud form access') &&
//      $account->hasPermission('administer site configuration'));
//  }

}
