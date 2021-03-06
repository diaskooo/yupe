<?php

/**
 * Файл основных настроек приложения
 *
 * ВНИМАНИЕ! ДАННЫЙ ФАЙЛ ИСПОЛЬЗУЕТСЯ ЯДРОМ YUPE!
 * ИЗМЕНЕНИЯ В ДАННОМ ФАЙЛЕ МОГУТ ПРИВЕСТИ К ПОТЕРЕ РАБОТОСПОСОБНОСТИ
 * Для собственных настроек создайте и используйте "/protected/config/userspace.php"
 * Подробную информацию по использованию "userspace" можно узнать из официальной
 * документаци - http://yupe.ru/docs/yupe/userspace.config.html
 *
 * @category YupeConfig
 * @package  Yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

// Определяем алиасы:
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('public', dirname($_SERVER['SCRIPT_FILENAME']));
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../../vendor/');
Yii::setPathOfAlias('themes','/../../themes/');

return array(
    'basePath'            => dirname(__FILE__) . '/..',
    // контроллер по умолчанию
    'defaultController'   => 'site',
    // название приложения
    'name'                => 'Yupe!',
    // язык по умолчанию
    'language'            => 'ru',
    'sourceLanguage'      => 'en',
    // тема оформления по умолчанию
    'theme'               => 'default',
    'charset'             => 'UTF-8',
    'controllerNamespace' => 'application\controllers',
    'preload'             => defined('YII_DEBUG')
        && YII_DEBUG
        && is_writable(Yii::getPathOfAlias('application.runtime'))
        && is_writable(Yii::getPathOfAlias('public.assets'))
            ? array('debug') : array(),
    'aliases'             => array(
        'bootstrap' => realpath(Yii::getPathOfAlias('vendor') . '/clevertech/yii-booster/src'),
    ),
    'import'              => array(
        // подключение основых путей
        'application.modules.yupe.models.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.controllers.*',
        'application.modules.yupe.extensions.tagcache.*',
    ),
    // подключение и конфигурирование модулей,
    // подробнее: http://www.yiiframework.ru/doc/guide/ru/basics.module
    'modules'             => array(
        'yupe' => array(
            'class' => 'application.modules.yupe.YupeModule',
            'cache' => true,
        ),
        // на продакшне gii рекомендуется отключить, подробнее: http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app
        /*'gii'   => array(
            'class'          => 'system.gii.GiiModule',
            'password'       => 'giiYupe',
            'generatorPaths' => array(
                'application.modules.yupe.extensions.yupe.gii',
            ),
            'ipFilters'=>array(),
        ),*/
    ),
    'behaviors'           => array(
        'onBeginRequest' => array(
            'class' => 'yupe\components\urlManager\LanguageBehavior'
        )
    ),
    'params'              => require dirname(__FILE__) . '/params.php',
    // конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)
    'components'          => array(
        'viewRenderer'  => array(
            'class'         => 'vendor.yiiext.twig-renderer.ETwigViewRenderer',
            'twigPathAlias' => 'vendor.twig.twig.lib.Twig',
            // All parameters below are optional, change them to your needs
            'fileExtension' => '.twig',
            'options'       => array('autoescape' => true,),
            'globals'       => array('html' => 'CHtml'),
            'filters'       => array('jencode' => 'CJSON::encode',),
        ),
        'debug'         => array('class' => 'vendor.zhuravljov.yii2-debug.Yii2Debug', 'internalUrls' => false,),
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        // используется лишь после установки Юпи:
        'db'            => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : array(),
        'bootstrap'     => array(
            'class'          => 'bootstrap.components.Booster',
            'responsiveCss'  => true,
            'fontAwesomeCss' => true,
        ),
        'eventManager'  => array('class' => 'yupe\components\EventManager'),
        'configManager' => array('class' => 'yupe\components\ConfigManager',),
        'moduleManager' => array('class' => 'yupe\components\ModuleManager',),
        // Работа с миграциями, обновление БД модулей
        'migrator'      => array('class' => 'yupe\components\Migrator',),
        // DAO simple wrapper:
        'dao'           => array('class' => 'yupe\components\DAO',),
        'image'         => array('class' => 'yupe\components\image\Image',),
        'uploadManager' => array('class' => 'yupe\components\UploadManager',),
        'themeManager'  => array(
            'class'      => 'CThemeManager',
            'basePath'   => dirname(__DIR__) . '/../themes',
            'themeClass' => 'yupe\components\Theme',
        ),
        'cache'         => array(
            'class'     => 'CFileCache',
            'behaviors' => array('clear' => array('class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',),),
        ),
        // конфигурирование urlManager, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.url
        'urlManager'    => array(
            'class'            => 'yupe\components\urlManager\LangUrlManager',
            //comment this if if multilingual unnecessary
            //'class'          => 'CUrlManager', // default yii UrlManager
            'languageInPath'   => true,
            //comment this if if multilingual unnecessary
            'langParam'        => 'language',
            //comment this if if multilingual unnecessary
            'urlFormat'        => 'path',
            'showScriptName'   => false,
            // чтобы убрать index.php из url, читаем: http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
            'cacheID'          => 'cache',
            'useStrictParsing' => true,
            'rules'            => array( // общие правила
                '/'                                                            => '/site/index',
                // для корректной работы устновщика
                '/install/default/<action:\w+>'                                => '/install/default/<action>',
                '/backend'                                                     => 'yupe/backend/index',
                '/backend/login'                                               => 'user/account/backendlogin',
                '/backend/<action:\w+>'                                        => 'yupe/backend/<action>',
                '/backend/<module:\w+>/<controller:\w+>'                       => '<module>/<controller>Backend/index',
                '/backend/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>Backend/<action>',
                '/backend/<module:\w+>/<controller:\w+>/<action:\w+>'          => '<module>/<controller>Backend/<action>',
                '/gii/<controller:\w+>/<action:\w+>'                           => 'gii/<controller>/<action>',
                '/site/<action:\w+>'                                           => 'site/<action>',
                '/debug/<controller:\w+>/<action:\w+>'                         => 'debug/<controller>/<action>',
                // Для  YiiDebugPanel
            )
        ),
        // конфигурируем компонент CHttpRequest для защиты от CSRF атак, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.security
        // РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
        // базовый класс CHttpRequest переопределен для загрузки файлов через ajax, подробнее: http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
        'request'       => array(
            'class'                  => 'yupe\components\HttpRequest',
            'enableCsrfValidation'   => true,
            'csrfCookie'             => array('httpOnly' => true,),
            'csrfTokenName'          => 'YUPE_TOKEN',
            'noCsrfValidationRoutes' => array('backend/AjaxImageUpload', 'backend/AjaxFileUpload'),
            'enableCookieValidation' => true,
            // подробнее: http://www.yiiframework.com/doc/guide/1.1/ru/topics.security#sec-4
        ),
        'session'       => array('cookieParams' => array('httponly' => true,)),
        // подключение компонента для генерации ajax-ответов
        'ajax'          => array('class' => 'yupe\components\AsyncResponse',),
        // параметры логирования, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.logging
        'log'           => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info, trace', // на продакшн лучше оставить error, warning
                ),
            ),
        ),
        'errorHandler'  => array( // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
    ),
    'rules'               => array( //подробнее http://yupe.ru/docs/yupe/userspace.config.html
    )
);
