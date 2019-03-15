<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 07.03.2019
 * Time: 16:50
 */

namespace app\models;


use app\controllers\PersonsController;
use app\models\Generated\HtmlBlockGenerated;
use yii\web\Controller;

/** @property string $content
 */

class HtmlBlock extends HtmlBlockGenerated
{

    public function getContent(){
        if(substr($this->html,0,6)==="view::"){
            $view=substr($this->html,6);
            return file_get_contents("../views".$view.".php");
        }
        return $this->html;
    }

}