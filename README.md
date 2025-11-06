# コーディングガイドライン

## 概要
このプロジェクトは以下の特徴を持つWordPress構築環境です：
- Gulpによる自動ビルドシステム
- srcディレクトリの変更が自動的にassetsに反映
- レスポンシブデザイン対応（変数による切替）
- 最新の画像最適化（AVIF対応）
- Localのthemesディレクトリにテーマとして自動反映

## 必要環境
- Node.js v22.0.0以上（推奨）
- npm v10.0.0以上（推奨）

### バージョン確認方法
ターミナルで以下のコマンドを実行：
```bash
node -v
npm -v
```

## セットアップ手順
1. gulpfile.jsの初期設定
   - projectNameをローカルのサイト名に合わせる：
     ```javascript
     const projectName = "WordPressTemplate";
     ```
   - wpThemeNameを出力したいテーマ名に設定：
     ```javascript
     const wpThemeName = "WordPressTemplate";
     ```
   - proxyの設定をWordPressのローカル環境のアドレスに変更：
     ```javascript
     proxy: "http://XXXXX.local/"
     ```

2. 依存パッケージのインストール：
   ```bash
   cd gulp
   npm i
   ```

3. 開発サーバーの起動：
   ```bash
   npx gulp
   ```

## Gulp タスク一覧
- `npx gulp`: 開発サーバー起動とファイル監視
- `npx gulp build`: 本番用ビルド
- `npx gulp buildMini`: 圧縮ありビルド
- `npx gulp cleanImages`: 不要な画像ファイル削除

### 画像最適化について
- AVIF形式への自動変換対応
- 画像の自動圧縮（JPG、PNG）
- 特定の画像を削除対象から除外する場合は、gulpfile.jsのcleanImagesタスクに以下のように設定：
  ```javascript
  const excludeFilesList = ["cat.jpg", "dog.png"];
  ```

## 開発ワークフロー

### ディレクトリ構造
- `src/`: 開発用ソースファイル
  - `sass/`: Sassファイル
  - `js/`: JavaScriptファイル
    - `global.js`: 全ページ共通のスクリプト
    - `toppage.js`:トップページ専用のスクリプト
    - `script.js`:その他ページ用のスクリプト
  - `images/`: 画像ファイル
- `assets/`: コンパイル後のファイル（編集禁止）
- `parts/`: テンプレートパーツ
- `*.php`: WordPress用テンプレートファイル

### レスポンシブデザイン設定
variables.scssでデバイス対応の切り替えが可能：
- `$break-flg: 0;` → SPファースト
- `$break-flg: 1;` → PCファースト

## 仕様
- SPファースト、PCファーストを設定で切り替え可能
- srcフォルダに対して作業を実施
- コンパイル後のコードはassetsフォルダに格納
- phpは直下のファイルの内容を修正
- SassをCSSにコンパイル実施
- 画像の圧縮を実施
- 必要に応じてCSS、JSの圧縮可
- テーマに必要なassets、parts、**.phpがLocalのThemesに直接コンパイルされる
- テーマとして自動反映されるため、Local以外にフォルダを複製してください# template-wordpress
