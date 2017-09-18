<?php
/*
 * 实现postgresql操作类(单列模式)
 *
 * Time:2017年9月18日11:41:03
 *
 * author:feiyuaner
 */

class Pgsql
{
  //私有化静态属性存储单列对象
  private static $obj = null;
  //私有化数据库的配置信息
  private $host;
  private $port;
  private $user;
  private $password;
  private $dbname;
  private $connection;
  //私有化构造方法
  private function __construct()
  {
    $this->host = '127.0.0.1';
    $this->port = '5432';
    $this->user = 'postgres';
    $this->password = '123456';
    $this->dbname = 'itcast';
    //调用连接数据库
    $this->link();
  }
  //禁止类外调用克隆方法
  private function __clone()
  {

  }
  //公共获取单列对象方法
  public static function getInstance()
  {
    //判断对象是否存在
    if(!self::$obj instanceof self)
      {
        //对象不存在,实例化
        self::$obj = new self();
      }
    //对象已经存在,直接返回
    return self::$obj;
  }
  //私有化数据库连接方法
  private function link()
  {
    //拼接连接信息
    $linkString = "host=".$this->host." port=".$this->port." dbname=".$this->dbname." user=".$this->user." password=".$this->password;
    //连接数据库
    $connection = @pg_connect($linkString);
    if($connection === false){
      die('database link error');
    }
    return $connection;
  }
  //公共sql语句执行方法
  private function query($sql)
  {
    $result = pg_query($sql) or die('query failed:'.pg_last_error());
    return $result;
  }
  //添加数据
  public function add($tableName,$data){
    $connection = $this->link();
    $result = pg_insert($connection, $tableName, $data);
    if($result === false)
      {
        die('failed:'.pg_last_error());
      }
    return $result;
  }
  //获取一条数据
  //$type 1为索引数组  2为关联数组
  public function findOne($sql,$type=2)
  {
    $result = $this->query($sql);
    switch ($type) {
      case '1':
        $data = pg_fetch_row($result);
        break;
      case '2':
        $data = pg_fetch_assoc($result);
        break;
      default:
        break;
    }
    return $data;
  }
  //获取多条数据
  public function findMany($sql)
  {
    $result = $this->query($sql);
    $data = pg_fetch_all($result);
    return $data;
  }
  //修改数据
  public function save($tableName, $data, $condition)
  {
    $connection = $this->link();
    $result = pg_update($connection, $tableName, $data, $condition);
    if($result === false)
      {
        die('failed:'.pg_last_error());
      }
    return $result;
  }
  //删除数据
  public function delete($tableName,$condition)
  {
    $connection = $this->link();
    $result = pg_delete($connection, $tableName, $condition);
    if($result === false)
      {
        die('failed:'.pg_last_error());
      }
    return $result;
  }
}