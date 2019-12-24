<?php

#
# Auto generated code by php.NET tools
#
# * Do not edit this file manually as running the tools pipeline update 
#   will overrides your modification.
# * Any modification that you've make will be lost. 
#
# This mysql schema cache file is designed for php.NET framework:
#
# https://github.com/GCModeller-Cloud/php-dotnet.git
#
# time: 2019/10/30 8:55:16
# by:   
#

namespace biodeep_workspace {

    imports("MVC.MySql.schemaDriver");

    /**
     * biodeep_workspace.mysqli.class
     *
     * > + program: ...
     * > + work_files: ...
     * > + task: ...
     * > + kegg_organism: ...
     * > + biosamples: ...
     * > + experiment_types: ...
     * > + project_workflow: ...
    */
    class biodeep_workspace {

        /**
         * Write ``biodeep_workspace.mysqli.class`` mysql schema 
         * cache data to MVC\MySql\SchemaInfo cache.
        */
        public static function LoadCache() {
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`program`", self::schema_describOf_program());
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`work_files`", self::schema_describOf_work_files());
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`task`", self::schema_describOf_task());
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`kegg_organism`", self::schema_describOf_kegg_organism());
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`biosamples`", self::schema_describOf_biosamples());
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`experiment_types`", self::schema_describOf_experiment_types());
            \MVC\MySql\SchemaInfo::WriteCache("`biodeep_workspace`.`project_workflow`", self::schema_describOf_project_workflow());
        }

        /** 
         * Create a new data table model for query data
         * 
         * @param string $tableName The data table name
         * 
         * @return \Table
        */
        public static function GetModel($tableName) {
            return new \Table(["biodeep_workspace" => $tableName]);
        }

        private static function Field($schema) {
            return [
                "Field"   => $schema[0], 
                "Key"     => $schema[1], 
                "Null"    => $schema[2], 
                "Type"    => $schema[3], 
                "Extra"   => $schema[4], 
                "Default" => $schema[5]
            ];
        }

        #region "biodeep_workspace.mysqli.class"
        
    /**
     * MySql table: ``biodeep_workspace.program``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_program() {
        return [
            "id"       => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "app_name" => self::Field(["app_name", "", "NO", "VarChar (64)", "", ""]), 
            "version"  => self::Field(["version", "", "NO", "VarChar (32)", "", ""])
        ];
    }

    /**
     * MySql table: ``biodeep_workspace.work_files``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_work_files() {
        return [
            "id"        => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "ref"       => self::Field(["ref", "", "NO", "Int64 (11)", "", ""]), 
            "program"   => self::Field(["program", "", "NO", "Int64 (11)", "", ""]), 
            "file_name" => self::Field(["file_name", "", "NO", "VarChar (256)", "", ""]), 
            "file_size" => self::Field(["file_size", "", "NO", "VarChar (128)", "", ""]), 
            "flag"      => self::Field(["flag", "", "NO", "Int64 (11)", "", ""]), 
            "user_id"   => self::Field(["user_id", "", "NO", "Int64 (11)", "", ""])
        ];
    }

    /**
     * MySql table: ``biodeep_workspace.task``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_task() {
        return [
            "id"      => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "ref"     => self::Field(["ref", "", "NO", "Int64 (11)", "", ""]), 
            "program" => self::Field(["program", "", "NO", "Int64 (11)", "", ""]), 
            "title"   => self::Field(["title", "", "NO", "VarChar (256)", "", ""]), 
            "status"  => self::Field(["status", "", "NO", "Int64 (11)", "", ""]), 
            "flag"    => self::Field(["flag", "", "NO", "Int64 (11)", "", ""]), 
            "user_id" => self::Field(["user_id", "", "NO", "Int64 (11)", "", ""])
        ];
    }

    /**
     * MySql table: ``biodeep_workspace.kegg_organism``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_kegg_organism() {
        return [
            "id"   => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "name" => self::Field(["name", "", "NO", "VarChar (512)", "", ""]), 
            "code" => self::Field(["code", "", "NO", "VarChar (8)", "", ""])
        ];
    }

    /**
     * MySql table: ``biodeep_workspace.biosamples``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_biosamples() {
        return [
            "id"   => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "name" => self::Field(["name", "", "NO", "VarChar (128)", "", ""])
        ];
    }

    /**
     * MySql table: ``biodeep_workspace.experiment_types``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_experiment_types() {
        return [
            "id"       => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "name"     => self::Field(["name", "", "NO", "VarChar (64)", "", ""]), 
            "category" => self::Field(["category", "", "NO", "Int64 (11)", "", ""])
        ];
    }

    /**
     * MySql table: ``biodeep_workspace.project_workflow``
     *
     * 
     *
     * @return array MySql schema table array.
    */
    private static function schema_describOf_project_workflow() {
        return [
            "id"              => self::Field(["id", "", "NO", "Int64 (11)", "auto_increment", ""]), 
            "title"           => self::Field(["title", "", "NO", "VarChar (128)", "", ""]), 
            "create_time"     => self::Field(["create_time", "", "NO", "DateTime", "", ""]), 
            "finish_time"     => self::Field(["finish_time", "", "YES", "DateTime", "", ""]), 
            "status"          => self::Field(["status", "", "NO", "Int64 (11)", "", ""]), 
            "user_id"         => self::Field(["user_id", "", "NO", "Int64 (11)", "", ""]), 
            "metadeco_task"   => self::Field(["metadeco_task", "", "NO", "Int64 (11)", "", ""]), 
            "metanno_task"    => self::Field(["metanno_task", "", "NO", "Int64 (11)", "", ""]), 
            "discovery_task"  => self::Field(["discovery_task", "", "NO", "Int64 (11)", "", ""]), 
            "flag"            => self::Field(["flag", "", "NO", "Int64 (11)", "", ""]), 
            "organism"        => self::Field(["organism", "", "NO", "Int64 (11)", "", ""]), 
            "sample_type"     => self::Field(["sample_type", "", "NO", "Int64 (11)", "", ""]), 
            "experiment_type" => self::Field(["experiment_type", "", "NO", "Int64 (11)", "", ""])
        ];
    }
        #endregion
    }
    
