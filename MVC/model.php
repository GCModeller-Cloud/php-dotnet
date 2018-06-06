<?php

Imports("Microsoft.VisualBasic.Strings");

use MVC\MySql\Expression\WhereAssert as MySqlScript;

/**
 * 数据表模型，这个模块主要是根据schema字典构建出相应的SQL表达式
 * 然后通过driver模型进行执行
*/
class Table {

	private $tableName;
	private $databaseName;
	private $driver;
	/**
	 * 数据表的表结构
	*/ 
    private $schema;
    private $condition;
	private $condition_type;
	private $AI;
	
	/**
	 * Create an abstract table model.
	 * 
	 * @param type      where/in/expression
	 * @param condition default is nothing, means all, no filter
	*/
    function __construct($config, $condition = null, $type = "where") {
		if (is_string($config)) {		
			$this->__initBaseOnTableName($config);
		} else {			
			$this->__initBaseOnExternalConfig($config["DB_TABLE"], $config);
		}  
		
		$this->condition      = $condition;
		$this->condition_type = $type;
	}
	
	/**
	 * 不通过内部的配置数据而是通过外部传递过来的新的配置数组
	 * 来进行初始化
	*/
	private function __initBaseOnExternalConfig($tableName, $config) {
		$this->tableName    = $tableName;
		$this->driver       = $config;
		$this->databaseName = $this->driver["DB_NAME"];
        $this->driver       = new Model(
            $this->driver["DB_NAME"], 
            $this->driver["DB_USER"],
            $this->driver["DB_PWD"],
            $this->driver["DB_HOST"],
            $this->driver["DB_PORT"]
        );

		# 获取数据库的目标数据表的表结构
		$schema = Model::GetSchema(
			$this->tableName, 
			$this->driver
		);
		
        $this->schema = $schema["schema"];
		$this->AI     = $schema["AI"];
	}

	/**
	 * 通过表名称来初始化
	*/
	private function __initBaseOnTableName($tableName) {
		$this->__initBaseOnExternalConfig($tableName, DotNetRegistry::$config);
	}

	public function getSchema() {
		return $this->schema;
	}
	
    public function exec($SQL) {
        return $this->driver->exec($SQL);
    }

	public function limit($m, $n = -1) {

	}

	public function order_by($keys, $desc = false) {

	}

	/**
	 * select all
	*/
    public function select($offset = -1, $n = -1) {
		$table  = $this->tableName;
		$db     = $this->databaseName;
        $assert = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();       

        if ($assert) {
            $SQL = "SELECT * FROM `$db`.`$table` WHERE $assert";
        } else {
            $SQL = "SELECT * FROM `$db`.`$table`";
        }
		
		if ($offset >= 0) {
			if ($n > 0) {
				$SQL .= " LIMIT $offset,$n;";
			} else {
				$SQL .= " LIMIT $offset;";
			}
		} else {
			$SQL .= ";";
		}

		# print_r($SQL);
		
        return $this->driver->ExecuteSQL($mysqli_exec, $SQL);
    }
	
	/**
	 * Create a new mysqli link
	*/
	public function mysqli() {
		return $this->driver->__init_MySql();
	}
	
	/**
	 * select count(*) from where ``...``;
	*/
	public function count() {
		$table  = $this->tableName;
		$db     = $this->databaseName;
        $assert = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();       
		$count       = "COUNT(*)";

        if ($assert) {
            $SQL = "SELECT $count FROM `$db`.`$table` WHERE $assert;";
        } else {
            $SQL = "SELECT $count FROM `$db`.`$table`;";
        }
    		
		$count = $this->driver->ExecuteScalar($mysqli_exec, $SQL);
		$count = $count["COUNT(*)"];

		return $count;
	}

    private function getWhere() {	

		# 如果条件是空的话，就不再继续构建表达式了
		# 这个SQL表达式可能是没有选择条件的
		# 否则在下面会抛出错误的
        if (!$this->condition || count($this->condition) == 0) {
            return null;
        } else {
			switch ($this->condition_type) {
				
				case "where":
					return $this->whereGeneral();
					break;
				case "in":
					return $this->whereIN();
					break;
				case "expression":
					return $this->condition;
					break;

				default:
					dotnet::ThrowException("Invalid type value: " . $this->condition_type);
			}
		}
    }

