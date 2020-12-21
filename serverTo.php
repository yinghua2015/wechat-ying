<?php
	header('Content-type:text/html;charset=utf-8');
	//1.连接
    // $link=mysqli_connect('localhost','root','','test') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());//测试地址
	$link=mysqli_connect('rm-j6c0xl840e2b18386.mysql.rds.aliyuncs.com','ether','n9483E6wBUFt5z6','ether') or die('Connect Error:'.mysqli_connect_errno().":".mysqli_connect_error());
    //2.设置编码方式
    mysqli_set_charset($link,'utf8');

	// echo "<pre>";
 //    print_r($_POST);
 //    echo "</pre>";
 //    die;

    //排序
	$order_column = addslashes($_REQUEST['order']['0']['column']);//哪一列排序，从0开始
	$order_dir = addslashes($_REQUEST['order']['0']['dir']);//ase desc 升序或者降序
	//拼接排序sql
	$orderSql = "";
	if(isset($order_column)){
	    $i = intval($order_column);
	    switch($i){
	        case 1;$orderSql = " order by percentage desc";break;
	        case 2;$orderSql = " order by name ".$order_dir;break;
	        case 4;$orderSql = " order by class ".$order_dir;break;
	        case 6;$orderSql = " order by quantity ".$order_dir;break;
	        case 9;$orderSql = " order by percentage ".$order_dir;break;
	        default;$orderSql = 'order by showData.uantity desc';
	    }
	}

	//搜索
	// $search = $_REQUEST['search']['value'];  //全局搜索时获取的搜索条件
	$search = !empty($_REQUEST['search_query']) ? $_REQUEST['search_query'] : '';//获取前台传过来的过滤条件
	//定义过滤条件查询过滤后的记录数sql
	$like = "'%".$search."%'";
	$sumSqlWhere =" where (name LIKE ".$like.") or (address LIKE ".$like.") or (class LIKE ".$like.") or (quantity LIKE ".$like.") or (percentage LIKE ".$like.")";


	//分页
	$start = $_REQUEST['start'];//从多少开始
	$length = $_REQUEST['length'];//数据长度
	$limitSql = '';
	$limitFlag = isset($_REQUEST['start']) && $length != -1 ;
	if ($limitFlag ) {
	    $limitSql = " LIMIT ".intval($start).", ".intval($length);
	}

	$sum = 0;
	$res_sum=mysqli_query($link, "SELECT count(1) as sum FROM showData ".$sumSqlWhere);
	if($res_sum && mysqli_num_rows($res_sum)>0){
		$res_sum_num=mysqli_fetch_array($res_sum, MYSQLI_ASSOC);
		$sum = $res_sum_num['sum'];
	}

	//3.执行SQL查询
	$sql="SELECT id,`address`,`name`,`class`,FORMAT(quantity,2) as quantity,percentage,createtime FROM showData ";
	// echo $sql;
	if(strlen($search)>0){
		// echo 111;
	    //如果有搜索条件，按条件过滤找出记录
	    $sql .=  $sumSqlWhere. $orderSql . $limitSql;
	}else{
		// echo 222;
		// echo $orderSql;
		// echo '</br>';
		// echo $limitSql;
	    //直接查询所有记录
	     $sql .= $orderSql . $limitSql;
	}

	// var_dump($sql);die;
    $res=mysqli_query($link, $sql);
    $rows =array();
    if($res && mysqli_num_rows($res)>0){
		$index = $start;
        while($row=mysqli_fetch_array($res, MYSQLI_ASSOC)){
			$row['id'] = ++$index;
            $rows[]=$row;
        }
    }else{

    }


    mysqli_free_result($res);
    //4.关闭连接
    mysqli_close($link);
	//获取Datatables发送的参数 必要
	$data['draw'] = !empty($_REQUEST['draw']) ?  $_REQUEST['draw'] : 1;
    $data['recordsTotal'] = $sum;
	$data['recordsFiltered'] = $sum;
	$data['data'] = $rows;
	echo json_encode($data,JSON_UNESCAPED_UNICODE);exit;