<?php

	//do not touch - Access Token
    if(!get_option('manual_token')){
		$access_token = substr(file_get_contents('https://graph.facebook.com/oauth/access_token?type=client_cred&client_id='.get_option('fb_app_id').'&client_secret='.get_option('fb_secret')), 13);
	}
	else{
		$access_token = get_option('manual_token');
	}
	
	//check if there are already options set, otherwise: Default
	if(get_option("comments_limit")){
		$comments_limit = get_option("comments_limit");
	}
	else{
		$comments_limit = '-1';
	}
		
	if(get_option("paging_limit")){
		$paging_limit = get_option("paging_limit");
	}
	else{
		$paging_limit = '10';
	}
?>

<link href="/wp-content/plugins/facebook-comment-control/css/fb_1.css" rel="stylesheet" type="text/css"/>
<link href="/wp-content/plugins/facebook-comment-control/css/fb_2.css" rel="stylesheet" type="text/css"/>
<link href="/wp-content/plugins/facebook-comment-control/css/fb_3.css" rel="stylesheet" type="text/css"/>
<script src="/wp-content/plugins/facebook-comment-control/js/jquery-latest.min.js" type="text/javascript"></script>
<script src="/wp-content/plugins/facebook-comment-control/js/jquery.pajinate-modified.js" type="text/javascript"></script>
<script type="text/javascript">



// Application ID# - enter your application ID# (Not API Key!) //
var appid = '<?php echo get_option("fb_app_id");?>';

// Admin ID# - enter your admin ID# (facebook profile id# in numbers, not a name id) //
var adminid = '<?php echo get_option("fb_admin_uid");?>';

// PHP support - if your server support PHP then change this to 'true' (default is 'true' yes) //
var phpsupport = 'true';

// Limit - number of comments to dispaly (default is '-1' unlimit [99999999999999999]) //
var comments_limit = '<?php echo $comments_limit;?>';

// Width - the width for example '800px' (default is '0' auto) //
var comments_width = '0';

// Margin - the margin of the whole content
// if you changed the width-setting above from '0' (auto), -
// then you may want to change this setting to '0 auto' to center it (default is '0px 0px') //
var comments_margin = '0px 0px';

// Paging - change to 'false' if you don't want pagging (default is 'true') //
var paging_comments = 'true';

// Paging Limit - number of comments per page (default is 10) //
var paging_limit = '<?php echo $paging_limit;?>';

// Count - change to 'false' if you don't want comments count (default is 'true') //
var comments_count = 'true';

// Login header - change to 'false' if you want to hide the login header (default is 'true') //
var login_header = 'true';

// Local Date type - change to 'true' if you want the local type (default is 'false') //
var localdate = 'false';

// Dark style - change to 'true' if you want it dark (default is 'false') //
var dark_style = 'false';

// Background Color (if dark style is 'true') - change to blank '' for transparent (default is '#fff' white) //
var bgcolor = '#fff';

</script>

<style type='text/css'>

span.aname {font-weight:bold;}

div.login_header {height:53px; margin-bottom:20px;}

div.login_header div.menu {
height:28px;
font:bold 18px 'lucida grande',tahoma,verdana,arial,sans-serif;
line-height:28px;
vertical-align:middle;
color:#fff;
background-color:#627BAD;
border-top:8px solid #3B5A98;
border-right:8px solid #3B5A98;
margin-left:53px;
padding-left:10px;
}

div.login_header div.menu span {font-size:11px; color:#eee;}

div.login_header div.menu a {
float:right;
font-size:11px;
color:#fff;
text-decoration:none;
padding:0px 10px;
}

div.login_header div.menu a:hover {background-color:#6D86B7;}

div.login_header div.img {
width:50px;
height:50px;
position:absolute;
z-index:1;
margin-top:3px;
}

div.login_header div.img img {border:none;}
</style>

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
	'//connect.facebook.net/de_DE/all.js';
	document.getElementById('fb-root').appendChild(e);
}());
</script>

