<?php
namespace asinfotrack\yii2\chartwidgets;

use yii\base\InvalidConfigException;

/**
 * Displays a solid gauge
 * 
 * @author Pascal Mueller, AS infotrack AG
 * @link http://www.asinfotrack.ch
 * @license MIT
 */
class SolidGauge extends \asinfotrack\yii2\chartwidgets\ChartWidgetBase
{
	
	/**
	 * @var integer the value representing an empty gauge (defaults to 0)
	 */
	public $minValue = 0;
	
	/**
	 * @var integer the value representing a full gauge (defaults to 100)
	 */
	public $maxValue = 100;
	
	/**
	 * @var integer the actual value
	 */
	public $value;
	
	/**
	 * @var integer start angle of the gauge (defaults to -110) 
	 */
	public $startAngle = -110;
	
	/**
	 * @var integer the end angle of the gauge (defaults to 110)
	 */
	public $endAngle = 110;
	
	/**
	 * @var string the template for the data label. You can use {value}
	 * as a placeholder for the actual value
	 */
	public $dataLabel = '<div class="text-center">{value}</div>';
	
	/**
	 * (non-PHPdoc)
	 * @see \yii\base\Object::init()
	 */
	public function init()
	{
		parent::init();
		
		//assert proper config
		if ($this->value === null) {
			throw new InvalidConfigException(Yii::t('app', 'The SolidGauge needs a value!'));
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \asinfotrack\yii2\chartwidgets\ChartWidgetBase::scripts()
	 */
	protected function scripts()
	{
		return ['highcharts-more','modules/solid-gauge'];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \asinfotrack\yii2\chartwidgets\ChartWidgetBase::createChartConfig()
	 */
	protected function createChartConfig()
	{
		return [
			'chart'=>[
				'type'=>'solidgauge',
			],
			'tooltip'=>['enabled'=>false],
			'legend'=>['enabled'=>false],
			'pane'=>[
				'size'=>'100%',
				'startAngle'=>$this->startAngle,
				'endAngle'=>$this->endAngle,
				'background'=>[
					'backgroundColor'=>'#dddddd',
					'innerRadius'=>'60%',
					'outerRadius'=>'100%',
					'shape'=>'arc',
				],
			],
			'plotOptions'=>[
				'solidgauge'=>[
					'dataLabels'=>[
						'y'=>-25,
						'borderWidth'=>0,
						'useHTML'=>true,
						'style'=>['fontFamily'=>'Open Sans', 'fontSize'=>'20px', 'fontWeight'=>400],
					],
				],
			],
			'yAxis'=>[
				'min'=>$this->minValue,
				'max'=>$this->maxValue,
				'stops'=>[
					[0, 	'#55BF3B'], // green
					[0.8, 	'#DDDF0D'],	// yellow
					[1.0, 	'#DF5353'], // red
				],
				'lineWidth'=>0,
				'minorTickInterval'=>null,
				'tickPixelInterval'=>400,
				'tickWidth'=>0,
				'labels'=>['enabled'=>false],
			],
			'series'=>[
				[
					'name'=>'SolidGauge',
					'data'=>[$this->value],
					'dataLabels'=>[
						'format'=>str_replace('{value}', '{y}', $this->dataLabel),
					],
				],
			],
		];
	}
	
}