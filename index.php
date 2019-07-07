<!DOCTYPE html>
<html>
<head>
	<title>聚宝盆接入游乐场</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<link rel="stylesheet" href="public/style.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<body>
	<a href="#" id="scroller" style=""><span>Scroll</span></a>
	<?php include_once('config.php') ?>
	<div class="container">
		<div class="row">
			<h2 style="margin-left: auto;margin-right: auto;">准备参数prepare your order</h2>
		</div>

	<hr/>


	<form action="pay.php" method="GET" class="form" style="max-width: 500px;margin-left: auto;margin-right: auto;">
	
		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">
				merchantcode:商户代码
			</label>
			<div class="col-sm-6">
				<input type="text" name="merchant_code" value="<?= $merchant_code ?>" id="merchant_code" class="form-control">
			</div>

		</div>
		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">
				key:商户秘钥(请勿以任何形式经非安全网络明文传送此参数)
			</label>
			<div class="col-sm-6">
				<input type="text" name="key" value="<?= $key ?>" id="key" class="form-control">
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">
				Orderid(maximum length:60, unique,will be lowercase in further processing):订单号最大60长度，必须唯一,所有大写字母会被转为小写处理 
			</label>
			<div class="col-sm-6">
				<input type="text" name="orderid" value="<?= $order_id ?>" id="order_id" class="form-control">
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">
				Channel Code
			</label>
			<div class="col-sm-6">
				<select  name="channel"  id="channel_code" class="form-control">
					<option value="1" selected="true">ALIQR</option>
					<option value="2">ALIH5</option>
					<option value="3">WECHATQR</option>
					<option value="4">WECHATH5</option>
					<option value="5">UNIONQR</option>
					<option value="6">UNIONH5</option>
				</select>
			</div>
		</div>



		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">Amount(Yuan,up to 2decimal places):金额 最大支持两个小数位 </label>
			<div class="col-sm-6">
				<input type="text" name="amount" value="<?= $amount ?>" id="amount" class="form-control">
			</div>
		</div>
		<div class="form-group row">
		 <label class="col-sm-6 col-form-label">Timestamp: 时间戳</label>
		 <div class="col-sm-6">
		 	<input type="text" name="timestamp" value="<?= $timestamp ?>" id="timestamp" class="form-control">
		</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">Reference(not required, to be attached in notification):参考信息(非必要，但如果传递，聚宝盆会在异步通知时原文传递给商户) </label>
			<div class="col-sm-6">
				<input type="text" name="reference" value="<?= $reference ?>" id="reference" class="form-control">
		</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-6 col-form-label">Notification URL: asych notification url异步通知节点</label>
			<div class="col-sm-6">
				<input type="text" name="notifyurl" value="<?= $notification_url ?>" id="notifyurl" class="form-control">
		</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-6 col-form-label">Callback Url: to redirect user after payment confirmd用户跳转节点 </label>
			<div class="col-sm-6">
				<input type="text" name="httpurl" value="<?= $http_back_url ?>" id="httpurl" class="form-control">
		</div>
		</div>
		

		<div class="form-group row">
			<div class="btn-group col-sm-12">
				<button type="submit" id="submit" class="btn btn-primary  col-sm-6">尝试请求REQUEST</button>
				<a href="/" class="btn btn-secondary  col-sm-6">刷新RELOAD</a>
			</div>
		</div>

		
	</form>
	</div>

<hr>

