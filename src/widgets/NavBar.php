<?php
namespace yii\lte\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\lte\helpers\Html;

/**
 * Class NavBar
 *
 * @package yii\lte\widgets
 * @author  Dedi Suhanda <dedi.suhanda@gmail.com>
 */
class NavBar extends Widget
{
    public $tag           = 'nav';
    public $options       = [];
    public $cssClass      = 'navbar';
    public $type          = 'static-top';
    public $sideBarToggle = true;
    public $toggleOptions = [];
    public $toggleCss     = 'sidebar-toggle';

    /**
     *
     */
    public function init()
    {
        $options = [
            'class' => $this->cssClass . ' navbar-' . $this->type,
        ];
        if (isset($this->options['class'])) {
            Html::addCssClass($options, $this->options['class']);
            unset($this->options['class']);
        }
        ArrayHelper::merge($options, $this->options);
        $contents   = [];
        $contents[] = Html::beginTag($this->tag, $options);

        if ($this->sideBarToggle) {
            $contents[] = $this->renderToggle();
        }

        echo implode("\n", $contents);
    }

    /**
     *
     */
    public function run()
    {
        echo Html::endTag($this->tag);
    }

    /**
     * @return array
     */
    public function renderToggle()
    {
        $toggleOptions = [
            'class'       => $this->toggleCss,
            'data-toggle' => 'offcanvas',
            'role'        => 'button',
            'href'        => '#'
        ];
        if (isset($this->toggleOptions['class'])) {
            Html::addCssClass($toggleOptions, $this->toggleOptions['class']);
            unset($this->toggleOptions['class']);
        }

        ArrayHelper::merge($toggleOptions, $this->toggleOptions);
        $contents   = [];
        $contents[] = Html::beginTag('a', $toggleOptions);
        $contents[] = Html::tag('span', 'Toggle navigation', ['class' => 'sr-only']);
        $contents[] = Html::tag('span', '', ['class' => 'icon-bar']);
        $contents[] = Html::tag('span', '', ['class' => 'icon-bar']);
        $contents[] = Html::tag('span', '', ['class' => 'icon-bar']);
        $contents[] = Html::endTag('a');

        return implode("\n", $contents);;
    }
}