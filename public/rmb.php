<?php
$url = "http://webforex.hermes.hexun.com/forex/quotelist?code=FOREXUSDCNY&column=code,price,PriceWeight,UpdownRate&callback=ongetjsonpforex&_=".getMillisecond();
//echo var_dump($url);
$url_btc = "http://graphs2.coinmarketcap.com/global/marketcap-total/";
// $show_btc = file_get_contents("./json/show_btc.json");
// $show_eth = file_get_contents("./json/show_eth.json");
// $show_usdt = file_get_contents("./json/show_usdt.json");
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}
//echo getMillisecond();
function curl_get_https($url)
{
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
       // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
    curl_close($curl);
    echo $tmpInfo;    //返回json对象
};
function curl_get_https_btc($url_btc)
{
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url_btc);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
       // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
    curl_close($curl);
    echo $tmpInfo;    //返回json对象
};
echo '{';
echo '"total"';
echo ':';
echo curl_get_https_btc($url_btc);
echo '}';
?>