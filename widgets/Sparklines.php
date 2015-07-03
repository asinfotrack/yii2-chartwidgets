<?php
namespace asinfotrack\yii2\chartwidgets\widgets;

use asinfotrack\yii2\chartwidgets\assets\SparklineAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Renders a sparklines widget.
 * @see http://omnipotent.net/jquery.sparkline
 *
 * @author Pascal Mueller, AS infotrack AG
 * @link http://www.asinfotrack.ch
 * @license MIT
 */
class Sparklines extends \yii\base\Widget
{

	const SPARKLINE_BAR = 'bar';
	const SPARKLINE_TRISTATE = 'tristate';
	const SPARKLINE_DISCRETE = 'discrete';
	const SPARKLINE_BULLET = 'bullet';
	const SPARKLINE_PIE = 'pie';
	const SPARKLINE_BOX = 'box';

	/**
	 * @var string the type of sparkline to render. Use constants of the widget class
	 * to define this property or check the jQuery-sparkline docs
	 */
	public $type = self::SPARKLINE_BAR;

	/**
	 * @var mixed the data to create the sparklines for
	 */
	public $values;

	/**
	 * @var int|string the widget-width (any valid css value). If not set defaults to auto
	 */
	public $width;

	/**
	 * @var int|string the widget-height (any valid css value). If not set defaults to auto.
	 */
	public $height;

	/**
	 * @var array the container options of this widget
	 */
	public $options = [];

	/**
	 * @var array the actual chart config. Use this property to configure the looks of the
	 * widget according to yor needs.
	 * @see http://omnipotent.net/jquery.sparkline/#s-docs
	 */
	public $sparklineConfig = [];

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		//register required asset
		$this->view->registerAssetBundle(SparklineAsset::className());

		//prepare container options
		$this->options['id'] = $this->id;
		Html::addCssClass($this->options, 'widget-sparklines');

		echo Html::tag('div', '', $this->options);
		$this->registerJs();
	}

	/**
	 * Creates and registers the needed javascript code to run the widget
	 */
	protected function registerJs()
	{
		//prepare values
		$values = Json::encode($this->values);

		//prepare config
		$config = [
			'type'=>$this->type,
			'width'=>$this->width,
			'height'=>$this->height,
		];
		$config = Json::encode(ArrayHelper::merge($this->sparklineConfig, $config));

		//create and register js
		$js = sprintf("$('#%s').sparkline(%s, %s);", $this->id, $values, $config);
		$this->view->registerJs($js);
	}

}
