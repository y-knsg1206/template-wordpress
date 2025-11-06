<?php

/**
 * 管理画面のカスタマイズ
 */
// 編集者　管理画面カスタマイズ
add_action('admin_menu', 'remove_menus');
function remove_menus()
{
  if (current_user_can('editor')) {
    remove_menu_page('edit.php?post_type=page'); //固定ページ
    remove_menu_page('edit-comments.php'); //コメントメニュー
    remove_menu_page('edit.php?post_type=column'); //コラム
    remove_menu_page('edit.php?post_type=works'); //works
    remove_menu_page('wpcf7'); //お問い合わせ
    remove_menu_page('tools.php'); //ツールメニュー
    remove_menu_page('index.php'); //ダッシュボード
  }
}
function remove_wp_nodes()
{
  if (current_user_can('editor')) {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('wp-logo'); // Wpロゴ
    $wp_admin_bar->remove_node('updates'); // アップデート通知
    $wp_admin_bar->remove_node('comments'); // コメント
    $wp_admin_bar->remove_node('new-content'); // 新規投稿ボタン
    $wp_admin_bar->remove_node('edit'); // 個別ページ
  }
}
add_action('admin_bar_menu', 'remove_wp_nodes', 999);

// WP管理画面の不要なサイドメニューを非表示 (編集者用)
add_action('admin_menu', function () {
  if (!current_user_can('administrator')) {
    // remove_menu_page( 'upload.php' ); // メディア
    // remove_menu_page( 'profile.php' ); // プロフィール
  }
}, 999);

