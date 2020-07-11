# 已完成

```mysql
CREATE TABLE user(
id INT NOT NULL AUTO_INCREMENT,
username VARCHAR(15) NOT NULL,
password VARCHAR(32) NOT NULL,
email VARCHAR(20) NOT NULL,
usergrp VARCHAR(10) NOT NULL,
regdate DATETIME,
PRIMARY KEY ( id ));
```

用户 user：

- id 编号: int
- username 用户名: str
- password 密码（md5）: str
- email 邮箱: str
- usergrp 用户组: str(user, reviewer, admin, blocked)
- regdate 注册时间: datetime

---

```mysql
CREATE TABLE auth(
id INT NOT NULL AUTO_INCREMENT,
userid INT NOT NULL,
cookie VARCHAR(32) NOT NULL,
expire INT NOT NULL,
PRIMARY KEY ( id ));
```

登录状态 auth：

- id 编号: int
- userid 用户编号: int
- cookie: str
- expire 过期时间: int

---

```mysql
CREATE TABLE emailcode(
id INT NOT NULL AUTO_INCREMENT,
email VARCHAR(20) NOT NULL,
code VARCHAR(6) NOT NULL,
PRIMARY KEY ( id ));
```

邮件验证码 emailcode：

- id 编号: int
- email 邮箱: str
- code 验证码: code

---

```mysql
CREATE TABLE files(
id INT NOT NULL AUTO_INCREMENT,
userid INT NOT NULL,
ftype VARCHAR(10) NOT NULL,
fname VARCHAR(32) NOT NULL,
fend VARCHAR(10) NOT NULL,
fdes VARCHAR(300) NOT NULL,
likes INT NOT NULL,
scores DOUBLE NOT NULL,
isshow BOOL NOT NULL,
iswait BOOL NOT NULL,
uptime DATETIME,
PRIMARY KEY ( id ));
```

稿件 files：

- id 编号: int
- userid 投稿人编号: int
- ftype 类型: (text, image, video)
- fname 文件名: str
- fend 文件后缀名: str
- fdes 简介: str
- likes 获赞数: int
- scores 平均分: double
- isshow 是否显示: bool
- iswait 是否待审核: bool
- uptime 投稿时间: datetime

---

# 待增加

评分：

- 编号: int
- 评分人编号: int
- 评分稿件编号: int
- 分数: int
- 评分时间: datetime

---

点赞：

- 编号: int
- 点赞人编号: int
- 点赞稿件编号: int
- 点赞时间: datetime