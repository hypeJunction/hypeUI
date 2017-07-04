<?php

namespace hypeJunction\UI;


class Lightbox {

	/**
	 * Set lightbox config options
	 *
	 * @param string $hook   "elgg.data"
	 * @param string $type   "page"
	 * @param array  $return Data
	 * @param array  $params Hoщk params
	 *
	 * @return array
	 */
	public static function configure($hook, $type, $return, $params) {

		$return['lightbox'] = [
			'current' => elgg_echo('js:lightbox:current', ['{current}', '{total}']),
			'previous' => elgg_view_icon('caret-left'),
			'next' => elgg_view_icon('caret-right'),
			'close' => elgg_view_icon('times'),
			'opacity' => 0.5,
			'maxWidth' => '990px',
			'maxHeight' => '990px',
			'initialWidth' => '300px',
			'initialHeight' => '300px',
		];

		return $return;
	}
}