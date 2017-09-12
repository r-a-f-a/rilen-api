<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
	$api->group(['namespace' => 'Api\Controllers', 'middleware' => '\Barryvdh\Cors\HandleCors::class'], function ($api) {
		$api->post('login', 'AuthController@authenticate');
		$api->post('register', 'AuthController@register');
		$api->post('auto', 'AuthController@auto');
		$api->get('token', 'AuthController@token');
		$api->post('cross', 'AuthController@cross');
		$api->post('crossLink', 'AuthController@crossLink');

		$api->group( [ 'middleware' => 'jwt.auth' ], function ($api) {
			$api->get('user', 'AuthController@userView');
			$api->get('validate_token', 'AuthController@validateToken');



			##### CONFIGS ####
			$api->post('config', 'ConfigLimitController@configupdate');
			$api->get('config', 'ConfigLimitController@show');
			$api->post('configs/global','ConfigBtgController@createorderglobal');
			$api->get('configs/global','ConfigBtgController@listglobals');
			$api->resource('configs/priorities', 'ConfigsController');

			##### RULES ####

            $api->resource('rules', 'RulesController');
			$api->post('rules/status', 'RulesController@status');
            $api->resource('rules/list', 'RulesListController');

			$api->resource('peals', 'PealController');
			$api->resource('peals/list', 'PealListController');


			$api->resource('rules/data', 'RulesDataController');
			$api->resource('rules/field', 'RulesFieldController');
            $api->resource('rules/version', 'RulesVersionController');
            $api->resource('rules/all', 'RulesAllController');


			##### TEMPLATES ####
			$api->get('templates/all', 'TemplateController@all');
			$api->post('templates/preview', 'TemplateController@preview');
			$api->post('templates/view', 'TemplateController@view');
			$api->resource('templates', 'TemplateController');


			##### LISTS ####
			$api->resource('list/products', 'ProductListController');
			$api->resource('list/brands', 'BrandListController');
			$api->resource('list/departments', 'DepartmentListController');
			$api->resource('list/categories', 'CategoryListController');
			$api->resource('list/subcategories', 'SubCategoryListController');

			##### THEMES #####
            $api->get('themes/all', 'ThemesController@all');


            ##### THEMES TAGS #####
            $api->resource('themes/tags','ThemesTagsController');
            $api->resource('themes','ThemesController');

            ##### REPORTS #####
            $api->resource('reports', 'ReportController');

            ##### DASHBOARD #####
            $api->resource('dashboard', 'DashboardController');

            ##### VMTA #####
            $api->get('vmta', 'VmtaController@getVmtaList');
            $api->post('vmta', 'VmtaController@updateVmta');
		});
	});
});
Route::get('go', 'Api\Controllers\RedirectorController@index');