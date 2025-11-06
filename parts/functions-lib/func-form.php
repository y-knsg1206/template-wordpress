<?php

/**
 * フォームの設定
 */
// Contact Form 7で自動挿入されるPタグ、brタグを削除
// https://junpei-sugiyama.com/contact-form7-autop/
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false()
{
  return false;
}

// WPCF7 自動改行を停止
add_filter('wpcf7_autop_or_not', '__return_false');

//WPCF7 mailcheck
add_filter('wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2);
add_filter('wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2);
function wpcf7_text_validation_filter_extend($result, $tag)
{
  $type = $tag['type'];
  $name = $tag['name'];
  $_POST[$name] = trim(strtr((string) $_POST[$name], "\n", " "));
  if ('email' == $type || 'email*' == $type) {
    if (preg_match('/(.*)_confirm$/', $name, $matches)) {
      $target_name = $matches[1];
      if ($_POST[$name] != $_POST[$target_name]) {
        if (method_exists($result, 'invalidate')) {
          $result->invalidate($tag, "確認用のメールアドレスが一致していません");
        } else {
          $result['valid'] = false;
          $result['reason'][$name] = '確認用のメールアドレスが一致していません';
        }
      }
    }
  }
  return $result;
}
add_filter('wpcf7_support_html5_fallback', '__return_true');

//WPCF7 kana
function wpcf7_validate_katakana($result, $tag)
{
  $name = $tag->name;
  $value = isset($_POST[$name]) ? trim(wp_unslash(strtr((string) $_POST[$name], "\n", " "))) : "";

  // フォームのIDが「your-furi」の場合
  if ($name === "your-furi") {
    if (!preg_match("/^[ァ-ヶー　 ]+$/u", $value)) {
      $result->invalidate($tag, "カタカナで入力してください。");
    }
  }
  return $result;
}
add_filter('wpcf7_validate_text', 'wpcf7_validate_katakana', 11, 2);
add_filter('wpcf7_validate_text*', 'wpcf7_validate_katakana', 11, 2);

