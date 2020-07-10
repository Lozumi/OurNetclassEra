var upload_app = new Vue({
	el: '#upload_app',
	data: {
		userid: 0,
		username: '',
		now_cs: 1,
		article_title: '',
		article_text: ''
	},
	created: function() {
		var user_id = 0;
		var user_name = '';
		$.ajax({
			async: false,
			type: 'post',
			url: '/server/auth.php',
			success: function(res) {
				user_id = res['code'];
				user_name = res['name'];
			}
		});
		this.userid = user_id;
		this.username = user_name;
		if(this.userid == 0) {
			mdui.alert('投稿前需要先登录！一秒后跳转至登录页面。', '提示');
			setTimeout(function() {
				location = '/login.html';
			}, 1000);
		}
	},
	methods: {
		not_login: function() {
			return this.userid == 0;
		},
		is_login: function() {
			return this.userid != 0;
		},
		logout: function() {
			$.ajax({
				type: 'post',
				url: '/server/logout.php',
				success: function(res) {
					if(res['code'] == 0) {
						mdui.alert('已注销！一秒后跳转至主页。', '成功！');
						setTimeout(function() {
							location = '/index.html';
						}, 1000);
					} else mdui.alert('好像有点问题...', '出错！');
				}
			});
		},
		select_article: function() {
			this.now_cs = 0;
		},
		select_picture: function() {
			this.now_cs = 1;
		},
		select_video: function() {
			this.now_cs = 2;
		},
		article_selected: function() {
			return this.now_cs == 0;
		},
		picture_selected: function() {
			return this.now_cs == 1;
		},
		video_selected: function() {
			return this.now_cs == 2;
		},
		get_login: function() {

		},
		upload_img: function() {

		}
	},
	watch: {
		now_cs: function() {
			switch(this.now_cs) {
				case 0:
					console.log('Article!');
					break;
				case 1:
					console.log('Picture!');
					break;
				case 2:
					console.log('Video!');
					break;
				default:
					console.log('Error!');
			}
		}
	}
});