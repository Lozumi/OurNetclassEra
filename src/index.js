var app = new Vue({
	el: '#app',
	data: {
		userid: 0,
		username: '',
		random_picture: []
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
		this.refresh_picture();
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
		refresh_picture: function() {
			this.random_picture = this.get_info('image', 'random', 10);
		},
		get_info: function(gtype, gsort, gnum) {
			var items = [];
			$.ajax({
				async: false,
				type: 'post',
				url: '/server/get.php',
				data: {
					ftype: gtype,
					fsort: gsort,
					fnum: gnum
				},
				success: function(res) {
					items = res;
				}
			});
			return items;
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