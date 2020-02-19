<?php

class Entity extends DatabaseHandler
{
    // Probably implement functionality to query with SQL functions
    // ORM
    // Actually not really an ORM but atleast automates Queries abit XDD
    private $con;
    private $tableName;
    private $generatedSQL;
    private $fetchStyle = "PDO::FETCH_OBJ";
    protected $table;
    private $Count;
    protected $dbFields = [];
    private $paramsArr = [];
    private $cachedQueries = [];
    protected $primaryKey = 'id';

    /*
    // Project tables
    public $article = [];
    // app_user
    public $user = [];

    public $category = [];
    public $comment = [];
    public $role = [];
    public $comment_status = [];
    public $article_status = [];
    */

    public function __construct() {
        // $this->con = $pdo;
        $dbh = new DatabaseHandler();
        $this->con = $dbh->getCon();
    }

    public function setPDO(PDO $pdo) {
        $this->con = $pdo;
    }

    public function setCount($value) {
        return $this->Count = $value;
    }

    public function getCount() {
        return $this->Count();
    }

    // ORM array experiments
    public function getFieldsByArray() {
        $implode = [];
        foreach($this->dbFields as $k => $v) {
            $implode[] = '`' . $v . '`';
        }
        $fields = implode(",", $implode);
        return $fields;
    }

    // getFieldsByProperties

