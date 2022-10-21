<?php
/**
 * Implements hook_views_data().
 */
function galicloud_views_views_data()
{
  $data = [];
  $data['galicloud_node_highlighted'] = [];
  $data['galicloud_node_highlighted']['table'] = [];
  $data['galicloud_node_highlighted']['table']['group'] = t('Galicloud Views');
  $data['galicloud_node_highlighted']['table']['provider'] = 'galicloud_views';
  $data['galicloud_node_highlighted']['table']['join'] = [
    'node_field_data' => [
      'left_field' => 'nid',
      'field' => 'nid',
    ],
  ];
  $data['galicloud_node_highlighted']['highlighted'] = [
    'title' => t('Highlighted content'),
    'help' => t('Boolean field for highlighted content.'),
    'field' => [
      'id' => 'boolean',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'boolean',
      'label' => t('Highlighted'),
      'type' => 'yes-no',
      'use_equal' => TRUE,
    ],
  ];
  return $data;
}
