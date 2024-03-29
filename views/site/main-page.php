<?php

/* @var $this yii\web\View */

/* @var Pages $page
 * @var Persons[] $persons
 * @var Clinic[] $clinicList
 * @var array $promoList
 */

use app\models\Clinic;
use app\models\Pages;
use app\models\Persons;
use yii\helpers\Html;
use yii\bootstrap\Carousel;

$this->title = "Сеть медицинских центров Столичная диагностика | УЗИ, Анализы Диалаб, Хеликс. Врачи из Москвы: Педиатр, Эндокринолог, Гинеколог, Гастроскопия, Кардиолог, Гастроэнтеролог, Уролог, Невролог, Аллерголог, Маммолог, Гематолог";
$this->registerMetaTag(["name" => "description", "content" => "Сеть медицинских центров Столичная диагностика | УЗИ, Анализы Диалаб, Хеликс. Врачи из Москвы: Педиатр, Эндокринолог, Гинеколог, Гастроскопия, Кардиолог, Гастроэнтеролог, Уролог, Невролог, Аллерголог, Маммолог, Гематолог"]);
$this->registerMetaTag(["name" => "keywords", "content" => "Сеть медицинских центров Столичная диагностика | УЗИ, Анализы Диалаб, Хеликс. Врачи из Москвы: Педиатр, Эндокринолог, Гинеколог, Гастроскопия, Кардиолог, Гастроэнтеролог, Уролог, Невролог, Аллерголог, Маммолог, Гематолог"]);

?>
<div class="top_wrapper">
    <div class="mainpage">
        <section class="first">
            <h4>«Столичная диагностика» — это правильный диагноз и современный подход к лечению!</h4>
            <ul>
                <li>С позиции доказательной медицины.</li>
                <li>Без лишних анализов, таблеток и дополнительных медицинских услуг.</li>
                <li>Современные технологии диагностики и лечения</li>
                <li>Профессионалы высочайшего уровня</li>
                <li>Оборудование экспертного класса</li>
                <li>Анализы последнего поколения</li>
            </ul>
        </section>
    </div>

    <?php
    if ($promoList) {
        ?>
        <div class="carousel_wrapper <?= count($promoList) === 1 ? "single_picture" : "" ?>">
            <?=
            Carousel::widget([
                'options' => [
                    'class' => "carousel slide",
                ],
                'clientOptions' => [
                    'interval' => false
                ],
                'items' => $promoList,
            ]);
            ?>
        </div>
        <?php
    } ?>
</div>

<?php $cid = Yii::$app->session->get("cid"); ?>
<div class="mainpage">
    <?php foreach ($clinicList as $clinic) {
        echo Html::a("Медицинский центр " . $clinic->in, ["/clinic/contacts", "cid" => $clinic->id], ["class" => "person_row spec_button" . (intval($cid) ===  $clinic->id ? " current" : "")]);
    }
    ?>
</div>

<div class="mainpage">
    <section>
        <h3>Профессионалы высочайшего уровня</h3>
        <p>Нам удалось собрать команду специалистов, работающих в крупных столичных медицинских центрах. Приоритетом при
            приеме на работу в наш центр является научная или преподавательская деятельность.</p>
        <ul>
            <li>Первый Московский государственный медицинский университет имени И.М. Сеченова</li>
            <li>Национальный медико-хирургический Центр им. Н.И. Пирогова</li>
            <li>Московский научно-практический центр дерматовенерологии и косметологии</li>
            <li>Центр планирования семьи и репродукции Москвы</li>
            <li>Московский государственный медико-стоматологический университет</li>
            <li>Московский областной научно-исследовательский клинический институт им. М. Ф. Владимирского</li>
            <li>Университетская клиническая больница №1</li>
            <li>Университетская клиническая больница №2</li>
            <li>Научно-исследовательский институт клинической кардиологии им. А.Л. Мясникова</li>
        </ul>
    </section>
</div>

<div class="mainpage">
    <section class="person_row">
        <?php
        foreach ($persons as $person) {
            /**@var $person Persons */
            echo $this->render("/persons/_card_ext", ["model" => $person]);
        }
        ?>
    </section>
</div>
<div class="mainpage">
    <?= Html::a("ВСЕ СПЕЦИАЛИСТЫ", ["/persons/index"], ["class" => "person_row spec_button"]) ?>
</div>
<div class="mainpage">
    <section class="mainpage">
        <h3>Оборудование экспертного класса</h3>
        <p>Для работы мы выбираем самое современное оборудование экспертного уровня.</p>
        <h4>УЗИ на современной системе Voluson E8</h4>
        <div>
            <figure><img src="/uploads/2014/03/Voluson-E8-product.jpg"
                         alt="Ультразвуковая система Voluson E8"
                         srcset="/uploads/2014/03/Voluson-E8-product.jpg 462w, /uploads/2014/03/Voluson-E8-product-300x176.jpg 300w"
                         sizes="(max-width: 462px) 100vw, 462px"></figure>
            <div>
                <p><br>Voluson E8 – это ультразвуковая система, предназначенная для использования в области женского
                    здоровья, включая акушерство, гинекологию, перинатологию и вспомогательную репродуктивную медицину.
                    Инновации в качестве изображения, автоматизации, технологии датчиков и анализе изображений
                    обеспечивают выдающееся качество изображений, помогая оказывать первоклассную помощь пациентам.</p>
            </div>
        </div>
    </section>

    <section class="mainpage">
        <h3>Анализы последнего поколения</h3>
        Мы обеспечиваем высокое качество и современный уровень лабораторных услуг. В этом нам помогают наши партнеры:
        <div class="partner_bar">
            <br>
            Лабораторная служба Хеликс
            <figure>
                <img class="partner_bar" src="/images/helix_bar.jpg"
                     alt="Партнер Столичной Диагностики - Лабораторная служба Хеликс">
            </figure>
            <br>
            Лаборатория Диалаб
            <figure>
                <img class="partner_bar" src="/images/dialab_bar.jpg"
                     alt="Партнер Столичной Диагностики - лаборатория Диалаб">
            </figure>
            <br>
            Медикал Геномикс
            <figure>
                <img class="partner_bar" src="/images/medgenomix_bar.jpg"
                     alt="Партнер Столичной Диагностики - Медикал Геномикс">
            </figure>
            <br>
        </div>
    </section>
</div>
