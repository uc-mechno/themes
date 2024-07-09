<?php

// 基本設定
function mytheme_setup()
{

  // ブロックベースのウィジェットエディタを無効化
  remove_theme_support('widgets-block-editor');

  // ページのタイトルを出力
  add_theme_support('title-tag');

  // HTML5対応
  add_theme_support('html5', array('style', 'script'));

  // アイキャッチ画像
  add_theme_support('post-thumbnails');

  // ナビゲーションメニュー
  register_nav_menus(array(
    'primary' => 'メイン',
  ));

  // 編集画面用のCSS
  add_theme_support('editor-styles');
  add_editor_style('editor-style.css');

  // グーテンベルク由来のCSS（theme.min.css）
  add_theme_support('wp-block-styles');

  // 埋め込みコンテンツのレスポンシブ化
  add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'mytheme_setup');


// ウィジェット
function mytheme_widgets()
{

  register_sidebar(array(
    'id' => 'sidebar-1',
    'name' => 'サイドメニュー',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
  ));
}
add_action('widgets_init', 'mytheme_widgets');


// CSS
function mytheme_enqueue()
{

  //Font Awesome
  wp_enqueue_style('mytheme-fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', array(), null);

  //Google Fonts
  wp_enqueue_style('mytheme-googlefonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,800', array(), null);

  //テーマのCSS
  wp_enqueue_style('mytheme-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue');


// Font Awesomeの属性
function mytheme_sri($html, $handle)
{
  if ($handle === 'mytheme-fontawesome') {
    return str_replace(
      '/>',
      'integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"' . ' />',
      $html
    );
  }
  return $html;
}
add_filter('style_loader_tag', 'mytheme_sri', 10, 2);

function remove_css()
{
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'remove_css');


/*
//使用可能なブロック
function mytheme_block() {

	return [
		'core/paragraph', //段落
		'core/image', //画像
		'core/heading', //見出し
		'core/gallery', //ギャラリー
		'core/list', //リスト
		'core/quote', //引用
		'core/shortcode', //ショートコード
		'core/archives', //アーカイブ
		'core/audio', //音声
		'core/buttons', //ボタン
		'core/button', //ボタン
		'core/calendar', //カレンダー
		'core/categories', //カテゴリー
		'core/code', //ソースコード
		'core/columns', //カラム
		'core/cover', //カバー
		'core/embed', //埋め込み
		'core-embed/twitter', //Twitter
		'core-embed/youtube', //YouTube
		'core-embed/facebook', //Facebook
		'core-embed/instagram', //Instagram
		'core-embed/wordpress', //WordPress
		'core-embed/soundcloud', //SoundCloud
		'core-embed/spotify', //Spotify
		'core-embed/flickr', //Flickr
		'core-embed/vimeo', //Vimeo
		'core-embed/animoto', //Animoto
		'core-embed/cloudup', //Cloudup
		'core-embed/crowdsignal', //Crowdsignal
		'core-embed/dailymotion', //Dailymotion
		'core-embed/imgur', //Imgur
		'core-embed/issuu', //Issuu
		'core-embed/kickstarter', //Kickstarter
		'core-embed/meetup-com', //Meetup.com
		'core-embed/mixcloud', //Mixcloud
		'core-embed/polldaddy', //Polldaddy
		'core-embed/reddit', //Reddit
		'core-embed/reverbnation', //ReverbNation
		'core-embed/screencast', //Screencast
		'core-embed/scribd', //Scribd
		'core-embed/slideshare', //Slideshare
		'core-embed/smugmug', //SmugMug
		'core-embed/speaker', //Speaker
		'core-embed/speaker-deck', //Speaker Deck
		'core-embed/tiktok', //TikTok
		'core-embed/ted', //TED
		'core-embed/tumblr', //Tumblr
		'core-embed/videopress', //VideoPress
		'core-embed/wordpress-tv', //WordPress.tv
		'core-embed/amazon-kindle', //Amazon Kindle
		'core/file', //ファイル
		'core/group', //グループ
		'core/freeform', //クラシック
		'core/html', //カスタム HTML
		'core/media-text', //メディアと文章
		'core/latest-comments', //最新のコメント
		'core/latest-posts', //最新の記事
		'core/more', //続きを読む
		'core/nextpage', //改ページ
		'core/preformatted', //整形済み
		'core/pullquote', //プルクオート
		'core/rss', //RSS
		'core/search', //検索
		'core/separator', //区切り
		'core/block', //再利用ブロック
		'core/social-links', //ソーシャルアイコン
		'core/spacer', //スペーサー
		'core/table', //テーブル
		'core/tag-cloud', //タグクラウド
		'core/verse', //詩
		'core/video', //動画
  ];
}
add_filter( 'allowed_block_types', 'mytheme_block' );
*/

// 使用可能なブロック
function mytheme_block( $allowed_block_types, $block_editor_context ) {

	// 投稿
	if ( $block_editor_context->post->post_type === 'post' ) {
		return array(
			'core/paragraph', //段落
			'core/image', //画像
		);
	}

	// 固定ページ
	if ( $block_editor_context->post->post_type === 'page' ) {
		return array(
			'core/paragraph', //段落
		);
	}

	// 上記以外
	return $allowed_block_types;

}
add_filter( 'allowed_block_types_all', 'mytheme_block', 10, 2 );
