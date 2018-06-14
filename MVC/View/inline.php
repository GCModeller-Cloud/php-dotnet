<?php

namespace MVC\Views {

    Imports("Microsoft.VisualBasic.Strings");

    /**
     * 直接支持php内联标签
    */
    class InlineView {

        /**
         * https://stackoverflow.com/questions/1309800/php-eval-that-evaluates-html-php
         * https://stackoverflow.com/questions/4389361/include-code-from-a-php-stream
        */
        public static function RenderInlineTemplate($template) {
            $config = ini_get('allow_url_include');
            $config = "1";

            # allow_url_include = On

            # 在这里需要根据服务器配置参数来决定代码的流程
            # 否则会报错
            if (empty($config) || ($config == "0") || ($config == 0)) {

                /*

                if (APP_DEBUG) {
                    $template = "<!-- Using eval() function as engine -->" . $template;
                }

                # 2018-5-21 使用eval()函数来执行会出现bug

                # include url 被禁用掉了
                # 使用eval函数
                return eval(' ?>' . $template . '<?php ');

                */

                $template = "<!-- PHP inline scripting required option ``allow_url_include = On`` -->" . $template;
                
                return $template;

            } else {

                if (APP_DEBUG) {
                    $template = "<!-- Using output buffer for dynamics includes -->" . $template;
                }

                ob_start();

                // 需要服务器端开启
                // PHP Warning:  include(): data:// wrapper is disabled in the server configuration by allow_url_include=0
                include "data://text/plain;base64," . base64_encode($template);
                return ob_get_clean();
            }
        }
    }
}
?>