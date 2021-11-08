<?php

use Codeception\Test\Unit;
use yii\helpers\Url;

class MainTest extends Unit
{
    /**
     * @var AcceptanceTester
     */
    protected $tester;
    private $delay = 3;

    public function _before()
    {
    }

    // tests
    public function testMain()
    {
        $I = $this->tester;
        $I->amOnPage(Url::toRoute(['/site/main-page']));
        $I->waitForText("Столичная диагностика", $this->delay);
        $I->waitForElement("div.head-name", $this->delay);
        $I->seeElement("div.head-name");
    }
}
