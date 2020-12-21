<?php
header("ALLOW-CONTROL-ALLOW-ORIGIN:*");
header('Content-type:text/html;charset=utf-8');
//1.连接
// $link=mysqli_connect('localhost','root','','test') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());//测试地址
$link = mysqli_connect('rm-j6cb8txa6t3ww941z90110.mysql.rds.aliyuncs.com', 'ether', 'n9483E6wBUFt5z6', 'ether') or die('Connect Error:' . mysqli_connect_errno() . ":" . mysqli_connect_error());

mysqli_set_charset($link, 'utf8');
//参数
$tel = addslashes($_REQUEST["name"]);
$pwd = addslashes($_REQUEST["pwd"]);
// echo var_dump($tel);
// echo var_dump($pwd);
// $tel = 'lb';
// $pwd = '5{X8sfPH^/lh/1H7';
// $token = md5($pwd);
// $sql = "insert into user(ga)values('".$token."')";


$insert = "select * from user where user_name = '$tel' and user_password = '$pwd'";
$result = mysqli_query($link, $insert);


$row = mysqli_num_rows($result);
if ($row == 1) {
    //定义一个数组
    $array = array();
    while ($row = mysqli_fetch_array($result)) {

        $array["user_id"] = $row["user_id"];
        $array["user_name"] = $row["user_name"];
        $array["user_password"] = $row["user_password"];
    }
    session_start();  //开启session
    $_SESSION['user'] = $array["user_name"];  // 把username存在$_SESSION['user'] 里面
    //把上面的数组以 json 格式返回
    $json = json_encode(array(
        "resultCode" => 200,
        "message" => "登录成功！"
        // "data"=>$array
    ));
    echo ($json);
} else {
    $json = json_encode(array(
        "resultCode" => 500,
        "message" => "登录失败！"
    ));
    echo ($json);
}
mysqli_close($link);
