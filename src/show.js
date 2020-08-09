var show_app = new Vue({
	el: '#show_app',
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
		var url = new URL(document.url);
		var id = url.searchParams.get("id");
		if (id == undefined) {
			mdui.alert("未选择作品哦! 1秒后返回上一页");
			setTimeout(() => {
				history.back();
			}, 1000);
		}
		$.get(`/server/get_info_by_id.php?id=${id}`, {
			success: function(data) {
				
			},
			error: function(data) {
				mdui.alert(data["err"]);
			}
		})
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