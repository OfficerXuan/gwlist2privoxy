<?php
/**
* 提取shocksocksX里的规则列表的被屏蔽的主机名，生成privoxy action文件，用于转发请求到ss-local
**/
$gfwlist_path = '/Users/falcon/.ShadowsocksX/gfwlist.js'; //gfwlist.js的列表路径
$output_path = __DIR__ .  '/shdowsocks.action'; // 存放 privoxy action的路径
$filter_str = "{+forward-override{forward-socks5 127.0.0.1:1081 .}}";// ss-local监听的地址和端口 

$content = file_get_contents($gfwlist_path);
preg_match('#var rules = \[(.*)\];#iUs', $content, $match);

$url_arr = array();
foreach(explode(',',$match[1]) as $url) {

	if(preg_match('#([\.\w]+\.[\*\w]+){1,}.*#',$url,$match2)){
		if(in_array($match2[1],$url_arr)){
			continue;
		}
		$url_arr[] = $match2[1];
	}
	
}

file_put_contents( $output_path , $filter_str . "\n" . implode("\n",$url_arr) );