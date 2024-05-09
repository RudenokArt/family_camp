<?php
/**
 * 
 */
class ACF_class {

	public static function getFormSteps () {
		$posts = get_posts([
			'category_name' => 'step_by_step_form',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order' => 'ASC',
			'orderby' => 'name',
		]);
		foreach ($posts as $key => $value) {
			$arr[] = [
				'ID' => $value->ID,
				'post_title' => $value->post_title,
				'post_content' => sanitize_text_field($value->post_content),
				'post_name' => $value->post_name,
			];
		}
		return $arr;
	}

	public static function getDirectionsList () {
		$directions = self::wpDbRe(
			'SELECT 
			`wp_term_taxonomy`.`term_taxonomy_id`,
			`wp_term_taxonomy`.`term_id`,
			`wp_term_taxonomy`.`taxonomy`,
			`wp_term_taxonomy`.`description`,
			`wp_terms`.`name`,
			`wp_termmeta`.`meta_key`,
			`wp_termmeta`.`meta_value`,
			`wp_posts`.`guid`
			FROM `wp_term_taxonomy`
			LEFT JOIN `wp_terms` ON `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id`
			LEFT JOIN `wp_termmeta` ON `wp_term_taxonomy`.`term_id` = `wp_termmeta`.`term_id`
			LEFT JOIN `wp_posts` ON `wp_termmeta`.`meta_value` = `wp_posts`.`ID`
			WHERE `wp_term_taxonomy`.`taxonomy`="direction"
			AND (`wp_termmeta`.`meta_key` = "image" OR `wp_termmeta`.`meta_key` = "contract")'
		);
		$arr = [];
		foreach ($directions as $key => $value) {
			$arr[$value->term_id]['term_taxonomy_id'] = $value->term_taxonomy_id;
			$arr[$value->term_id]['term_id'] = $value->term_id;
			$arr[$value->term_id]['taxonomy'] = $value->taxonomy;
			$arr[$value->term_id]['description'] = $value->description;
			$arr[$value->term_id]['name'] = $value->name;
			$arr[$value->term_id][$value->meta_key] = $value->guid;
		}
		return $arr;
	}

	public static function getSeasonsList () {
		$seasons = self::wpDbRe(
			'SELECT 
			`wp_term_taxonomy`.`term_taxonomy_id`,
			`wp_term_taxonomy`.`term_id`,
			`wp_term_taxonomy`.`taxonomy`,
			`wp_term_taxonomy`.`description`,
			`wp_terms`.`name`,
			`wp_termmeta`.`meta_key`,
			`wp_termmeta`.`meta_value`,
			`wp_posts`.`guid`
			FROM `wp_term_taxonomy`
			LEFT JOIN `wp_terms` ON `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id`
			LEFT JOIN `wp_termmeta` ON `wp_term_taxonomy`.`term_id` = `wp_termmeta`.`term_id`
			LEFT JOIN `wp_posts` ON `wp_termmeta`.`meta_value` = `wp_posts`.`ID`
			WHERE `wp_term_taxonomy`.`taxonomy`="season"
			AND `wp_termmeta`.`meta_key` = "image"'
		);
		return $seasons;
	}

	public static function getArrivalsList () {

		$arrivals = self::wpDbRe(
			'SELECT 
			`wp_posts`.`ID`, 
			`wp_posts`.`post_title`,
			`wp_posts`.`post_content`,
			`wp_term_relationships`.`term_taxonomy_id`,
			`wp_terms`.`name` AS `taxonomy_name`,
			`wp_term_taxonomy`.`taxonomy` AS `taxonomy_slug`
			FROM `wp_posts` 
			JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
			JOIN `wp_term_taxonomy` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id`
			JOIN `wp_terms` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id`
			WHERE `wp_posts`.`post_type`="arrival" AND `wp_posts`.`post_status`="publish"
			AND (`wp_term_taxonomy`.`taxonomy`="season" OR `wp_term_taxonomy`.`taxonomy`="direction")
			ORDER BY `wp_posts`.`post_date` ASC'
		);

		$arr = [];
		foreach ($arrivals as $key => $value) {
			$arr[$value->ID]['ID'] = $value->ID;
			$arr[$value->ID]['post_title'] = $value->post_title;
			$arr[$value->ID]['post_content'] = $value->post_content;
			$arr[$value->ID][$value->taxonomy_slug] = $value->term_taxonomy_id;
			// $arr[$value->ID][$value->taxonomy_slug][$value->term_taxonomy_id] = $value->taxonomy_name;
		}

		return $arr;
	}

	
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
			$item['post_content'] = sanitize_text_field($post->post_content);
			
			// $item['post_content'] = $post->post_content;
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