<?php

/**
 * ログイン画面のカスタマイズ
 */

// 背景・ロゴ・カラー設定
add_action('login_head', function () {
  $theme_url = get_theme_file_uri();
?>
  <style>
    .login {
      --login-bg-url: url("<?php echo $theme_url; ?>/assets/images/sora.jpg");
      --login-logo-url: url("<?php echo $theme_url; ?>/images/logo_top.svg");
      --login-primary-color: #C99A06;
      --login-text-color: #000000;
      --login-bg-opacity: rgba(0, 0, 0, 0.5);
      --login-bg-blend-mode: darken;
      --login-input-bg: #ffffff;

      /* Bright Version */
      /* --login-bg-opacity: rgba(255, 255, 255, 0.5); */
      /* --login-bg-blend-mode: lighten; */


      background: var(--login-bg-opacity) var(--login-bg-url) no-repeat center center;
      background-size: cover;
      background-blend-mode: var(--login-bg-blend-mode);
    }

    .login h1 a {
      /* background-color: #fff; */

      background-image: var(--login-logo-url);
      background-size: contain;
      /* width: 320px; */
      /* height: calc(47.2px * (320 / 445.9)); */
      width: 150px;
      height: calc(150px * (150 / 242));
      transition: .5s;
    }

    .login h1 a:hover {
      opacity: 0.5;
    }

    .login form {
      background: rgba(255, 255, 255, 1);
      /* background-color: #EDE9DF; */
      border: none;
    }

    .login label {
      color: var(--login-text-color);
      /* font-weight: bold; */
    }

    .login #nav,
    .login .language-switcher,
    .login .privacy-policy-page-link,
    .login #backtoblog,
    .login #language-switcher {
      display: none;
    }

    .login .privacy-policy-page-link a,
    .login #backtoblog a,
    .login #nav a {
      color: var(--login-text-color);
    }

    .login.wp-core-ui .button {
      transition: .5s;
    }

    .login.wp-core-ui .button:hover {
      opacity: 0.8;
    }

    .login.wp-core-ui .button-primary {
      background: var(--login-primary-color);
      border-color: var(--login-primary-color);
      transition: .5s;
    }

    .login.wp-core-ui .button-secondary {
      color: var(--login-text-color);
      border-color: var(--login-primary-color);
      background: #fff;
    }

    .login #login_error,
    .login .message,
    .login .success {
      border-left-color: var(--login-primary-color);
    }

    .login form .input,
    .login form input[type=checkbox],
    .login input[type=text] {
      background: var(--login-input-bg);
      border-color: var(--login-primary-color);
    }

    .login form .input:focus,
    .login form input[type=checkbox]:focus,
    .login input[type=text]:focus {
      box-shadow: 0 0 0 1px var(--login-primary-color);
    }

    input[type=checkbox]:checked::before {
      content: url("data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%2020%2020%27%3E%3Cpath%20d%3D%27M14.83%204.89l1.34.94-5.81%208.38H9.02L5.78%209.67l1.34-1.25%202.57%202.4z%27%20fill%3D%27%23C99A06%27%2F%3E%3C%2Fsvg%3E");
    }
  </style>
<?php
});

// ログイン画面のロゴリンク先URL
add_filter('login_headerurl', function () {
  return get_bloginfo('url');
});

// ログイン画面のロゴタイトル
add_filter('login_headertitle', function () {
  return get_bloginfo('name');
});

