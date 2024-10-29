<?php

/**
 * Plugin Name: Annotation
 * Plugin URI:  http://wordpress.org/plugins/annotation
 * Description: The Annotation WP plugin provides a user friendly shortcode wrapper for the jQuery UI ToolTip Widget as well as the standard UI themes.
 * Author:      Anthony Wells
 * Author URI:  http://www.bytewisemcu.org/profile/awells
 * Version:     0.5.0
 * Text Domain: annotation
 * Domain Path: /languages/
 */

/**
 * Annotation Class
 *
 * This class provides the framework for tooltip like annotations in WP posts.
 *
 * $Id$
 *
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

final class Annotation {
	const PackageName     = 'Annotation';

	const Version         = '0.5.0';

	const PackagePrefix   = 'jqueryuiwrapper';

	const DefaultTheme    = 'cupertino';

	private $annotations;
	private $jqueryui_ver;
	private $themes;

	public function __construct() {
		$this->annotations = array( );
		$this->themes = array( );
		$this->setup_actions();
	}

	public function setup_actions() {
		add_action( 'init',                       array($this, 'initialize'        ),   1 );
		add_action( 'wp_enqueue_scripts',         array($this, 'enqueue_scripts'   ),   1 );
		add_action( 'wp_print_footer_scripts',    array($this, 'add_footer_scripts'),   1 );
	}

	public function initialize() {
		add_shortcode('annotate', array( $this, 'annotate'));
	}

	public function enqueue_scripts() {
		global $wp_scripts;
		// 'jquery-effects-core', 'jquery-effects-explode',
		wp_enqueue_script('jquery-ui-tooltip');
	    $ui = $wp_scripts->query('jquery-ui-core');
	    $this->jqueryui_ver = $ui->ver;
	}

	private function theme_exists( $theme = '' ) {
		if ( array_key_exists($theme, $this->themes) ) return true;
		$dir = dir(plugin_dir_path(__FILE__) . 'themes' . DIRECTORY_SEPARATOR . $this->jqueryui_ver);
		if (false === $dir) return false;
		while (false !== $entry = $dir->read()) {
			if ($entry == '.' || $entry == '..') continue;
			if (is_dir($dir->path  . DIRECTORY_SEPARATOR . $entry ) && ($entry == $theme)) return true;
		}
		return false;
	}

	private function load_theme( $theme = '' ) {
		if ( array_key_exists($theme, $this->themes) ) return;
	    wp_enqueue_style('jquery-ui-' . $theme, plugin_dir_url( __FILE__ ) . "themes/" . $this->jqueryui_ver . "/" . $theme . "/jquery-ui.css", false, null);
	    $this->themes['$theme'] = 1;
	}

	private function simple_css_to_json( $css = '' ) {
		$css_properties = array_map(function($item) { return explode(':', $item); }, explode(';', $css));
		$JSON_CSS = "{" . implode(', ', array_reduce($css_properties,
			function($result, $item) {
				array_push($result, "'" . trim($item[0]) . "': \"" . trim($item[1]) . "\"");
				return $result;
			},
			array() )) . "}";
		return $JSON_CSS;
	}

	public function annotate( $attr, $content = null ) {
		if (is_null($content)) {
			if ( array_key_exists('content', $attr) ) {
				$content = $attr['content'];
			} else return "";  // do nothing
		}
		// do nothing if the 'text' and/or 'img' tag is not declared
		if ( !array_key_exists('text', $attr) && !array_key_exists('img', $attr) ) return "";
		$content = do_shortcode($content);
		if (array_key_exists('id', $attr)) {
			$annotation = array(
				'content' => $content,
				'id'      => $attr['id'],
				'theme'   => array_key_exists('theme', $attr) && $this->theme_exists($attr['theme']) ? $attr['theme'] : Annotation::DefaultTheme,
			);
			if ( array_key_exists('style', $attr) ) $annotation['style'] = $this->simple_css_to_json($attr['style']);
			if ( array_key_exists('text', $attr) ) $annotation['text'] = $attr['text'];
			if ( array_key_exists('img', $attr) ) $annotation['img'] = $attr['img'];
			array_push($this->annotations, $annotation);
			$this->load_theme($annotation['theme']);
		}
		$output = "<span ";
		if ( array_key_exists('id', $attr) ) { $output .= "id=\"annotate_" . $attr['id'] . "\" title=\"\" "; } else { $output .= "title=\"" . $content . "\" "; }
		$output .= ">";
		if ( array_key_exists('img', $attr) ) {
			$output .= "<img src=\"" . $attr['img'] . "\"";
			if (array_key_exists('text', $attr)) $output .= " alt=\"" . $attr['text'] . "\"";
			$output .= ">";
		} else {
		   	$output .= $attr['text'];
		}
		$output .= "</span>";
		return $output;
	}

	public function add_footer_scripts() {
		if (count($this->annotations) == 0) return;
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
<?php
		foreach ($this->annotations as $annotation) {
?>
		jQuery( '#annotate_<?php echo $annotation['id']; ?>' ).tooltip({
<?php
			if (array_key_exists('style', $annotation)) {
?>
		    open: function (event, ui) {
       			ui.tooltip.css(<?php echo $annotation['style'] ?>);
    		},
<?php
			}
?>
			tooltipClass: "<?php echo $annotation['theme'] ?>",
			content: "<?php echo $annotation['content'] ?>",
//			hide: 'explode'
		});
<?php
		}
?>
	});
</script>
<?php
	}

}

new Annotation;
