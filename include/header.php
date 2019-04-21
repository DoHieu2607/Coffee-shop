<style>
	#nav-menu-container ul li a:hover{
	color: #FF9933;
	text-decoration:none}
	.dangnhap a{color:#FFFFFF;}
	.dangnhap a:hover{
	color: #FF9933;
	text-decoration:none;
	}
	.dropdown a{color:#FFFFFF}
	.dropdown{position:relative;}
	.dropdown ul .dropdown-menu
	{
		display:absolute;
		min-width:160px;
		display:none;
		
	}
	.dropdown ul .dropdown-menu li{
		display:block !important;
		white-space:nowrap;
		color:#FFFFFF;
	}
	.dropdown ul{
	background-color: #FFFFFF;
	color:black;
	}
	.dropdown a:hover{text-decoration:none;}
	.dropdown a:focus{text-decoration:none;}
	.dropdown ul li{
		padding-left:10px;
		
		font-size:14px;
		color:#FFFFFF;
	}
	.dropdown .dropdown-menu li button{
		position: relative;
		height:35px;
		width:140px;
		color:black;
		background-color:#FFFFFF;
		border:none;
		text-align:center;
	}
	.dropdown .dropdown-menu li:hover{
		background-color:#FF8C55;
	}
	.dropdown .dropdown-menu li button:hover{
	background-color:#FF8C55;
	color:#FFFFFF;	
	}
</style>
<div id="header">			  	
	<div class="container">
		<div class="row align-items-center justify-content-between d-flex">
			<div id="logo">
				<a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
			</div>
			<nav id="nav-menu-container">
				<ul class="nav-menu">
					<?php
						$url=$_SERVER['PHP_SELF'];
						$index=strpos($url,"index.php");
				    if($index>0){
				    	// neu la trang index
				    ?>
				    <li class="menu-active"><a href="#header">Trang chủ</a></li>
				    <li><a href="#about">Chuyện cà phê</a></li>
				    <li><a href="#coffee">Coffee</a></li>
				    <li><a href="#review">Đánh giá</a></li>
				    <?php
						}else{ //neu khong phai trang index
				    ?>
				    <li class="menu-active"><a href="<?php echo "./index.php";?>">Trang chủ</a></li>
				    <li><a href="<?php echo "./index.php";?>">Chuyện cà phê</a></li>
				    <li><a href="#coffee">Coffee</a></li>	
				    <li><a href="<?php echo "./index.php";?>">Đánh giá</a></li>
				    <?php
						}
				    ?>
				</ul>
			</nav><!-- #nav-menu-container -->
			<div>
				<a href="#cart_popup" data-toggle="modal">
					<img src="img/cart.png" style="width:40%;" />
				</a>
				 
			</div>  	
			<?php 
				if(isset($_SESSION['myname']))
				{
			?>
					<div class="dropdown">
						<a href="#" id="dropdown"><img src="img/profile.png" width="30px" height="30px"/><?php echo $_SESSION['myname'] ?></a>
							<ul class="dropdown-menu" id="dropdown-menu">
								<li><button id="profile">Thông tin cá nhân</button></li>
								
						<!-- trang admin hoac manager -->
						<?php 
						if(isset($_SESSION['role'])){
							if(strcmp($_SESSION['role'],"admin") ==0)
							{
						?>
								<li><a href="#" id="logout11">admin</a></li>
						<?php
							}
							if(strcmp($_SESSION['role'],"manager") ==0)
							{
						?>
								<li><a href="#" id="logout22">manager</a></li>
						<?php
							}
						}
						?>
						<!-- het trang admin manager -->
							<li><button id="logout" style="color:">Thoát</button></li>
						</ul>
					</div>
					<script>
					$(document).ready(function(){
						$(document).on('click','#dropdown',function(event){
							event.preventDefault()
							$(this).parent().find('#dropdown-menu').first().toggle(300);
							$(this).parent().siblings().find('#dropdown-menu').hide(300);
							
							$(this).parent().find('#dropdown-menu').mouseleave(function(){
								var thisUI = $(this);
								$('html').click(function(){
									thisUI.hide();
									$('html').unbind('click');
								});
							});
						});
					});
				</script>
			<?php }
				else
				{
			?>
				<div class="dangnhap">
					<a href="#myloginForm" data-toggle="modal">Đăng nhập</a>
				</div>
				
			<?php
				}
			?>
						
		</div>
	</div>
</div><!-- #header -->
<!-- start banner Area -->
<section class="banner-area" id="home">	
	<div class="container">
		<div class="row fullscreen d-flex align-items-center justify-content-start">
			<div class="banner-content col-lg-7">
				<h1>
					Bắt đầu ngày mới <br>
					với một ly cà phê				
				</h1>
			</div>											
		</div>
	</div>
</section>
<!-- End banner Area -->	
<!--Cart -->
<div id="cart_popup" class="modal fade"  tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-lg modal-dialog-centered " role="document"> 
		<div class="modal-content">
				<div class="col-md-12">
					<button type="button" class="close" data-dismiss="modal" style="width:40px; height:40px;">&times;</button>
				</div>
                <div class="modal-header">
                    <h4 class="modal-title" style=" font-weight:bold">Đặt hàng</h4>
                </div>
                <div class="modal-body">
					<span id="cartDetails"></span>
					<div align="right">
             			<a href="#" class="btn btn-primary" id="check_out_cart">Thanh toán</a>
			 			<a href="#" class="btn btn-default" id="clear_cart">Hủy</a>
					</div>
				</div>
					
			</div>
	</div>
</div>
<?php include("register.php") ?>
<script>
$(document).ready(function(){
load_cart_data()
function load_cart_data()
{
	$.ajax({
		url:"fetch_cart.php",
		method:"POST",
		dataType:"json",
		success:function(data)
		{
		$("#cartDetails").html(data.cart_detail);
		},
		error:function()
			{alert("Tạo giỏ hàng không thành công");}
		});
}
$(document).on('click','.them',function(){
		var product_id = $(this).attr("id");
		var product_name =$("#name"+product_id+"").val();
		var product_price =$("#price"+product_id+"").val();
		var action ="add";
		$.ajax({
			url:"xuly.php",
			method:"POST",
			data:{product_id:product_id,product_name:product_name,product_price:product_price,action:action},
			success:function(data)
			{
				load_cart_data();
				alert("Đã thêm sản phẩm!");
			},
			error:function(){alert("Thêm không thành công");}
		});
	});
$(document).on('click', '.delete', function(){
		var product_id = $(this).attr("id");
		var action = 'remove';
		if(confirm("Bạn có chắc muốn xóa sản phẩm?"))
		{
			$.ajax({
				url:"xuly.php",
				method:"POST",
				data:{product_id:product_id, action:action},
				success:function()
				{
					load_cart_data();
					
				}
			});
		}
		else
		{
			return false;
		}
	});
$(document).on('click', '#clear_cart', function(){
		var action = 'empty';
		$.ajax({
			url:"xuly.php",
			method:"POST",
			data:{action:action},
			success:function()
			{
				load_cart_data();
			}
		});
	});
$(document).on('click', '.plus', function(){
	var action = 'plus';
	var product_id = $(this).attr("id");
	$.ajax({
		url:"xuly.php",
		method:"POST",
		data:{product_id:product_id,action:action},
		success:function()
		{
			load_cart_data();
		}
	});
});
$(document).on('click', '.min', function(){
	var action = 'min';
	var product_id = $(this).attr("id");
	$.ajax({
		url:"xuly.php",
		method:"POST",
		data:{product_id:product_id,action:action},
		success:function()
		{
			load_cart_data();
		}
	});
});
$(document).on('click','#check_out_cart', function(){
	var action = 'checkout';
	$.ajax({
		url:"xuly.php",
		method:"POST",
		data:{action:action},
		success:function(data)
		{
			if(data == "no")
			{
				alert("Bạn chưa đăng nhập!");
			}
			else
			{
				window.location.href = 'checkout.php';
			}
		}
	});
});
});

</script>
	