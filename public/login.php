<?php
    header("ALLOW-CONTROL-ALLOW-ORIGIN:*");
	header('Content-type:text/html;charset=utf-8');
	//1.连接
    // $link=mysqli_connect('localhost','root','','test') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());//测试地址
	$link=mysqli_connect('rm-j6c0xl840e2b18386.mysql.rds.aliyuncs.com','ether','n9483E6wBUFt5z6','ether') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());
    //2.设置编码方式
    mysqli_set_charset($link,'utf8');
    //参数
     $tel = $_POST["name"];
     $pwd = $_POST["pwd"];
    // $tel = 'lb';
    // $pwd = '5{X8sfPH^/lh/1H7';
    // $token = md5($pwd);
    // $sql = "insert into user(ga)values('".$token."')";
    //根据条件查询
    $insert = "select * from user where user_name = '$tel' and user_password = '$pwd'";
    $result = mysqli_query($link,$insert);

    //判断是否可以查询出要登录的手机号，还是使用 mysql_num_rows（）返回的值是否为 1,就是1条数据，因此这个$row就是返回的一整条数据
    $row = mysqli_num_rows($result);
    if($row == 1){
        //定义一个数组
        $array = array();
        /*
         * 如果等于1，说明查询成功，也就是登录成功，说明这个用户是存在的，就需要把对应的数据返回给一个数组
         * 为什么要用 while 语句呢？因为登录一次只查询一条语句，while(){}语句，只执行一次
        */
        while($row = mysqli_fetch_array($result)){
            //把返回的数据从 $row 中取出存入 $array中，一般是要把所有的字段都储存在 数组中
            $array["user_id"] = $row["user_id"];
            $array["user_name"] = $row["user_name"];
            $array["user_password"] = $row["user_password"];
        }
        session_start();  //开启session
        $_SESSION['user'] = $array;  // 把username存在$_SESSION['user'] 里面
        //把上面的数组以 json 格式返回
        $json = json_encode(array(
            "resultCode"=>200,
            "message"=>"登录成功！",
            // "data"=>$array
        ));
        echo($json);
    }else{
        $json = json_encode(array(
            "resultCode"=>500,
            "message"=>"登录失败！"
        ));
        echo($json);
    }
    mysqli_close($link);
