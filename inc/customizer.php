<?php
/**
 * TATEYAMA Theme Customizer
 *
 * @link https://wpdocs.osdn.jp/%E3%83%86%E3%83%BC%E3%83%9E%E3%82%AB%E3%82%B9%E3%82%BF%E3%83%9E%E3%82%A4%E3%82%BA_API
 *
 * @package TATEYAMA
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function tateyama_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'tateyama_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'tateyama_customize_partial_blogdescription',
		) );
	}

	$wp_customize->remove_section('header_image');
	$wp_customize->remove_section('background_image');

	$wp_customize->add_panel( 'tateyama_top_panel', array(
		'title' =>'トップページ',
		'priority' => 220, // Mixed with top-level-section hierarchy.
	) );

	$wp_customize->add_section( 'tateyama_top_header_section', array(
		'title'    => 'ヘッダー',
		'priority' => 20,
		'panel' => 'tateyama_top_panel',
		//'active_callback' => 'is_front_page'
	) );

	$wp_customize->add_section( 'tateyama_top_pr_section', array(
		'title'    => 'PRセクション',
		'priority' => 40,
		'panel' => 'tateyama_top_panel',
		//'active_callback' => 'is_front_page'
	) );

	$wp_customize->add_section( 'tateyama_top_info_section', array(
		'title'    => 'Informationセクション',
		'priority' => 60,
		'panel' => 'tateyama_top_panel',
		//'active_callback' => 'is_front_page'
	) );

	$wp_customize->add_section( 'tateyama_top_footer_section', array(
		'title'    => 'フッター',
		'priority' => 100,
		'panel' => 'tateyama_top_panel',
		//'active_callback' => 'is_front_page'
	) );

	for ( $i = 1; $i <= 3; $i ++ ) {
		// セッティング トップページヘッダー画像
		$wp_customize->add_setting( 'tateyama_options[headerImage' . $i . ']', array(
			'default'   => '',
			'type'      => 'option',
			'transport' => 'postMessage',
		) );

		// コントロール トップページヘッダー画像
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'tateyama_options_header_image' . $i,
			array(
				'label'    => 'ヘッダー画像' . $i,
				'section'  => 'tateyama_top_header_section',
				'settings' => 'tateyama_options[headerImage' . $i . ']',
			)
		) );
	}

	// セッティング トップページヘッダーテキスト
	$wp_customize->add_setting( 'tateyama_options[headerUseCatch]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページヘッダーテキスト
	$wp_customize->add_control( 'tateyama_options_header_use_catch', array(
		'settings' => 'tateyama_options[headerUseCatch]',
		'label'    => 'ヘッダーテキストにキャッチフレーズを使用',
		'section'  => 'tateyama_top_header_section',
		'type'     => 'checkbox',
	) );

	// セッティング トップページヘッダーテキスト
	$wp_customize->add_setting( 'tateyama_options[headerText]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページヘッダーテキスト
	$wp_customize->add_control( 'tateyama_options_header_text', array(
		'settings' => 'tateyama_options[headerText]',
		'label'    => 'ヘッダーテキストを入力(２０文字以内)',
		'section'  => 'tateyama_top_header_section',
		'type'     => 'text',
	) );

	// セッティング PRセクション見出し
	$wp_customize->add_setting( 'tateyama_options[prText]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PRセクション見出し
	$wp_customize->add_control( 'tateyama_options_pr_text', array(
		'settings' => 'tateyama_options[prText]',
		'label'    => 'PRテキストを入力(10文字以内)',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'text',
	) );

	// セッティング PRセクション見出し2
	$wp_customize->add_setting( 'tateyama_options[prText2]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PRセクション見出し2
	$wp_customize->add_control( 'tateyama_options_pr_text2', array(
		'settings' => 'tateyama_options[prText2]',
		'label'    => 'PR2テキストを入力(英語など)',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'text',
	) );

	// セッティング PR画像配置タイプ
	$wp_customize->add_setting( 'tateyama_options[prImageType]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PR画像配置タイプ
	$wp_customize->add_control( 'tateyama_options_pr_image_type', array(
		'settings' => 'tateyama_options[prImageType]',
		'label'    => '画像配置タイプ',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'radio',
		'choices'  => array(
			'1' => '１枚',
			'2' => '２枚',
			'3' => '３枚（左）',
			'4' => '３枚（右）',
		)
	) );

	for ( $i = 1; $i <= 3; $i ++ ) {
		// セッティング PRセクション画像
		$wp_customize->add_setting( 'tateyama_options[prImage' . $i . ']', array(
			'default'   => '',
			'type'      => 'option',
			'transport' => 'postMessage',
		) );

		// コントロール PRセクション画像
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'tateyama_options_pr_image' . $i,
			array(
				'label'    => 'PR画像' . $i,
				'section'  => 'tateyama_top_pr_section',
				'settings' => 'tateyama_options[prImage' . $i . ']',
			)
		) );
	}

	// セッティング PRセクション本文
	$wp_customize->add_setting( 'tateyama_options[prContext]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PRセクション本文
	$wp_customize->add_control( 'tateyama_options_pr_context', array(
		'settings' => 'tateyama_options[prContext]',
		'label'    => 'PRセクション本文',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'textarea',
	) );

	// セッティング PRセクション Moreリンク
	$wp_customize->add_setting( 'tateyama_options[prLink]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PRセクション Moreリンク
	$wp_customize->add_control( 'tateyama_options_pr_link', array(
		'settings' => 'tateyama_options[prLink]',
		'label'    => 'PRセクション Moreリンクテキスト',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'text',
	) );

	// セッティング PRセクション Moreリンク
	$wp_customize->add_setting( 'tateyama_options[prPage]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PRセクション Moreリンク
	$wp_customize->add_control( 'tateyama_options_pr_page', array(
		'settings' => 'tateyama_options[prPage]',
		'label'    => 'PRセクション Moreリンク固定ページ',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'dropdown-pages',
	) );

	// セッティング PRセクション Moreリンク
	$wp_customize->add_setting( 'tateyama_options[prUrl]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール PRセクション Moreリンク
	$wp_customize->add_control( 'tateyama_options_pr_url', array(
		'settings' => 'tateyama_options[prUrl]',
		'label'    => 'PRセクション MoreリンクURL',
		'section'  => 'tateyama_top_pr_section',
		'type'     => 'text',
	) );

	// セッティング トップページフッター住所
	$wp_customize->add_setting( 'tateyama_options[footerAddress]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッター住所
	$wp_customize->add_control( 'tateyama_options_footer_address', array(
		'settings' => 'tateyama_options[footerAddress]',
		'label'    => 'フッター住所を入力',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'text',
	) );

	// セッティング トップページフッター電話番号
	$wp_customize->add_setting( 'tateyama_options[footerTel]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッター電話番号
	$wp_customize->add_control( 'tateyama_options_footer_tel', array(
		'settings' => 'tateyama_options[footerTel]',
		'label'    => 'フッター電話番号を入力',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'text',
	) );

	// セッティング トップページフッター営業日・時間
	$wp_customize->add_setting( 'tateyama_options[footerStoreInfo]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッター営業日・時間
	$wp_customize->add_control( 'tateyama_options_footer_store_info', array(
		'settings' => 'tateyama_options[footerStoreInfo]',
		'label'    => 'フッター営業日・時間を入力(例：定休日 / 無休　営業時間 / 9:00～24:00)',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'text',
	) );

	// セッティング トップページフッターお問い合わせ見出し
	$wp_customize->add_setting( 'tateyama_options[footerContactTitle]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッターお問い合わせ見出し
	$wp_customize->add_control( 'tateyama_options_footer_contact_title', array(
		'settings' => 'tateyama_options[footerContactTitle]',
		'label'    => 'フッターお問い合わせ 見出し',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'text',
	) );

	// セッティング トップページフッターお問い合わせリンクテキスト
	$wp_customize->add_setting( 'tateyama_options[footerContactLink]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッターお問い合わせリンクテキスト
	$wp_customize->add_control( 'tateyama_options_footer_contact_link', array(
		'settings' => 'tateyama_options[footerContactLink]',
		'label'    => 'フッターお問い合わせ リンクテキスト',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'text',
	) );

	// セッティング トップページフッター固定ページ選択
	$wp_customize->add_setting( 'tateyama_options[footerContactPageId]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッター固定ページ選択
	$wp_customize->add_control( 'tateyama_options_footer_contact_page_id', array(
		'settings' => 'tateyama_options[footerContactPageId]',
		'label'    => 'フッターお問い合わせ(固定ページから選択)',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'dropdown-pages',
	) );

	// セッティング トップページフッターお問い合わせリンクURL
	$wp_customize->add_setting( 'tateyama_options[footerContactUrl]', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	) );

	// コントロール トップページフッターお問い合わせリンクURL
	$wp_customize->add_control( 'tateyama_options_footer_contact_url', array(
		'settings' => 'tateyama_options[footerContactUrl]',
		'label'    => 'フッターお問い合わせ リンクURL',
		'section'  => 'tateyama_top_footer_section',
		'type'     => 'text',
	) );


}

add_action( 'customize_register', 'tateyama_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function tateyama_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function tateyama_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function tateyama_top_media_callback() {

}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function tateyama_customize_preview_js() {
	wp_enqueue_script( 'tateyama-customizer', get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'tateyama_customize_preview_js' );