    biodeep_workspace::LoadCache();

    // table php classes code:

    
    /**
     * 
    */
    class program {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::VarChar (64)>  
      * 
      * @var string
     */
    public $app_name;
    /**
      * <MySQLDbTypes::VarChar (32)>  
      * 
      * @var string
     */
    public $version;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`program`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("program");
            }

            return self::$mysql_model;
        }

        /**
         * @return program
        */
        private static function provider() {
            return new program();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`program`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return program[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`program` record row with given condition. 
         *
         * @return program
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new program());

            return $obj;
        }
    }


    /**
     * 
    */
    class work_files {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::Int64 (11)> 这个文件在实际的应用程序平台中的编号 
      * 
      * @var integer
     */
    public $ref;
    /**
      * <MySQLDbTypes::Int64 (11)> 程序平台的枚举编号 
      * 
      * @var integer
     */
    public $program;
    /**
      * <MySQLDbTypes::VarChar (256)>  
      * 
      * @var string
     */
    public $file_name;
    /**
      * <MySQLDbTypes::VarChar (128)>  
      * 
      * @var string
     */
    public $file_size;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $flag;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $user_id;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`work_files`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("work_files");
            }

            return self::$mysql_model;
        }

        /**
         * @return work_files
        */
        private static function provider() {
            return new work_files();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`work_files`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return work_files[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`work_files` record row with given condition. 
         *
         * @return work_files
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new work_files());

            return $obj;
        }
    }


    /**
     * 
    */
    class task {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $ref;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $program;
    /**
      * <MySQLDbTypes::VarChar (256)>  
      * 
      * @var string
     */
    public $title;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $status;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $flag;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $user_id;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`task`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("task");
            }

            return self::$mysql_model;
        }

        /**
         * @return task
        */
        private static function provider() {
            return new task();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`task`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return task[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`task` record row with given condition. 
         *
         * @return task
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new task());

            return $obj;
        }
    }


    /**
     * 
    */
    class kegg_organism {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::VarChar (512)>  
      * 
      * @var string
     */
    public $name;
    /**
      * <MySQLDbTypes::VarChar (8)>  
      * 
      * @var string
     */
    public $code;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`kegg_organism`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("kegg_organism");
            }

            return self::$mysql_model;
        }

        /**
         * @return kegg_organism
        */
        private static function provider() {
            return new kegg_organism();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`kegg_organism`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return kegg_organism[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`kegg_organism` record row with given condition. 
         *
         * @return kegg_organism
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new kegg_organism());

            return $obj;
        }
    }


    /**
     * 
    */
    class biosamples {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::VarChar (128)>  
      * 
      * @var string
     */
    public $name;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`biosamples`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("biosamples");
            }

            return self::$mysql_model;
        }

        /**
         * @return biosamples
        */
        private static function provider() {
            return new biosamples();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`biosamples`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return biosamples[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`biosamples` record row with given condition. 
         *
         * @return biosamples
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new biosamples());

            return $obj;
        }
    }


    /**
     * 
    */
    class experiment_types {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::VarChar (64)>  
      * 
      * @var string
     */
    public $name;
    /**
      * <MySQLDbTypes::Int64 (11)> 实验类型枚举值
    * 
    * 0 代谢组
    * 1 脂质组
    * 2 蛋白组
    * 3 转录组
    * 4 微生物组
    * 5 离子组 
      * 
      * @var integer
     */
    public $category;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`experiment_types`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("experiment_types");
            }

            return self::$mysql_model;
        }

        /**
         * @return experiment_types
        */
        private static function provider() {
            return new experiment_types();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`experiment_types`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return experiment_types[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`experiment_types` record row with given condition. 
         *
         * @return experiment_types
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new experiment_types());

            return $obj;
        }
    }


    /**
     * 
    */
    class project_workflow {
    
            /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $id;
    /**
      * <MySQLDbTypes::VarChar (128)>  
      * 
      * @var string
     */
    public $title;
    /**
      * <MySQLDbTypes::DateTime>  
      * 
      * @var string
     */
    public $create_time;
    /**
      * <MySQLDbTypes::DateTime>  
      * 
      * @var string
     */
    public $finish_time;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $status;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $user_id;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $metadeco_task;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $metanno_task;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $discovery_task;
    /**
      * <MySQLDbTypes::Int64 (11)>  
      * 
      * @var integer
     */
    public $flag;
    /**
      * <MySQLDbTypes::Int64 (11)> 物种名称的枚举 
      * 
      * @var integer
     */
    public $organism;
    /**
      * <MySQLDbTypes::Int64 (11)> 样本类型的枚举 
      * 
      * @var integer
     */
    public $sample_type;
    /**
      * <MySQLDbTypes::Int64 (11)> 对实验类型的枚举 
      * 
      * @var integer
     */
    public $experiment_type;

        /**
         * 数据表模型对象缓存
         *
         * @var \Table
        */
        private static $mysql_model;

        /**
         * 获取得到`biodeep_workspace`.`project_workflow`数据表的数据库操作模型
         *
         * @return \Table 一个数据表模型对象
        */
        public static function Model() {
            if (empty(self::$mysql_model)) {
                self::$mysql_model = biodeep_workspace::GetModel("project_workflow");
            }

            return self::$mysql_model;
        }

        /**
         * @return project_workflow
        */
        private static function provider() {
            return new project_workflow();
        }

        /**
         * add a new row data into table `biodeep_workspace`.`project_workflow`
        */
        public static function add($data) {            
            return self::Model()->add($data);
        }

        /**
         * @return project_workflow[]
        */
        public static function select($where, $limit = NULL, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($limit)) {
                $model = $model->limit($limit);
            }

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data   = $model->select();
            $models = \MVC\MySql\Projector::Fills($data, self::provider);

            $models;
        }

        /**
         * Find a single `biodeep_workspace`.`project_workflow` record row with given condition. 
         *
         * @return project_workflow
        */
        public static function find($where, $orderBy = NULL, $desc = false) {
            $model = self::Model()->where($where);

            if (!empty($orderBy)) {
                $model = $model->order_by($orderBy, $desc);
            }

            $data = $model->find();
            $obj  = \MVC\MySql\Projector::FillModel($data, new project_workflow());

            return $obj;
        }
    }

}
