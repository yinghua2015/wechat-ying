<?php
header('Content-type:text/html;charset=utf-8');
	//1.连接
// $link = mysqli_connect('localhost', 'root', '', 'test') or die('Connect Error:' . mysqli_connect_errno() . ":" . mysqli_connect_error());

    //2.设置编码方式
global $gloable_ether_dataBaseLink;
//初始化
function get_html($pageindex)
{
	$curlPost = "http://etherscan.io/token/generic-tokenholders2?a=0xf41861f194e7ba8de95144a89e0c6ed16ee0b3a0&s=1E%2b28&p=" . $pageindex;
	$ch = curl_init($curlPost);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	return $data;
};

function open_dataBase()
{
	$linkether = mysqli_connect('rm-j6c0xl840e2b18386.mysql.rds.aliyuncs.com', 'ether', 'n9483E6wBUFt5z6', 'ether') or die('Connect Error:' . mysqli_connect_errno() . ":" . mysqli_connect_error());
	mysqli_set_charset($linkether, 'utf8');
	return $linkether;
};

function close_dataBase($linkether)
{
	mysqli_close($linkether);
}

function get_address_ex_name($linkether, $address)
{
	$ex_address = const_address($address);
	if ($ex_address != null) {
		// echo var_dump($ex_address)."</br>";
		return array($ex_address[1], $ex_address[2]);
	}
	$reslike = mysqli_query($linkether, "SELECT ex_name from ether.t_ex_eth_address WHERE address='" . $address . "';", MYSQLI_STORE_RESULT);
	if (mysqli_num_rows($reslike) > 0) {
		$ex_name = mysqli_fetch_array($reslike)[0];
		return array($ex_name . "_user", "用户地址");
	} else {
		return array("null", "null");
	}
}

// echo var_dump(get_address_ex_name($gloable_ether_dataBaseLink,'0x54340ce5f725b2e9b9275f3b6443d930e9e37f2e'));
// close_dataBase($gloable_ether_dataBaseLink);
// return;
function parse_html($data)
{
	global $gloable_ether_dataBaseLink;
	$arrListNew = array();
	$address_exp = "/(0x\w{40})<\/a>/";
	preg_match_all($address_exp, $data, $matches_address);
	$num = count($matches_address[0]);
	for ($i = 0; $i < $num; $i++) {
		$address = $matches_address[0][$i];
		$adr = str_replace("</a>", "", $address);
		array_push($arrListNew, array($adr));
		$ex_name = get_address_ex_name($gloable_ether_dataBaseLink, $adr);
		if ($ex_name != null) {
			array_push($arrListNew[$i], $ex_name[0]);
			array_push($arrListNew[$i], $ex_name[1]);
		} else {
			$n = "null";
			array_push($arrListNew[$i], $n);
			array_push($arrListNew[$i], $n);
		}
	};
	$amount_exp = "/\<td>([-+]?[0-9]*\.?[0-9]+)<\/td>/";
	preg_match_all($amount_exp, $data, $matches_amount);
	// echo var_dump($matches_amount);
	$num2 = count($matches_amount[0]);
	for ($i = 1, $x = 0; $i < $num2; $i += 2, $x++) {
		$quantity = $matches_amount[0][$i];
		$amount = str_replace("<td>", "", $quantity);
		$amount = str_replace("</td>", "", $amount);
		array_push($arrListNew[$x], $amount);
	};
	$percent_exp = "/\<td>(\d+\.\d+\%)<\/td>/";
	preg_match_all($percent_exp, $data, $matches_percent);
	// echo var_dump($matches_amount);
	$num3 = count($matches_percent[0]);
	for ($i = 0; $i < $num3; $i++) {
		$percent = $matches_percent[0][$i];
		// $pct=substr($percent,0,strlen($percent)-2);
		$pct = str_replace("%", "", $percent);
		$pct = str_replace("<td>", "", $pct);
		$pct = str_replace("</td>", "", $pct);
		array_push($arrListNew[$i], $pct);
	}
	return $arrListNew;
}

function is_record_exist($link_database, $address)
{
	// echo $address;
	$sql = sprintf("SELECT count(id) as vv from showData where address='%s'", $address);
	$result = mysqli_query($link_database, $sql, MYSQLI_ASSOC);
	$rr = mysqli_fetch_assoc($result);
	if (((int)$rr['vv']) != 0) {
		return true;
	} else {
		return false;
	}
}

