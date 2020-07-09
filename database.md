# Database definations

用户：

- 编号: int
- 用户名: str
- 密码（md5）: str
- 邮箱: str
- 用户组: str
- 注册时间: date

---

登录状态 auth:

- 编号: int
- sessionid: str
- expire time: timestamp

---

稿件：

- 编号: int
- 投稿人: int
- 类型: (text/image/video)
- 文件: str
- 获赞数: int
- 平均分: float
- 是否显示: bool
- 是否待审核: bool
- 投稿时间: date

---

评分：

- 编号: int
- 评分人: int
- 评分稿件: int
- 分数: int
- 评分时间: date

---

点赞：

- 编号: int
- 点赞人: int
- 点赞稿件: int
- 点赞时间: date