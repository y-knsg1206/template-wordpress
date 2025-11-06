<?php

/**
 * カスタム投稿タイプ "Case" を登録
 * 投稿スラッグや表示名は必要に応じて変更可能。
 * 一覧ページのテンプレートファイル `archive-case.php` もスラッグに合わせて修正すること。
 */
add_action('init', 'my_add_custom_post_case');
function my_add_custom_post_case()
{
  // 'case' というカスタム投稿タイプを登録
  register_post_type(
    'case', // 投稿タイプのスラッグ（識別子）
    array(
      'label' => '事例紹介', // 管理画面のメニューに表示される名称
      'labels' => array( // 投稿タイプに関する各種ラベルを設定
        'name' => '事例紹介', // 投稿タイプの名前（複数形）
        'all_items' => '事例紹介', // 一覧ページのリンクテキスト
      ),
      'public' => true, // フロントエンドに公開
      'has_archive' => true, // アーカイブページを有効化
      'menu_position' => 6, // 管理画面のメニュー位置
      'show_in_rest' => true, // ブロックエディタ（Gutenberg）を有効化
      'supports' => array( // 投稿タイプでサポートする機能
        'title',       // タイトル
        'editor',      // 本文エディター
        'thumbnail',   // アイキャッチ画像
        'revisions',   // リビジョン管理
      ),
    )
  );

  // 'case_cat' というカスタムタクソノミーを登録
  register_taxonomy(
    'case_cat', // タクソノミーのスラッグ（識別子）
    'case', // 関連付ける投稿タイプ
    array(
      'label' => '事例カテゴリー', // 管理画面のメニューに表示される名称
      'public' => true, // フロントエンドに公開
      'hierarchical' => true, // 階層型タクソノミーを有効化
      'show_in_rest' => true, // ブロックエディタ（Gutenberg）を有効化
    )
  );

  // 'case_pickup' というカスタムタクソノミーを登録
  register_taxonomy('case_pickup', ['case'], [
    'label'                 => 'Pick up',
    'public'                => false,
    'hierarchical'          => true,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'show_in_rest'          => true,
    // ターム管理を禁止（割当だけ許可）
    'capabilities'          => [
      'manage_terms' => 'do_not_allow',
      'edit_terms'   => 'do_not_allow',
      'delete_terms' => 'do_not_allow',
      'assign_terms' => 'edit_posts',
    ],
  ]);

  // ===== 初回のみ固定タームを投入 =====
  if (!get_option('case_pickup_seeded')) {
    if (!term_exists('pickup', 'case_pickup')) {
      wp_insert_term('ピックアップする', 'case_pickup', ['slug' => 'pickup']);
    }
    update_option('case_pickup_seeded', 1);
  }
}
