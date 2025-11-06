<?php

/**
 * func-base
 * WordPressの基本的な機能を設定・追加するための関数群
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support
 *
 * https://haniwaman.com/functions/
 */
// WordPressのテーマに必要な基本機能をサポートするための設定
function my_setup()
{
  add_theme_support('post-thumbnails'); /* アイキャッチ */
  add_theme_support('automatic-feed-links'); /* RSSフィード */
  add_theme_support('title-tag'); /* タイトルタグ自動生成 */
  add_theme_support(
    'html5',
    array( /* HTML5のタグで出力 */
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}
add_action('after_setup_theme', 'my_setup');

/*
 * 出力を抑制
 */
function disable_output()
{
  // 絵文字を削除することで、レスポンスを上げる
  // https://wp-doctor.jp/blog/2022/08/17/%E3%83%AF%E3%83%BC%E3%83%89%E3%83%97%E3%83%AC%E3%82%B9%E3%81%AE%E9%AB%98%E9%80%9F%E5%8C%96%E3%81%AE%E3%81%9F%E3%82%81%E3%81%AB%E3%80%81%E4%B8%8D%E8%A6%81%E3%81%AA%E7%B5%B5%E6%96%87%E5%AD%97%E3%81%AE/
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

  // pタグとbrタグの自動挿入を解除
  // https://www.plusdesign.co.jp/blog/author7c462/86.html
  remove_filter('the_content', 'wpautop');
}

add_action('init', 'disable_output');

//タイトルタグの区切り文字を「|」に変更
add_theme_support('title-tag');
function custom_document_title_separator($sep)
{
  return '|';
}
add_filter('document_title_separator', 'custom_document_title_separator');

//自動リダイレクトを無効
function remove_redirect_guess_404_permalink($redirect_url)
{
  if (is_404())
    return false;
  return $redirect_url;
}
add_filter('redirect_canonical', 'remove_redirect_guess_404_permalink');

/* プラグイン自動更新のメール通知を無効化 */
add_filter('auto_plugin_update_send_email', '__return_false');

/* テーマ自動更新のメール通知を無効化 */
add_filter('auto_theme_update_send_email', '__return_false');



remove_filter('the_content', 'wpautop');

// ページネーションのページ番号を 2桁ゼロ埋めにする
add_filter('wp_pagenavi', function ($html) {
  $html = preg_replace_callback('/>(\d+)</', function ($matches) {
    return '>' . sprintf('%02d', $matches[1]) . '<';
  }, $html);

  return $html;
});
