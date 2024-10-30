<?php
/**
 * Plugin Name: Newspaper tagDiv CDN modal image enabler
 * Plugin URI: https://giacomolaw.me
 * Description: Enable the modal image when using a CDN in the Newspaper and Newsmag themes.
 * Author: Giacomo Lawrance
 * Author URI: https://giacomolaw.me
 * Version: 1.1.1
 * Text Domain: cdn-modal-enabler
 *
 */

// Td modal img on all images
function td_modal_plugin_init(){
    if(is_single()) {
        add_filter('the_content', 'add_responsive_class');
        function add_responsive_class($content){
			// Avoid empty string error if there is no content to work with
			if ( ! $content ) {
				return $content;
			}
			$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
			$document = new DOMDocument();
			libxml_use_internal_errors(true);
			$document->loadHTML(utf8_decode($content));
			$imgs = $document->getElementsByTagName('img');
			foreach ($imgs as $img) {
				$existing_class = $img->getAttribute('class');
				$img->setAttribute('class', "td-modal-image $existing_class");
			}
			$html = $document->saveHTML();
			return $html;
		}
    }
}
add_action('template_redirect', 'td_modal_plugin_init');