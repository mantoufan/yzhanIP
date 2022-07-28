<?php $q=reset(explode('?',end(explode('mtfq=',@$_SERVER['QUERY_STRING']))));?>

<!doctype html>

<html>

<head>

<meta charset="utf-8">

<title><?php echo ($q?$q.'_':'');?>游戏攻略</title>

<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">

<meta name="applicable-device" content="pc,mobile">

<meta name="MobileOptimized" content="width"/>

<meta name="HandheldFriendly" content="true"/>

<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

<meta name="apple-mobile-web-app-capable" content="yes">

<meta name="x5-fullscreen" content="true">

<meta name="full-screen" content="yes">

<style>

	body{

		margin: 0;

		padding: 0;

	}

	#search,.list a{

		width: 99.6%;

		line-height: 1.5em;

		font-size: 16px;

		text-indent:.5em;

	}

	.list a{

		background: #F7F7F7;

		border: 1px solid #FFFFFF;

		border-width: 1px 0;

		display: inline-block;

		color:#333333;

		text-decoration: none;

	}

	.list{

		margin: 0;

		padding: 0;

	}

	.list li{

		list-style: none;

		padding: 0;

	}

	.none{

		display: none;

	}

	h1{

		font-size: 1em;

		margin: 0;

		text-align: center;

		line-height: 25px;

		background: #F7F7F7;

	}

	.m-back{

		background: #555555;

		color: #FFFFFF;

		text-decoration: none;

		width: 40px;

		text-align: center;

		line-height: 30px;

		float: right;

		line-height: 25px;

	}

</style>

</head>



<body>

<a class="m-back" href="javascript:history.back()">返回</a>

<h1>攻略</h1>

<?php

	if($q){

		echo '<input id="search" placeholder="请输入关键字" type="text" data-list=".list" data-nodata="未找到" autocomplete="off">';

	}

?>

<ul class="list">

<?php

	if($q){

		require('vendor/autoload.php');

		$ql = QL\QueryList::getInstance();

		$ql->use(QL\Ext\Google::class);



		$data= $searcher = $ql->google(100)->search($q.' site:jingyan.baidu.com')->page(1);

		if($data){

			foreach($data as $k=>$v){

				$a=explode('_',$v['title']);

				$s='<div class="none">'.$q.'</div>';

				$a[0]=strtr($a[0],array($q=>$s,'《'.$q.'》'=>$s));

				echo '<li><a href="'.$v['link'].'">'.$a[0].'</a></li>';

			}

		}

	}else{

		$data=array('赛尔号','绝地求生','王者荣耀','创造与魔法','迷你世界','荒野行动','英雄联盟','第五人格','奶块','我的世界','阴阳师','球球大作战','QQ飞车','荒野行动','英魂之刃','QQ炫舞','天天酷跑','穿越火线','DNF');

		foreach($data as $k=>$v){

			echo '<a href="'.$v.'">'.$v.'</a>';

		}

	}

?>

</ul>

<script src="https://cdnjs.loli.net/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="https://cdnjs.loli.net/ajax/libs/hideseek/0.8.0/jquery.hideseek.min.js"></script>

<script src="//cdn.os120.com/share/mtfFrame.js" ></script>

<script src="https://cdnjs.loli.net/ajax/libs/ismobilejs/0.4.1/isMobile.min.js"></script>

<script>

	mtfFrame.refresh();

	if($('#search').length>0){

		$('#search').hideseek({

			nodata: '未找到',

			navigation: true,

			highlight: true

		});

		$('.list li a').click(function(){

			mtfFrame.openWin($(this).attr('href'),'',isMobile.any?1:'');

			return false;

		});

	}

</script>

</body>

</html>