<?php

namespace Drupal\galicloud_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\user\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Returns responses for Galicloud pages routes.
 */
class GalicloudPagesController extends ControllerBase
{

  /**
   * Builds the response.
   */
  public function simple()
  {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works simple!'),
    ];

    return $build;
  }

  /**
   * Builds the response.
   */
  public function calculator($num1, $num2)
  {

    if (!is_numeric($num1) || !is_numeric($num2)) {
      throw new BadRequestHttpException(t('No numeric arguments specified.'));
    }

    $list[] = $this->t("@num1 + @num2 = @sum",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@sum' => $num1 + $num2
      ]
    );
    $list[] = $this->t("@num1 - @num2 = @difference",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@difference' => $num1 - $num2
      ]
    );
    $list[] = $this->t("@num1 x @num2 = @product",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@product' => $num1 * $num2
      ]
    );

    if ($num2 != 0)
      $list[] = $this->t("@num1 / @num2 = @division",
        [
          '@num1' => $num1,
          '@num2' => $num2,
          '@division' => $num1 / $num2
        ]
      );
    else {
      $list[] = $this->t("@num1 / @num2 = undefined (division by zero)",
        array('@num1' => $num1, '@num2' => $num2));
    }

    $output['forcontu_pages_calculator'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Operations:'),
    ];
    return $output;
  }

  /**
   * Builds the response.
   */
  public function user(UserInterface $user)
  {

    $list[] = $this->t("Username: @username", ['@username' => $user->getAccountName()]);
    $list[] = $this->t("Email: @email", ['@email' => $user->getEmail()]);
    $list[] = $this->t("Roles: @roles", ['@roles' => implode(', ', $user->getRoles())]);
    $list[] = $this->t("Last accessed time: @lastaccess", array('@lastaccess' => \Drupal::service('date.formatter')->format($user->getLastAccessedTime(), 'short')));
    $output['galicloud_pages_user'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('User data:'),
    ];
    return $output;
  }

  public function links()
  {
    //link to /admin/structure/blocks
    $url1 = Url::fromRoute('block.admin_display');
    $link1 = Link::fromTextAndUrl(t('Go to the Block administration page'), $url1);
    $list[] = $link1;
    $list[] = $this->t('This text contains a link to %enlace. Just convert it to String to use it into a text.', ['%enlace' => $link1->toString()]);

    //Lint to the frontpage
    $url3 = Url::fromRoute('<front>');
    $link3 = Link::fromTextAndUrl(t('Go to Front page'), $url3);
    $list[] = $link3;
    //link to /node/1
    $url4 = Url::fromRoute('entity.node.canonical', ['node' => 1]);
    $link4 = Link::fromTextAndUrl(t('Link to node/1'), $url4);
    $list[] = $link4;
    //link to /node/1/edit
    $url5 = Url::fromRoute('entity.node.edit_form', ['node' => 1]);
    $link5 = Link::fromTextAndUrl(t('Link to edit node/1'), $url5);
    $list[] = $link5;
    //link to https://www.galicloud.com
    $url6 = Url::fromUri('https://www.galicloud.com');
    $link6 = Link::fromTextAndUrl(t('Link to www.galicloud.com'), $url6);
    $list[] = $link6;

    //link to internal css file
    $url7 = Url::fromUri('internal:/core/themes/bartik/css/layout.css');
    $link7 = Link::fromTextAndUrl(t('Link to layout.css'), $url7);
    $list[] = $link7;

    //link to https://www.drupal.org with extra attributes
    $url8 = Url::fromUri('https://www.drupal.org');
    $link_options = [
      'attributes' => [
        'class' => [
          'external-link',
          'list'
        ],
        'target' => '_blank',
        'title' => 'Go to drupal.org',
      ],
    ];
    $url8->setOptions($link_options);
    $link8 = Link::fromTextAndUrl(t('Link to drupal.org'), $url8);
    $list[] = $link8;

    $output['galicloud_pages_links'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Examples of links:'),
    ];
    return $output;
  }

}