function insert_new_data($link_database, $row_data)
{
	$sql = sprintf("INSERT into showData (address,name,class,quantity,percentage,createtime,updatetime) VALUES('%s','%s','%s',%s,%s,'%s','%s');", $row_data[0], $row_data[1], $row_data[2], $row_data[3], $row_data[4], '2016-12-25 11:46:13', '2017-01-03 13:49:13');
	// echo $row_data[0];
	// $sql = "INSERT INTO `showData`(address,name,class,quantity,percentage,createtime,updatetime) VALUES ('$row_data[0]', '$row_data[1]', 'null', '$row_data[2]', '$row_data[3]','2016-12-25 11:46:13', '2017-01-03 13:49:13')";
	echo $sql;
	// echo "</br>";
	$res = mysqli_query($link_database, $sql);
	echo var_dump($res) . "insert </br>";
}

function update_data($link_database, $row_data)
{
	// $sql=sprintf("UPDATE showData set name='%s',class='%s',quantity=%s,percentage=%s, createtime='2016-12-25 11:46:13',updatetime='2017-01-03 13:49:13' where address='%s';",$row_data[1],$row_data[2],$row_data[3],$row_data[4],$row_data[0]);
	$sql = sprintf("UPDATE showData set quantity=%s,percentage=%s where address='%s';", $row_data[3], $row_data[4], $row_data[0]);
	// $class = 'unknown';
	// $sql = "UPDATE `showData` set name ='" . $row_data[1] . "',class = '" . $class . "',quantity = '" . $row_data[2] . "',percentage='" . $row_data[3] . "' where address = '" . $row_data[0] ."'";
	//  echo $sql;
	$res = mysqli_query($link_database, $sql);
	echo ($res) . "update </br>";
}

function update_dataBase($arrListNew)
{
	global $link;
	foreach ($arrListNew as $key => $value) {
		# code...
		if (is_record_exist($link, $value[0]) == false) {
			// echo "insert data";
			insert_new_data($link, $value);
		} else {
			// echo "111111";
			// echo $value[0];
			update_data($link, $value);
			// echo "update data";
		}
	}
}

function make_rowcount_thousand($result_list)
{
	global $link;
	$address_list = "";
	foreach ($result_list as $key => $value) {
		# code...
		$address_list = $address_list . "'" . $value[0] . "',";
	}
	$address_list = substr($address_list, 0, strlen($address_list) - 1);
	// echo $address_list;
	$sql = sprintf("DELETE FROM showData where address not in (%s);", $address_list);
	// echo $sql;
	$res = mysqli_query($link, $sql);
	echo var_dump($res) . "insert </br>";
}