<div class="container">

	<div class="row">
		<div class="col-md-12">

  	<ul class="nav nav-tabs" id="myTab">
		  <li class="nav-item">
		    <a class="nav-link active"  data-toggle="tab" href="#pay" >发起订单ORDER</a>
		  </li>

		  <li class="nav-item">
		    <a class="nav-link"  data-toggle="tab" href="#notification" >异步通知NOTIFICATION</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link "  data-toggle="tab" href="#query" >主动查询QUERY</a>
		  </li>

		  <li class="nav-item">
		    <a class="nav-link "  data-toggle="tab" href="#merchantwithdraw" >MerchantWithdrawal</a>
		  </li>
	</ul>

			<div class="tab-content" id="myTabContent">


    <div class="tab-pane fade show active" id="pay">
    		
    		<hr/>
    	<div class="alert alert-dark" role="alert">
		  POST json/application 至 <?= $gateway_url ?>pay
		</div>

			<ul class="alert alert-warning">
    			<li>首先准备以上参数</li>
    			<li>以下部分是根据以上参数的签名步骤实例详解</li>
    			
    		</ul>

			<form>
			  <div class="form-group ">
			    <label class="col-sm-12">签名串string to sign<code>ksort parameters, md5(urldecode(http_build_query(fields))&key)</code></label>
			    <br/>
			    <div class="col-sm-12">
			      <textarea id="tos" class="form-control" rows="3"></textarea>
			    </div>
			  </div>
			  <div class="form-group ">
			    <label class="col-sm-12">签名 sign<code>md5(string to sign )</code></label>
			    <div class="col-sm-12">
			      <textarea id="md5" class="form-control"></textarea>
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="col-sm-12">原始json报文raw json request</label>
			    <div class="col-sm-12">
			      <textarea id="json_request" class="form-control" rows="5"></textarea>
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="col-sm-12">API原始返回raw json return</label>
			    <div class="col-sm-12">
			      <textarea id="json_response" class="form-control" rows="20" placeholder="点击以上<尝试请求>得到服务器实时真实返回)"></textarea>
			    </div>
			

			    <br/>
			    <div class="form-group row">
					<div class="btn-group col-sm-12">
						<a href="#" target="_blank" id="gotocashier" class="btn btn-primary  col-sm-6" style="display: none;">Go to cashier</a>
			    		<a href="#" id="gotomobile" class="btn btn-secondary  col-sm-6" style="display: none;">Launch Mobile app</a>

					</div>
				</div>


			  </div>
			</form>
    </div>
    <div class="tab-pane fade" id="notification">
    	<div class="alert alert-dark" role="alert">异步通知会由(35.236.138.217,35.234.56.140,35.234.42.89,35.194.142.7)其中的服务器发出</div>
 
    		<ul class="alert alert-warning">
    			<li>恭喜完成订单请求部分接入</li>
    			<li>以下是根据以上参数聚宝盆服务器生成通知的实例分解过程</li>
    			<li>请于收到此通知时返回纯文本ok给我们，即使此订单已处理，不存在，或者是遭遇其他业务错误，我们对于ok的理解是你们服务器收到了我们的这个消息</li>
    			
    		</ul>
  
		<form>
			

			<div class="form-group ">
			    <label class="col-sm-12">异步通知的原始报文 <code>amount,merchant_code,order_id,status,reference,transaction_id</code></label>
			   <p>status等于 PAID 或者 SUCCESS 是已经完成付款的订单 </p>
			    <div class="col-sm-12">
			    	<textarea id="nmessage" class="form-control" rows="3" placeholder="Submit to generate"></textarea>
			    </div>
			</div>

			<hr/>
			<div class="alert alert-dark">
				签名 <Br/> 
			</div>

			<div class="form-group ">
			    <label class="col-sm-12">待签名串 <code>remove sign field. ksort($fields) then urldecode(http_build_query(fields))&key </code><br/><br/>
			    
				</label><br/>
			    <div class="col-sm-12"><textarea id="ntos" class="form-control" rows="3" placeholder="Submit to generate"></textarea></div>
			</div>
			<div class="form-group ">
			    <label class="col-sm-12">签名<code>(md5(string to sign )) </code></label><br/>
			    <div class="col-sm-12"><textarea id="nsign" class="form-control" rows="3" placeholder="Submit to generate"></textarea></div>
			</div>

			
		</form>

    </div>


    <div class="tab-pane fade" id="query">
    	<div class="alert alert-dark" role="alert">POST json/application 至 <?= $gateway_url ?>query</div>
 
    		<ul class="alert alert-warning">
    			<li>商户可使用此方法主动查询某订单的状态</li>
    			<li>orderid或transactionid两项中至少传递一项</li>
    			<li>以下是根据以上参数组成查询报文的实例详解</li>
    		</ul>
  
		<form>

			<div class="form-group ">
			    <label class="col-sm-12">待签名串<code>升序排序key值，然后建立http query+ "&" + key</code><br/><br/></label><br/>
			    <div class="col-sm-12">
			    	<textarea id="qtos" class="form-control" rows="3" placeholder="Submit to generate"></textarea>
			    </div>
			</div>

			<div class="form-group">
			    <label class="col-sm-12">签名</label><br/>
			    <div class="col-sm-12"><textarea id="qsign" class="form-control" rows="3" placeholder="Submit to generate"></textarea></div>
			</div>




			  <div class="form-group">
			    <label class="col-sm-12">原始json报文</label>
			    <div class="col-sm-12">
			      <textarea id="query_json_request" class="form-control" rows="5"></textarea>
			    </div>
			  </div>

			<hr/>
		
			
		</form>

    </div>


    <div class="tab-pane fade" id="merchantwithdraw">
    	<div class="alert alert-dark" role="alert">POST json/application 至 <?= $gateway_url ?>merchant/withdraw</div>
 
    		<ul class="alert alert-warning">
    			<li>Merchant Code: 你的merchant code</li>
    			<li>Amount: minumum of 1 cny</li>
    			<li>Message :  提款银行卡详情，请使用base64 encode</li>
    			<li>Callback URL: 提款状态异步通知目标url</li>
    			<li>Timestamp : 当前时间</li>

    			<li>Sign : md5(all parameters sorted by parameter name&merchantkey) </li>
    		</ul>
  
		<form>

			


			<div class="form-group ">
			    <label class="col-sm-12">待签名串<code>升序排序key值，然后建立http query+ "&" + key</code><br/><br/></label><br/>
			    <div class="col-sm-12">
			    	<textarea id="mwtos" class="form-control" rows="3" placeholder=""><?= htmlspecialchars($mwtos) ?></textarea>
			    </div>
			</div>

			<div class="alert ">
				Sign :  <code><?= $merchant_withrawal['sign'] ?></code>
			</div>

			<div class="form-group">
			    <label class="col-sm-12">原始json报文</label><br/>
			    <div class="col-sm-12"><textarea id="mwsign" class="form-control" rows="3" placeholder=""><?= json_encode($merchant_withrawal) ?></textarea></div>
			</div>




			<hr/>
			<div class="form-group">
			    <label class="col-sm-12">json notification <code>待签名串<code>升序排序key值，然后建立http query+ "&" + key</label><br/>
			    <div class="col-sm-12"><textarea style="height: 200px;" id="mwsign" class="form-control" rows="3" placeholder="">{
    "amount": "xx.xx",
    "merchant": "xxxxx",
    "status": "APPROVED/REJECTED",
    "timestamp": xxxxxxxxxx,
    "withdrawal_id": xxx,
    "sign": "xxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}</textarea></div>
			</div>
		
			
		</form>

    </div>


    

		</div>

	</div>

  

  </div>


<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"> </script>

 <script type="text/javascript">

 	function build_query(orderid,transid){
 		var query_params = {
 			merchant_code : $("#merchant_code").val(),
 			orderid : orderid,
 			transid : transid,
 			amount : $("#amount").val(),
 			timestamp : new Date().getTime()
 		};

 		query_params = ksort(query_params);
		var tos =  http_build_query(query_params) + "&"+ $("#key").val();
		var sign = CryptoJS.MD5(tos).toString();
		query_params.sign = sign;
 		$("#qtos").val(tos);
 		$("#qsign").val(sign);	
		$("#query_json_request").val(JSON.stringify(query_params))
 	}

 	function ksort(o) {
    return Object.keys(o).sort().reduce((r, k) => (r[k] = o[k], r), {});
	}

 	function build_notify(transid){

		var fields = {
			amount : $("#amount").val(),
			merchant_code : $("#merchant_code").val(),
			order_id :  $("#order_id").val().toLowerCase(),
			status : "PAID",
			reference : $("#reference").val(),
			transaction_id : transid
		};
		fields = ksort(fields);
		var tos =  http_build_query(fields) + "&"+ $(key).val();
		var sign = CryptoJS.MD5(tos).toString();
		fields.sign = sign;
		$("#ntos").val(tos);
		$("#nsign").val(sign);
		$("#nmessage").val(JSON.stringify(fields))
 	}

 	function jQFormSerializeArrToJson(formSerializeArr){
	 var jsonObj = {};
	 $.map( formSerializeArr, function( n, i ) {
	     jsonObj[n.name] = n.value;
	 });
	 return jsonObj;
	}
	function http_build_query(arr){
		var s= [];
		for (x in arr) {
    		s.push(x + "=" + arr[x]);
		}
		return s.join("&");
	}

 	$(document).ready(function(){

 		$('#myTab a').on('click', function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})

 		$("body").delegate(".form", "keyup", function(event) {
 			var properJsonObj = jQFormSerializeArrToJson($(this).serializeArray());
 			properJsonObj.orderid = properJsonObj.orderid.toLowerCase();
 			properJsonObj = ksort(properJsonObj);
 			var key =properJsonObj.key;
	        delete properJsonObj.key;
 			var tos=  http_build_query(properJsonObj ) + "&"+ key;
	        var sign = 	CryptoJS.MD5(tos).toString();
	        $("#md5").val(sign);
	        $("#tos").val(tos)
	        properJsonObj.sign = sign;
	        $("#nmessage").val('')
			$("#ntos").val('')
			$("#nsign").val('')
	        $("#json_request").val(JSON.stringify(properJsonObj))
	        build_notify("transiddemo")
	        build_query(properJsonObj.orderid, "transiddemo")
 		})

 		$("body").delegate(".form" , "blur" , function(){
 			
 		$(".form").trigger("keyup");
 		})

 		$(".form").trigger("blur");

 		$("body").delegate(".form", "submit", function(event) {

 			$("#gotocashier").hide();
			$("#gotomobile").hide();

	 		event.preventDefault();

	 		var properJsonObj = jQFormSerializeArrToJson($(this).serializeArray());

	      	properJsonObj.orderid = properJsonObj.orderid.toLowerCase();
	      	var url = $(this).attr('action') + "?" +http_build_query(properJsonObj);
	      	
	      	console.log(properJsonObj)

	        $.ajax({
	            type      : 'GET',
	            url       : url,
	            beforeSend : function(){
	            	$("#submit").attr("disabled", true);
	            	$("#submit").text("loading");
	            	$("#json_response").val("loading...");
	            },
	            success : function(res) {    
	            	$("#submit").text("尝试请求");
					$("#submit").removeAttr("disabled");
	            	$("#json_response").val(JSON.stringify(res.response ,undefined ,4))

	            	// if($("#redirect").val() == '1' && typeof res.response !="undefined" && typeof res.response.data !="undefined" && typeof res.response.data.qrcode !="undefined"){
	            	// 	console.log(res.response)
	            	// 	 window.location.href = res.response.data.qrcode;
	            	// }

					    $('html, body').animate({
					        scrollTop: $("#myTabContent").offset().top
					    }, 2000);
				

	            	if(typeof res.response.data.return != "undefined"){
		            	// var alipayintent= "alipays://platformapi/startapp?saId=10000007&clientVersion=3.7.0.0718&qrcode=";
		            	$("#gotocashier").attr("href",  res.response.data.return);
						// $("#gotomobile").attr("href",alipayintent+ encodeURIComponent(res.response.data.qrcode));

						$("#gotocashier").show();
						// $("#gotomobile").show();




	            	}


	            },
	            error: function(xhr, status, error) {
	               alert(error);
	               $("#submit").text("尝试请求");
	               $("#submit").removeAttr("disabled");
	            }
	        });
     
            
    	});


 	})


 </script>

 <script type="text/javascript">
 	$(document).ready(function(){ 
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#scroller').fadeIn(); 
        } else { 
            $('#scroller').fadeOut(); 
        } 
    }); 
    $('#scroller').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});

</script>
</body>
</html>


