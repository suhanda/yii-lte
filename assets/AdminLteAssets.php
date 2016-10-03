<?php
namespace yii\lte\assets;

/**
 * Class AdminLteAssets
 *
 * @package yii\lte\assets
 * @author  Dedi Suhanda <dedi.suhanda@gmail.com>
 */
class AdminLteAssets extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset'
    ];

    public function init()
    {
        $this->setSourcePath('@vendor/almasaeed2010/dist');

        $this->setupAssets('css', [
            "css/AdminLTE.css"
        ]);

        $this->setupAssets('js', [
            'js/app'
        ]);

        parent::init();
    }
}