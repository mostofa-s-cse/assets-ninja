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
		add_action('plugin_loaded', array($this,'load_textdomain'));
		add_action('wp_enqueue_scripts',array($this,'load_front_assets'));
	}

	function load_front_assets() {
		wp_enqueue_style('asn-main-css', ASN_ASSETS_PUBLIC_DIR."/css/main.css",null,$this->version);
		wp_enqueue_script('asn-main-js',ASN_ASSETS_PUBLIC_DIR."/js/main.js", array('jquery','asn-another-js'),$this->version,true);
		wp_enqueue_script('asn-another-js',ASN_ASSETS_PUBLIC_DIR."/js/another.js", array('jquery'),$this->version,true);

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

	function load_textdomain() {
		load_plugin_textdomain('assetsninja', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/');
	}
}

new AssetsNinja();