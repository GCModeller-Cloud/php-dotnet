<?php

abstract class controller {

    /**
     * Web app应用的逻辑实现，这个变量应该是一个class object来的
    */
    protected $appObj;
    /**
     * 对Web app应用的逻辑层的反射器
    */
    protected $reflection;    
    protected $app_logic;

    /**
     * 构建一个对web app的访问控制器
     * 
     * @param object $app 应该是一个class
    */
    function __construct($app) {
        $this->appObj = $app;

        if (!is_object($app)) {
            throw new Error("App should be a class object!");
        } else {
            $this->reflection = new ReflectionClass(get_class($app));            
        }
    }
    
    /**
     * 函数返回一个逻辑值，表明当前的访问是否具有权限，如果这个函数返回False，那么
     * web服务器将会响应403，访问被拒绝
     * 
     * @return boolean 当前的访问权限是否验证成功？
    */
    abstract public function accessControl();

    /**
     * 在完成了这个函数的调用之后，服务器将会返回成功代码
     * 并退出当前的脚本执行状态
     * 
     * @param string $message 需要通过json进行传递的消息文本
     * 
     * @return void
    */
    public function success($message) {
        header("HTTP/1.1 200 OK");
        header("Content-Type: application/json");

        echo dotnet::successMsg($message);
        exit();
    }

    /**
     * 在完成了这个函数的调用之后，服务器将会返回错误代码
     * 并退出当前的脚本执行状态
     * 
     * @param string $message 需要通过json进行传递的消息文本
     * @param integer $errCode 错误代码，默认为1
     * 
     * @return void
    */
    public function error($message, $errCode = 1) {
        header("HTTP/1.0 500 Internal Server Error");
        header("Content-Type: application/json");

        echo dotnet::errorMsg($message, $errCode);
        exit($errCode);
    }
}
?>