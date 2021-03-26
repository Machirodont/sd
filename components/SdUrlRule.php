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

    public const ENDPOINT=[
        's'=>"f",
    ];

    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        $url = "/";
        if (isset($params['cid'])) {
            if ($tag = UrlTags::findOne(["param" => "cid", "value" => $params['cid']])) {
                $url .= $tag->tag . "/";
            } else {
                $url .= "clinic_" . $params['cid'] . "/";
            }
            unset($params['cid']);
        }

        if ($route === 'persons/view') {
            if (!array_key_exists("id", $params)) return false;
            if ($tag = UrlTags::findOne(["route" => $route, "param" => "id", "value" => $params['id']])) {
                $url .= $tag->tag . "/";
            } else {
                $url .= "specialist_" . $params['id'] . '/';
            }
            return $url;
        }

        if ($route === 'site/page') {
            if (!array_key_exists("id", $params)) return false;
            if ($tag = UrlTags::findOne(["route" => $route, "param" => "id", "value" => $params['id']])) {
                $url .= $tag->tag . "/";
            } else {
                $url .= "page_" . $params["id"] . "/";
            }
            return $url;
        }

        if ($route === 'promo/view') {
            if (!array_key_exists("id", $params)) return false;
            $url .= "promo_" . $params["id"] . "/";
            return $url;
        }

        if ($route === 'services/index') {
            $url .= "services/";
            if (array_key_exists("id", $params)) {
                $url .= $params["id"] . "-service/";
            }
            return $url;
        }

        if ($route === 'site/main-page') {
            return $url;
        }


        if ($route === 'site/logout') {
            $url .= "logout/";
            return $url;
        }

        if ($route === 'site/login') {
            $url .= "login/";
            return $url;
        }

        if ($route === 'clinic/index') {
            $url .= "clinics/";
            return $url;
        }

        if ($route === 'clinic/index') {
            $url .= "clinics/";
            return $url;
        }

        if ($route === 'clinic/contacts') {
            $url .= "contacts/";
            return $url;
        }

        if ($route === 'clinic/company') {
            $url .= "company/";
            return $url;
        }

        if ($route === 'persons/index') {
            $url .= "specialisty/";
            return $url;
        }

        if ($url !== "/") {
            return $url.$route;
        }
        return false;
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

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


        //---- 301 редиректы
        if ($pathInfo === "price_sdmed.php") {
            if (Yii::$app->request->get("filial") == 1) Yii::$app->response->redirect("ruza/contacts/", 301)->send();
            if (Yii::$app->request->get("filial") == 2) Yii::$app->response->redirect("tuchkovo/contacts/", 301)->send();
            if (Yii::$app->request->get("filial") == 3) Yii::$app->response->redirect("gagarin/contacts/", 301)->send();
            Yii::$app->response->redirect("contacts/", 301)->send();
            exit;
        };

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
        //--/- 301 редиректы


        $params = [];
        $route = Yii::$app->defaultRoute;
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

                if ($part === "clinics") $route = "clinic/index";
                if ($part === "contacts") $route = "clinic/contacts";
                if ($part === "company") $route = "clinic/company";
                if ($part === "specialisty") $route = "persons/index";
                if ($part === "services") $route = "services/index";
                if (preg_match('/specialist_([0-9]+)/', $part, $matches)) {
                    $route = "persons/view";
                    $params["id"] = $matches[1];
                }
                if (preg_match('/page_([0-9]+)/', $part, $matches)) {
                    $route = "site/page";
                    $params["id"] = $matches[1];
                }
                if ($part === "parce") $route = "site/parce";
                if ($part === "login") $route = "site/login";
                if ($part === "logout") $route = "site/logout";
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

    public static function formatAsGet(array $params)
    {
        $get = "";
        foreach ($params as $name => $val) {
            $get .= urlencode($name) . "=" . urlencode($val) . '&';
        }
        return substr($get, 0, (strlen($get) - 1));
    }
}