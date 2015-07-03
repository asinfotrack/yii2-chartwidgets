<?php
namespace asinfotrack\yii2\chartwidgets\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use miloschuman\highcharts\Highcharts;

/**
 * Base class for all actual implementations of the widgets.
 * This class is responsible for managing the common settings
 * of them all.
 * 
 * @author Pascal Mueller, AS infotrack AG
 * @link http://www.asinfotrack.ch
 * @license MIT
 */
abstract class HighchartWidgetBase extends \yii\base\Widget
{
	
	/**
	 * @var array holds the actual config of the widget.
	 */
	protected $widgetConfig = [];
	
	/**
	 * @var string the title of the widget
	 */
	public $title;
	
	/**
	 * @var integer the widget-height in pixels
	 */
	public $height;
	
	/**
	 * @var integer[] the spacing of the widget (top, right, bottom, left)
	 */
	public $spacing = [0,0,0,0];
	
	/**
	 * @var integer the border width in pixels
	 */
	public $borderWidth = 0;
	
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		
		//assert proper config
		if ($this->height === null || !is_int($this->height)) {
			throw new InvalidConfigException(Yii::t('app', 'Each chart needs a height in integer-format!'));
		}
		
		//prepare a common default config
		$defaultConfig = [
			'credits'=>['enabled'=>false],
			'title'=>$this->title === null ? null : ['text'=>$this->title],
			'height'=>$this->height,
			'spacing'=>$this->spacing,
			'borderWidth'=>$this->borderWidth,
		];
		
		$this->widgetConfig = ArrayHelper::merge($defaultConfig, $this->createChartConfig());
	}
	
	/**
	 * Override this method to request additional scripts as defined in
	 * \miloschuman\highcharts\Highcharts
	 * 
	 * @return array array containing script names
	 */
	protected function scripts()
	{
		return [];
	}
	
	/**
	 * @inheritdoc
	 */
	public function run()
	{
		return Highcharts::widget([
			'scripts'=>$this->scripts(),
			'options'=>$this->widgetConfig,
		]);
	}
	
	/**
	 * This method has to be implemented by the concrete widget-types.
	 * It should return a configuration-array which will be passed to the
	 * highcharts widget.
	 * 
	 * The actual values will be set by the widget itself.
	 * 
	 * @see \miloschuman\highcharts\Highcharts
	 * @return array config containing the basic widget-type-config
	 */
	protected abstract function createChartConfig();
	
}
