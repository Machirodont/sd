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
 * @property bool $placeContentInFile
 * @property string|null $contentFileName
 * @property string|null $contentFullFileName
 * @property array $entityRoute
 */
class HtmlBlock extends HtmlBlockGenerated
{

    public function rules()
    {
        return [
            [['itemKey', 'itemTable', 'html'], 'required'],
            [['itemKey', 'order'], 'integer'],
            [['itemTable', 'html', 'content'], 'string'],
        ];
    }

    private $_content = null;
    private $_contentFile = null;

    public function getContent()
    {
        if (!is_null($this->_content)) return $this->_content;
        $this->_content = $this->html;
        if ($this->placeContentInFile) {
            if ($this->contentFileName && file_exists($this->contentFullFileName)) {
                $this->_content = file_get_contents($this->contentFullFileName);
            }
        }
        return $this->_content;
    }

    public function setContent(string $content)
    {
        $this->_content = $content;
    }

    public function getPlaceContentInFile(): bool
    {
        return substr($this->html, 0, 6) === "view::";
    }

    public function getContentFileName(): ?string
    {
        if (!$this->placeContentInFile) return null;
        $this->_contentFile = substr($this->html, 6);
        return $this->_contentFile;
    }

    public function getContentFullFileName(): ?string
    {
        return $this->contentFileName ? "../views" . $this->contentFileName . ".php" : null;
    }

    public function getEntityRoute(): array
    {
        $tabRoutes = [
            "sd_persons" => "/persons/view",
            "sd_clinics" => "/clinic/contacts",
            "sd_pages" => "/site/page",
        ];
        if (!array_key_exists($this->itemTable, $tabRoutes)) return null;
        return [$tabRoutes[$this->itemTable], "id" => $this->itemKey];
    }


    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->placeContentInFile) {
            file_put_contents($this->contentFullFileName, $this->content);
        } else {
            $this->html = $this->content;
        }
        return parent::save($runValidation, $attributeNames);
    }
}