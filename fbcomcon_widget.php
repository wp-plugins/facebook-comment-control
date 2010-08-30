<link href="'. get_option("siteurl").'/'.PLUGINDIR.'/facebook-comment-control/css/compressed.css" rel="stylesheet" type="text/css"/>
<script src="'. get_option("siteurl").'/'.PLUGINDIR.'/facebook-comment-control/js/jquery-latest.min.js" type="text/javascript"></script>
<div id="fb-root"></div>

<div class="wallkit_frame clearfix">
	<a id="login" href="#" style="display:none;">
		<div style="text-align:right;">
			<img src="<?php echo get_option( "siteurl" ).'/'.PLUGINDIR.'/facebook-comment-control/img/fb_login.jpg';?>" width="65" height="22" alt="login" style="text-decoration:none !important;"/><br/>
			<?php _e('Connect with Facebook<br/>to show recent comments','fbcomcon');?>
		</div>
	</a>
		<div class="comment_body" id="fbcomments"></div>
</div>

<script type="text/javascript">
	
	FB.getLoginStatus(function(response) {
		if (response.session) {
			loadComments();
		}
		else {
			$('#login').show();
		}
	}); 
	
	$('#login').bind('click', function() {
		FB.login(function(response){window.location.reload();});
	});
	
function showComments() {

			var users = new Array();
			var comments = new Array();
			FB.api(
				{
					method: 'fql.multiquery',
					queries: {
						comments: 'SELECT fromid, text, id, time, username, xid, object_id FROM comment WHERE xid IN (SELECT xid FROM comments_info WHERE app_id = <?php echo get_option("fbcomcon_app_id");?>) ORDER BY time desc LIMIT 0,5',
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
						

						// Comment URL Link
						var commenturl = comments[i].xid;
						if(commenturl.substr(0,4) == 'http') {
							var commenturl = '<a href="'+unescape(comments[i].xid)+'" target="_blank"><?php _e("View Page");?></a>';
						}
						else{
							var commenturl = '';
						}
						
						//Creating Content
						data +=
						'<div id="post_'+ comments[i].xid +'_'+ comments[i].id +'" class="wallkit_post">'+
						'<div class="wallkit_profilepic">'+ userimg +'</div>'+
						'<div class="wallkit_postcontent">'+
						'<h4>'+ username +
						'<br/><span class="wall_time">'+ commentdate +'</span></h4>'+
						'<div>'+ commenttext +'</div>';
						
						if(commenturl != ''){ 
							data +=
							'<div class="wallkit_actionset">'+
							''+ commenturl +
							'</div>';
						}
						data +=
						'</div>'+
						'</div>';
					}
					
					$('#fbcomments').html('<div class="wallkit_posts">' + data + '</div>');

				}
			);
		}

		function loadComments() {
			$('#fbcomments').html('<img src="http://static.ak.fbcdn.net/rsrc.php/z5R48/hash/ejut8v2y.gif" title="<?php _e('Loading...','fbcomcon');?>" alt="<?php _e('Loading...','fbcomcon');?>" style="width:32px; height:32px; display:block; margin:50px auto;">');
			showComments(0);
		}

// Retrieve Facebook Comments code by Gil Goldshlager
// http://facebook.com/gil.goldshlager
// Thanks to 'pingflood' & 'TH_Wesley' from the Facebook developers forum
</script>