function refresh_data()
{
	# code...
	$result_list = array();
	for ($i = 0; $i < 20; $i++) {
		$result_list = array_merge($result_list, parse_html(get_html($i + 1)));
	}
	update_dataBase($result_list);
	make_rowcount_thousand($result_list);
}
// echo const_address("0x4b1a99467a284cc690e3237bc69105956816f762")[1];
// return;
function const_address($address)
{
	$const_address = array(
		array("0x3f5ce5fbfe3e9af3971dd833d26ba9b5c936f0be", "Binance_1", "交易所大地址"),
		array("0xd551234ae421e3bcba99a0da6d736074f22192ff", "Binance_2", "交易所大地址"),
		array("0x564286362092d8e7936f0549571a803b203aaced", "Binance_3", "交易所大地址"),
		array("0x0681d8db095565fe8a346fa0277bffde9c0edbbf", "Binance_4", "交易所大地址"),
		array("0xfe9e8709d3215310075d67e3ed32a380ccf451c8", "Binance_5", "交易所大地址"),
		array("0x15aB2321d7E83d00C015048b567f4F6AadC1B022", "Binance_6", "交易所大地址"),
		array("0x6cc5f688a315f3dc28a7781717a9a798a59fda7b", "Okex_1", "交易所大地址"),
		array("0x236f9f97e0e62388479bf9e5ba4889e46b0273c3", "Okex_2", "交易所大地址"),
		array("0x1151314c646ce4e0efd76d1af4760ae66a9fe30f", "Bitfinex_1", "交易所大地址"),
		array("0x7727e5113d1d161373623e5f49fd568b4f543a9e", "Bitfinex_2", "交易所大地址"),
		array("0x4fdd5eb2fb260149a3903859043e962ab89d8ed4", "Bitfinex_3", "交易所大地址"),
		array("0x876eabf441b2ee5b5b0554fd502a8e0600950cfa", "Bitfinex_4", "交易所大地址"),
		array("0x742d35cc6634c0532925a3b844bc454e4438f44e", "Bitfinex_5", "交易所大地址"),
		array("0x03bdf69b1322d623836afbd27679a1c0afa067e9", "Bitmax_1", "交易所大地址"),
		array("0x4b1a99467a284cc690e3237bc69105956816f762", "Bitmax_2", "交易所大地址"),
		array("0xfbb1b73c4f0bda4f67dca266ce6ef42f520fbb98", "Bittrex_1", "交易所大地址"),
		array("0xe94b04a0fed112f3664e45adb2b8915693dd5ff3", "Bittrex_2", "交易所大地址"),
		array("0x0d0707963952f2fba59dd06f2b425ace40b492fe", "Gate.io_1", "交易所大地址"),
		array("0x7793cd85c11a924478d358d49b05b37e91b5810f", "Gate.io_2", "交易所大地址"),
		array("0x1c4b70a3968436b9a0a9cf5205c787eb81bb558c", "Gate.io_3", "交易所大地址"),
		array("0xd24400ae8bfebb18ca49be86258a3c749cf46853", "Gemini_1", "交易所大地址"),
		array("0x6fc82a5fe25a5cdb58bc74600a40a69c065263f8", "Gemini_2", "交易所大地址"),
		array("0x9c67e141c0472115aa1b98bd0088418be68fd249", "HitBTC_1", "交易所大地址"),
		array("0x59a5208b32e627891c389ebafc644145224006e8", "HitBTC_2", "交易所大地址"),
		array("0xa12431d0b9db640034b0cdfceef9cce161e62be4", "HitBTC_3", "交易所大地址"),
		array("0x274f3c32c90517975e29dfc209a23f315c1e5fc7", "Hotbit", "交易所大地址"),
		array("0xab5c66752a9e8167967685f1450532fb96d5d24f", "Huobi_1", "交易所大地址"),
		array("0x6748f50f686bfbca6fe8ad62b22228b87f31ff2b", "Huobi_2", "交易所大地址"),
		array("0xfdb16996831753d5331ff813c29a93c76834a0ad", "Huobi_3", "交易所大地址"),
		array("0xeee28d484628d41a82d01e21d12e2e78d69920da", "Huobi_4", "交易所大地址"),
		array("0x5c985e89dde482efe97ea9f1950ad149eb73829b", "Huobi_5", "交易所大地址"),
		array("0xdc76cd25977e0a5ae17155770273ad58648900d3", "Huobi_6", "交易所大地址"),
		array("0xadb2b42f6bd96f5c65920b9ac88619dce4166f94", "Huobi_7", "交易所大地址"),
		array("0xa8660c8ffd6d578f657b72c0c811284aef0b735e", "Huobi_8", "交易所大地址"),
		array("0x1062a747393198f70f71ec65a582423dba7e5ab3", "Huobi_9", "交易所大地址"),
		array("0xe93381fb4c4f14bda253907b18fad305d799241a", "Huobi_10", "交易所大地址"),
		array("0xfa4b5be3f2f84f56703c42eb22142744e95a2c58", "Huobi_11", "交易所大地址"),
		array("0x46705dfff24256421a05d056c29e81bdc09723b8", "Huobi_12", "交易所大地址"),
		array("0x99fe5d6383289cdd56e54fc0baf7f67c957a8888", "Huobi_13", "交易所大地址"),
		array("0x1b93129f05cc2e840135aab154223c75097b69bf", "Huobi_14", "交易所大地址"),
		array("0xeb6d43fe241fb2320b5a3c9be9cdfd4dd8226451", "Huobi_15", "交易所大地址"),
		array("0x956e0dbecc0e873d34a5e39b25f364b2ca036730", "Huobi_16", "交易所大地址"),
		array("0x2910543af39aba0cd09dbb2d50200b3e800a63d2", "Kraken_1", "交易所大地址"),
		array("0x0a869d79a7052c7f1b55a8ebabbea3420f0d1e13", "Kraken_2", "交易所大地址"),
		array("0xe853c56864a2ebe4576a807d26fdc4a0ada51919", "Kraken_3", "交易所大地址"),
		array("0x267be1c1d684f78cb4f6a176c4911b741e4ffdc0", "Kraken_4", "交易所大地址"),
		array("0xfa52274dd61e1643d2205169732f29114bc240b3", "Kraken_5", "交易所大地址"),
		array("0x2b5634c42055806a59e9107ed44d43c426e58258", "Kucoin_1", "交易所大地址"),
		array("0x899B5d52671830f567BF43A14684Eb14e1f945fe", "Kucoin_2", "交易所大地址"),
		array("0x8271b2e8cbe29396e9563229030c89679b9470db", "Liqui.io_1", "交易所大地址"),
		array("0x5e575279bf9f4acf0a130c186861454247394c06", "Liqui.io_2", "交易所大地址"),
		array("0x32be343b94f860124dc4fee278fdcbd38c102d88", "Poloniex_1", "交易所大地址"),
		array("0xab11204cfeaccffa63c2d23aef2ea9accdb0a0d5", "Poloniex_2", "交易所大地址"),
		array("0x209c4784ab1e8183cf58ca33cb740efbf3fc18ef", "Poloniex_3", "交易所大地址"),
		array("0xb794f5ea0ba39494ce839613fffba74279579268", "Poloniex_4", "交易所大地址"),
		array("0x390de26d772d2e2005c6d1d24afc902bae37a4bb", "Upbit", "交易所大地址"),
		array("0xd94c9ff168dc6aebf9b6cc86deff54f3fb0afc33", "Yunbi_1", "交易所大地址"),
		array("0x42da8a05cb7ed9a43572b5ba1b8f82a0a6e263dc", "Yunbi_2", "交易所大地址"),
		array("0x700f6912e5753e91ea3fae877a2374a2db1245d7", "Yunbi_3", "交易所大地址"),
		array("0xf73c3c65bde10bf26c2e1763104e609a41702efe", "Bibox", "交易所大地址"),
		array("0xe3031C1BfaA7825813c562CbDCC69d96FCad2087", "cex_1", "交易所大地址"),
		array("0xaa15db6acc3264e383ffb067070486c1b920518f", "cex_2", "交易所大地址"),
		array("0x30146933A3A0BABc74eC0b3403beC69281Ba5914", "bit-z", "交易所大地址"),
		array("0xb9ee1e551f538a464e8f8c41e9904498505b49b0", "Coinex", "交易所大地址"),
		array("0x915d7915f2b469bb654a7d903a5d4417cb8ea7df", "Fcoin", "交易所大地址"),
		array("0x7a10ec7d68a048bdae36a70e93532d31423170fa", "Bgogo_1", "交易所大地址"),
		array("0xce1bf8e51f8b39e51c6184e059786d1c0eaf360f", "Bgogo_2", "交易所大地址"),
		array("0xd4dcd2459bb78d7a645aa7e196857d421b10d93f", "BigONE_1", "交易所大地址"),
		array("0xa30d8157911ef23c46c0eb71889efe6a648a41f7", "BigONE_2", "交易所大地址"),
		array("0xc9ba6e5eda033c66d34ab64d02d14590963ce0c2", "团队", "团队激励10亿,团队"),
		array("0x7fc1e0742cb304f8aa36486fded24d986c36bbb8", "回购", "回购地址,团队"),
		array("0xe436115aa131876deb77627ae01a5ff1a8046a7f", "用户", "赵东,投资人"),
		array("0x389122A30174DEbC3d371151891E08493EB13756", "用户", "优壳李李,散户"),
		array("0x64e874ce614013aa5f3ef4c30157e3a88b4f10a0", "用户", "林佳鹏,投资人"),
	);
	foreach ($const_address as $key => $value) {
		if (strcasecmp($value[0], $address) == 0) {
			return $value;
		}
	}
	return null;
}

// $link = open_dataBase();
$gloable_ether_dataBaseLink = open_dataBase();
$link = $gloable_ether_dataBaseLink;
// echo var_dmup($gloable_ether_dataBaseLink);
// echo get_address_ex_name($gloable_ether_dataBaseLink,"0x2c71439dd2b37e4ed4d2b6430f4a232c1b094b5d");
refresh_data();
close_dataBase($gloable_ether_dataBaseLink);
// mysqli_close($link);
return;

exit;
