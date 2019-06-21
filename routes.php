<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::any("/",["as"=>"admin_login","uses"=>"admin\SecurityController@doLogin"]);

Route::get('dirPagination',array('uses' => 'admin\SecurityController@getPagination'));
Route::any("admin/",["as"=>"admin_login","uses"=>"admin\SecurityController@doLogin"]);
Route::any("admin/login/post",["as"=>"admin_login_post","uses"=>"admin\SecurityController@doLoginPost"]);
Route::any("admin/forgotpassword", ['as' => 'admin_forgotpassword', 'uses' => "admin\SecurityController@forgotPassword"]);
Route::any("admin/forgot_password", ['as' => 'admin_forgot_password_code', 'uses' => "admin\SecurityController@forgot_password_code"]);
Route::get('/admin/reset_password', function () {
    return view('admin.security.reset_password');
});
Route::post("admin/reset_password_data", ['as' => 'admin_reset_password_data', 'uses' => "admin\SecurityController@forgot_password"]);

Route::group(array('middleware' => 'auth_check'), function(){

    Route::get("admin/dashboard",["as"=>"admin_dashboard","uses"=>"admin\SecurityController@index"]);
    
    Route::get("admin/logout", ['as' => 'logout', 'uses' => 'admin\SecurityController@doLogout']);
    Route::get("admin/changepassword", ['as' => 'logout', 'uses' => 'admin\SecurityController@doLogout']);
   
    Route::any("admin/change/password",["as"=>"admin_change_password","uses"=>"admin\UserController@changeUserPassword"]);
    Route::any("admin/store/changepassword",["as"=>"admin_store_password","uses"=>"admin\UserController@storeChangePassword"]); 

    Route::any("admin/editprofile/{id}",["as"=>"admin_editprofile","uses"=>"admin\UserController@editProfile"]); 
    Route::any("admin/updateprofile/{id}",["as"=>"admin_updateprofile","uses"=>"admin\UserController@updateprofile"]);
    
    /* Department Section Start */
    Route::get("admin/department/list",["as"=>"admin_department_list","uses"=>"admin\DepartmentController@getList"]);
    Route::any('admin/departmentlist', array('uses'=>'admin\DepartmentController@postDepartmentList'));
    Route::get("admin/department/add",["as"=>"admin_department_add","uses"=>"admin\DepartmentController@add"]);
    Route::any("admin/department/store",["as"=>"admin_department_store","uses"=>"admin\DepartmentController@store"]);
    Route::get("admin/department/edit/{id?}",["as"=>"admin_department_edit","uses"=>"admin\DepartmentController@edit"]);
    Route::any("admin/department/update/{id?}",["as"=>"admin_department_update","uses"=>"admin\DepartmentController@update"]);
    Route::post('admin/department/delete', array('uses'=>'admin\DepartmentController@destroy'));
    /* Department Section End */
    
    /*For Users Management*/
    Route::any("admin/user/add",["as"=>"admin_user_add","uses"=>"admin\UserController@add"]);
    Route::any("admin/user/store",["as"=>"admin_user_store","uses"=>"admin\UserController@store"]);
    Route::any("admin/user/list",["as"=>"admin_user_list","uses"=>"admin\UserController@getUsers"]);
    Route::any('admin/userlist', array('uses'=>'admin\UserController@postUser'));
    Route::any("admin/user/edit/{id}",["as"=>"admin_user_edit","uses"=>"admin\UserController@edit"]);
    Route::any("admin/user/update/{id}",["as"=>"admin_user_update","uses"=>"admin\UserController@update"]);
    Route::get('admin/user/delete/{id}', array('uses'=>'admin\UserController@destroy'));
    Route::any("admin/state/getcountrywisestate",["as"=>"getcountrywisestate","uses"=>"admin\UserController@getState"]);

    
    
    /* Cms Model Routing */
    Route::get('admin/cms',['as' => 'admin_cms', 'uses' => 'admin\CMSController@getCMSList']);
    Route::post('admin/cmslist', array('as'=>'admin_cmslist','uses'=>'admin\CMSController@postCMSList'));
    Route::get("admin/cms/create", ['as' => 'admin_cms_add', 'uses' => 'admin\CMSController@create']);
    Route::post("admin/cms/store", ['as' => 'admin_cms_store', 'uses' => 'admin\CMSController@store']);
    Route::get("admin/cms/edit/{id}", ['as' => 'admin_cms_edit', 'uses' => 'admin\CMSController@edit']);
    Route::post("admin/cms/update/{id}", ['as' => 'admin_cms_update', 'uses' => 'admin\CMSController@update']);
    Route::post("admin/cms/delete", ['as' => 'admin_cms_delete', 'uses' => 'admin\CMSController@destroy']);
    Route::get("admin/cms/status/update/{id}/{type}", ['as' => 'admin_cms_statusupdate', 'uses' => 'admin\CMSController@statusupdate']);
    Route::get("admin/cms/view/{slug}", ['as' => 'admin_cms_view', 'uses' => 'admin\CMSController@view']);
    
     /* Navigation Management */
    Route::any('admin/navigation',['as' => 'navigation', 'uses' => 'admin\NavigationController@getNavigation']);
    Route::post("admin/getmenudata", ['as' => 'getmenudata', 'uses' => 'admin\NavigationController@postNavigationMenuData']);
    Route::post("admin/savenavigationmenu", ['as' => 'savenavigationmenu', 'uses' => 'admin\NavigationController@postSaveNavigationMenu']);
    Route::post("admin/addmenu", ['as' => 'addmenu', 'uses' => 'admin\NavigationController@addmenu']);
    Route::post("admin/savecustommenu", ['as' => 'addmenu', 'uses' => 'admin\NavigationController@addCustomMenu']);
    Route::post("admin/removemenu", ['as' => 'remove_menu', 'uses' => 'admin\NavigationController@removeMenuData']);
    
    /* For Setting */
    Route::get("admin/setting/create", ['as' => 'admin_setting_add', 'uses' => 'admin\SettingController@create']);
    Route::post("admin/setting/store", ['as' => 'admin_setting_store', 'uses' => 'admin\SettingController@store']);
	
	/*For Portfolio Management*/
    Route::any("admin/portfolio/add",["as"=>"admin_portfolio_add","uses"=>"admin\PortfolioController@create"]);
    Route::any("admin/portfolio/store",["as"=>"admin_portfolio_store","uses"=>"admin\PortfolioController@store"]);
    Route::any("admin/portfolio/list",["as"=>"admin_portfolio_list","uses"=>"admin\PortfolioController@getPortfolioList"]);
    Route::any('admin/portfoliolist', array('uses'=>'admin\PortfolioController@postPortfolioList'));
    Route::any("admin/portfolio/edit/{id}",["as"=>"admin_portfolio_edit","uses"=>"admin\PortfolioController@edit"]);
    Route::any("admin/portfolio/update/{id}",["as"=>"admin_portfolio_update","uses"=>"admin\PortfolioController@update"]);
    Route::any('admin/portfolio/delete', array('uses'=>'admin\PortfolioController@destroy'));
    
});

    /* Front Start*/
    Route::any("/",["as"=>"front_home","uses"=>"front\HomeController@index"]);
    Route::any("cms/{slugname?}",  ['uses' => 'front\CMSController@index']);
    Route::get("sitemap",  ['as'  => 'sitemap', 'uses' => 'front\CMSController@sitemap']);
    Route::any("/aboutus",["uses"=>"front\HomeController@aboutus"]);
    Route::any("contact-us",['as'=>'contact-us',"uses"=>"front\ContactController@index"]);
    Route::any("contact/store",['as' => 'contact_store',"uses"=>"front\ContactController@store"]);
    Route::any("portfolio",["as"=>"front_portfolio","uses"=>"front\PortfolioController@index"]);
    Route::any("portfolio/{slug}",["uses"=>"front\PortfolioController@getPortfolioDetails"]);
    /* Front End */