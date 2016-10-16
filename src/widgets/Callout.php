<?php
namespace suhanda\AdminLte\widgets;


use suhanda\AdminLte\helpers\Html;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class Callout extends Widget
{
    const TYPE_INFO    = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER  = 'danger';

    /** @var string */
    public $type = self::TYPE_INFO;

    /** @var  string */
    public $title;

    /** @var  string */
    public $message;

    /** @var string */
    public $messageTag = 'p';

    /** @var array */
    public $messageOptions = [];

    /** @var bool */
    public $dismissible = true;

    /** @var array */
    public $options = [];

    /** @var array */
    public static $typeIcons = [
        self::TYPE_INFO    => 'info',
        self::TYPE_SUCCESS => 'check',
        self::TYPE_WARNING => 'warning',
        self::TYPE_DANGER  => 'ban',
    ];

    /**
     * @return string
     */
    public function run()
    {
        Html::addCssClass($this->options, ['callout', 'callout-' . $this->type]);

        $message = Html::tag($this->messageTag, $this->message, $this->messageOptions);
        $html    = [$this->renderTitle(), $message];

        return Html::tag('div', implode(PHP_EOL, $html), $this->options);
    }

    /**
     * @return string
     */
    public function renderTitle()
    {
        if ($this->title) {
            $iconName = ArrayHelper::getValue(static::$typeIcons, $this->type, 'info');
            $icon     = Html::icon($iconName, ['class' => 'icon']);

            return Html::tag('h4', $icon . $this->title);
        }

        return '';
    }
    
}