<div class="wallkit_frame clearfix">
<div class="login_header">
<div class="img"><fb:profile-pic uid="loggedinuser" size="square" width="50" height="50" /></div>
<div class="menu"><a id="login" href="#" style="display:none;">Login</a><a id="logout" href="#" style="display:none;">Logout</a></div>
</div>
<div class="comment_body" id="fbcomments"></div>
</div>

<script type="text/javascript">
if (comments_width != '0'){
$(document).ready(function(){
$('div.wallkit_frame').css('width',''+comments_width+'');
});
}

$(document).ready(function(){
$('div.wallkit_frame').css('margin',''+comments_margin+'');
});

if (login_header == 'false'){
$(document).ready(function(){
$('div.login_header').hide();
});
};

if (comments_count == 'true'){function commentscount(){
var totalcount = $("div.wallkit_post").size();
$("div.post_counter").text(""+totalcount+" Comments.");
};}

if (dark_style == 'true'){
$(document).ready(function(){
$('head').append('<link rel="stylesheet" href="http://www.fileden.com/files/2006/10/3/258652/dark_comments.css" type="text/css" />');
$('body').css('background-color',''+bgcolor+'');
});}

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
						data = '<h4>No comments</h4>';
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
    var userimg = '<a target="_blank" href="'+ users[comments[i].fromid].url +'" title="'+ users[comments[i].fromid].name +' - view profile."><img src="https://graph.facebook.com/'+ comments[i].fromid +'/picture" class="img"></a>';
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
commentdate = curr_date + "." + curr_month + "." + curr_year + " at " + curr_hour + ":" + curr_min + " " + a_p;
if (localdate == 'true'){var commentdate = comment_date};

// Comment BODY text
var commenttext = comments[i].text;
var commenttext = commenttext.replace(/\n/g,'<br />');

// Comment URL Link
var commenturl = comments[i].xid;


// Comments Delete Link
var commentdelete = comments[i].fromid;
if (commentdelete == ''+ adminid +''){var commentdelete = '<a href="#" onclick="delete_comment(\''+ comments[i].id +'\',\''+ comments[i].xid +'\'); return false;" class="delete" title="Delete">Delete</a> &nbsp;|&nbsp; ';}
else if (phpsupport != 'false'){var commentdelete = '<a href="#" onclick="deleteComment(\''+comments[i].id+'\',\''+comments[i].xid+'\'); return false;" class="delete" title="Delete">Delete</a> &nbsp;|&nbsp; '} else {var commentdelete = '';}

data +=
'<div id="post_'+ comments[i].xid +'_'+ comments[i].id +'" class="wallkit_post">'+
'<div class="wallkit_profilepic">'+ userimg +'</div>'+
'<div class="wallkit_postcontent">'+
'<h4>'+ username +
'<span class="wall_time">'+ commentdate +'</span></h4>'+
'<div>'+ commenttext +'</div>'+
'<div class="wallkit_actionset">'+
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
	
			$('#fbcomments').html('<img src="http://static.ak.fbcdn.net/rsrc.php/z5R48/hash/ejut8v2y.gif" title="Loading..." alt="Loading..." style="width:32px; height:32px; display:block; margin:50px auto;">');
			showComments(currentpage);
		}
		
			function deleteComment(commentid,commentxid) {
			if (!confirm('Delete Comment?')) return false;

			FB.api({
				method: 'comments.remove',
				comment_id: commentid,
				xid: commentxid,
				access_token: '<?=$access_token?>'
			},
			function(response) {
				if (!response || response.error_code) {
					alert("ERROR: Failed to delete comment, please try again.");
				} else {
					alert('Comment Successfully Deleted');
					$("#post_"+commentxid+"_"+commentid).slideUp(500, this.remove);
				}
			});
		}

function delete_comment(commentid,commentxid){
	FB.api({
		method: 'comments.remove',
		comment_id: commentid,
		xid: commentxid
		},
function(response) {
	if (response == 0){
		alert('ERROR: Failed to delete comment, please try again.');
		window.location.reload();
	}else{
		alert('Comment Successfully Deleted');
		window.location.reload();
		}
	});
}

// Retrieve Facebook Comments code by Gil Goldshlager
// http://facebook.com/gil.goldshlager
// Thanks to 'pingflood' & 'TH_Wesley' from the Facebook developers forum
</script>