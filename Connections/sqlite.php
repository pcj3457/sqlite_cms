<?php 

class MyDB extends SQLite3
{   
    function __construct()
    {    $mysqlitedb=dirname(dirname(__FILE__)).'/db/webdb.db';
        $this->open($mysqlitedb);
    }
}

?>