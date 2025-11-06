<?php

function Change_menulabel()
{
  global $menu;
  global $submenu;
  $name = '新着情報';
  $menu[5][0] = $name;
  $submenu['edit.php'][5][0] = $name . '一覧';
  $submenu['edit.php'][10][0] = '新しい' . $name;
}

function Change_objectlabel()
{
  global $wp_post_types;
  $name = '新着情報';
  $labels = &$wp_post_types['post']->labels;
  $labels->name = $name;
  $labels->singular_name = $name;
  $labels->add_new_item = $name . 'の新規追加';
  $labels->edit_item = $name . 'の編集';
  $labels->new_item = '新規' . $name;
  $labels->view_item = $name . 'を表示';
  $labels->search_items = $name . 'を検索';
  $labels->not_found = $name . 'が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に' . $name . 'は見つかりませんでした';
}

/**
 * カスタムカテゴリ「トピックス」を追加する関数
 */
function add_custom_topics_category()
{
  register_taxonomy('topics', ['post'], [
    'label'             => 'トピックス',
    'public'            => false,
    'hierarchical'      => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_in_rest'      => true,
    'capabilities'      => [
      'manage_terms' => 'do_not_allow',
      'edit_terms'   => 'do_not_allow',
      'delete_terms' => 'do_not_allow',
      'assign_terms' => 'edit_posts',
    ],
  ]);

  // ===== 初回のみ固定タームを投入 =====
  if (!get_option('topics_seeded')) {
    if (!term_exists('topics', 'topics')) {
      wp_insert_term('トピックス', 'topics', ['slug' => 'topics']);
    }
    update_option('topics_seeded', 1);
  }
}

function init_custom_categories()
{
  add_custom_topics_category();
  Change_objectlabel();
}

add_action('init', 'init_custom_categories');
add_action('admin_menu', 'Change_menulabel');
