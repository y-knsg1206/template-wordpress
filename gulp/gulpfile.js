const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob-use-forward');
const mmq = require("gulp-merge-media-queries");
const autoprefixer = require('autoprefixer');
const postcss = require("gulp-postcss");
const imagemin = require('gulp-imagemin');
const avif = require("gulp-avif");
const plumber = require('gulp-plumber');
const changed = require("gulp-changed");
const notify = require('gulp-notify');
const cssnano = require("cssnano");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const del = require("del");
const browserSync = require('browser-sync').create();

// ===================================================================
// プロジェクト設定
// ===================================================================
const os = require("os");
const projectName = "template"; // ローカルのサイト名に合わせる
const wpThemeName = "template";
const userInfo = os.userInfo();
const baseFolder =
  process.env.BASE_FOLDER ||
  `/Users/${userInfo.username}/Local Sites/${projectName}/app/public/wp-content/themes/${wpThemeName}`;


// ===================================================================
// パス設定
// ===================================================================
const srcPath = {
  css: `../src/sass/**/*.scss`,
  js: `../src/js/**/*.js`,
  img: `../src/images/**/*`,
  php: `../**/*.php`,
}

const destPath = {
  all: `../assets/**/*`,
  css: `../assets/css/`,
  js: `../assets/js/`,
  img: `../assets/images/`,
}

// ===================================================================
// テーマをLocalにコピー
// ===================================================================
function copyTheme() {
  return src([
    "../assets/**",
    "../parts/**",
    "../*.php",
    "../style.css",
    // "../screenshot.png",
  ], { dot: true, base: "../" })
    .pipe(changed(baseFolder))
    .pipe(dest(baseFolder));
}


// ===================================================================
// CSSコンパイル
// ===================================================================
function css() {
  return src(`${srcPath.css}`)
    .pipe(plumber({ errorHandler: notify.onError('Error: <%= error.message %>') }))
    .pipe(sassGlob())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([
      autoprefixer({ overrideBrowserslist: ['defaults', 'not op_mini all'] })
    ]))
    .pipe(mmq())
    .pipe(dest(destPath.css))
    .pipe(browserSync.stream());
}

// ===================================================================
// css圧縮
// ===================================================================
function cssMinify() {
  return src(`${destPath.css}/style.css`)
    .pipe(postcss([cssnano()]))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(destPath.css))
}

// ===================================================================
// 画像圧縮
// ===================================================================
const images = () => {
  return src(srcPath.img)
    .pipe(changed(destPath.img))
    .pipe(
      imagemin([
        imagemin.mozjpeg({ quality: 80 }),
        imagemin.optipng({ optimizationLevel: 3 }),
        imagemin.svgo({ plugins: [{ removeViewBox: false }] })
      ])
    )
    .pipe(dest(destPath.img))
};

// AVIF変換
const imagesAvif = () => {
  return src('../src/images/**/*.{jpg,png}')
    .pipe(changed(destPath.img, { extension: '.avif' }))
    .pipe(avif({ quality: 80 }))
    .pipe(dest(destPath.img));
}

// ==================================================================
// jsコンパイル
// ===================================================================
function javascript() {
  return src(srcPath.js)
    .pipe(dest(destPath.js))
}

// ===================================================================
// js圧縮
// ===================================================================
function jsMinify() {
  return src(srcPath.js)
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(destPath.js))
}

// ===================================================================
// BrowserSync関連タスク
// ===================================================================
const browserSyncOption = {
  proxy: "http://template.local/",// ローカルにある「Site Domain」に合わせる
  notify: false,
}

// ===================================================================
// クリーンタスク
// ===================================================================
const clean = () => {
  return del([
    destPath.all,
    `${baseFolder}/**`,
    `!${baseFolder}`,
  ], { force: true });
};

// ===================================================================
// TT5以外のTTテーマ削除タスク
// 任意のタイミングで 'npx gulp cleanThemes' を手動実行
// ===================================================================
const themesDir = `${baseFolder}/../`;
const cleanThemes = () => {
  return del([
    'twentytwenty*',
    '!twentytwentyfive',
    '!twentytwentyfive/**'
  ], {
    cwd: themesDir,
    force: true
  });
};

exports.cleanThemes = cleanThemes;

// ===================================================================
// ファイル監視タスク
// ===================================================================
const reload = (done) => {
  browserSync.reload();
  done();
};

const watchFiles = () => {
  browserSync.init(browserSyncOption);
  watch(srcPath.css, series(css, copyTheme, reload));
  watch(srcPath.img, series(images, imagesAvif, copyTheme, reload));
  watch(srcPath.js, series(javascript, copyTheme, reload));
  watch(srcPath.php, series(copyTheme, reload));
};


// ===================================================================
// タスクのエクスポート
// ===================================================================
exports.default = series(css, images, imagesAvif, javascript, copyTheme, watchFiles);

// 本番用ビルド
exports.build = series(clean, css, images, imagesAvif, javascript, copyTheme);

// 圧縮用ビルド
exports.buildMini = series(clean, css, images, imagesAvif, javascript, cssMinify, jsMinify, copyTheme);

// ===================================================================
// jpg/png削除タスク（特定のファイルは除外）
// ビルド後、jpg/pngが不要であれば 'npx gulp cleanImages' を手動実行
// ===================================================================
const cleanImages = () => {
  // 除外するファイルをリストアップ（空の場合は適用しない）
  const excludeFilesList = []; // 除外するファイルをここに追加
  const excludeFiles = excludeFilesList.length > 0 ? excludeFilesList.map(file => `!${destPath.img}${file}`) : [];

  // 削除対象：dist内の全てのjpg/png及びbaseFolder内のassets/imagesフォルダ内のjpg/png
  // ただし、除外リストにあるものは削除しない
  return del([
    `${destPath.img}*.{jpg,png}`,
    `${baseFolder}/assets/images/**/*.{jpg,png}`,
    ...excludeFiles
  ], { force: true });
};

exports.cleanImages = cleanImages;
