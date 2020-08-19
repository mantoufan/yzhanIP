<?php
	$_uid=@$_POST['uid'];$_d=@$_POST['d'];$_action=@$_POST['action'];
	$r=array('status'=>FALSE,'error'=>'login-wrong');

	if($_uid){
		include('mtf/php/mtfHTTP/mtfHTTP.php');
		$mtfHTTP=new mtfHTTP();
		$j=$mtfHTTP->curl(array('u'=>'http://dat.mtf.im/api/people/uid2i/?uid='.$_uid));
		$a=json_decode($j,TRUE);
		if($a){
			$i=$a['i'];
			if($i){
				$u='d/'.$i.'.dat';
				if($_action==='save'){
					if($_d){
						if(@$_d['d']){
							$r['status']=TRUE;
							$r['error']='';
							$r['d']=$_d['d'];
							file_put_contents($u,json_encode($_d));
						}else{
							$r['error']='data-wrong';
						}
					}else{
						@unlink($u);
						$r['error']='data-empty';
					}
				}elseif($_action==='load'){
					$r['status']=TRUE;
					$r['error']='';
					$_d=json_decode(@file_get_contents($u),TRUE);
					if($_d){
						$r['d']=$_d['d'];
					}
				}
			}
		}
	}	
	
	echo json_encode($r);
?>