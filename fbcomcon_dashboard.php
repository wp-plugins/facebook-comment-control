<?php

	//do not touch - Access Token
    if(!get_option('manual_token')){
		$access_token = substr(file_get_contents('https://graph.facebook.com/oauth/access_token?type=client_cred&client_id='.get_option('fbcomcon_app_id').'&client_secret='.get_option('fbcomcon_secret')), 13);
	}
	else{
		$access_token = get_option('fbcomcon_custom_token');
	}
	
	//get uid from cookie
	$cookie_name = 'fbs_'.get_option('fbcomcon_app_id');
	$cookie_content = $_COOKIE[$cookie_name];
	parse_str($cookie_content);
	$logged_in_uid = $uid;
	$logged_in_uid = ereg_replace("[^0-9]", "", $logged_in_uid);
	
	include_once('check_options.php');

?>

<div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({appId: '<?php echo get_option("fbcomcon_app_id");?>', status: true, cookie: true, xfbml: true});

	FB.getLoginStatus(function(response) {
		if (response.session) {
		 loadComments();
		 $('#login').hide();
		 $('#logout').show();
		 FB.api('/me', function(response) {
		 $('div.login_header div.menu').prepend("<span><?php _e('Logged in as','fbcomcon');?></span>");
		 $('div.login_header div.menu span').after("&nbsp;" + response.name);
		 });
		}
		else {
		 $('#logout').hide();
		 $('#login').show();
		 $('div.login_header div.menu').prepend("Not Connected <span>Please login.</span>");
		}
	});


      $('#login').bind('click', function() {
        FB.login(function(response){window.location.reload();});
      });

      $('#logout').bind('click', function() {
        FB.logout(function(response){window.location.reload();});
      });

};

(function() {
	var e = document.createElement('script'); e.async = false;
	e.src = document.location.protocol +
	'//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
}());
</script>

<div class="wallkit_frame clearfix">
<div class="login_header">
<div class="img"><fb:profile-pic uid="loggedinuser" size="square" width="50" height="50" /></div>
<div class="menu"><a id="login" href="#" style="display:none;"><?php _e('Login','fbcomcon');?></a><a id="logout" href="#" style="display:none;"><?php _e('Logout','fbcomcon');?></a></div>
</div>
<div class="comment_body" id="fbcomments"></div>
</div>

<script type="text/javascript">

if ('<?php echo $login_header;?>' == 'false'){
	$(document).ready(
		function(){
			$('div.login_header').hide();
		}
	);
};

if ('<?php echo $comments_count;?>' == 'true'){
	function commentscount(){
		var totalcount = $("div.wallkit_post").size();
		if (totalcount > 0) {
			$("div.post_counter").text(""+totalcount+" <?php _e('Comments','fbcomcon');?>.");
		}
	};
}


