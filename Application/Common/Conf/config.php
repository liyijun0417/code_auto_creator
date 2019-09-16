<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODEL'            => 1,
	'VAR_PAGE'             => 'page',
	'LAYOUT_ON'            => true,
	'MODULE_ALLOW_LIST'    => array('Home','Admin','TPH'),
    'DEFAULT_MODULE'       => 'Admin',
    'DEFAULT_FILTER'       => 'htmlspecialchars',
    'SHOW_PAGE_TRACE'      => false,
    'AUTOLOAD_NAMESPACE' => array(
        'Lib'     => APP_PATH.'Yijun',
    ),
	//'TMPL_EXCEPTION_FILE' => '404.html',
    'db_type'   => 'mysql',
    'db_host'   => '127.0.0.1',
    'db_name'   => 'pszw',
    'db_user'   => 'root',
    'db_pwd'    => '',
    'db_port'   => 3306,
    'db_prefix' => '',
	'SYSTEM_NAME'=>'代码生成器',
);
