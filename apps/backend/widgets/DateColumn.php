<?php
/**
 * Created by PhpStorm.
 * User: wayhood
 * Date: 16/2/23
 * Time: 下午9:59
 */

namespace backend\widgets;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;

class DateColumn extends \yii\grid\DataColumn
{
    public $filter = 'range';
    public $dateFormat = 'Y-m-d';
    public $language = false;


    protected function renderFilterCellContent()
    {
        if (!is_string($this->filter)) {
            return $this->filter;
        } else if (!in_array($this->filter, ['range', 'single'])) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if ($this->filter == 'range') {
                //$options = array_merge(['prompt' => ''], $this->filterInputOptions);
                //return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
                //$html = Html::tag('div', "<span style='". $this->dateLabelStyle ."'>". $this->fromText ."</span>" . Html::activeTextField($this->grid->filter, $this->name.'_range[from]', ['style'=>$this->dateInputStyle, 'class'=>'filter-date']));

                //    ;
                //echo CHtml::tag('div', array(),
                //echo CHtml::tag('div', array(), "<span style='". $this->dateLabelStyle ."'>". $this->toText ."</span>". CHtml::activeTextField($this->grid->filter, $this->name.'_range[to]', array('style'=>$this->dateInputStyle, 'class'=>'filter-date')));
            } else {
                //echo Html::tag('div', Html::activeTextField($this->grid->filter, $this->name.'_range[to]', ['class'=>'filter-date']));
                return \yii\jui\DatePicker::widget([
                    'model' => $model,
                    'attribute'  => $this->attribute.'_range[to]',
                    'dateFormat' => 'php:'.$this->dateFormat,
                    'options' => [
                        'class' => 'filter-date',
                        //'readonly' => true
                    ],
                ]);
                //return Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error;
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }
}