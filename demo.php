<?php
//验证单例是否正确
$db1 = Pgsql::getInstance();
//查询数据
$rs  = $db1->findMany("select * from student");
//添加数据
// $data = array('id' => 2,'name' => 'php','subjects' => 2,);
// $rs = $db1->add('student',$data);
// $data = array('name' => 'itcastphp');
// $condition = array('id' => 2);
//修改数据
// $rs = $db1->save('student', $data, $condition);
//删除数据
// $rs = $db1->delete('student',$condition);
echo '<pre>';
var_dump($rs);