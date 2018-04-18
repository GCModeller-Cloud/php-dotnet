<?php

class debugView {
	
	public static function GetView($engine) {
        // 获取所加载的所有脚本列表
        $includes = get_included_files();
	}
    
    /**
     * 将当前的会话之中所使用到的MySQL查询导出来 
     * 
     * @param engine: 
    */
	public static function GetMySQLView($engine) {
		$template = '<li class="dotnet-mysql-debugger">%s</li>';
		$html     = "";
		
		foreach ($engine->mysql_history as $sql) {
            $error  = $sql[1];
            $sql    = $sql[0];

            if (!$error) {
                $li = sprintf($template, $sql) . "\n";
            } else {
                $li = $sql . "\n\n<code><pre>" . $error . "</pre></code>";
                $li = sprintf($template, $li) . "\n";
            }
			
			$html  = $html . $li;
		}
		
		return $html;
	}

	/**
     * 经过格式化的var_dump输出
     */
    public static function VarDump($o) {

        // var_dump函数并不会返回任何数据，而是直接将结果输出到网页上面了，
        // 所以在这里为了能够显示出格式化的var_dump结果，在这里前后都
        // 添加<code>标签。
        echo "<code><pre>";
        $string = var_dump($o);    
        echo "</pre></code>";    
    }

    public static function printCode($code) {
        echo "<code><pre>";
        echo $code;
        echo "</pre></code>";
    }
}
?>