<?php 

//sae 版本连接数据库
  	mysql_connect(SAE_MYSQL_HOST_M.":".SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
	mysql_select_db(SAE_MYSQL_DB);

	mysql_query("set names utf8");
	//
	require_once "sdk.php";
	$jssdk = new JSSDK("wx580e2fc5aa425b45","8e17cbdb1b33070a81f2de88d99f5ff7");

	$signPackage = $jssdk->GetSignPackage();

	//获取接口方法
	function httpGet($url) {
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
	    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    $res = curl_exec($curl);
	    curl_close($curl);	
	    return $res;
	}
	//开发者信息
	$code = $_GET['code'];//用户点击链接跳转此页面，开发者获取用户code
	$appid = "wx580e2fc5aa425b45";
	$appsecret = "8e17cbdb1b33070a81f2de88d99f5ff7";

//开始获取用户信息
	//授权模式
	$api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
 	$json = httpGet($api);
 	$arr = json_decode($json,true);
 	
	//用户同意授权获取token openid 
	$openid = $arr["openid"];
	$access_token=$arr["access_token"];
	//information  通过token openid 换取用户的详细信息
	$api = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
	$json = httpGet($api);
 	$arr = json_decode($json,true);
	
	$nickname = $arr["nickname"];
	$headimgurl = $arr["headimgurl"];
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>countMoney</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/animate.css"/>
	</head>
	<body>
		<div class="wrap">
		<div class="menu">
			<img class="menu1" src="images/rankBtn.png"/>
			<img class="menu2" src="images/ruleBtn.png"/>
			<img class="menu2" src="images/prizeBtn.png"/>
			<img class="menu4" src="images/userBtn.png"/>
		</div>
		<!-- 整个遮罩层 -->
		<div class="mask">
			<img src="images/close.png" class="close"/>
			<div class="frame">
				<!-- 注册信息的遮罩层 -->
				<div class="content submitData" >
					<img src="images/inputInf.png" class="inputInf"/>
					<p>个人信息将作为领奖依据</p>
					<p>请认真填写喔</p>
					<div class="input">
						<label for="name">姓名</label>
						<input type="text" id="name" />
					</div>
					<div class="input">
						<label for="tel">电话</label>
						<input type="tel" id="tel" />
					</div>
					<button id="submit">提交并开始游戏</button>
				</div>
				<!-- 活动规则的遮罩内容 -->
				<div class="content rule" >
					<h2>活动规则</h2>
					<p>1、每人有多次游戏机会，但成绩只能提交一次，且提交之后不能更改！</p>
					<p>2、提交成绩时要提供姓名及手机号码作为兑奖凭证，因用户本人未在规定时间内提供正确的手机号码造成的奖品损失，由用户个人承担。</p>
					<p>3、活动时间为2016年5月11日-5月19日24:00，活动结束后将在“雾灵山庄”微信公布中奖名单。</p>
					<p>4、获奖规则：系统将根据大家提交的成绩，按照由多到少的规则进行排行，排名第1的网友将获得一等奖，排名第2-第21位的网友将分获二等奖，以此类推。</p>
					<p>5、奖品的发放：活动结束后，将由工作人员与您取得联系，并将相应的卡券编号发送到您提供的手机号码上。</p>
				</div>
				<!-- 活动奖品的遮罩内容 -->
				<div class="content rule prize" >
					<h2>活动奖品</h2>
					<p>一等奖1人：价值1488元7号楼1晚豪华标间免费房券1张，并可享康体项目3折优惠；</p>
					<p>二等奖20人：100元订房代金券每人1张，并可享康体项目4折优惠；</p>
					<p>三等奖50人：50元订房代金券每人1张，并可享康体项目5折优惠。</p>
					<p>奖品的有效期：2016年5月20日至6月15日（周五、周六及法定节假日不可用）</p>
				</div>
				<!-- 奖券使用说明的遮罩内容 -->
				<div class="content rule prize usePrize" >
					<h2>奖券使用说明</h2>
					<p>1、奖品的使用：请务必至少提前一周致电010-81027788或81027799进行预约，并于入住时向前台服务人员出示您手机上收到的卡券编号即可使用（需同时验证获奖人姓名与手机号码）。</p>
					<p>2、代金券仅适用于线下门市价入住客房消费使用，不适用于通过携程或微信等其他线上渠道预定使用。</p>
					<p>3、免费房安排的房间将视当时酒店排房情况而定，如您所预约的时段预订已满，将与您协商调整入住时间。</p>
					<p>4、免费房券及代金券不得用于除订房外其他产品消费，不得与酒店其他优惠折扣或礼券同时使用，且不予退换、兑换现金或找赎。</p>
					<p>5、对于恶意刷奖者和作弊者，主办方有权取消其兑奖资格。</p>
				</div>
				<!-- 数钱榜的遮罩内容 -->
				<div class="content rank">
					<img src="images/rankTitle.png" class="rankTitle"/>
					<div id="wrapper">
						<ul>
						<?php 					
							$query= "SELECT * FROM countMoney ORDER BY score desc";
							$result = mysql_query($query);
							$num=0;
							while($row = mysql_fetch_assoc($result)){
								$num++;
								if($num>=10){
									break;
								}		
						 ?>
							<li>
								<span>
									<img src="<?php echo $row['headimgurl'];?>"/>
								</span>
								<span>
									<?php echo $row['nickname']; ?>
								</span>
								<span>
									<?php echo $row['score'];?>分
								</span>
							</li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- 第一页-->
		<div class="pageOne">
			<img src="images/challenge.png" class="animated bounceInDown challenge "/>
			<img src="images/title.png" class="title animated lightSpeedIn"/>
			<img src="images/money.png" class="money"/>
			<img src="images/start.png" class="start animated flash"/>
			<img src="images/hand.png" class="hand animated flash"/>
			<img src="images/wall.png" class="wall"/>
		</div>
		<!-- 第二页-->
		<div class="pageTwo" >
			<div class="slideWord">
				<img src="images/redBorder.png"/>
				<div class="inner">
					<div class="imgWrap">
						<img src="images/word1.png" class="worldSlide"/>
						<img src="images/word2.png"/>
						<img src="images/word3.png"/>
					</div>					
				</div>					
			</div>
			<div class="point">
			 	<span>0</span>
				<span>0</span>
				<span>0</span>
				<span>10</span>
			</div>
			<img src="images/money2.png" class="moneyslide"/>
			<!--<img src="images/upMoney.png"  class="moneyslide moneyslide2"/>-->
			<div class="moneyWrap" id="target">
				<img src="images/money2.png"/>
			</div>
			<img src="images/bigHand.png" class="bigHand"/>
			<img src="images/wall.png" class="wall"/>
		</div>
		<!-- 第三页-->
		<div class="pageThree">
			<img class="congratulate" src="images/congratulate.png"/>
			<div class="getMoney">
				￥ <span class='upoint'></span>00
				<p>没办法！你已经强到没有对手了</p>
				<div>我的辉煌战绩:￥<span class='upoint'></span>00  当前排名：第<span class='paiming'></span>位</div>
			</div>
			<a href="access.html"><img class="again" src="images/again.png"/></a>
			<img class="shareBtn" src="images/shareBtn.png"/>
			<div class="shareWord">
				<img src="images/shareWord.png"/>
			</div>
		</div>
		</div>
		<!-- 图片的加载层 -->
		<div class="loading">
			<span></span>
		</div>
	</body>
	<script src="js/iscroll.js" type="text/javascript"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script src="js/touch.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(){
			//图片预加载
			var imgArr=[
			'images/again.png',
			'images/bigHand.png',
			'images/challenge.png',
			'images/clock.png',
			'images/close.png',
			'images/congratulate.png',
			'images/hand.png',
			'images/inputInf.png',
			'images/money.png',
			'images/money2.png',
			'images/page1.jpg',
			'images/page2.jpg',
			'images/page3.jpg',
			'images/prizeBtn.png',
			'images/rankBtn.png',
			'images/rankTitle.png',
			'images/redBorder.png',
			'images/ruleBtn.png',
			'images/shareBtn.png',
			'images/shareWord.png',
			'images/start.png',
			'images/title.png',
			'images/top1.png',
			'images/top2.png',
			'images/top3.png',
			'images/upMoney.png',
			'images/userBtn.png',
			'images/wall.png',
			'images/word1.png',
			'images/word2.png',
			'images/word3.png',
			'images/yellowBg.png'
			];
			
			var L = imgArr.length;
			var startNum = 0;
			for(var i =0;i<L;i++){
				var imgObj = new Image();
				imgObj.src = imgArr[i];
				imgObj.onload = function(){
					startNum++;
					var percent = (startNum/L).toFixed(2)*100+"%";
					$('.loading span').html(percent);
					if(startNum == L-1){
						$(".loading").hide();
					}
				}
			}		
			//关闭mask
			$('.close').get(0).addEventListener('touchend',function(){
				$('.mask').fadeOut(200);
				$('.content').hide();
			});
			//点击开始 通过openid查看当前用户是否存在于数据库
			var haveLogin = <?php 
				$query = "SELECT * FROM countMoney WHERE openid='{$openid}'";
				$result = mysql_query($query);
				if(mysql_num_rows($result)>0){
					echo "true";
				}else{
					echo "false";
				}
			 ?>;
			$('.start').eq(0).get(0).addEventListener('touchend',function(){
				if(haveLogin==true){
					//进入游戏页面
					//如果存在就可直接进入游戏
					$(".pageOne").hide();
					$('.pageTwo').show();
					$('.mask,.menu').hide();
				}else{
					//不存在就弹出填写信息的提示框
					$('.mask').fadeIn(200);
					$('.submitData').show();
				}
			});
			//点击各个按钮 4个按钮出现不同的弹层
			//数钱榜
			$(".menu img:nth-child(1)").get(0).addEventListener('touchend',function(){
				$('.mask').fadeIn(200);
				$('.rank').show();
				//排行榜滚动条
				myScroll = new iScroll('wrapper');
			});
			//活动规则
			$(".menu img:nth-child(2)").get(0).addEventListener('touchend',function(){
				$('.mask').fadeIn(200);
				$('.rule').eq(0).show();
			});
//			touch.on( "body", "touchend", "#menu3", function(ev){
//			//活动奖品
			$(".menu img:nth-child(3)").get(0).addEventListener('touchend',function(){
				$('.mask').fadeIn(200);
				$('.prize').eq(0).show();
			});
			//奖券使用说明
			$(".menu img:nth-child(4)").get(0).addEventListener('touchend',function(){
				$('.mask').fadeIn(200);
				$('.usePrize').show();
			});

			//填写完资料提交资料开始游戏
			$("#submit").get(0).addEventListener('touchend',function(){
				$('#name,#tel').blur();
				var name = $("#name").val();//用户填写的名字
				var tel = $("#tel").val();//用户填写的手机号
				var nameTest = /^(\w{2,5}|[\u4e00-\u9fa5]{2,5})$/g.test(name);//验证名字
				var telTest = /^(\d{11})$/g.test(tel);//验证手机
				if(nameTest&&telTest){   //数据验证 通过进入游戏
					//进入游戏页面
					$(".pageOne").hide();
					$('.pageTwo').show();
					$('.mask,.menu').hide();				
				}else{
					alert("请输入正确信息");
				}
			});		
			
			//开始玩游戏
			var bol = true;
			var start = true;
			//阻止拖拽 默认事件
			$('body').on('touchmove', function (event) {
				event.preventDefault();
			});
			var N = 0;//分数
			
			var pageTwo = document.querySelector(".pageTwo");
			//数钱
			touch.on( "#target","swipeup",function(ev){
				if(start){
					if(bol){
						$(".bigHand").remove();
						bol = false;
						countTime();
					}
					for(var i = 0 ;i<$('.moneyslide2').length;i++){
						if($('.moneyslide2').eq(i).offset().top<-200){
							$('.moneyslide2').eq(i).remove();
						}
					}
					//创建图片
					var img = document.createElement('img');
					img.src = "images/upMoney.png";
					img.className="moneyslide moneyslide2 moneyFly";
					pageTwo.appendChild(img);
					//加分数 顺带补零 001-050-100格式
					N++;
					str = String(N);
					if(str.length ==1){ str = "0"+"0"+str;}
					if(str.length ==2){ str = "0"+str;}
					for(var j = str.length-1;j>=0;j--){
						$(".point span").eq(j).html(str[j]);
					}
				}
				ev.preventDefault();
			} );
			
			//分享图层
			var shareBtn = document.querySelector('.shareBtn');
			shareBtn.addEventListener('touchend',function(){
				$(".shareWord").show();
			});
			//分享层点击结束时候遮罩消失	
			var share = document.querySelector('.shareWord');
			share.addEventListener('touchend',function(){
				$(this).hide();
			})
			//倒计时结束关闭定时器，数据提交submit.php
			function countTime(){
				var timer = null;
				var allTime = 20;
				var slideHeight = document.querySelector('.worldSlide').height+7;
				var L = 0;
				timer=setInterval(function(){
					allTime--;
					$(".point span").eq(3).html(allTime);
					if(allTime<=0){
						//游戏结束
						start = false;
						clearInterval(timer);
						$.ajax({
							type:"get",
							url:"http://hanhui.applinzi.com/countMoney/submit.php",
							data:{
								openid:'<?php echo $openid?>',
								nickname:'<?php echo $nickname?>',
								headimgurl:'<?php echo $headimgurl?>',
								username:$("#name").val(),
								tel:$("#tel").val(),
								score:N
							},
							dataType:'json',
							async:true,
							success:function(json){
								//提交数据  接受成功前台需要的响应
								if(json.code!=10){
									//前台写入分数与结果 
									$('.upoint').html(N);
									$('.paiming').html(json.pw);
									$('.pageTwo').hide();
									$('.pageThree').show();
									
								}else{
									//
									alert(json.msg);
								}
							},
							error:function(json){
								//返回去错误信息
								alert(json.msg);
							}
						});		
					}
					if(allTime%5==0){
						L>=2?L=0:L++;
						$(".imgWrap").animate({
							top:-L*slideHeight
						},200);
					}
				},1000);
			}
			//微信分享的相关配置
			wx.config({
			    debug: true,
			    appId: '<?php echo $signPackage["appId"];?>',
			    timestamp: <?php echo $signPackage["timestamp"];?>,
			    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			    signature: '<?php echo $signPackage["signature"];?>',
			    jsApiList: [
			      //所有要调用的 API 都要加到这个列表中
			      "onMenuShareTimeline"
			    ]
			});
			//配置成功分享调用
			wx.ready(function () {
				wx.onMenuShareTimeline({//分享朋友圈
				    title: '数钱', // 分享标题
				    link: 'http://1.hanhui.applinzi.com/webchat/access.html', // 分享链接
				    imgUrl: 'http://1.hanhui.applinzi.com/webchat/images/money.png', // 分享图标
				    success: function () { 
				        // 用户确认分享后执行的回调函数
				        alert('分享成功');
				    },
				    cancel: function () { 
				        // 用户取消分享后执行的回调函数
				        alert('cancel');
				    }
				});
			})		
		});
		
	</script>
</html>
