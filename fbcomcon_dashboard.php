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
			
	/*  getting post data into java variable
	 *  Used for direct link
	 */


	$content = '';
	$count_foreach = 1;
	$myposts = get_posts('numberposts=-1');
	foreach($myposts as $post){
		$content .= '"'.$post->ID.'","'.get_permalink($post->ID).'","'.urlencode(get_permalink($post->ID)).'","'.$post->post_title.'",';
		$count_foreach++;
	}
	$myposts = get_pages('numberposts=-1');
	foreach($myposts as $pagg){
		$content .= '"'.$pagg->ID.'","'.get_page_link($pagg->ID).'","'.urlencode(get_page_link($pagg->ID)).'","'.$pagg->post_title.'",';
		$count_foreach++;
	}
	$content = substr($content, 0, -1);
?>
<script type="text/javascript">
	var postdata = [<?php echo $content;?>];
</script>

<link href="<?php echo get_option("siteurl")."/".PLUGINDIR;?>/facebook-comment-control/css/compressed.css" rel="stylesheet" type="text/css"/>
<?php if(get_option("fbcomcon_layout")=='dark'){
	echo '<link href="'.get_option("siteurl")."/".PLUGINDIR.'/facebook-comment-control/css/dark_compressed.css" rel="stylesheet" type="text/css" />';
}?>
<script src="<?php echo get_option("siteurl")."/".PLUGINDIR;?>/facebook-comment-control/js/compressed.js" type="text/javascript"></script>
<script type="text/javascript">

// Application ID# - enter your application ID# (Not API Key!) //
var appid = '<?php echo get_option("fbcomcon_app_id");?>';

// Admin ID# - enter your admin ID# (facebook profile id# in numbers, not a name id) //
var adminid = '<?php echo get_option("fbcomcon_admin_uid");?>';

// Limit - number of comments to dispaly (default is '-1' unlimit [99999999999999999]) //
var comments_limit = '<?php echo $comments_limit;?>';

// Paging - change to 'false' if you don't want pagging (default is 'true') //
var paging_comments = '<?php echo $paging_comments;?>';

// Paging Limit - number of comments per page (default is 10) //
var paging_limit = '<?php echo $paging_limit;?>';

// Count - change to 'false' if you don't want comments count (default is 'true') //
var comments_count = '<?php echo $comments_count;?>';

// Login header - change to 'false' if you want to hide the login header (default is 'true') //
var login_header = '<?php echo $login_header;?>';

// Local Date type - change to 'true' if you want the local type (default is 'false') //
var localdate = 'false';
</script>


