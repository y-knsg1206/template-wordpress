<?php

/**
 * Functions
 */

// 基本設定
get_template_part('parts/functions-lib/func-base');

// セキュリティー対応
get_template_part('parts/functions-lib/func-security');

// ショートコードの設定
get_template_part('parts/functions-lib/func-shortcode');

// URLのショートカット設定
get_template_part('parts/functions-lib/func-url');

// URLのショートカット設定
get_template_part('parts/functions-lib/func-utility');

// メインクエリのSP表示件数設定
// get_template_part('parts/functions-lib/func-posts-edit');

// スクリプト、スタイルシートの設定
get_template_part('parts/functions-lib/func-enqueue-assets');

// ログイン画面のカスタマイズ
// get_template_part('parts/functions-lib/func-login');

// 管理画面のカスタマイズ
// get_template_part('parts/functions-lib/func-admin');

// 管理画面の投稿・固定ページのカスタマイズ
get_template_part('parts/functions-lib/func-admin-columns');

// フォームの設定
get_template_part('parts/functions-lib/func-form');

// カスタム投稿の設定
get_template_part('parts/functions-lib/func-add-posttype-case');

// 投稿の設定
get_template_part('parts/functions-lib/func-add-posttype-post');
