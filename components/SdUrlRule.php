<?php


namespace app\components;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\UrlRule;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;


class SdUrlRule extends UrlRule implements UrlRuleInterface
{

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
            $url .= "clinic_" . $params['cid'] . "/";
        }

        if ($route === 'clinic/index') {
            $url = "clinics/";
            return $url;
        }

        if ($route === 'clinic/contacts') {
            $url .= "contacts/";
            return $url;
        }

        if ($route === 'persons/view') {
            if (isset($params['id'])) {
                $url .= "doctor_" . $params['id'] . '/';
            } else return false;
            return $url;
        }

        if ($route === 'persons/index') {
            $url .= "doctors/";
            return $url;
        }
        return false;  // данное правило не применимо
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

        //---- 301 редиректы
        $redirects=(new Query())
            ->select("*")
            ->from("sd_redirect")
            ->where(
                "\"".htmlspecialchars($pathInfo)."\" LIKE CONCAT(\"%\",`from`, \"%\")"
            )
            ->all();
        if(count($redirects)>0){
            Yii::$app->response->redirect("/".$redirects[0]["to"], 301)->send();
            exit;
        }
        //--/- 301 редиректы

        $params = [];
        $route = "";
        if (preg_match_all('/([^\\/]+)/', $pathInfo, $matches)) {
            foreach ($matches[1] as $part) {
                if (preg_match('/clinic_([0-9]+)/', $part, $matches)) {
                    $params["cid"] = $matches[1];
                    Yii::$app->session->open();
                    Yii::$app->session["cid"] = $params["cid"];
                    if (!Yii::$app->session["cid"]) Yii::$app->session->remove("cid");
                }
                if ($part === "clinics") $route = "clinic/index";
                if ($part === "contacts") $route = "clinic/contacts";
                if ($part === "doctors") $route = "persons/index";
                if (preg_match('/doctor_([0-9]+)/', $part, $matches)) {
                    $route = "persons/view";
                    $params["id"] = $matches[1];
                }
            }
            if ($route !== "") {
                return [$route, $params];
            }
        }
        return false;  // данное правило не применимо
    }

}