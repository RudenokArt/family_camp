<?php
/**
 * 
 */
class ACF_class {

	
	public static function getList ($post_type, $orderby='date', $order='ASC') {

		$posts = get_posts([
			'post_type' => $post_type,
			'post_status' => 'publish',
			'numberposts' => -1,
			'orderby' => $orderby,
			'order' => $order,
		]);

		$postsStrIds = '';
		foreach ($posts as $key => $value) {
			if ($key != 0) {
				$postsStrIds = $postsStrIds . ', ';
			}
			$postsStrIds = $postsStrIds . $value->ID;
		}

		$metadata = self::wpDbRe('
			SELECT * FROM `wp_postmeta`
			WHERE `meta_key`="_thumbnail_id"
			AND `post_id` IN (' . $postsStrIds. ')
			');
		$imgIds = [];
		foreach ($metadata as $key => $value) {
			$imgIds[] = $value->meta_value;
		}

		if ($imgIds) {
			$images = get_posts([
				'include' => $imgIds,
				'post_type' => 'attachment',
				'numberposts' => -1,
			]);
		}

		foreach ($posts as $p => $post) {
			$item = [];
			$item['ID'] = $post->ID;
			$item['post_title'] = $post->post_title;
			$item['post_content'] = sanitize_textarea_field($post->post_content);
			foreach ($metadata as $key => $value) {
				if ($value->post_id == $post->ID) {
					foreach ($images as $i => $img) {
						if ($value->meta_value == $img->ID) {
							$item['image'] = $img->guid;
						}
					}
				}
			}
			$arr[] = $item;
		}
		if (isset($arr)) {
			return $arr;
		}
	}


	public static function debugLog ($arr) {
		file_put_contents(get_template_directory().'/log.json', json_encode($arr));
	}
	

	private static function wpDbRe ($sql) {
		global $wpdb;
		return $wpdb->get_results($sql);
	}
}