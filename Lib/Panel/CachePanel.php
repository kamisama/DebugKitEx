<?php
/**
 * DebugKitEx Cache Panel Class
 *
 * Add a Cache Panel to the debug kit plugin,
 * displaying cache i/o activities
 *
 * See <https://github.com/cakephp/debug_kit> for DebugKit Plugin for CakePHP
 *
 * PHP 5
 * CakePHP 2.2 and older
 *
 * Copyright (c) 2012, Wan Qi Chen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author 		Wan Qi Chen <kami@kamisama.me>
 * @copyright 	Copyright 2012, Wan Qi Chen <kami@kamisama.me>
 * @link 		https://github.com/kamisama/DebugKitEx
 * @package 	DebugKitEx
 * @since 		2.2.0
 * @license 	MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Add a Cache Panel to the debug kit plugin,
 * displaying cache i/o activities
 *
 * @package DebugKitEx
 * @subpackage DebugKitEx.vendors
 */
App::uses('DebugPanel', 'DebugKit.Lib');
class CachePanel extends DebugPanel
{

	public $plugin = 'DebugKitEx';

	/**
	 * Not used yet
	 *
	 * Since 2.2.4
	 * @var int
	 */
	public $priority = 0;

	/**
	 *
	 */
	public $css = array('DebugKitEx.debug_kit_ex.css');


	/**
	 * Prepare output vars before Controller Rendering.
	 *
	 * Also sets the "title" for custom titling...
	 *
	 * @param object $controller Controller reference.
	 * @return array $content (partial)
	 */
	public function beforeRender(Controller $controller) {

		$content = array();

		if (method_exists('Cache', 'getLogs')) {
			$content['stats'] = Cache::getLogs();
		}

		if ($this->priority > 0 && isset($content['stats'])) {
			if ($content['stats']['count'] === 0) {
				$this->title = __d('debug_kit_ex', '<b>0</b> cache');
			} else {
				$this->title = __d('debug_kit_ex', '<b>%dms / %d</b> cache', round($content['stats']['time']), $content['stats']['count']['total']);
			}
		}

		return $content;
	}

	/**
	 * Prepare output vars
	 *
	 * Split to static method because we have to call it FROM the View
	 *   we will call this method from: View/Elements/cache_panel.ctp
	 *
	 * If we call it from beforeRender()
	 *   we will miss all of the Cache calls in Views/Helpers/Elements
	 *
	 * @return array $content (complete)
	 */
	static function getContent() {

		$configs = Cache::configured();
		$content = array();

		if (method_exists('Cache', 'getLogs')) {
			$content['stats'] = Cache::getLogs();
		}

		foreach($configs as $config)
		{
			$engine = Cache::settings($config);

			if (method_exists('Cache', 'getLogs')) {
				$logs = Cache::getLogs($config);
			} else {
				$logs['logs'] = array();
			}

			$content['cache'][$config] = array('settings' => $engine, 'logs' => $logs['logs']);
		}

		ksort($content['cache']);

		return $content;
	}

}