function showComments(start) {
			start |= 0;

			var per_page = '<?php echo $comments_limit;?>';
			if (per_page == '-1'){var per_page = '99999999999999999'};
			start *= per_page;
	
			var users = new Array();
			var comments = new Array();
			FB.api(
				{
					method: 'fql.multiquery',
					queries: {
						comments: 'SELECT fromid, text, id, time, username, xid, object_id FROM comment WHERE xid IN (SELECT xid FROM comments_info WHERE app_id = <?php echo get_option("fbcomcon_app_id");?>) ORDER BY time desc LIMIT '+start+','+per_page,
						users: 'SELECT id, name, url FROM profile WHERE id IN (SELECT fromid FROM #comments)'
						
					}
				},
				function(response) {
					comments = response[0].fql_result_set
					for (i=0;i<response[1].fql_result_set.length;i++) {
						users[response[1].fql_result_set[i].id] = response[1].fql_result_set[i];
					}            

					var data = '';

					if (comments.length == 0 || typeof comments.length === 'undefined') {
						data = '<h4 style="height:18px;"><?php _e('No comments','fbcomcon');?></h4>';
						limit_next_page = true;
					} else if (comments.length < per_page) {
						limit_next_page = true;
					} else {
						limit_next_page = false;
					}
			
					for (i=0;i<comments.length;i++) {
						
						// Comment Profile Image and Link
						var userimg = comments[i].fromid;
						if(userimg == '1309634065'){
							var userimg = '<span><img src="http://static.ak.fbcdn.net/rsrc.php/z5HB7/hash/ecyu2wwn.gif" class="img"></span>';
						}else{
							var userimg = '<a target="_blank" href="'+ users[comments[i].fromid].url +'" title="'+ users[comments[i].fromid].name +' - <?php _e('view profile','fbcomcon');?>."><img src="https://graph.facebook.com/'+ comments[i].fromid +'/picture" class="img"></a>';
						}

						// Comment username and Link
						var username = comments[i].fromid;
						if(username == '1309634065'){
							var username = '<span class="aname">'+ comments[i].username +'</span>';
						}else{
							var username = '<a target="_blank" href="'+ users[comments[i].fromid].url +'">'+ users[comments[i].fromid].name +'</a>';
						}

						// Comment Date and Time
						var commentdate = new Date( comments[i].time *1000);
						var curr_date = commentdate.getDate();
						var curr_month = commentdate.getMonth();
						curr_month++;
						var curr_year = commentdate.getFullYear();
						var curr_hour = commentdate.getHours();
						var curr_min = commentdate.getMinutes();
						commentdate = curr_date + "." + curr_month + "." + curr_year + " <?php _e('at','fbcomcon');?> " + curr_hour + ":" + curr_min;

						// Comment BODY text
						var commenttext = comments[i].text;
						var commenttext = commenttext.replace(/\n/g,'<br />');
						
						// Comments Message Link
						var commentmessage = comments[i].fromid;
						if(commentmessage != '1309634065' && commentmessage != <?php echo $logged_in_uid;?> ){
							var commentmessage = '<a href="http://www.facebook.com/inbox/?compose&id='+ users[comments[i].fromid].id + '" class="message" target="_blank" title="<?php _e('Message','fbcomcon');?>"><?php _e('Message','fbcomcon');?></a> | ' ;
						}
						else{
							commentmessage = '';
						}

						// Comments Delete Link
						<?php if ($logged_in_uid == get_option("fbcomcon_admin_uid")){
							echo "var commentdelete = '<a href=\"#\" onclick=\"deleteComment(\\''+comments[i].id+'\\',\\''+comments[i].xid+'\\'); return false;\" class=\"delete\" title=\"Delete\">". __('Delete','fbcomcon') ."</a> &nbsp;|&nbsp; ';";
						}
						else{ echo "var commentdelete = ''";}?>

						// Comment URL Link
						var commenturl = comments[i].xid;
						if(commenturl.substr(0,4) == 'http') {
							var commenturl = '<a href="'+unescape(comments[i].xid)+'" target="_blank"><?php _e("View Page");?></a>';
						}
						
						//Creating Content
						data +=
						'<div id="post_'+ comments[i].xid +'_'+ comments[i].id +'" class="wallkit_post">'+
						'<div class="wallkit_profilepic">'+ userimg +'</div>'+
						'<div class="wallkit_postcontent">'+
						'<h4>'+ username +
						'<span class="wall_time">'+ commentdate +'</span></h4>'+
						'<div>'+ commenttext +'</div>'+
						'<div class="wallkit_actionset">'+
						''+ commentmessage +
						''+ commentdelete +
						''+ commenturl +
						'</div>'+
						'</div>'+
						'</div>';
					}
					
					$('#fbcomments').html('<div class="wallkit_posts">' + data + '</div>');
					if ('<?php echo $paging_comments;?>' == 'true' || '<?php echo $comments_count;?>' == 'true'){
					$('div.wallkit_posts').before('<div class="wallkit_subtitle"><div class="post_counter"></div></div>');
					$('div.wallkit_posts').after('<div class="wallkit_subtitle"><div class="post_counter"></div></div>');
					}
					if ('<?php echo $paging_comments;?>' == 'true'){
					$('div.wallkit_subtitle').prepend('<div class="pager"><ul class="pagerpro"></ul></div>');
					$('div.comment_body').pajinate({items_per_page : '<?php echo $paging_limit;?>'});
					};
					if ('<?php echo $comments_count;?>' == 'true'){commentscount();};
				}
			);
		}

		var currentpage = -1;
		var limit_next_page = false;
		function loadComments(direction) {
			direction |= 1;

			if (limit_next_page && direction > 0) return false;

			currentpage += direction;
			if (currentpage < 0) {
				currentpage = 0;
				return false;
			}
	
			$('#fbcomments').html('<img src="http://static.ak.fbcdn.net/rsrc.php/z5R48/hash/ejut8v2y.gif" title="<?php _e('Loading...','fbcomcon');?>" alt="<?php _e('Loading...','fbcomcon');?>" style="width:32px; height:32px; display:block; margin:50px auto;">');
			showComments(currentpage);
		}
		
		<?php if ($logged_in_uid == get_option("fbcomcon_admin_uid")){
			echo "
				function deleteComment(commentid,commentxid) {
					if (!confirm('". __('Delete Comment','fbcomcon') ."?')) return false;

					FB.api({
						method: 'comments.remove',
						comment_id: commentid,
						xid: commentxid,
						access_token: '".$access_token."'
					},
					function(response) {
						if (!response || response.error_code) {
							alert(\"". __('ERROR: Failed to delete comment, please try again.','fbcomcon') ."\");
						} else {
							alert('". __('Comment Successfully Deleted','fbcomcon') ."');
							$(\"#post_\"+commentxid+\"_\"+commentid).slideUp(500, this.remove);
						}
					});
				}";
			}?>


// Retrieve Facebook Comments code by Gil Goldshlager
// http://facebook.com/gil.goldshlager
// Thanks to 'pingflood' & 'TH_Wesley' from the Facebook developers forum
</script>