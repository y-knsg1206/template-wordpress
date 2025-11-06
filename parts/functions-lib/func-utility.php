<?php

/**
 * func-utility
 * ユーティリティ関数
 */

/**
 * 投稿が指定した日数以内であるか判定（未設定の場合は7日）
 */
function new_posting($days = 7, $entry_time = null)
{
  $today = date_i18n('U');
  if (!$entry_time) {
    $entry = get_the_time('U');
  }
  $posting = date('U', ($today - $entry)) / 86400;
  if ($days > $posting) {
    return true;
  }
  return false;
}

/**
 * 元のファイル名から拡張子を取り除き、.avif に変換した文字列を返す
 *
 * @param string $filename 画像ファイル名（例：hero.jpg, sample.png）
 * @return string avif 変換後のファイル名（例：hero.avif, sample.avif）
 */
function convert_avif($filename)
{
  if (empty($filename)) return '';
  $info = pathinfo($filename);
  return $info['filename'] . '.avif';
}

/**
 * モディファイアクラスを生成
 * @param string $base ベースクラス名
 * @param string|array $modifiers モディファイア名
 * @return string モディファイアクラス名
 */
function modifier_class($base, $modifiers = null)
{
  $classes = [$base];

  foreach ((array) $modifiers as $mod) {
    if (!empty($mod)) {
      $classes[] = "{$base}--{$mod}";
    }
  }

  return implode(' ', $classes);
}

/**
 * 外部URL判定関数
 */
if (! function_exists('is_external_url')) {
  function is_external_url($url)
  {
    return is_string($url) && preg_match('~^https?://~i', $url);
  }
}

/**
 * カスタムのksesを使用
 * @param string $content コンテンツ
 * @return string コンテンツ
 */
function kses_custom($content)
{
  $allowed_tags = wp_kses_allowed_html('post');
  $allowed_tags['wbr'] = [];

  return wp_kses($content, $allowed_tags);
}
