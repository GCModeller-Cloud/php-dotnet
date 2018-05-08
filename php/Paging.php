<?php

/**
 * 数据库查询数据分页帮助工具
*/
class Page {

    /*
    
        page = {
            page: data [],
            total_page: number,
            current_page: number,
            endOfPage: logical 
        }

    */

    /**
     * 返回分页数据
     * 
     * @param array|number $id 可以是数字id或者一个数组用来指示id列
    */
    public static function RetrivePage($tableName, $id, $limits = 100) {
        $guid  = "";
        $start = -1;
        
        if (is_numeric($id)) {
            $guid  = "id";
            $start = $id;
        } else {
            $guid  = array_keys($id)[0];
            $start = $id[$guid];
        }

        $table   = new Table($tableName);
        $maxid   = $table->ExecuteScalar("max(`$guid`)");
        $current = ($start) / $limits;
        $pages   = ($maxid - $start) / $limits;

        if ($maxid < $start) {
            # 起始的编号已经超过了最大编号，则肯定没有数据了
            return [
                "page"         => [], 
                "total_page"   => $pages, 
                "current_page" => $current, 
                "endOfPage"    => true
            ];
        } else {
            $page = $table->where([
                $guid => gt_eq($start)
            ])->limit($limits) 
              ->order_by([$guid])
              ->select();
            $endOfPage = Enumerable::Last($page)[$guid] == $maxid;
            
            return [
                "page"         => $page, 
                "total_page"   => $pages, 
                "current_page" => $current, 
                "endOfPage"    => $endOfPage
            ];
        }
    }
}
?>