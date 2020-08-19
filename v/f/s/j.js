var BE=function(o,t){
	return t?o && typeof(o[t])!=="undefined":typeof(o)!=="undefined";
};
var U={
	d:[],
	tag:function(){
		$('#m-tags').html('');
		if(U.d.length>0){
			var k=['全部'];
			$(U.d).each(function(a,b){
				if(BE(b,'k')){
					k=$.merge(k,b.k);
				}
			});
			k=$.unique(k);
			$(k).each(function(a,b){
				var i=$('<input>');
				i.attr('type','button');
				i.val(b);
				$('#m-tags').append(i);
				i.click(function(){
					$('#m-main').html('');
					U.list('t DESC',b==='全部'?'':$(this).val());
				});
			});
		}
	},
	zero:function(num, n) {
		if(!n){
			n=2;
		}
		return ("0000000000000000"+num).substr(-n);  
	},
	date:function(n){
		if(n){}else{
			n=new Date();
			n=n.getFullYear()+"-"+U.zero(n.getMonth())+"-"+U.zero(n.getDate())+" "+U.zero(n.getHours())+":"+U.zero(n.getMinutes())+":"+U.zero(n.getSeconds());
		}
		return n;
	},
	add:function(u,t,z,a){
		var d={'p':'','d':'','u':'','t':'','b':''},l,k=[],s=$('<SPAN>');
		for(var i in d){
			if(i==='u'){
				if(U.isURL(u)){
					d[i]=$('<a>');
				}else{
					d[i]=$('<div>');
					d.u.attr('contenteditable','true');
				}
			}else{
				d[i]=$('<div>');
			}
		}
		d.u.html(u);
		d.u.attr('href',(u.substr(0,4)==='http'?u:'//'+u));
		d.u.attr('target','_blank');
		d.d.append(d.u);
		d.d.append(d.t);
		if(t){
			k=$.unique(t.split(' '));
		}
		k.push('X');
		l=k.length-1;
		$(k).each(function(a,b){
			var i=$('<input>');
			i.attr('type','button');
			i.val(b);
			if(a===l){
				d.b.append(i);
				i.click(function(){
					U.remove($(this));
				});
			}else{
				d.t.append(i);
				i.click(function(){
					$('#m-main').html('');
					U.list('t DESC',$(this).val());
				});
			}
		});
		s.html(z);
		d.t.append(s);

		d.p.append(d.d);
		d.p.append(d.b);
		d.d.addClass('pure-u-11-12');
		d.b.addClass('pure-u-1-12');

		$('#m-main').prepend(d.p);

		if(a){
			k.pop();
			U.d.unshift({"u":u,"k":k,"t":U.date()});
			U.save();
		}
	},
	remove:function(p){
		var p=p.parent().parent(),u,z;

		q=p.find('div:first');
		u=q.find(':first-child').html();
		z=q.find('span').html();
		$(U.d).each(function(a,b){
			if(b.u===u && b.t===z){
				U.d.splice(a,1);
				return false;
			}
		});
		p.remove();
		U.tag();
		U.save();
	},
	list:function(c,t){
		if(U.d){
			U.d.sort(function(a, b) {
				var d;
				if(c==='t'){
					d=new Date(a[c]).getTime()-new Date(b[c]).getTime();
				}else{
					d=a[c]-b[c];
				}
				return d;
			});

			if(c.split(' ')[1]==='DESC'){
				U.d.reverse();
			}

			$(U.d).each(function(a,b){
				if(t){
					if($.inArray(t,b.k)<0){
						return true;
					}
				}
				U.add(b.u,(BE(b,'k')?b.k.join(' '):''),b.t);
			});
		}
	},
	load:function(){
		$('#m-main').html('');
		if(store.get('d')){
			U.d=store.get('d');
			U.list('t DESC');
		}
		U.tag();
	},
	save:function(){
		store.set('d',U.d);
		U.sysn('save');
	},
	sysn:function(a){
		var uid=store.get('uid'),i=store.get('i'),b=a;
		if(uid && i){
			$.post('api.php',{uid:uid,d:{d:U.d},action:b},function(r){
				if(BE(r,'d')){
					if(b==='load'){
						if('undefined' !== r.d){
							$('#m-main').html('');
							U.list('t DESC');
							var d=r.d[0],t=new Date(d.t).getTime(),ar=[];
							$(U.d).each(function(a,b){
								var z=new Date(b.t).getTime();
								if(z>t){
									ar.push(b);
								}else{
									return false;
								}
							});
							if(ar.length>0){
								U.d=$.merge(ar,r.d);//首次登录，同步
								U.save();
							}else{
								store.set('d',r.d);
							}
							U.load();
						}
					}
				}else if('undefined' !== r.error){
					var a=r.error.split('-')[0];
					if(a==='login'){
						store.remove('i');
						store.remove('uid');
						U.tip();
					}
				}
			},'json');
		}
	},
	tip:function(){
		var uid=store.get('uid'),i=store.get('i'),s,t=$('#m-tip');
		if(uid && i){
			s='<span>'+i+'</span><span>退出</span>网址和信息自动保存到云';
		}else{
			s='<span>点此登录</span>保存网址和信息到云 不同设备可看';
		}
		t.html(s);
		t.find('span').click(function(){
			var h=$(this).html();
			if(h==='退出'){
				store.clear();
				U.d=[];
				U.load();
				U.tip();
				location.hash='';
			}else{
				var r;
				if(h==='点此登录'){
					r='https://mtf.im/mod/SSO?r='+encodeURIComponent(location.href);
				}else if(store.get('i')){
					r='https://mtf.im/'+store.get('i');
				}
				location.href=r;
			}
		});
	},
	ps:function(s) {
		if(!s){
			s=window.location.hash.substr(1);
		}
		var q= {};
		var a = (s[0] === '?' ? s.substr(1) : s).split('&');
		for (var i = 0; i < a.length; i++) {
			var b = a[i].split('=');
			q[decodeURIComponent(b[0])] = decodeURIComponent(b[1] || '');
		}
		return q;
	},
	init:function(){
		var a=U.ps();
		if(BE(a,'uid') && BE(a,'i')){
			store.set('uid',a.uid);
			store.set('i',a.i);
		}
		if(BE(a,'mtfUrl')){
			$('#m-url').val(a.mtfUrl);
		}
		if(BE(a,'mtfTag')){
			$('#m-tag').val(a.mtfTag);
		}
		U.tip();
		U.load();
		U.sysn('load');
	},
	isURL:function(s) {
		var pattern = new RegExp('^(https?:\\/\\/)?'+
		'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+
		'((\\d{1,3}\\.){3}\\d{1,3}))'+
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+
		'(\\?[;&a-z\\d%_.~+=-]*)?'+
		'(\\#[-a-z\\d_]*)?$','i');
		return s.indexOf('.')>-1?pattern.test(s):false;
	}
};
$('#m-form').submit(function(){
	var l=$('#m-url').val();
	if(l){
		U.add(l,$('#m-tag').val(),U.date(),1);
		U.tag();
	}
	return false;
});
U.init();