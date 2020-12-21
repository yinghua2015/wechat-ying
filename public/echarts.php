<?php
//添加数据
header('Content-type:text/html;charset=utf-8');
	//1.连接
$link=mysqli_connect('rm-j6c0xl840e2b18386.mysql.rds.aliyuncs.com','ether','n9483E6wBUFt5z6','ether') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());

    //2.设置编码方式
// mysqli_set_charset($link, 'utf8');
//var_dump($_REQUEST);die;
//$arr = $_REQUEST['arr'];
$echarts = "SELECT class,sum(quantity) as amount,sum(percentage) as percent FROM showData group by class order by class  asc;";

$reslike = mysqli_query($link, $echarts);
//echo var_dump(mysqli_fetch_assoc($reslike));
//echo mysqli_fetch_assoc($reslike)[0];
// foreach (mysqli_fetch_assoc($reslike) as $key => $value) {
//     # code...
//     echo  $value[percent];
// }
$results = array();

while ($row = mysqli_fetch_assoc($reslike )) {
    $results[] = $row;
}
if ($results) {
echo json_encode($results);

} else {
echo mysql_error();
};


    //mysqli_free_result($res);
    //4.关闭连接
mysqli_close($link);