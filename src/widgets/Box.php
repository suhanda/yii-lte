<?php
namespace suhanda\AdminLte\widgets;

use suhanda\AdminLte\helpers\Html;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class Box
 * @package suhanda\AdminLte\widgets
 */
class Box extends Widget
{
    const TYPE_DEFAULT = 'default';
    const TYPE_INFO    = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER  = 'danger';

    public $type = self::TYPE_DEFAULT;

    /** @var bool */
    public $isCollapse = false;

    /** @var array */
    public $options = [];

    /** @var array | string */
    public $tools = [];

    public $title;

    public $headerOptions = [];

    public $bodyOptions = [];

    public $footerOptions = [];

    /** @var  string */
    protected $footerTag;
    /** @var  string */
    protected $tag;
    /** @var  string */
    protected $bodyTag;


    public function init()
    {
        Html::addCssClass($this->options, ['box', 'box-' . $this->type]);
        if ($this->isCollapse) {
            Html::addCssClass($this->options, 'collapsed-box');
        }
        $this->tag     = ArrayHelper::remove($this->options, 'tag', 'div');
        $html          = [];
        $html[]        = Html::beginTag($this->tag, $this->options);
        $html[]        = $this->renderHeader();
        $this->bodyTag = ArrayHelper::remove($this->bodyOptions, 'tag', 'dev');
        Html::addCssClass($this->bodyOptions, ['box-body']);
        $html[] = Html::beginTag($this->bodyTag, $this->bodyOptions);

        echo implode(PHP_EOL, $html);
    }

    /**
     * @return string
     */
    public function beginFooter()
    {
        // close body
        $html            = [Html::endTag($this->bodyTag)];
        $this->footerTag = ArrayHelper::remove($this->footerOptions, 'tag', 'div');
        Html::addCssClass($this->footerOptions, 'box-footer');
        $html[] = Html::beginTag($this->footerTag, $this->footerOptions);

        return implode(PHP_EOL, $html);
    }

    /**
     * @return string
     */
    public function endFooter()
    {
        return Html::endTag($this->footerTag);
    }

    /**
     * @return string
     */
    public function run()
    {
        $html = [];
        if (empty($this->footerTag)) {
            $html[] = Html::endTag($this->bodyTag);
        }
        $html[] = Html::endTag($this->tag);

        echo implode(PHP_EOL, $html);
    }

    /**
     * @return string
     */
    protected function renderHeader()
    {
        $headerWithBorder = ArrayHelper::remove($this->headerOptions, 'withBorder', true);
        if ($headerWithBorder) {
            Html::addCssClass($this->headerOptions, 'with-border');
        }

        $headerTag  = ArrayHelper::remove($this->headerOptions, 'tag', 'div');
        $headerIcon = ArrayHelper::remove($this->headerOptions, 'icon');

        $html = [Html::beginTag($headerTag, $this->headerOptions)];
        if ($this->title) {

            $html[] = $this->renderTitle($headerIcon);
        }

        if (!empty($this->tools)) {
            $html[] = Html::beginTag('div', ['class' => ['box-tools', 'pull-right']]);
            $html[] = $this->renderTools();
            $html[] = Html::endTag('div');
        }

        $html[] = Html::endTag($headerTag);

        return implode(PHP_EOL, $html);
    }


    /**
     * @return array|string
     */
    protected function renderTools()
    {
        if (is_string($this->tools)) {
            return $this->tools;
        }

        $html = array_map(function ($tool) {

            if (is_string($tool)) {
                switch ($tool) {
                    case 'collapse':
                        return "<button class=\"btn btn-box-tool\" data-widget=\"collapse\" data-toggle=\"tooltip\" title=\"Collapse\"><i class=\"fa fa-minus\"></i></button>";
                    case 'remove' :
                        return "<button class=\"btn btn-box-tool\" data-widget=\"remove\" data-toggle=\"tooltip\" title=\"Remove\"><i class=\"fa fa-times\"></i></button>";
                    default:
                        return $tool;
                }

            }

            // is label
            $label = ArrayHelper::remove($tool, 'label', '');
            Html::addCssClass($tool, 'label');

            return Html::tag('span', $label, $tool);

        }, $this->tools);

        return implode(PHP_EOL, $html);
    }

    /**
     * @param $headerIcon
     * @return string
     */
    protected function renderTitle($headerIcon)
    {
        $html = [];
        if ($headerIcon) {
            $html[] = Html::icon($headerIcon);
        }
        $html[] = Html::tag('h3', $this->title);

        return implode(' ', $html);
    }

}