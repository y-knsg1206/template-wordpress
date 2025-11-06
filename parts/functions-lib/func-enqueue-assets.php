<?php

/**
 * func-enqueue-assets
 *
 * @codex https://wpdocs.osdn.jp/%E3%83%8A%E3%83%93%E3%82%B2%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC
 */
add_action('wp_enqueue_scripts', function () {
  if (!is_admin()) {
    // WordPressがデフォルトで提供するjQueryは使用せず、外部CDNから読み込む
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-migrate');
    wp_enqueue_script('jquery', '//code.jquery.com/jquery-3.7.1.min.js', array(), '3.7.1', false);
    wp_enqueue_script('jquery-migrate', '//code.jquery.com/jquery-migrate-3.5.2.min.js', array('jquery'), '3.5.2', false);
  }
});

function my_script_init()
{
  // フォントの設定
  wp_enqueue_style('GoogleFonts', '//fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Oswald:wght@200..700&display=swap', array(), null);

  // swiper CSS
  wp_enqueue_style('slider-style', '//unpkg.com/swiper@8/swiper-bundle.min.css', array(), '', 'all');
  // swiper JavaScript
  wp_enqueue_script('slider-script', '//unpkg.com/swiper@8/swiper-bundle.min.js', array(), '', true);

  // GSAP JavaScript
  wp_enqueue_script('gsap', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js', array(), '3.13.0', true);
  wp_enqueue_script('gsap-scrolltrigger', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollTrigger.min.js', array('gsap'), '3.13.0', true);

  // 基本CSS
  wp_enqueue_style('my-style', get_theme_file_uri('assets/css/style.css'), array(), date('YmdHis', filemtime(get_theme_file_path('assets/css/style.css'))), 'all');

  // 全ページ共通の JavaScript (global.js)
  wp_enqueue_script('global', get_theme_file_uri('assets/js/global.js'), array(), date('YmdHis', filemtime(get_theme_file_path('assets/js/global.js'))), true);

  // トップページは toppage.js、下層ページは script.jsを読み込む
  if (is_front_page()) {
    wp_enqueue_script('top', get_theme_file_uri('assets/js/toppage.js'), array('global'), date('YmdHis', filemtime(get_theme_file_path('assets/js/toppage.js'))), true);
  } else {
    wp_enqueue_script('script', get_theme_file_uri('assets/js/script.js'), array('global'), date('YmdHis', filemtime(get_theme_file_path('assets/js/script.js'))), true);
  }
}
add_action('wp_enqueue_scripts', 'my_script_init');