<div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({appId: ''+appid+'', status: true, cookie: true, xfbml: true});

	FB.getLoginStatus(function(response) {
		if (response.session) {
		 loadComments();
		 $('#login').hide();
		 $('#logout').show();
		 FB.api('/me', function(response) {
		 $('div.login_header div.menu').prepend("<span>Logged in as</span>");
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

if (login_header == 'false'){
$(document).ready(function(){
$('div.login_header').hide();
});
};

if (comments_count == 'true'){function commentscount(){
var totalcount = $("div.wallkit_post").size();
if (totalcount > 0) {
	$("div.post_counter").text(""+totalcount+" <?php _e('Comments','fbcomcon');?>.");
}
};}


function showComments(start) {
			start |= 0;

			var per_page = comments_limit;
			if (per_page == '-1'){var per_page = '99999999999999999'};
			start *= per_page;
	
			var users = new Array();
			var comments = new Array();
			FB.api(
				{
					method: 'fql.multiquery',
					queries: {
						comments: 'SELECT fromid, text, id, time, username, xid, object_id FROM comment WHERE xid IN (SELECT xid FROM comments_info WHERE app_id = '+appid+') ORDER BY time desc LIMIT '+start+','+per_page,
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
						var myDate = new Date( comments[i].time *1000);
						var comment_date = myDate.toLocaleString();

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
					var commentdate = new Date(comments[i].time*1000);
					var curr_date = commentdate.getDate();
					var curr_month = commentdate.getMonth();
					curr_month++;
					var curr_year = commentdate.getFullYear();
					var a_p = "";
					var curr_hour = commentdate.getHours();
					if (curr_hour < 12){a_p = "AM";}else{a_p = "PM";}if (curr_hour == 0){curr_hour = 12;}if (curr_hour > 12){curr_hour = curr_hour - 12;}
					
					var curr_min = commentdate.getMinutes();
					if(curr_min < 10){
						curr_min = '0' + curr_min;
					}
					commentdate = curr_date + "." + curr_month + "." + curr_year + " at " + curr_hour + ":" + curr_min + " " + a_p;
					
					if (localdate == 'true'){var commentdate = comment_date};

					// Comment BODY text
					var commenttext = comments[i].text;
					var commenttext = commenttext.replace(/\n/g,'<br />');
					
					// Comments Message Link
					var commentmessage = comments[i].fromid;
					if(commentmessage != '1309634065' && commentmessage != <?php echo $logged_in_uid;?> ){
						var commentmessage = '<a href="http://www.facebook.com/inbox/?compose&id='+ users[comments[i].fromid].id + '" class="message" target="_blank" title="Message"><?php _e('Message','fbcomcon');?></a> | ' ;
					}
					else{
						commentmessage = '';
					}

					// Comments Delete Link
					<?php if ($logged_in_uid == get_option("fbcomcon_admin_uid")){
						echo "
							var commentdelete = '<a href=\"#\" onclick=\"deleteComment(\\''+comments[i].id+'\\',\\''+comments[i].xid+'\\'); return false;\" class=\"delete\" title=\"Delete\">". _e('Delete','fbcomcon') ."</a> &nbsp;|&nbsp; ';";
					}
					else{ echo "var commentdelete = ''";}?>

					// Comment URL Link
					var commenturl = comments[i].xid;
					var count_foreach = 1;
					var count_arr = 0;
					var post_id = '';
					var post_url = '';
					var post_enc_url = '';
					var post_title = '';
					while (count_foreach <= <?php echo $count_foreach;?>){
						var post_id = count_arr;
						var post_url = count_arr+1;
						var post_enc_url = count_arr+2;
						var post_title = count_arr+3;
						if (commenturl == postdata[post_id] || commenturl == postdata[post_enc_url]){
							var commenturl = '<a href="'+postdata[post_url]+'" target="_blank">'+postdata[post_title]+'</a>';
						}
						count_foreach++;
						count_arr = count_arr+4;
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
					if (paging_comments == 'true'){
					$('div.wallkit_posts').before('<div class="wallkit_subtitle"><div class="post_counter"></div></div>');
					$('div.wallkit_posts').after('<div class="wallkit_subtitle"><div class="post_counter"></div></div>');
					}
					else if (comments_count == 'true'){
					$('div.wallkit_posts').before('<div class="wallkit_subtitle"><div class="post_counter"></div></div>');
					$('div.wallkit_posts').after('<div class="wallkit_subtitle"><div class="post_counter"></div></div>');
					};
					if (paging_comments == 'true'){
					$('div.wallkit_subtitle').prepend('<div class="pager"><ul class="pagerpro"></ul></div>');
					$('div.comment_body').pajinate({items_per_page : ''+paging_limit+''});
					};
					if (comments_count == 'true'){commentscount();};
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
					if (!confirm('". _e('Delete Comment','fbcomcon') ."?')) return false;

					FB.api({
						method: 'comments.remove',
						comment_id: commentid,
						xid: commentxid,
						access_token: '".$access_token."'
					},
					function(response) {
						if (!response || response.error_code) {
							alert(\"". _e('ERROR: Failed to delete comment, please try again.','fbcomcon') ."\");
						} else {
							alert('". _e('Comment Successfully Deleted','fbcomcon') ."');
							$(\"#post_\"+commentxid+\"_\"+commentid).slideUp(500, this.remove);
						}
					});
				}";
			}?>


// Retrieve Facebook Comments code by Gil Goldshlager
// http://facebook.com/gil.goldshlager
// Thanks to 'pingflood' & 'TH_Wesley' from the Facebook developers forum
</script>