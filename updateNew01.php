<?php
//更新数据
	header('Content-type:text/html;charset=utf-8');
	//1.连接
    $link=mysqli_connect('rm-j6c0xl840e2b18386.mysql.rds.aliyuncs.com','ether','n9483E6wBUFt5z6','ether') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());

    //2.设置编码方式
    mysqli_set_charset($link,'utf8');

    // var_dump($_REQUEST);die;
    $address = $_REQUEST['address'];
    echo $address;
    echo "</br>";
    $name = $_REQUEST['name'];
    echo $name;
    echo "</br>";
    //$address = $_REQUEST['address'];
    $class = $_REQUEST['class'];
    echo $class;
    echo "</br>";
    // $quantity = $_REQUEST['quantity'];
    // $percentage = $_REQUEST['percentage'];
	//3.执行SQL查询
    //$sql=sprintf("UPDATE `ether.showData` set name = '".$name."',class = '".$class."' where id = ".$address);
    $sql = sprintf("UPDATE ether.showData set name= '%s',class='%s' where address='%s'", $name, $class, $address);
    // echo $sql;
	$res=mysqli_query($link, $sql);
	if($res){
        echo "修改成功";
	    // echo "修改成功";
	}else{
	    echo "修改失败";
	}

    //mysqli_free_result($res);
    //4.关闭连接
    mysqli_close($link);