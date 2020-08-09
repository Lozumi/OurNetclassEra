/*const ap = new APlayer({
    container: document.getElementById('aplayer'),
    fixed: true,
    autoplay: true,
    theme: '#3f51b5',
    audio: [{
        name: '羽根',
        artist: '折戸伸治',
        url: '//play2.loid.top:5080/video/back.mp3',
        cover: 'back.png'
    }]
});*/
var app = new Vue({
	el: '#app',
	data: {
		userid: 0,
		username: '',
		random_picture: [],
		col_count: 4
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
		const _this = this;
		var get_col = function() {
			var aspect = window.innerWidth / window.innerHeight;
			_this.col_count = 4;
			if(aspect <= 1.3)
				_this.col_count = 3;
			if(aspect <= 1)
				_this.col_count = 2;
			if(aspect <= 0.75)
				_this.col_count = 1;
		};
		window.onresize = get_col;
		get_col();
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
	}
});