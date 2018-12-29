<?php

include __DIR__ . "/../../package.php";

Imports("php.htaccess");
Imports("php.URL");
Imports("MVC.router");

$url = "/dict.php?app=search&q=browse&FORM=BDVSP6&mkt=zh-cn";

console::dump(URL::mb_parse_url($url, true));

$rule = new \PHP\RewriteRule("^dict/(\S+)?q=(.+)&FORM=(.+)", "/dict.php?app=$1&q=$2&FORM=$3");

console::dump($rule);

echo "\n\n\n\n\n\n\n\n\n\n\n";

console::log("====================================================================");


console::dump($url, "The input url is:");
console::dump($rule->RouterRewrite($url), "The output url is:");