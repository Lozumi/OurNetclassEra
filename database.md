# 已完成

用户 user：

- id 编号: int
- username 用户名: str
- password 密码（md5）: str
- email 邮箱: str
- usergrp 用户组: str
- regdate 注册时间: date

---

登录状态 auth：

- id 编号: int
- userid 用户编号: int
- cookie: str
- expire 过期时间: int

---

邮件验证码 emailcode：

- id 编号: int
- email 邮箱: str
- code 验证码: code

---

# 待增加

稿件：

- 编号: int
- 投稿人编号: int
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
- 评分人编号: int
- 评分稿件编号: int
- 分数: int
- 评分时间: date

---

点赞：

- 编号: int
- 点赞人编号: int
- 点赞稿件编号: int
- 点赞时间: date