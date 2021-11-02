<?php


namespace app\components;


use app\models\UrlTags;
use Yii;
use yii\helpers\Url;

class UrlConstructor
{
    private $route;
    private $params;
    private $url;

    public const ENDPOINT = [
        'site/main-page' => '',
        'site/logout' => "logout",
        'site/login' => "login",
        'clinic/index' => "clinics",
        'clinic/contacts' => "contacts",
        'clinic/company' => "company",
        'persons/index' => "specialisty",
        "services/index" => "services",
        "site/parce" => "parce",
        "appointment/appointment-index" => "appointment-index",
        "appointment/create" => "appointment-create",
        "appointment/cancel" => "appointment-cancel",
        "appointment/pick-up" => "appointment-pick_up",
        "appointment/set-status" => "appointment-set_status",
        "appointment/view" => "appointment-view",
        "appointment/appointments-by-number" => "appointments-by-number",
    ];


    public const P_ENDPOINT = [
        'persons/view' => ["pName" => "id", "defaultTag" => "specialist"],
        'site/page' => ["pName" => "id", "defaultTag" => "page"],
        'promo/view' => ["pName" => "id", "defaultTag" => "promo"],
    ];


    public function __construct(string $route, array $params)
    {
        $this->params = $params;
        $this->route = $route;
    }

    public function buildUrl(): string
    {
        $this->url = "/";
        $this->addClinicTag();

        if (array_key_exists($this->route, self::P_ENDPOINT)) {
            $this->parametrizedEndpoint(self::P_ENDPOINT[$this->route]["pName"], self::P_ENDPOINT[$this->route]["defaultTag"]);
        } elseif ($this->route === 'services/index') {
            $this->servicesEndpoint();
        } elseif (array_key_exists($this->route, self::ENDPOINT)) {
            $this->simpleEndpoint();
        }

        return $this->url;
    }

    private function addClinicTag()
    {
        if (array_key_exists('cid', $this->params) && !is_null($this->params['cid'])) {
            $this->url .= self::getTag("site/main-page", "cid", $this->params['cid'], "clinic") . "/";
            unset($this->params['cid']);
        }
    }

    private function simpleEndpoint()
    {
        $this->url .= self::ENDPOINT[$this->route] . "/";
        if (count($this->params)) $this->url .= '?' . http_build_query($this->params);
    }

    private function parametrizedEndpoint($paramName, $prefix)
    {
        if (!array_key_exists($paramName, $this->params)) return false;
        $this->url .= self::getTag($this->route, $paramName, $this->params[$paramName], $prefix) . "/";
    }

    private function servicesEndpoint()
    {
        $this->url .= "services/";
        if (array_key_exists("id", $this->params)) {
            $this->url .= $this->params["id"] . "-service/";
        }
    }

    private function getTag(string $route, string $param, ?string $value, string $prefix): string
    {
        $tag = UrlTags::findOne(["route" => $route, "param" => $param, "value" => $value]);
        return $tag ? $tag->tag : $prefix . "_" . $value;
    }

    public static function urlWithCID($cid)
    {
        $route = Yii::$app->request->queryParams;
        $r = "/" . Yii::$app->requestedRoute;
        unset($route["cid"]);
        unset($route["r"]);
        array_unshift($route, $r);
        $route["cid"] = $cid;
        return Url::toRoute($route);
    }
}