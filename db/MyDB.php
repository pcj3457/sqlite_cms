<?php class MyDB extends SQLite3
{
    function __construct()
    {    $mysqlitedb=dirname(__FILE__).'/webdb.sqllite';
        $this->open($mysqlitedb);
    }
}
?>