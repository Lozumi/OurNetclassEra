var upload_app = new Vue({
	el: '#upload_app',
	data: {
		userid: 0,
		username: '',
		article_title: '',
		article_text: '',
		imageURL: '/upload.png',
		pic_loading: 0,
		pic_data: ''
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
		if(this.userid <= 0) {
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
		pic_file_change: function() {
			let file = this.$refs.pic_inputer.files[0];
			if(!/image/.test(file.type)) {
				mdui.alert('请选择一个图片文件！', '提示');
				return;
			} if(file.size > 15728640) {
				mdui.alert('图片的大小不能超过 15MiB！', '提示');
				return;
			} let reader = new FileReader();
			reader.readAsDataURL(file);
			const _this = this;
			reader.onload = function() {
				_this.imageURL = reader.result;
				_this.pic_loading = 0;
			};
			reader.onprogress = function(event) {
				if(event.lengthComputable)
					_this.pic_loading = event.loaded * 100 / event.total;
			};
			this.pic_data = new FormData();
			this.pic_data.append('picfile', file);
		},
		upload_img: function() {
			if(this.pic_data == '') {
				mdui.alert('请选择需要投稿的图片！', '提示');
				return;
			} $.ajax({
				type: 'post',
				url: '/server/pic_upload.php',
				data: this.pic_data,
				contentType: false,
				processData: false,
				success: function(res) {
					if(res['code'] == 0) {
						mdui.alert('投稿成功！一秒后自动刷新。', '成功');
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else mdui.alert(res['msg'], '出错！');
				}
			});
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