	private function whereIN() {
		$assert = array();
		$schema = $this->schema;
		
		foreach ($this->condition as $field => $value) {
			
			if (array_key_exists($field, $schema)) {
				$value = join("', '", $value);				
				array_push($assert, "`$field` IN ('$value')");
			}
		}
		
		if (count($assert) == 0) {
            $this->throwEmpty();
        } else {
			$assert = join(" AND ", $assert);
			return $assert;
		}    
	}
	
	private function throwEmpty() {
		$debug = "";
		$debug = $debug . "Where condition requested! But no assert expression can be build: \n";
		$debug = $debug . "Here is the condition that you give me:\n";
		$debug = $debug . "<pre><code>";
		$debug = $debug . json_encode($this->condition);
		$debug = $debug . "</code></pre>";
		$debug = $debug . "This is the table structure of target mysql table:\n";
		$debug = $debug . "<pre><code>";
		$debug = $debug . json_encode($this->schema);
		$debug = $debug . "</code></pre>";
		
		dotnet::ThrowException($debug);   
	}
	
	private function whereGeneral() {
		/*
		$assert = array();
        $schema = $this->schema;		
		
        foreach ($this->condition as $field => $value) {			
			
            if (array_key_exists($field, $schema)) {
                array_push($assert, "`$field` = '$value'");
            }
        }

        if (count($assert) == 0) {
            $this->throwEmpty();
        } else {
			$assert = join(" AND ", $assert);
			return $assert;
		}        
		*/
		return MySqlScript::AsExpression($this->condition);
	}	

	/**
	 * select but limit 1
	*/
    public function find() {
		$table       = $this->tableName;
		$db          = $this->databaseName;
        $assert      = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();       

        if ($assert) {
            $SQL = "SELECT * FROM `$db`.`$table` WHERE $assert LIMIT 1;";
        } else {
            $SQL = "SELECT * FROM `$db`.`$table` LIMIT 1;";
        }	
		
		# echo $SQL;

        return $this->driver->ExecuteScalar($mysqli_exec, $SQL);
    }

	/**
	 * Select and limit 1 and return the field value, if target 
	 * record is not found, then returns false.
	 * 
	 * @param name The table field name. Case sensitive! 
	 * 
	 * @return mix The reuqired field value. 
	*/
	public function findfield($name) {
		$single = $this->find();

		if ($single) {
			return $single[$name];
		} else {
			return false;
		}		 
	}

	public function ExecuteScalar($aggregate) {
		$table  = $this->tableName;
		$db     = $this->databaseName;
        $assert = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();       

        if ($assert) {
            $SQL = "SELECT $aggregate FROM `$db`.`$table` WHERE $assert LIMIT 1;";
        } else {
            $SQL = "SELECT $aggregate FROM `$db`.`$table` LIMIT 1;";
        }
        
		$single = $this->driver->ExecuteScalar($mysqli_exec, $SQL);
		
		if ($single) {
			return $single[$aggregate];
		} else {
			return false;
		}
	}

	/**
	 * select * from `table`;
	*/
	public function all() {
		$table       = $this->tableName;
		$db          = $this->databaseName;
		$SQL         = "SELECT * FROM `$db`.`$table`;";
		$mysqli_exec = $this->driver->__init_MySql();    

		return $this->driver->ExecuteSQL($mysqli_exec, $SQL);
	}

    /**
     * Create a where condition filter for the next SQL expression.
     *	  
     * @param assert The assert array of the where condition or an string expression.
    */
    public function where($assert) {
		$next = null;

		if (gettype($assert) === 'string') {
			$next = new Table($this->tableName, $assert, "expression");
		} else {
			$next = new Table($this->tableName, $assert, "where");
		}
        
        return $next;
    }

	public function in($assert) {
		$next = new Table($this->tableName, $assert, "in");
		return $next;
	}
	
