<?php
namespace yii\lte\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\YiiAsset;

/**
 * Class FontAwesomeAssets
 *
 * @package yii\lte\assets
 * @author  Dedi Suhanda <dedi.suhanda@gmail.com>
 */
class FontAwesomeAssets extends AssetBundle
{
    public function init()
    {
        $this->setSourcePath('@vendor/fortawesome/font-awesome');
        $this->setupAssets('css', [
            "css/font-awesome",
        ]);

        parent::init();
    }
}