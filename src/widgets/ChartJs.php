<?php
namespace suhanda\AdminLte\widgets;

use suhanda\AdminLte\assets\ChartJsAssets;
use suhanda\AdminLte\helpers\Html;
use yii\base\Widget;
use yii\helpers\Json;

/**
 * Class ChartJsWidget
 *
 * @package suhanda\AdminLte\widgets
 */
class ChartJs extends Widget
{
    public $type    = '';
    public $data    = [];
    public $options = [];

    public $width  = 400;
    public $height = 400;

    public function init()
    {
        echo Html::tag('canvas', '', [
            'id'     => $this->getId(),
            'width'  => $this->width,
            'height' => $this->height
        ]);

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
        $view->registerJs(sprintf("var %s = document.getElementById('%s')"), $id, $id);
        $view->registerJs(sprintf("var %sChart = new Char(%s,%s);"), $id, $id, Json::encode($options));
    }
}