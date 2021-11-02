<?php


namespace app\components;

use app\models\UrlTags;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\UrlRule;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;


class SdUrlRule extends UrlRule implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        return (new UrlConstructor($route, $params))->buildUrl();
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        //---- 301 редиректы
        self::executeOldDomainsRedirect();
        self::executeOldPricePageRedirect($pathInfo);
        self::executePresetRedirect($pathInfo);
        //--/- 301 редиректы

        $route = (new RouteConstructor($pathInfo))->buildRoute();

        self::setClinicFromRoute($route);

        return is_array($route) ? $route : false;
    }


    private static function setClinicFromRoute($route)
    {
        if (is_array($route) && count($route) > 0 && array_key_exists("cid", $route[1])) {
            if ($route[1]["cid"]) {
                Yii::$app->session->open();
                Yii::$app->session->set("cid", $route[1]["cid"]);
            } else {
                Yii::$app->session->remove("cid");
            }
        }
    }

    private static function executePresetRedirect(string $pathInfo)
    {
        $redirects = (new Query())
            ->select("*")
            ->from("sd_redirect")
            ->where(
                "\"" . htmlspecialchars($pathInfo) . "\" LIKE CONCAT(\"%\",`from`, \"%\")"
            )
            ->all();
        if (count($redirects) > 0) {
            Yii::$app->response->redirect("/" . $redirects[0]["to"], 301)->send();
            exit;
        }
    }

    private static function executeOldPricePageRedirect(string $pathInfo)
    {
        if ($pathInfo === "price_sdmed.php") {
            if (Yii::$app->request->get("filial") == 1) Yii::$app->response->redirect("ruza/contacts/", 301)->send();
            if (Yii::$app->request->get("filial") == 2) Yii::$app->response->redirect("tuchkovo/contacts/", 301)->send();
            if (Yii::$app->request->get("filial") == 3) Yii::$app->response->redirect("gagarin/contacts/", 301)->send();
            Yii::$app->response->redirect("contacts/", 301)->send();
            exit;
        };
    }

    private static function executeOldDomainsRedirect()
    {
        $domainRedirects = [
            "http://gagarin.sd-med.ru" => ["urlTag" => "/gagarin", "cid" => 5],
            "http://gagarin-med.ru" => ["urlTag" => "/gagarin", "cid" => 5],
            "http://ruza.sd-med.ru" => ["urlTag" => "/ruza", "cid" => 2],
            "http://ruza-uzi.ru" => ["urlTag" => "/ruza", "cid" => 2],
        ];

        if (Yii::$app->request->hostInfo !== Yii::$app->params["mainHost"] && Yii::$app->request->hostInfo !== "http://tech.sd-med.ru") {
            $urlWithMainHost = Yii::$app->params["mainHost"] . Yii::$app->request->url;
            if (array_key_exists(Yii::$app->request->hostInfo, $domainRedirects)) {
                $urlWithMainHost = Yii::$app->params["mainHost"] . $domainRedirects[Yii::$app->request->hostInfo]["urlTag"] . Yii::$app->request->url;
                Yii::$app->session->open();
                Yii::$app->session->set("cid", $domainRedirects[Yii::$app->request->hostInfo]["cid"]);
            }
            Yii::$app->response->redirect($urlWithMainHost, 301)->send();
            exit;
        }
    }
}