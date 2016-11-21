<?php

namespace App\Services;

use Route;

/**
 * 系统路由
 * 
 * 注：大部分的路由及控制器所执行的动作来说，
 * 
 * 你需要返回完整的 Illuminate\Http\Response 实例或是一个视图
 *
 * @author jiang <mylampblog@163.com>
 */
class Routes
{
    private $adminDomain;

    private $wwwDomain;

    private $noPreDomain;

    private $is_mobile;

    /**
     * 初始化，取得配置
     *
     * @access public
     */
    public function __construct()
    {
        $this->adminDomain = config('sys.sys_admin_domain');
        $this->wwwDomain = config('sys.sys_blog_domain');
        $this->noPreDomain = config('sys.sys_blog_nopre_domain');
        $this->is_mobile = $this->is_mobile();
    }

    /**
     * 后台的通用路由
     * 
     * 覆盖通用的路由一定要带上别名，且別名的值为module.class.action
     * 
     * 即我们使用别名传入了当前请求所属的module,controller和action
     *
     * <code>
     *     Route::get('index-index.html', ['as' => 'module.class.action', 'uses' => 'Admin\IndexController@index']);
     * </code>
     *
     * @access public
     */
    public function admin()
    {
        Route::group(['domain' => $this->adminDomain], function()
        {
            Route::group(['middleware' => ['csrf']], function()
            {
                Route::get('/', 'Admin\Foundation\LoginController@index');
                Route::controller('login', 'Admin\Foundation\LoginController', ['getOut' => 'foundation.login.out']);
            });

            Route::group(['middleware' => ['auth', 'acl', 'alog']], function()
            {
                Route::any('{module}-{class}-{action}.html', ['as' => 'common', function($module, $class, $action)
                {
                    $class = 'App\\Http\\Controllers\\Admin\\'.ucfirst(strtolower($module)).'\\'.ucfirst(strtolower($class)).'Controller';
                    if(class_exists($class))
                    {
                        $classObject = new $class();
                        if(method_exists($classObject, $action)) return call_user_func(array($classObject, $action));
                    }
                    return abort(404);
                }])->where(['module' => '[0-9a-z]+', 'class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);
            });
        });
        return $this;
    }

    /**
     * 博客通用路由
     * 
     * 这里必须要返回一个Illuminate\Http\Response 实例而非一个视图
     * 
     * 原因是因为csrf中需要响应的必须为一个response
     *
     * @access public
     */
    public function www()
    {
        if($this->is_mobile){
            //return $this->mobile();
        }
        $app_name = 'Home';
        //var_dump($app_name);exit;
        $homeDoaminArray = ['home' => $this->wwwDomain, 'home_empty_prefix' => $this->noPreDomain];
        foreach($homeDoaminArray as $key => $value)
        {
            Route::group(['domain' => $value, 'middleware' => ['csrf']], function() use ($key,$app_name)
            {
                if(isset($_GET['search']) && $_GET['search']){
                    Route::get('/', $app_name.'\SearchController@index');
                }else{
                    Route::get('/', $app_name.'\IndexController@index');
                }

                Route::any('{url}.html', ['as' => $key, function($url)use($app_name)
                {
                    if($url=='404'){
                        return abort(404);
                    }
                    if(is_numeric($url)){
                        $class = 'index';
                        $action = 'detail';
                    }else{
                        $url_arr = explode('/',$url);
                        $class = $url_arr[0];
                        $action = isset($url_arr[1]) ? $url_arr[1] : 'index';
                        if($url_arr[0] == 'new'){
                            $class = 'index';
                            $action = 'gather';
                        }
                    }

                    $class = 'App\\Http\\Controllers\\'.$app_name.'\\'.ucfirst(strtolower($class)).'Controller';
                    if(class_exists($class))
                    {
                        $classObject = new $class();
                        if(method_exists($classObject, $action))
                        {
                            $return = call_user_func(array($classObject, $action),$url);
                            if( ! $return instanceof \Illuminate\Http\Response)
                            {
                                $cacheSecond = config('home.cache_control');
                                $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
                                return response($return)->header('Cache-Control', 'max-age='.$cacheSecond)->header('Expires', $time);
                            }
                            return $return;
                        }
                    }
                    return abort(404);
                }])->where(['url' => '[0-9a-z\/_]+']);
            });

            //兼容以前的 "/tag/关键词" url规则
            Route::any('/tag/{keyword}', ['as' => $key, function($keyword) {
                $classObject = new \App\Http\Controllers\Home\SearchController();
                $action = 'index';
                $return = call_user_func(array($classObject, $action),$keyword);
                if( ! $return instanceof \Illuminate\Http\Response)
                {
                    $cacheSecond = config('home.cache_control');
                    $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
                    return response($return)->header('Cache-Control', 'max-age='.$cacheSecond)->header('Expires', $time);
                }
                return $return;
            }]);
        }
        return $this;
    }

    private function mobile(){
        $app_name = 'Mobile';
        $mobileDoaminArray = ['mobile' => $this->wwwDomain, 'mobile_empty_prefix' => $this->noPreDomain];
        foreach($mobileDoaminArray as $key => $value)
        {
            Route::group(['domain' => $value, 'middleware' => ['csrf']], function() use ($key,$app_name)
            {
                Route::any('/', $app_name.'\IndexController@index');
                Route::any('{url}.html', ['as' => $key, function($url)use($app_name)
                {
                    if($url=='404'){
                        return abort(404);
                    }
                    if(is_numeric($url)){
                        $class = 'index';
                        $action = 'detail';
                    }else{
                        $url_arr = explode('/',$url);
                        $class = $url_arr[0];
                        $action = isset($url_arr[1]) ? $url_arr[1] : 'index';
                    }

                    $class = 'App\\Http\\Controllers\\'.$app_name.'\\'.ucfirst(strtolower($class)).'Controller';
                    $class = class_exists($class) ? $class : 'App\\Http\\Controllers\\'.$app_name.'\\IndexController';
                    $classObject = new $class();
                    $action = method_exists($classObject, $action) ? $action : 'index';
                    $return = call_user_func(array($classObject, $action),$url);
                    if( ! $return instanceof \Illuminate\Http\Response)
                    {
                        $cacheSecond = config('home.cache_control');
                        $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
                        return response($return)->header('Cache-Control', 'max-age='.$cacheSecond)->header('Expires', $time);
                    }
                    return $return;
                }])->where(['url' => '[0-9a-z\/_]+']);
            });
        }
        return $this;
    }

    //判断是否是手机
    private function is_mobile()
    {
        if(stripos($_SERVER['HTTP_USER_AGENT'],"android")!=false||stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")!=false||stripos($_SERVER['HTTP_USER_AGENT'],"wp")!=false)
        {
            return true;
        }
        return false;
    }

}
