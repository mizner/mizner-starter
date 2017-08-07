<?php

namespace Mizner\Theme;

class Extras {

	public function init() {
		add_filter( 'body_class', [ $this, 'add_slug_body_class' ], 10 );
		add_filter( 'oembed_result', [ $this, 'video_embed_enable_api' ], 10, 3 );
		add_filter( 'body_class', [ $this, 'browser_body_class' ] );
	}

	public function browser_body_class( $classes ) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if ( $is_lynx ) {
			$classes[] = 'lynx';
		} elseif ( $is_gecko ) {
			$classes[] = 'gecko';
		} elseif ( $is_opera ) {
			$classes[] = 'opera';
		} elseif ( $is_NS4 ) {
			$classes[] = 'ns4';
		} elseif ( $is_safari ) {
			$classes[] = 'safari';
		} elseif ( $is_chrome ) {
			$classes[] = 'chrome';
		} elseif ( $is_IE ) {
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$browser = substr( "$browser", 25, 8 );
			if ( $browser == "MSIE 7.0" ) {
				$classes[] = 'ie7';
				$classes[] = 'ie';
			} elseif ( $browser == "MSIE 6.0" ) {
				$classes[] = 'ie6';
				$classes[] = 'ie';
			} elseif ( $browser == "MSIE 8.0" ) {
				$classes[] = 'ie8';
				$classes[] = 'ie';
			} elseif ( $browser == "MSIE 9.0" ) {
				$classes[] = 'ie9';
				$classes[] = 'ie';
			} else {
				$classes[] = 'ie';
			}
		} else {
			$classes[] = 'unknown';
		}

		if ( $is_iphone ) {
			$classes[] = 'iphone';
		}

		return $classes;
	}

	public function video_embed_enable_api( $html, $url, $args ) {
		/*
		 * Modify video parameters.
		 * This allows interacting with the youtube videos via javascript. See: https://css-tricks.com/play-button-youtube-and-vimeo-api/
		 */
		if ( strstr( $html, 'youtube.com/embed/' ) ) {
			$html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1', $html );
		}

		return $html;
	}

	public function add_slug_body_class( $classes ) {
		global $post;
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}

		return $classes;
	}


}