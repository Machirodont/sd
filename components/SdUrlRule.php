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


        $params = [];
        $route = "";

        if ($pathInfo === "/" || $pathInfo === "") {
            return ["/site/main-page", []];
        }
        if (preg_match_all('/([^\\/]+)/', $pathInfo, $matches)) {
            foreach ($matches[1] as $part) {
                $tag = UrlTags::findOne(["tag" => $part]);
                if ($tag) {
                    $params[$tag->param] = $tag->value;
                    if ($tag->route) $route = $tag->route;
                }

                if (preg_match('/clinic_([0-9]+)/', $part, $matches)) {
                    $route = "/site/main-page";
                    $params["cid"] = $matches[1];
                }
                if (preg_match('/promo_([0-9]+)/', $part, $matches)) {
                    $route = "/promo/view";
                    $params["id"] = $matches[1];
                }
                if ($route === "services/index") {
                    if (preg_match('/^([0-9]+)/', $part, $matches)) {
                        $params["id"] = $matches[1];
                    }
                }
                if (preg_match('/specialist_([0-9]+)/', $part, $matches)) {
                    $route = "persons/view";
                    $params["id"] = $matches[1];
                }
                if (preg_match('/page_([0-9]+)/', $part, $matches)) {
                    $route = "site/page";
                    $params["id"] = $matches[1];
                }

                if ($part && $endpointRoute = array_search($part, UrlConstructor::ENDPOINT)) {
                    $route = $endpointRoute;
                }
            }
            if (array_key_exists("cid", $params)) {
                if ($params["cid"]) {
                    Yii::$app->session->open();
                    Yii::$app->session->set("cid", $params["cid"]);
                } else {
                    Yii::$app->session->remove("cid");
                }
            }

            if ($route !== "") {
                return [$route, $params];
            }
        }
        return false;  // данное правило не применимо
    }

    public static function urlWithCID($cid)
    {
        $route = Yii::$app->request->queryParams;
        $r = "/" . Yii::$app->requestedRoute;
        unset($route["cid"]);
        unset($route["r"]);
        array_unshift($route, $r);
        $route["cid"] = $cid;
        return \yii\helpers\Url::toRoute($route);
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