<?php
namespace suhanda\AdminLte\widgets;

use suhanda\AdminLte\assets\ChartJsAssets;
use suhanda\AdminLte\helpers\Html;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class ChartJsWidget
 *
 * @package suhanda\AdminLte\widgets
 */
class ChartJs extends Widget
{
    public $type        = '';
    public $data        = [];
    public $options     = [];
    public $htmlOptions = [];

    public $width  = 400;
    public $height = 400;

    public function init()
    {
        $htmlOptions = ArrayHelper::merge([
            'id'     => $this->getId(),
            'width'  => $this->width,
            'height' => $this->height
        ], $this->htmlOptions);

        echo Html::tag('canvas', '', $htmlOptions);

        $this->registerScripts();
    }

    protected function registerScripts()
    {
        $view = $this->getView();
        ChartJsAssets::register($view);
        $id      = $this->getId();
        $options = [
            'type'    => $this->type,
            'data'    => $this->data,
            'options' => $this->options,
        ];
        $view->registerJs(
            sprintf(
                "var %sChart = new Char(document.getElementById('%s'),%s);",
                $id,
                $id,
                Json::encode($options)
            )
        );
    }
}
