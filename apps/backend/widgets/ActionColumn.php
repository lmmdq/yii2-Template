<?php
/**
 * @link http://www.wayhood.com/
 */

namespace backend\widgets;

use Yii;
use yii\helpers\Html;
/**
 * Class ActionColumn
 * @package backend\widgets
 * @author Song Yeung <netyum@163.com>
 * @date 15-6-7
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    public $header = '操作';

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a(Yii::t('yii', 'View'), $url, $options);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a(Yii::t('yii', 'Update'), $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a(Yii::t('yii', 'Delete'), $url, $options);
            };
        }




        //);exit;
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                $controllerId = Yii::$app->controller->getUniqueId();

                if (Yii::$app->user->can('/'.$controllerId.'/'.$name)) {

                    $url = $this->createUrl($name, $model, $key, $index);

                    return call_user_func($this->buttons[$name], $url, $model, $key);
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }, $this->template);
    }
}