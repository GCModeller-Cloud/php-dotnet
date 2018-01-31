<?php

/*
 * 数据表模型，这个模块主要是根据schema字典构建出相应的SQL表达式
 * 然后通过driver模型进行执行
 */
class Table {

    private $tableName;
    private $driver;
    private $schema;
    private $condition;
	private $AI;
	
    function __construct($tableName, $condition = null) {
        $this->tableName = $tableName;
        $this->driver    = dotnet::$config;
        $this->driver    = new Model(
            $this->driver["DB_NAME"], 
            $this->driver["DB_USER"],
            $this->driver["DB_PWD"],
            $this->driver["DB_HOST"],
            $this->driver["DB_PORT"]
        );

        # 获取数据库的目标数据表的表结构
        $this->schema    = $this->driver->Describe($tableName);
        $this->schema    = Model::schemaArray($this->schema);
        $this->condition = $condition;
		$this->AI        = Model::getAIKey($this);
    }

	public function getSchema() {
		return $this->schema;
	}
	
    public function exec($SQL) {
        return $this->driver->exec($SQL);
    }

    // select all
    public function select() {
        $table  = $this->tableName;
        $assert = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();       

        if ($assert) {
            $SQL = "SELECT * FROM `$table` WHERE $assert;";
        } else {
            $SQL = "SELECT * FROM `$table`;";
        }
        
        return $this->driver->ExecuteSQL($mysqli_exec, $SQL);
    }

    private function getWhere() {	

		# 如果条件是空的话，就不再继续构建表达式了
		# 这个SQL表达式可能是没有选择条件的
		# 否则在下面会抛出错误的
        if (!$this->condition || count($this->condition) == 0) {
            return null;
        } else {
			// echo "create expression for ";
			// print_r($this->condition);
		}
		
        $assert = array();
        $schema = $this->schema;		
		
        foreach ($this->condition as $field => $value) {			
			
            if (array_key_exists($field, $schema)) {
                array_push($assert, "`$field` = '$value'");
            }
        }

        if (count($assert) == 0) {
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

        $assert = join(" AND ", $assert);

        return $assert;
    }

    // select but limit 1
    public function find() {
        $table  = $this->tableName;
        $assert = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();       

        if ($assert) {
            $SQL = "SELECT * FROM `$table` WHERE $assert LIMIT 1;";
        } else {
            $SQL = "SELECT * FROM `$table` LIMIT 1;";
        }
        
        return $this->driver->ExecuteScalar($mysqli_exec, $SQL);
    }

    /*
     * @param $assert: The assert array of the where condition.
     * 
     */
    public function where($assert) {
        $next = new Table($this->tableName, $assert);
        return $next;
    }

    // insert into
    public function add($data) {

		$mysqli_exec = $this->driver->__init_MySql(); 
		$table       = $this->tableName;
		$fields      = array();
		$values      = array();
		$uid         = null;
					
		# 检查自增字段
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
		}
		
		foreach ($this->schema as $fieldName => $def) {
			if (array_key_exists($fieldName, $data)) {
				
				$value = $data[$fieldName];
				
				array_push($fields, "`$fieldName`");
				array_push($values, "'$value'");
				
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
		$SQL = "INSERT INTO `{$table}` ($fields) VALUES ($values);";	
				
        if (!mysqli_query($mysqli_exec, $SQL)) {

            // 可能有错误，给出错误信息
            return false;
			
        } else {
			
            if (!$uid) {
				# 这个表之中没有自增字段，则返回true
				return true;
			} else {
				# 在这个表之中存在自增字段，则返回这个uid
				# 方便进行后续的操作
				return $uid;
			}           
        }	
    }

    // update table
    public function save($data) {
		$table       = $this->tableName;
        $assert      = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();
		$SQL         = "";
		$updates     = array();
		
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
		$SQL = "UPDATE `$table` SET $updates";
		
		if (!$assert) {
			
			# 更新所有的数据？？？要不要给出警告信息
			$SQL = $SQL . ";";
			
		} else {
			$SQL = $SQL . " WHERE " . $assert . " LIMIT 1;";
		}
		
		// print_r($SQL);
		
		if (!mysqli_query($mysqli_exec, $SQL)) {
			return false;
		} else {
			return true;
		}
    }

    // delete from
    public function delete($data) {
		$table       = $this->tableName;
        $assert      = $this->getWhere();
        $mysqli_exec = $this->driver->__init_MySql();
		
		# DELETE FROM `metacardio`.`experimental_batches` WHERE `id`='4';
		if (!$assert) {
			dotnet::ThrowException("WHERE condition can not be null!");
		} else {
			$SQL     = "DELETE FROM `$table` WHERE $assert;";
		}
		
		if (!mysqli_query($mysqli_exec, $SQL)) {
			return false;
		} else {
			return true;
		}
    }
}
?>