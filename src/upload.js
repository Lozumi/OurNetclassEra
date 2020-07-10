var upload_app = new Vue({
	el: '#upload_app',
	data: {
		now_cs: 1,
		article_title: '',
		article_text: ''
	},
	methods: {
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