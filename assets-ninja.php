<?php
/*
Plugin Name: AssetsNinja
Plugin URI: https://mostofa.me
Description: Description
Version: 1.0
Author: LWHH
Author URI: https://mostofa.me
License: GPLv2 or later
Text Domain: assetsninja
Domain Path: /languages/
*/

define("ASN_ASSETS_DIR", plugin_dir_url( __FILE__ )."assets/");
define("ASN_ASSETS_PUBLIC_DIR", plugin_dir_url( __FILE__ )."assets/public/");
define("ASN_ASSETS_ADMIN_DIR", plugin_dir_url( __FILE__ )."assets/admin/");

class AssetsNinja {
	private $version;
	function __construct() {
		$this->version = time();

		add_action('init', array($this, 'asn_init'));

		add_action('plugin_loaded', array($this,'load_textdomain'));
		add_action('wp_enqueue_scripts',array($this,'load_front_assets'));
		add_action('admin_enqueue_scripts',array($this,'load_admin_assets'));
	}

	function asn_init() {
		wp_deregister_style('fontawesome-css');
		wp_register_style('fontawesome-css','//use.fontawesome.com/releases/v6.5.2/css/all.css');

		wp_deregister_script('tinyslider-js');
		wp_register_script('tinyslider-js','//cdn.tinymce.com/4/tinymce.min.js',null,'1.0',true);

	}

	function load_front_assets() {
		wp_enqueue_style('asn-main-css', ASN_ASSETS_PUBLIC_DIR."/css/main.css",null,$this->version);
//		wp_enqueue_script('asn-main-js',ASN_ASSETS_PUBLIC_DIR."/js/main.js", array('jquery','asn-another-js'),$this->version,true);
//		wp_enqueue_script('asn-another-js',ASN_ASSETS_PUBLIC_DIR."/js/another.js", array('jquery'),$this->version,true);

		$js_file =array(
			'asn-main-js'=>array('path'=>ASN_ASSETS_PUBLIC_DIR. "/js/main.js",'dep'=>array('jquery','asn-another-js')),
			'asn-another-js'=>array('path'=>ASN_ASSETS_PUBLIC_DIR. "/js/another.js",'dep'=>array('jquery'))
	);
	foreach($js_file as $handle=>$fileinfo) {
		wp_enqueue_script($handle,$fileinfo['path'],$fileinfo['dep'],$fileinfo['version'],true);
	}
		$data = array(
			'name'=>"lwM",
			'url'=>'https://google.com/'
		);
		$moredata= array(
			'name'=>"More data Name",
			'url'=>'https://google.com/'
		);

		$translated_strings = array(
		    'greetings'	=> __('Hello World...','assetsninja')
		);


		wp_localize_script('asn-another-js','sitedata',$data);
		wp_localize_script('asn-another-js','moredata',$moredata);
		wp_localize_script('asn-another-js','translations',$translated_strings);
	}


	function load_admin_assets($screen) {
		$_screen = get_current_screen();

//	--------------	print all data debug----------------

//		echo "<pre";
//		print_r($_screen);
//		echo "</pre>";
//		die();


		if('edit.php' == $screen && 'page' == $_screen->post_type ) {
			wp_enqueue_script('asn-admin-js',ASN_ASSETS_ADMIN_DIR . "/js/admin.js", array('jquery'),$this->version,true);
		}
//		if('options-general.php' == $screen) {
//		wp_enqueue_script('asn-admin-js',ASN_ASSETS_ADMIN_DIR . "/js/admin.js", array('jquery'),$this->version,true);
//	 }
	}

	function load_textdomain() {
		load_plugin_textdomain('assetsninja', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/');
	}
}

new AssetsNinja();