    public function getColumns() {
        $class = new \ReflectionClass($this);

        $columnsToImplode = [];
        foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $columnsToImplode[] = '`' . $prop->getName() . '`';
        }
        $columns = implode(",", $columnsToImplode);
        return $columns;
    }

    public function getPropertiesValues() {
        $class = new \ReflectionClass($this);

        $implode = [];
        foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $propName = $prop->getName();
            echo $this->{$propName} . "<br>";
        }
    }

    public function Bind(array $values) {
        // bind (post) data to an object // But probably gonna be hard idk
        foreach($values as $key => $value) {
            $this->{$value} = $_POST[$value];
        }
    }

    // Does the same like the method Insert. But here it works like ORM's
    public function save() {
        $fields = $this->getColumns();

        $class = new \ReflectionClass($this);

        $questionMarks = [];
        foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $questionMarks[] = "?";
        }
        $params = implode(",", $questionMarks);

        $sql = "INSERT INTO $this->table ({$fields}) VALUES({$params})";
        $stmt = $this->con->prepare($sql);
        $i = 1;
        foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $propName = $prop->getName();
            $property = $this->{$propName};
            // print_r($property);
            // echo $property . '<br>';
            $stmt->bindValue($i, $property);
            $i++;
        }
        // $stmt->execute();
        $this->setSQL($sql);
        return $stmt->execute();
    }

    public function Where(array $condition) {
        $class = new \ReflectionClass($this);

        $whereToImplode = [];
        $valueToImplode = [];

        foreach($condition as $k => $v) {
            foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
                if($prop->getName() == $k) {
                    $propName = $prop->getName();
                    $valueToImplode[] = $v;
                    $whereToImplode[] = " WHERE " . $k . ' = ?';
                }
            }
        }
        $value = implode(" ", $valueToImplode);
        array_push($this->paramsArr, $value);

        $where = implode(" ", $whereToImplode);
        $this->generatedSQL .= $where;

        if(strpos($this->generatedSQL, "SELECT") !== false) {
            // print_r($this->paramsArr);
            return $this;
        } else {
            $stmt = $this->con->prepare($this->generatedSQL);
            $i = 1;
            foreach($this->paramsArr as $k => $v) {
                $stmt->bindValue($i, $v);
                $i++;
            }
            array_push($this->cachedQueries, $this->generatedSQL);
            $this->generatedSQL = '';
            $this->paramsArr = [];
            return $stmt->execute();
            // echo $i . "<br>";
            // print_r($this->paramsArr);
        }
    }

    public function getCachedQueries() {
        return $this->cachedQueries;
    }

    public function _And(array $condition, $get = 0) {
        // $orToImplode = [];
        $class = new \ReflectionClass($this);
        // $andToImplode = [];
        $andToImplode = [];
        $valueToImplode = [];
        foreach($condition as $k => $v) {
            foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
                if($prop->getName() == $k) {
                    $propertyName = $prop->getName();
                    $andToImplode[] = " AND " . $k . ' = ?';
                    $valueToImplode[] = $v;
                }
            }
        }
        $orQuery = implode(" ", $andToImplode);
        $value = implode(" ", $valueToImplode);
        array_push($this->paramsArr, $value);
        $this->generatedSQL .= $orQuery;
        // echo $this->generatedSQL;
        // if
        // return $this;
        // echo $this->generatedSQL;
        // print_r($this->paramsArr);
        // echo count($this->paramsArr);
        if($get == 1) {
            $stmt = $this->con->prepare($this->generatedSQL);
            $i = 1;
            foreach ($this->paramsArr as $k => $v) {
                $stmt->bindValue($i, $v);
                $i++;
            }
            $stmt->execute();
            $this->setCount($stmt->rowCount());
            array_push($this->cachedQueries, $this->generatedSQL);
            $this->generatedSQL = '';
            $this->paramsArr = [];
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return $this;
        }
    }

    public function _Or(array $condition) {
        // $orToImplode = [];
        $class = new \ReflectionClass($this);
        // $andToImplode = [];
        $orToImplode = [];
        foreach($condition as $k => $v) {
            foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
                if($prop->getName() == $k) {
                    $propertyName = $prop->getName();
                    $orToImplode[] = " OR " . $k . ' = ?';
                }
            }
        }
        array_push($this->paramsArr, $this->{$propertyName});
        $orQuery = implode(" ", $orToImplode);
        $this->generatedSQL .= $orQuery;
        return $this;
    }

    public function Get() {
        if(count($this->paramsArr) == 0) {
            $stmt = $this->con->prepare($this->generatedSQL);
            $stmt->execute();
            $this->generatedSQL = '';
            $this->paramsArr = [];
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            $stmt = $this->con->prepare($this->generatedSQL);
            $i = 1;
            foreach($this->paramsArr as $k => $v) {
                $stmt->bindParam($i, $v);
                $i++;
            }
            $stmt->execute();
            array_push($this->cachedQueries, $this->generatedSQL);
            $this->generatedSQL = '';
            $this->paramsArr = [];
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
       // return 1;
    }

    public function GetSingle() {
        if(count($this->paramsArr) != 0) {
            $stmt = $this->con->prepare($this->generatedSQL);
            $i = 1;
            foreach($this->paramsArr as $k => $v) {
                $stmt->bindValue($i, $v);
                $i++;
            }
            $stmt->execute();
            $this->generatedSQL = '';
            $this->paramsArr = [];
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    public function OrderBy(array $condition) {
        $cond = [];
        // Could add logic with Reflection class to check if a property with the value/name of v exists
        foreach($condition as $k => $v) {
            if($k == "ASC") {
                $cond[] = " ORDER BY " . $v . " ASC";
            } else {
                $cond[] = " ORDER BY " . $v . " DESC";
            }
        }
        $orderBy = implode(" ", $cond);
        $this->generatedSQL .= $orderBy;
        return $this;
    }

    public function Select($fields = []) {
        if($fields) {
            $fieldsToImplode = [];
            foreach($fields as $field) {
                $fieldsToImplode[] = '`' . $field . '`';
            }
            $fields = implode(",", $fieldsToImplode);
        }
        $fields = $this->getColumns();
        $sql = "SELECT {$fields} FROM $this->table";
        $this->setSQL($sql);
        return $this;
    }

    public function Join(array $joinFields , array $conditions, $where = [], $value = 1, $operator = "=") {
        $joinFieldsToImplode = [];
        foreach($joinFields as $joinField) {
            $joinFieldsToImplode[] = '' . $joinField . ' ' . 'AS ' . explode(".",$joinField)[0];
        }

        $fields = $this->getColumns();

        $conditionsToImplode = [];
        foreach($conditions as $k => $v) {
            $conditionsToImplode[] = " INNER JOIN " . explode(".", $k)[0] . ' ON ' . $k . ' = ' . $v;
        }
        $jfields = implode(",", $joinFieldsToImplode);
        $conditions = implode(" ", $conditionsToImplode);

        $sql = "SELECT {$fields}, {$jfields} FROM $this->table {$conditions}";
        $this->setSQL($sql);
        // echo $this->generatedSQL;
        return $this;

    }

    public function Delete() {
        $sql = "DELETE FROM $this->table ";
        $this->setSQL($sql);
        return $this;
    }

    public function Update(array $fields) {
        $implode = [];
        $class = new \ReflectionClass($this);
        foreach($fields as $k => $v) {
            foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
                if($prop->getName() == $k) {
                    // echo $prop->getName();
                    // $implode[] = " " . $prop->getName() . ' = ?';
                    $propertyValue = $prop->getName();
                    // $implode[] = " ". $prop->getName() . ' = "' .  $this->{$propertyValue} . '"';
                    $implode[] = " ". $prop->getName() . ' = ?';
                    array_push($this->paramsArr, $this->{$propertyValue});
                }
            }
        }


        $fields = implode(",", $implode);
        $sql = "UPDATE $this->table SET {$fields}";
        $this->setSQL($sql);
        return $this;
    }

    public function Take($amount) {
        $this->generatedSQL .= " LIMIT " . $amount;
        return $this;
    }

    public function Offset($amount) {
        $this->generatedSQL .= " OFFSET " . $amount;
        return $this;
    }

    // Write Or() and And() function

    public function Count() {
        if(count($this->paramsArr) != 0) {
            $stmt = $this->con->prepare($this->generatedSQL);
            $i= 1;
            foreach($this->paramsArr as $k => $v) {
                $stmt->bindValue($i, $v);
                $i++;
            }
           $stmt->execute();
            $this->generatedSQL = '';
            $this->paramsArr = [];
            return $stmt->rowCount();
        }
        $stmt = $this->con->prepare($this->generatedSQL);
        $stmt->execute();
        $test = "{$this->getSQL()}";
        $this->generatedSQL = '';
        $this->paramsArr = [];
        return $stmt->rowCount();
    }

    public function setTableName($value) {
        return $this->tableName = $value;
    }

    private function setSQL($value) {
        return $this->generatedSQL = $value;
    }

    public function getSQL() {
        return $this->generatedSQL;
    }

    public function getMaxID() {
        $stmt = $this->con->prepare("SELECT MAX({$this->primaryKey}) AS 'id' FROM $this->table");
        $stmt->execute();
        return $stmt->fetch()['id'];
    }

    public function WhereLike(array $condition) {
        $class = new \ReflectionClass($this);

        $whereToImplode = [];
        $valueToImplode = [];

        foreach($condition as $k => $v) {
            foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
                if($prop->getName() == $k) {
                    $propName = $prop->getName();
                    $valueToImplode[] = $v;
                    $whereToImplode[] = " WHERE " . $k . ' LIKE ' . ' CONCAT("%", ?, "%")';
                }
            }
        }
        $value = implode(" ", $valueToImplode);
        array_push($this->paramsArr, $value);

        $where = implode(" ", $whereToImplode);
        $this->generatedSQL .= $where;
        // if(strpos($this->generatedSQL, "SELECT") !== false) {
            // print_r($this->paramsArr);
        // echo $this->generatedSQL;
            return $this;
    }

    public function selectView($viewName) {
        $stmt = $this->con->prepare("SELECT * FROM {$viewName}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    public function saveSQLInFile($sql, $file) {
        //if(is_file($file)) {
           // $fileStream = file_get_contents($file);
            // file_put_contents($file, $sql);
        // file_put_contents($file, $sql);

        //
        //

        $stream = fopen($file, "w");
        $content = file_get_contents($file);
        echo $content;
        fwrite($stream, $content . "\n" . $sql . "\n");
        file_put_contents($file, $content . $sql);
        fclose($stream);

          //  fclose($fileStream);

        //}
    }
    */
}