	/**
	 * insert into.
	 *
	 * @param data table row data in array type
	*/ 
    public function add($data) {

		$table       = $this->tableName;
		$db          = $this->databaseName;
		$fields      = array();
		$values      = array();		
					
		# 检查自增字段
		/*
		if ($this->AI) {
			$key = $this->AI;		
						
			if (!$data[$key]) {
				# 自增字段还没有值，则将表中目前最大的值+1
				$SQL = "SELECT max(`$key`) as `uid` FROM `$table`;";
				$uid  = $this->driver->ExecuteScalar($mysqli_exec, $SQL);							
				
				if (!$uid) {
					$uid = 1;
				} else {
					$uid = $uid["uid"] + 1;
				}
								
				$data[$key] = $uid;
			} else {
				$uid = $data[$key];
			}
			
			# print("$key => $uid");
		}*/
		
		foreach ($this->schema as $fieldName => $def) {
			if (array_key_exists($fieldName, $data)) {
				
				$value = $data[$fieldName];
				# 使用转义函数进行特殊字符串的转义操作
				# $value = mysqli_real_escape_string($mysqli_exec, $value);

				array_push($fields, "`$fieldName`");
				array_push($values, "'$value'");
				
			} else if ($this->AI && Strings::LCase($fieldName) == Strings::LCase($this->AI) ) {
				# Do Nothing
			} else {

                # 检查一下这个字段是否是需要值的？如果需要，就将默认值填上
                if ($def["Null"] == "NO") {
					
                    # 这个字段是需要有值的，则尝试获取默认值
                    $default = $def["Default"];

                    if ($default) {

                        array_push($fields, "`$fieldName`");
                        array_push($values, "'$default'");

                    } else {
						
                        # 这个字段需要有值，但是用户没有提供值，而且也不存在默认值
                        # 则肯定无法将这条记录插入数据库
                        # 需要抛出错误？？

                    }
                }
            }
		}
		
		$fields = join(", ", $fields);
		$values = join(", ", $values);
		
		# INSERT INTO `metacardio`.`xcms_files` (`task_id`) VALUES ('ABC');
		$SQL         = "INSERT INTO `$db`.`{$table}` ($fields) VALUES ($values);";	
		$mysqli_exec = $this->driver->__init_MySql(); 

        if (!$this->driver->exec($SQL, $mysqli_exec)) {
			
            // 可能有错误，给出错误信息
            return false;
			
        } else {
			
            if (!$this->AI) {
				# 这个表之中没有自增字段，则返回true
				return true;
			} else {
				# 在这个表之中存在自增字段，则返回这个uid
				# 方便进行后续的操作
				return mysqli_insert_id($mysqli_exec);
			}           
        }	
    }

    // update table
    public function save($data) {
		$table   = $this->tableName;
		$db      = $this->databaseName;
        $assert  = $this->getWhere();        
		$SQL     = "";
		$updates = array();
		
		# UPDATE `metacardio`.`experimental_batches` SET `workspace`='2018/01/31/02-36-49/2', `note`='22222', `status`='10' WHERE `id`='3';
		
		foreach ($this->schema as $fieldName => $def) {
			# 只更新存在的数据，所以在这里只需要这一个if分支即可
			if (array_key_exists($fieldName, $data)) {
				$value = $data[$fieldName];
				$set   = "`$fieldName` = '$value'";
				
				array_push($updates, $set);
			}
		}
		
		$updates = join(", ", $updates);
		$SQL = "UPDATE `$db`.`$table` SET $updates";
		
		if (!$assert) {
			
			# 更新所有的数据？？？要不要给出警告信息
			$SQL = $SQL . ";";
			
		} else {
			$SQL = $SQL . " WHERE " . $assert . " LIMIT 1;";
		}
						
		if (!$this->driver->exec($SQL)) {
			return false;
		} else {
			return true;
		}
    }

    // delete from
    public function delete() {
		$table  = $this->tableName;
		$db     = $this->databaseName;
        $assert = $this->getWhere();        
		
		# DELETE FROM `metacardio`.`experimental_batches` WHERE `id`='4';
		if (!$assert) {
			dotnet::ThrowException("WHERE condition can not be null in DELETE SQL!");
		} else {
			$SQL     = "DELETE FROM `$db`.`$table` WHERE $assert;";
		}
				
		if (!$this->driver->exec($SQL)) {
			return false;
		} else {
			return true;
		}
	}
}
?>