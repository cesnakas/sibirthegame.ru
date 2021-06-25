<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
?>

    <section class="banner" itemscope itemtype="http://schema.org/Product">
        <div class="wrap banner-wrap">
            <div class="banner-left">
                <div class="banner-preOrder">
                    <div class="banner-preorder__left">
                        <img itemprop="image" src="<?=SITE_TEMPLATE_PATH?>/dist/img/box-img.png" alt="Коробка с игрой">
                    </div>
                    <div class="banner-preOrder__right" itemprop="offers">
                        <meta itemprop="name" content="Настольная игра «Сибирь. Начало»">
                        <meta itemprop="description" content="Настольная игра «Сибирь. Начало» – игра для 2-4 игроков, которым интересно оказаться в роли покорителя Сибири XVIII века. Осваивайте со своим отрядом новые территории, находите сокровища, возводите церкви и остроги, основывайте поселения и сражайтесь с врагами! Станьте настоящим правителем земли сибирской!">
                        <meta itemprop="priceCurrency" content="RUB">
                        <p class="banner-preOrder__title">Цена:</p>
                        <p class="banner-preOrder__price"><span class="banner-preOrder__price--number" itemprop="price">1899</span> рублей</p>
                        <p class="banner-preOrder__footnote">
                            Доставка Почтой России по РФ, курьером по Москве,
                            <br>
                            самовывоз м. Дмитровская ("Хлебозавод").
                        </p>
                        <div class="banner-preOrder__img--mobile"></div>
                        <a @click="click_buy" class="black-btn banner-preOrder__btn">Купить</a>
                    </div>
                </div>
            </div>
            <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/cover.png" class="banner-cover" alt="Персонажи">
            <div class="banner-cover--mobile" style="background-image: url(/dist/img/cover-mobile.jpg);"></div>
        </div>
    </section>

    <?php
    /*
    $APPLICATION->IncludeComponent(
        'defa:block',
        'main_banner',
        [

        ]
    );
    */
    ?>

    <section class="limitations">
        <div class="wrap limitations-wrap">
            <div class="limitations--text">
                Настольная игра <b>«Сибирь. Начало»</b> – игра для 2-4&nbsp;игроков,
                которым интересно оказаться в роли покорителя Сибири XVIII века. Осваивайте со своим отрядом новые
                территории, находите сокровища, возводите церкви и остроги, основывайте поселения и сражайтесь с
                врагами! <br>
                Станьте настоящим правителем земли сибирской!
            </div>
            <div class="limitations-list">
                <div class="limitations-list__item">
                    <img class="limitations-list__item__img" src="<?=SITE_TEMPLATE_PATH?>/dist/img/limitation_age.svg" alt="img">
                    <b class="limitations-list__item__title">Возраст</b>
                    <p class="limitations-list__item__descr">от 8 лет</p>
                </div>
                <div class="limitations-list__item">
                    <img class="limitations-list__item__img" src="<?=SITE_TEMPLATE_PATH?>/dist/img/limitation_players.svg" alt="img">
                    <b class="limitations-list__item__title">Количество игроков</b>
                    <p class="limitations-list__item__descr">2–4</p>
                </div>
                <div class="limitations-list__item">
                    <img class="limitations-list__item__img" src="<?=SITE_TEMPLATE_PATH?>/dist/img/limitation_time.svg" alt="img">
                    <b class="limitations-list__item__title">Длительность игры</b>
                    <p class="limitations-list__item__descr">30–60 минут</p>
                </div>
            </div>
        </div>
    </section>

    <section id="mechanics" class="mechanics">
        <div class="wrap mechanics-wrap">

            <h2 class="h2 mechanics__h2">Механика игры</h2>

            <p class="mechanics__descr">Поочередно выставляя от стартового поля и осваивая тайлы карты земель Сибири,
                игроки передвигают по ней своих ватажников так, чтобы их расположение на объектах карты соответствовало требованиям различных заданий. В конце каждого хода игрок должен постараться выполнить одно или несколько выбранных им заданий.<br/>
                Каждое выполненное задание приносит игроку победные очки. <br/>
                <span class="red-text">Побеждает в игре тот, кто в конце партии наберет наибольшее
            количество очков.</span>
            </p>

            <div class="mechanics-list">
                <div class="mechanics-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/mechanics_1.png" class="mechanics-item__img" alt="img">
                    <h4 class="mechanics-item__title">Открывай новые территории</h4>
                    <p class="mechanics-item__descr">Выкладывай тайлы новых земель
                        и передвигай своих ватажников по тундре,
                        тайге и степи. Осваивай земли,
                        переворачивая тайлы.</p>
                </div>
                <div class="mechanics-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/mechanics_2.png" class="mechanics-item__img" alt="img">
                    <h4 class="mechanics-item__title">Выполняй задания</h4>
                    <p class="mechanics-item__descr">Выбирай карточки заданий,
                        выполняй их и зарабатывай очки
                        для победы в игре. Сложные задания
                        дают больше очков!</p>
                </div>
                <div class="mechanics-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/mechanics_3.png" class="mechanics-item__img" alt="img">
                    <h4 class="mechanics-item__title">Действуй стратегически</h4>
                    <p class="mechanics-item__descr">Выстраивай своих ватажников таким образом, чтобы быстрее выполнять задания и мешать делать это соперникам.</p>
                </div>
            </div>

            <div class="mechanics__video">
                <style>
                    .mechanics__video {
                        display: flex;
                        justify-content: center;
                        margin-top: 70px;
                    }
                </style>
                <iframe src="https://www.youtube.com/embed/ieZsbOAkdkA" width="560" height="315"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen="allowfullscreen"></iframe>
            </div>

        </div>
    </section>

    <section id="inBox" class="inBox">
        <div class="wrap inBox-wrap">
            <h2 class="h2 inBox__h2">Что в коробке?</h2>
            <div class="inBox-list">
                <div class="inBox-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_1.jpeg" class="inBox-item__img" style="margin-top: 10px;">
                    <h4 class="inBox-item__title">1 стартовое игровое поле</h4>
                    <p class="inBox-item__descr">(Уральский хребет);</p>
                </div>
                <div class="inBox-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_2.jpeg" class="inBox-item__img" style="margin-top: 10px;">
                    <h4 class="inBox-item__title">90 квадратных двусторонних тайлов земель Сибири трех видов:</h4>
                    <p class="inBox-item__descr">30 тайлов тундры, 30 тайлов тайги, 30 тайлов степи</p>
                </div>
                <div class="inBox-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_3.jpeg" class="inBox-item__img" style="margin-top: 10px;">
                    <h4 class="inBox-item__title">20 фигурок ватажников</h4>
                    <p class="inBox-item__descr">4-х разных цветов</p>
                </div>
                <div class="inBox-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_4.jpeg" class="inBox-item__img" style="margin-top: 165px;">
                    <h4 class="inBox-item__title">94 карточки</h4>
                    <p class="inBox-item__descr">60 карточек поручений, 30 карточек фортуны, 4 карточки пути </p>
                </div>
                <div class="inBox-item">
                    <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_5.jpeg" class="inBox-item__img" style="margin-top: 0px;">
                    <h4 class="inBox-item__title">Правила игры и памятка превращения тайлов</h4>
                </div>
            </div>
            <div class="swiper-container inBox-slider swiper-container-initialized swiper-container-horizontal">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="inBox-item">
                            <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_1.jpeg" alt="" class="inBox-item__img">
                            <h4 class="inBox-item__title">1 стартовое игровое поле</h4>
                            <p class="inBox-item__descr">(Уральский хребет);</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="inBox-item">
                            <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_2.jpeg" alt="" class="inBox-item__img">
                            <h4 class="inBox-item__title">90 квадратных двусторонних тайлов земель Сибири трех видов:</h4>
                            <p class="inBox-item__descr">30 тайлов тундры, 30 тайлов тайги, 30 тайлов степи</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="inBox-item">
                            <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_3.jpeg" alt="" class="inBox-item__img">
                            <h4 class="inBox-item__title">20 фигурок ватажников</h4>
                            <p class="inBox-item__descr">4-х разных цветов</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="inBox-item">
                            <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_4.jpeg" alt="" class="inBox-item__img">
                            <h4 class="inBox-item__title">94 карточки</h4>
                            <p class="inBox-item__descr">60 карточек поручений, 30 карточек фортуны, 4 карточки пути </p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="inBox-item">
                            <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/inBox_5.jpeg" alt="" class="inBox-item__img">
                            <h4 class="inBox-item__title">Правила игры и памятка превращения тайлов</h4>
                            <p class="inBox-item__descr"></p>
                        </div>
                    </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <a href="/dist/game_rules.pdf" target="_blank" class="red-btn inBox-btn">Скачать правила .pdf </a>
    </section>

    <section class="vocabulary">
        <div class="wrap vocabulary-wrap">
            <div class="vocabulary-content">
                <img class="vocabulary-content__logo" src="<?=SITE_TEMPLATE_PATH?>/dist/img/logo-mini.png" alt="Лого Сибирь">
                <img class="vocabulary-content__title" src="<?=SITE_TEMPLATE_PATH?>/dist/img/slovnik-title.svg" alt="Словник">
                <p class="vocabulary-content__descr">Хотите узнать как собрать <b>ясак</b>? Как найти <b>шамана</b>?
                    Кто такой <b>целовальник</b>? Что такое <b>мягкая рухлядь</b>?
                    Читайте наш <b>Словник</b> и узнайте больше
                    об истории Сибири.</p>
                <img class="vocabulary-content__characters" src="<?=SITE_TEMPLATE_PATH?>/dist/img/characters.png" alt="Персонажи">
                <a class="red-btn vocabulary-content__btn" href="/encyclopedia.html">Читать</a>
            </div>
        </div>
    </section>

    <section id="preorder" class="preOrder">
        <div class="wrap preOrder-wrap">
            <div class="preOrder--inner">
                <div class="preOrder-left">
                    <img class="preOrder-left__img" src="<?=SITE_TEMPLATE_PATH?>/dist/img/game_box.png" alt="Коробка с игрой">
                    <strong class="preOrder-left-content__descr mobile-only"></strong>
                    <p class="preOrder-left-content__descr mobile-only"></p>
                    <a @click="click_buy" class="black-btn preOrder-right__btn mobile-only">Купить</a>
                </div>
                <div class="preOrder-right">
                    <p class="preOrder-right__text">Цена:</p>
                    <p class="preOrder-right__price"><span class="preOrder-right__price--number">1899</span> рубль</p>
                    <p class="preOrder-right__descr">
                        Доставка Почтой России по РФ, курьером по Москве,
                        <br>
                        самовывоз м. Дмитровская ("Хлебозавод").
                    </p>
                    <a @click="click_buy" class="red-btn preOrder-right__btn mobile-none">Купить</a>
                    <h3 class="preOrder-left-content__title mobile-none"></h3>
                    <p class="preOrder-left-content__descr mobile-none"></p>
                    <!-- <div class="preOder-dislaimer">
                        <p>* - предзаказная цена действительна до <b>1 декабря 2020 года</b></p>
                    </div> -->
                </div>
            </div>
        </div>
        <div id="publisher" class="publisher">
            <div class="wrap">
                <h2 class="h2 contacts__h2">Об издателе</h2>
                <div class="publisher-content">
                    <div class="publisher-item">
                        <img src="<?=SITE_TEMPLATE_PATH?>/dist/img/logo_cvz.svg" alt="система ценностей">
                    </div>

                    <div class="publisher-item">
                        <div class="publisher-item-info">
                            <div class="infos">
                                <p>Создатель игры&nbsp;— автономная некоммерческая организация по&nbsp;поддержке просветительских проектов <b>«Система Ценностей»</b>. АНО основана в&nbsp;2013 году. Реализует издательские, контентные, культурные проекты.</p>
                                <p>Тематика всех проектов так или иначе связана с&nbsp;культурой, в&nbsp;которой мы&nbsp;живем. К&nbsp;сожалению, тема многонациональной истории России и&nbsp;СССР сейчас сильно политизирована, узурпирована пропагандой. Мир разделился на&nbsp;квасных патриотов и&nbsp;безродных космополитов. Мы&nbsp;против такого деления и&nbsp;своими проектами стараемся показать, что серединный путь возможен.</p>
                                <p>Мы&nbsp;не&nbsp;«грантоеды», не&nbsp;пильщики госбюджета и&nbsp;не&nbsp;иностранные агенты. Да, такое тоже бывает!</p>
                                <p>Если вам интересно нас поддержать, подпишитесь на&nbsp;<a class="red-link" href="https://www.facebook.com/sistema.cennostey/" target="_blank">рассылку</a>, делитесь нашими новостями, <a class="red-link" href="http://sistemacennostey.ru/supporters/help/" target="_blank">донаты</a> тоже приветствуются!</p>
                            </div>
                            <div class="publisher-item-info__links">
                                <div>
                                    <a href="http://sistemacennostey.ru/" rel="nofollow" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="publisher-links--svg icon sprite-icons">
                                            <use href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#i-link-icons" xlink:href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#i-link-icons">
                                            </use>
                                        </svg>
                                        sistemacennostey.ru
                                    </a>
                                </div>
                                <div>
                                    <a href="https://www.facebook.com/sistema.cennostey/" rel="nofollow" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="publisher-links--svg icon sprite-icons">
                                            <use href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#i-link-icons" xlink:href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#i-link-icons">
                                            </use>
                                        </svg>
                                        Facebook
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="contacts" class="contacts">
            <div class="wrap contacts-wrap">
                <h2 class="h2 contacts__h2">Контакты</h2>
                <div class="contacts-content">
                    <div class="contacts-content__list">
                        <p class="contacts-content__list__title">По всем вопросам:</p>
                        <p class="contacts-content__list__text">
                            Тел.: <a href="tel:+74951234567" class="red-link">+7 (916) 1708626</a>
                        </p>
                        <p class="contacts-content__list__text">
                            E-mail: <a href="mailto:info@sistemacennostey.ru" class="red-link">info@sistemacennostey.ru</a>
                        </p>
                    </div>
                    <!-- <div class="contacts-content__info">
                        <img class="contacts-content__info__img" src="/dist/img/whatsapp.svg" alt="img">
                        <p class="contacts-content__info__text">Также вы можете заказать игру, связавшись с нами в <a :href="contacts.whatsapp" class="red-link">WhatsApp</a></p>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>