<?php
namespace yii\lte;

use yii\base\Theme as BaseTheme;
use yii\lte\assets\AdminLteAssets;

/**
 * Class Theme
 * @package yii\lte\assets
 */
class Theme extends BaseTheme
{

    /** @var string */
    public $root = '@app';

    /** @var */
    public $skin;

    /** @var array */
    protected $bodyCss = [
        'hold-transition'
    ];

    /** @var array */
    public $topMenuItems = [];

    /** @var array */
    public $siteMenuItems = [];

    /** @var bool */
    public $isSideBarCollapse = false;

    /** @var bool */
    public $isSideBarMini = true;

    /** @var bool */
    public $isFixed = false;

    /** @var bool */
    public $isBoxed = false;


    public function init()
    {
        $this->basePath = __DIR__;
        if ($this->skin) {
            AdminLteAssets::$skin = $this->skin;
        }

        if (!$this->pathMap) {
            $this->pathMap = [
                $this->root . '/views' => [
                    $this->root . '/views',
                    $this->getPath('views')
                ]
            ];
        }

        if ($this->isBoxed) {
            $this->bodyCss[] = 'layout-boxed';
        }

        if ($this->isSideBarMini) {
            $this->bodyCss[] = 'sidebar-mini';
        }

        if ($this->isSideBarCollapse) {
            $this->bodyCss[] = 'sidebar-collapse';
        }

        if ($this->isFixed) {
            $this->bodyCss[] = 'fixed';
        }

        $this->bodyCss[] = $this->getSkin();

        parent::init();
    }

    /**
     * @return array
     */
    public function getBodyCss()
    {
        return array_unique($this->bodyCss);
    }

    /**
     * @param $skin
     */
    public function setSkin($skin)
    {
        AdminLteAssets::$skin = $skin;
    }

    /**
     * @return string
     */
    public function getSkin()
    {
        return AdminLteAssets::$skin;
    }

}