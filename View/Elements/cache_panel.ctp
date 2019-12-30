<?php
/**
 * DebugKitEx Cache Panel View
 *
 * Copyright (c) 2012, Wan Chen aka Kamisama
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author 		Wan Qi Chen <kami@kamisama.me>
 * @copyright 	Copyright 2012, Wan Qi Chen <kami@kamisama.me>
 * @link 		https://github.com/kamisama/DebugKitEx
 * @package 	DebugKitEx
 * @subpackage 	DebugKitEx.View.Elements
 * @since 		2.2.0
 * @license 	MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if (method_exists('CachePanel', 'getContent')) {
	// we get the ALL of the Cache stats, including those needed to render the Views/Helpers/Elements
	$content = CachePanel::getContent();
	// TODO: any way to update the Panel Title from here?
}

?>
<h2><?php echo __d('debug_kit_ex', 'Cache Logs')?></h2>
<?php if (isset($content['stats'])) : ?>

	<div class="head3-bloc">
	<h3><?php
		echo __d('debug_kit_ex', 'Total queries : %s, in %s ms', $content['stats']['count']['total'], $content['stats']['time']);
		echo '</h3>';
		echo '<span class="meter"><span class="cache-writes" style="width:' . ($content['stats']['count']['write']/$content['stats']['count']['total']*100) .'%;"></span></span>';
		echo ' <small>(<b>';
		echo $content['stats']['count']['read'];
		echo '</b> ';
		echo  __dn('debug_kit_ex', 'read', 'reads', $content['stats']['count']['read']);
		echo ' / <b>';
		echo $content['stats']['count']['write'];
		echo '</b> ';
		echo  __dn('debug_kit_ex', 'write', 'writes', $content['stats']['count']['write']);
		echo ')</small>';
		?>
	</div>

	<ul class="nav">
		<?php
		$keys = array_keys($content['cache']);
		foreach($keys as $key) {
			if (!empty($content['cache'][$key]['logs'])) {
				echo '<li><a href="#_cache-'.Inflector::slug($key).'">'.$key.' (' . count($content['cache'][$key]['logs']) . ')</a></li>';
			}
		}?>
	</ul>

	<?php foreach ($content['cache'] as $name => $datas): ?>
	<div class="sql-log-panel-query-log">

		<div class="head-bloc" id="_cache-<?php echo Inflector::slug($name); ?>">
			<span class="cache-engine"><?php echo $datas['settings']['engine']; ?></span>
			<h4><?php echo $name ?></h4>
		</div>
		<?php

			if (!empty($datas['logs']))
			{
				echo '<table class="debug-table debug_ex-table">';
				echo '<tr>';
				echo '<th>'.__d('debug_kit_ex', 'Type').'</th>';
				echo '<th>'.__d('debug_kit_ex', 'Keyname').'</th>';
				echo '<th class="time">'.__d('debug_kit_ex', 'Took (ms)').'</th>';
				echo '</tr>';

				$totalTime = 0;
				$totalRead = 0;
				$totalWrite = 0;
				$totalClear = 0;

				foreach($datas['logs'] as $log)
				{
					// Class = "clear" has special meaning in bootstrap, change to clear-row
					$rowClass = $log['type'] == 'clear' ? 'clear-row' : $log['type'];

					echo '<tr class="' . (!$log['success'] ? 'missed' : '') . ' ' . $rowClass . '">';
					echo '<td class="type"><span class="label-'.$log['type'].'">'.$log['type'] .'</span></td>';
					echo '<td>'.$log['key']. ($log['success'] ? '' : ' <span style="float:right">(missed)</span>') . '</td>';
					echo '<td class="time">'. $log['time']. '</td>';
					echo '</tr>';

					$totalTime += $log['time'];
					${'total' . ucwords($log['type'])}++;
				}


				echo '<tr class="table-summary">';
				echo '<td colspan=2>';
				echo '<span class="label-read">'.$totalRead.'</span> ';
				echo '<span class="label-write">'.$totalWrite.'</span> ';
				echo '<span class="label-clear">'.$totalClear.'</span>';
				echo '</td>';
				echo '<td class="time">';
				echo $totalTime;
				echo ' ms</td>';
				echo '</tr>';

				echo '</table>';
			}
			else echo '<p class="info">' .__d('debug_kit_ex', 'No cache activities') . '</p>';
		 ?>

	</div>
	<?php endforeach; ?>
<?php elseif (!empty($content)) : ?>
	<div class="alert-error"><strong>Cache class not found</strong><br/>
		Copy the folder <code>app/Plugin/DebugKitEx/Lib/Cache</code> into <code>app/Lib</code>
	</div>
<?php else :
	echo $this->Toolbar->message('Warning', __d('debug_kit_ex', 'No configured cache'));
endif; ?>
