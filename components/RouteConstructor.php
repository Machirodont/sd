<?php


namespace app\components;


use app\models\UrlTags;
use Yii;

class RouteConstructor
{

    private $pathInfo; //Часть url между именем домена и параметрами
    private $params = [];
    private $route = "";

    private const P_ENDPOINTS = [
        ["pattern" => '/clinic_([0-9]+)/', "paramName" => "cid", "route" => "site/main-page"],
        ["pattern" => '/promo_([0-9]+)/', "paramName" => "id", "route" => "promo/view"],
        ["pattern" => '/specialist_([0-9]+)/', "paramName" => "id", "route" => "persons/view"],
        ["pattern" => '/page_([0-9]+)/', "paramName" => "id", "route" => "site/page"],
        ["pattern" => '/^([0-9]+)\\-service/', "paramName" => "id", "route" => "services/index"],
    ];

    public function __construct(string $pathInfo)
    {
        $this->pathInfo = $pathInfo;
    }

    public function buildRoute(): ?array
    {
        if ($this->pathInfo === "/" || $this->pathInfo === "") {
            return ["/site/main-page", []];
        }
        if (preg_match_all('/([^\\/]+)/', $this->pathInfo, $matches)) {
            foreach ($matches[1] as $part) {
                $this->customTagsRouting($part);
                $this->parametrizedEndpointsRouting($part);
                $this->simpleEndpointsRouting($part);
            }

            if ($this->route !== "") {
                return [$this->route, $this->params];
            }
        }
        return null;
    }

    private function customTagsRouting(string $part)
    {
        $tag = UrlTags::findOne(["tag" => $part]);
        if ($tag) {
            $this->params[$tag->param] = $tag->value;
            if ($tag->route) $this->route = $tag->route;
        }
    }

    private function parametrizedEndpointsRouting($part)
    {
        foreach (self::P_ENDPOINTS as $endpoint) {
            if (preg_match($endpoint['pattern'], $part, $matches)) {
                $this->route = $endpoint['route'];
                $this->params[$endpoint['paramName']] = $matches[1];
            }
        }
    }

    private function simpleEndpointsRouting($part)
    {
        if ($part && $endpointRoute = array_search($part, UrlConstructor::ENDPOINT)) {
            $this->route = $endpointRoute;
        }
    }
}