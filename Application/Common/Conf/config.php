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
    'db_host'   => '这里是地址',
    'db_name'   => 'qjzy',
    'db_user'   => 'root',
    'db_pwd'    => '这里是数据库密码',
    'db_port'   => 3306,
    'db_prefix' => '',
	'SYSTEM_NAME'=>'代码生成器',//项目名称
);
