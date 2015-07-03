<?php
namespace asinfotrack\yii2\chartwidgets\assets;

/**
 * Asset bundle needed for sparkline widgets
 *
 * @author Pascal Mueller, AS infotrack AG
 * @link http://www.asinfotrack.ch
 * @license MIT
 */
class SparklineAsset extends \yii\web\AssetBundle
{

	public $sourcePath = '@vendor/asinfotrack/yii2-chartwidgets/assets/src';

	public $js = [
		'jquery.sparkline.min.js',
	];

	public $depends = [
		'yii\web\JqueryAsset',
	];

}
