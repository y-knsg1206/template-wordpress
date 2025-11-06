<?php

/**
 *  管理画面の投稿・固定ページのカスタマイズ
 */

// 投稿一覧と固定ページ一覧でアイキャッチ画像を表示
function customize_manage_posts_columns($columns)
{
  $columns['thumbnail'] = __('アイキャッチ画像');
  echo '<style>.fixed .column-thumbnail {width:120px;} .fixed .column-thumbnail img {width:100%;max-width:100px;height:auto;}</style>';
  return $columns;
}
add_filter('manage_posts_columns', 'customize_manage_posts_columns');
add_filter('manage_pages_columns', 'customize_manage_posts_columns');

function customize_manage_posts_custom_column($column_name, $post_id)
{
  if ('thumbnail' == $column_name) {
    $thum = get_the_post_thumbnail($post_id, 'small', array('style' => 'width:100%;max-width:100px;height:auto;'));
    if (!empty($thum)) {
      echo $thum;
    } else {
      echo __('None');
    }
  }
}
add_action('manage_posts_custom_column', 'customize_manage_posts_custom_column', 10, 2);
add_action('manage_pages_custom_column', 'customize_manage_posts_custom_column', 10, 2);

// 管理画面の固定ページ一覧にスラッグを表示
function add_page_columns_name($columns)
{
  $columns['slug'] = "スラッグ";
  echo '<style>.fixed .column-slug {width:120px;}</style>';
  return $columns;
}
function add_page_column($column_name, $post_id)
{
  if ($column_name == 'slug') {
    $post = get_post($post_id);
    echo esc_attr($post->post_name);
  }
}
add_filter('manage_pages_columns', 'add_page_columns_name');
add_action('manage_pages_custom_column', 'add_page_column', 10, 2);
add_filter('manage_posts_columns', 'add_page_columns_name');
add_action('manage_posts_custom_column', 'add_page_column', 10, 2);

// 選択済みカテゴリーの自動並べ替えを無効化
add_action('wp_terms_checklist_args', function ($args, $post_id = null) {
  $args['checked_ontop'] = false;
  return $args;
});
