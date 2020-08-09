var show_app = new Vue({
	el: '#show_app',
	data: {
		userid: 0,
		username: '',
		item: []
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
		var url = new URL(document.URL);
		var id = url.searchParams.get("id");
		if (id == undefined) {
			mdui.alert("未选择作品哦!\n1秒后返回上一页");
			setTimeout(() => {
				history.back();
			}, 1000);
		}
		$.ajax({
			type: "get",
			url: `/server/get_info_by_id.php?id=${id}`,
			success: function(res) {
				show_app.item = res;
			},
			error: function(res) {
				mdui.alert(res.responseJSON.err);
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

function like() {
	$.ajax({
		type: "post",
		url: "/server/like.php",
		data: {
			id: show_app.item.id,
		},
		success: function() {
			show_app.item.likes++;
			mdui.alert("点赞成功!");
		},
		error: function(res) {
			mdui.alert("点赞失败... 原因: "+res.responseJSON.err);
		}
	});
}