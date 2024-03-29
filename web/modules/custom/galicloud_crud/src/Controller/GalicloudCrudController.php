<?php

namespace Drupal\galicloud_crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Returns responses for Galicloud crud routes.
 */
class GalicloudCrudController extends ControllerBase
{

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * The controller constructor.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user.
   */
  public function __construct(Connection $connection, AccountInterface $account)
  {
    $this->connection = $connection;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('database'),
      $container->get('current_user')
    );
  }

  /**
   * Builds the response.
   */
  public function build()
  {


    $build['form'] = \Drupal::formBuilder()->getForm('Drupal\galicloud_crud\Form\PeopleForm');

    $header = [
//      'uid' => $this->t('User'),
//      'name' => $this->t('Name'),
//      'age' => $this->t('Age'),
//      'actions' => $this->t('Actions'),
      $this->t('User'),
      $this->t('Name'),
      $this->t('Age'),
      $this->t('Actions'),
    ];

    $data = $this->connection->select('galicloud_people', 'gp')->fields('gp', ['id','uid', 'name', 'age'])->execute()->fetchAll(\PDO::FETCH_ASSOC);

    $rows = [];
    foreach ($data as $row){
      $url = Url::fromRoute('entity.user.canonical', ['user' => $row['uid']]);
      $row['uid'] = Link::fromTextAndUrl(User::load($row['uid'])->getAccountName()??'Anonimo', $url) ;
      $deleteUrl = Url::fromRoute('galicloud_crud.delete',['pid'=>$row['id']]);
      $row['delete'] = Link::fromTextAndUrl($this->t('Delete'),$deleteUrl) ;

      $editUrl = Url::fromRoute('galicloud_crud.form',['id'=>$row['id'],'name'=>$row['name'],'age'=>$row['age']]);

      $row['edit'] = Link::fromTextAndUrl($this->t('Edit'),$editUrl ) ;

//      $row['links']['data'] = [
//        'container' => [
//          'edit_link' => [
//            '#type' => 'link',
//            '#url' => $editUrl,
//            '#title' => 'Editar'
//          ],
//          'delete_link' => [
//            '#type' => 'link',
//            '#url' => $deleteUrl,
//            '#title' => 'Borrar'
//          ],
//        ]
//      ];

      unset($row['id']);
      $rows[] = $row;

    }

    $build['content'] = [
      '#prefix' => '<h3>' . $this->t('Created people') . '</h3>',
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No people available. '),

    ];

    return $build;
  }


  public function deletePerson($pid){
    $this->connection->delete('galicloud_people')->condition('id',$pid)->execute();
    return $this->redirect('galicloud_crud.crud');

  }

}
