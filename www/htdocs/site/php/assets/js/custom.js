$(document).ready(function(){
	//lets style up the images to add border radius
	var imgw = $(".profile.img a.pr-img img").width();
	var imgh = $(".profile.img a.pr-img img").height();
	if(imgh >= 80){
		$(".profile.img a.pr-img img").css('border-radius','80px');
	} else {
		$(".profile.img a.pr-img img").css('border-radius',imgw+'px');
	}
	var ftr_h = $(".feature-author .featured-img img").height();
	var ftr_w = $(".feature-author .featured-img img").width();
	//$(".feature-author .featured-img img").css('border-radius',ftr_h+'px '+ftr_w+'px');
	var ph = $(".col-md-12.profile_img img").height();
	var pw = $(".col-md-12.profile_img img").width();
	$(".col-md-12.profile_img img").css('border-radius',pw+'px');
	
	$(".top-for").click(function(){
		var v = $(this).find('[type="radio"]').val();
		if(v == 'A'){
			$(".user-to-top").slideDown();
		} else {
			$(".user-to-top").slideUp();
		}
	});
	$(".withdr-form .method").change(function(){
		var v = $(this).val();
		if($(".selected-method").hasClass('hide')){
		} else {
			$(".selected-method").addClass('hide');
		}
		$(".selected-method").css('display','none');
		$.ajax({
			type:'GET',
			url: 'ajax_calls/withdraw_method.php?m='+v,
			success:function(d){
				$(".selected-method").html(d);
				$(".selected-method").removeClass('hide');
				$(".selected-method").css('display','block');
			}
		});
	});
	$(".mobile-toggle a").click(function(e){
		e.preventDefault();
		if($(this).hasClass('open')){
			$(this).removeClass('open');
			$(".header .header-navigation").slideUp();
		} else {
			$(this).addClass('open');
			$(".header .header-navigation").slideDown();
		}
	});
	$(".sidebar-toggle a").click(function(e){
		e.preventDefault();
		if($(this).hasClass('open')){
			$(this).removeClass('open');
			$(".the-sidebar").removeClass('block');
			//$(".the-sidebar").css('display','none');
		} else {
			$(this).addClass('open');
			$(".the-sidebar").addClass('block');
			//$(".the-sidebar").css('display','block');
		}
	});
	$(".rateit").click(function(){
		var v = $(this).find('.rateit-range').attr('aria-valuenow');
		var bid = $(this).attr('bid');
		var u = 'ajax_calls/rate_book.php?bid='+bid+'&r='+v;
		$.ajax({
			type:'GET',
			url:u,
			success:function(d){
				//window.location = document.URL;
			}
		});
	});
	$(".cr-change").click(function(e){
		e.preventDefault();
		c = $(this).text();
		$.ajax({
			type:'GET',
			url:'ajax_calls/change_currency.php?c='+c,
			success:function(d){
				window.location = document.URL;
			}
		});
	});
	$(".review-form").click(function(e){
		e.preventDefault();
		$(".reviews-form").removeClass('open');
		if($(".reviews-form").hasClass('open')){
			$(".reviews-form").removeClass('open');
			$(".reviews-form").slideUp();
		} else {
			$(".reviews-form").addClass('open');
			$(".reviews-form").slideDown();
		}
	});
	$(".book").click(function(){
		$(".modal-body").html('<center><i class="fa fa-spinner fa-spin" style="font-size:40px;padding-top:40px;padding-bottom:40px;"></i></center>');
		var id = $(this).attr('data-id');
		$(".modal-title").html('');
		if($(this).hasClass('buy')){
			var act = 'buy';
			var u = 'ajax_calls/buy_book.php?a='+act+'&bid='+id;
			$(".modal-title").html('Buy this book');
		} else if($(this).hasClass('sub')){
			var act = 'sub';
			var u = 'ajax_calls/buy_book.php?a='+act+'&bid='+id;
			$(".modal-title").html('Rent to this book');
		} else if($(this).hasClass('wishlist')) {
			var act = 'wish';
			var u = 'ajax_calls/add_wishlist.php?bid='+id+'&a='+act;
			$(".modal-title").html('Add this book to wishlist');
		} else if($(this).hasClass('like')) {
			var act = 'like';
			var u = 'ajax_calls/like_book.php?a='+act+'&bid='+id;
			$(".modal-title").html('Like this book');
		} else if($(this).hasClass('recommend')) {
			var act = 'recommend';
			var u = 'ajax_calls/recommend_book.php?a='+act+'&bid='+id;
			$(".modal-title").html('Recommend this book');
		}
		$.ajax({
			type:'GET',
			url:u,
			success:function(d){
				$(".modal-body").html(d);
				if((act == 'wish' && d.indexOf('added to your wishlist') !== -1) || (act == 'recommend' && d.indexOf('success') !== -1)){
					window.location = document.URL;
				}
			},
			error:function(a,b,c){
				var status = a.status;
				if(status == 404){
					$(".modal-body").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Connection error. Trying again..</div>');
					setTimeout(function(){$(this).trigger('click');$(".modal").modal('close')},'2000');
				}
			}
		});
	});
	$(".confirm").click(function(e){
		e.preventDefault();
		$(".alert.alert-info").html('<center><i class="fa fa-spinner fa-spin" style="font-size:45px;padding-top:20px;padding-bottom:20px;"></i></center>');
		var bid = $(this).attr('bid');
		var act = $(this).hasClass('rent') ? 'rent' : 'buy';
		$.ajax({
			type:'GET',
			url:'ajax_calls/buy_rent.php?bid='+bid+'&act='+act,
			success:function(d){
				$(".alert.alert-info").html(d);
				if(act == 'rent'){
					if(d.indexOf('successfully') !== -1){
						/*var read_url = 'read.php?bid='+bid;
						var win = window.open(read_url, '_blank');
						win.focus();*/
						window.location = 'account?subs';
					}
				} else {
					if(d.indexOf('successfully') !== -1){
						window.location = document.URL;
					}
				}
			}
		});
	});
	$(".list-group-item.user-m").click(function(e){
		e.preventDefault();
		t = $(this).find('a').attr('href').substr(1);
		$(".loading").css('display','block');
		$(".loading").css('top','30px;');
		$(".list-group-item").removeClass('active');
		$(this).addClass('active');
		if($(".sidebar-toggle a").hasClass('open')){
			$(".sidebar-toggle a").removeClass('open');
			$(".the-sidebar").removeClass('block');
		}
		if(t == 'dash'){
			var u = 'dashboard_ajax.php';
		} else {
			if(t == 'story'){
				var u = 'ajax_calls/user_books.php?t='+t+'&mystory';
			} else if(t == 'refs'){
				var u = 'ajax_calls/user_refs.php';
			} else {
				var u = 'ajax_calls/user_books.php?t='+t;
			}
		}
		$.ajax({
			type:'GET',
			url:u,
			success:function(d){
				$(".book-view").html(d);
				$(".loading").css('display','none');
			}
		});
	});
	$(".pay-method .radio").click(function(){
		var v = $(this).find('[type="radio"]').val();
		if(v == 'mm'){
			$(".mm-form").slideDown('slow');
			$(".cc-form").slideUp('slow');
		} else {
			$(".mm-form").slideUp('slow');
			$(".cc-form").slideDown('slow');
		}
	});
	$(".nw .radio").click(function(){
		var v = $(this).find('[type="radio"]').val();
		if(v.indexOf('pesapal') != -1){
			$(".pesapal-email").css('display','block');
		} else {
			$(".pesapal-email").css('display','none');
		}
	});
	$(".dep-btn").click(function(){
		$(this).val('processing transaction...');
	});
	$(".chat-form").keyup(function(event){
		if(event.keyCode == 13){
			$(this).submit();
		}
	});
	$(".chat-form").submit(function(e){
		e.preventDefault();
		formData = $(this).serializeArray();
		postURL = $(this).attr('action');
		var lastID = $(".lastid").text();
		var txt = $('.chat-form textarea').val();
		if(txt.length > 0){
			$.ajax({
				type:'POST',
				data:formData,
				url:postURL,
				success:function(d){
					$('.chat-form textarea').val('');
				}
			});
		}
	});
	$(".ajax-form").submit(function(e){
		e.preventDefault();
		formData = $(this).serializeArray();
		postURL = $(this).attr('action');
		$(".status").html('<center><i class="fa fa-spinner fa-spin" style="font-size:45px;padding-top:20px;padding-bottom:20px;"></i></center>');
		$.ajax({
			type:'POST',
			data:formData,
			url:postURL,
			success:function(d){
				if(d == 'Y' || d == 'N' || d == 'A'){
					if(d == 'Y'){
						if(postURL.indexOf('_next') == -1){
							window.location = 'register';
						} else {
							window.location = 'register?_next='+postURL.substr(postURL.indexOf('=')+1);
						}
					} else if(d == 'N') {
						if(postURL.indexOf('_next') == -1){
							window.location = 'register2';
						} else {
							window.location = 'register2?_next='+postURL.substr(postURL.indexOf('=')+1);
						}
					} else if(d == 'A') {
						if(postURL.indexOf('_next') == -1){
							window.location = 'register_agent';
						} else {
							window.location = 'register_agent?_next='+postURL.substr(postURL.indexOf('=')+1);
						}
					}
				} else {
					$(".status").html(d);
					window.location = document.URL;
				}
			},
		});
	});
	$("#uname").keyup(function(){
		var v = $(this).val();
		$(".res").html('');
		$(this).removeClass('border-color-red');
		if(v.length > 0){
			$.ajax({
				type:'GET',
				url: 'ajax_calls/check_username.php?u='+v,
				success:function(res){
					if(res){
						$(".res").html(res);
						$(this).addClass('border-color-red');
					}
				}
			});
		}
	});
	$(".edit-school").click(function(e){
		e.preventDefault();
		$(".school-info").css('display','none');
		$(".school-form").css('display','block');
	});
	$("#s_loc").change(function(){
		var c = $(this).val();
		$.ajax({
			type:'GET',
			url:'ajax_calls/get_states.php?c='+c,
			success:function(c_list){
				$("#city").html('<option value="">Select</option>'+c_list);
			}
		});
	});
	$("#loc").change(function(){
		var c = $(this).val();
		$.ajax({
			type:'GET',
			url:'ajax_calls/get_cc.php?c='+c,
			success:function(d){
				$("#p_phone").val('+'+d);
			}
		});
	});
	$("#city").change(function(){
		var c = $("#s_loc").val();
		var s = $(this).val();
		$.ajax({
			type:'GET',
			url:'ajax_calls/get_schools.php?c='+c+'&s='+s,
			success:function(c_list){
				$("#schools select").html('<option value="">Select</option>'+c_list);
			}
		});
	});
	$("#change-cap").click(function(e){
		e.preventDefault();
		$.ajax({
			type:'GET',
			url:'get_captcha.php',
			success:function(d){
				$(".captcha").html(d);
			}
		});
	});
	$(".request-author").click(function(e){
		e.preventDefault();
		$.ajax({
			type:'GET',
			url:'ajax_calls/request_author.php',
			success:function(d){
				window.location = document.URL;
			}
		});
	});
	$(".request-agent").click(function(e){
		e.preventDefault();
		$.ajax({
			type:'GET',
			url:'ajax_calls/request_agent.php',
			success:function(d){
				window.location = document.URL;
			}
		});
	});
	$(".in-notifications").click(function(){
		$.ajax({
			type:'GET',
			url:'ajax_calls/update_notifications.php',
			success:function(d){
				$(this).find('.badge.badge-danger').text('0');
			}
		});
	});
	var url = document.URL;
	if(url.indexOf('/register') != -1 || url.indexOf('/login') != -1){
		$(".main .container form input:visible:enabled:first").focus();
	}
});
function getMessageCount(){
	$.ajax({
		type:'GET',
		url:'ajax_calls/msg_count.php',
		success:function(data){
			if(data.length > 0){
				$(".msg_count_new").html(data);
				$(".msg_count_new_sidebar").html('<span class="badge badge-danger msg_count_new" style="font-size: 10px !important;">'+data+'</span>');
			}
		}
	});
}
var h = $(document).height();
var ex = $(".footer").height() +  $(".header").height() + $(".pre-header").height() + $(".pre-footer").height() + $(".steps-block").height() + 200;
var body_h = h - ex;
$(".main").css('min-height',ex+'px');