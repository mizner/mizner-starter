<?php

namespace Mizner\Theme;

use WP_Query;

class Query {

	public function excerpt( $text, $length = 100 ) {
		if ( $length > strlen( $text ) ) {
			return $text;
		}

		return substr( $text, 0, $length ) . '...';
	}

	public function recent_posts() {

		$recent_posts = [];

		$the_query = new WP_Query( [
			'post_type'      => 'post',
			'posts_per_page' => 4,
		] );

		foreach ( $the_query->posts as $post ) {
			$recent_posts[] = (object) [
				'id'      => $post->ID,
				'title'   => $post->post_title,
				'excerpt' => $this->excerpt( $post->post_content, 100 ),
				'link'    => get_the_permalink( $post->ID ),
				'image'   => get_the_post_thumbnail_url( $post->ID, 'small' )
			];

		}

		return $recent_posts;
	}
}