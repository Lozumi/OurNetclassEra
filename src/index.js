var app = new Vue({
	el: '#app',
	data: {
		userid: 0,
		username: ''
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
						mdui.alert('已注销！一秒后自动刷新。', '成功！');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else mdui.alert('好像有点问题...', '出错！');
				}
			});
		}
	}
});