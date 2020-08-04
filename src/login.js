$ = mdui.$;
var login_app = new Vue({
	el: '#login_app',
	data: {
		username_input: '',
		password_input: ''
	},
	created: function () {
		$.ajax({
			async: false,
			type: 'post',
			url: '/server/auth.php',
			success: function (res) {
				if (res['code'] > 0) {
					mdui.alert('已经登录！一秒后跳转至主页。', '提示');
					setTimeout(function () {
						location = '/index.html';
					}, 1000);
				}
			}
		});
	},
	methods: {
		get_login: function () {
			if (this.username_input == '')
				mdui.alert('用户名不能为空！', '错误！');
			else if (this.password_input == '')
				mdui.alert('密码不能为空！', '错误！');
			else {
				$.ajax({
					type: 'post',
					url: '/server/login.php',
					data: {
						'userid': this.username_input,
						'password': this.password_input
					},
					success: function (res) {
						if (res['code'] == 0) {
							mdui.alert('登录成功！一秒后跳转至主页。', '成功！');
							setTimeout(function () {
								location = '/index.html';
							}, 1000);
						} else mdui.alert(res['msg'], '出错！');
					}
				});
			}
		}
	}
});