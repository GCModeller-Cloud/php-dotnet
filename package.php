<?php

/**
 * dotnet package manager, you must include this module at first.
 * 
 * 在php之中有一个DOTNET类型：http://php.net/manual/en/class.dotnet.php
 * 但是这个模块的使用有诸多的限制，假若使用本项目的时候，发现出现错误:
 * 
 * Fatal error: Cannot redeclare class dotnet in "mod\php.NET\package.php" on line 6
 * 
 * 则应该要检查一下你的php服务器的设置是否是区分大小写的？
 * 因为这个类名称dotnet假若不区分大小写的话，是和系统自带的DOTNET类型同名的
 */
class dotnet {

    /**
     * This method have not implemented yet!
     * 
     * Usage:
     *      die(dotnet::$MethodNotImplemented);
     */
    public static $MethodNotImplemented = "This method have not implemented yet!";

    /**
     * 对于这个函数额调用者而言，就是获取调用者所在的脚本的文件夹位置
     * 这个函数是使用require_once来进行模块调用的
     *
     * @mod: 相对应调用者所处的脚本的位置而言的相对文件路径
     */
    public static function Imports($mod) {
    
        $stack = debug_backtrace();
        // -1: 调用者的文件位置
        // -2: package.php的文件位置
        $firstFrame = $stack[count($stack) - 2];
        $initialFile = $firstFrame['file'];
        $DIR = dotnet::ParentDirectory($initialFile);
        // $DIR = dotnet::ParentDirectory($DIR);

        // echo basename($mod)."<br/>";
        // echo $initialFile."<br/>";
        // $mod = basename($mod);
        $mod = "{$DIR}/{$mod}";
        // echo $mod."<br/>";//

        // 在这里导入需要导入的模块文件
        include_once($mod);
        // 返回所导入的文件的全路径名
        return $mod;
    }

    /**
     * 获取得到某一个文件的其所处的父文件夹的全路径
     */
    public static function ParentDirectory($file) {

        dotnet::SuppressWarningMessage();   

        $file = str_replace("\\", "/", $file);
        $file = split("/", $file);
        // 去除最后一个元素，最后一个元素为文件名，这样子剩下的都是文件夹的单词了 
        array_pop($file);
        $file = join("/", $file);

        dotnet::ShowAllMessage();

        return $file;
    }

    public static function ThrowException($message) {

    }

    /**
     * 调用这个函数之后，将会阻止继续输出警告信息，假若在调用了这个函数之后，
     * 需要重新显示错误消息，则可以调用 dotnet::ShowAllMessage 函数
     */
    public static function SuppressWarningMessage() {

        // 阻止php输出警告信息
        // http://php.net/manual/en/function.error-reporting.php
        error_reporting(E_WARNING);
    }

    /**
     * 使用这个函数将会显示出所有的错误消息
     */ 
    public static function ShowAllMessage() {

        // Report all PHP errors (see changelog)
        error_reporting(E_ALL);
    }
}

?>