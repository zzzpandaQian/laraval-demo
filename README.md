# 项目名称

## 安装步骤

- 根据 `.env.example` 中的 `DB_DATABASE` 创建数据库
- Windows 执行命令：`./init`
- Mac 或 Linux，先执行 `chmod +x init.sh`增加权限，然后执行命令：`./init.sh`。

## 项目信息

后台地址：`http://atcms.test/atadmin`
账号 `admin`
密码 `antto2021`

## 注意事项

- 若部署在二级目录, 发送短信的修改：修改文件 public\js\laravel-sms.js `getUrl()`方法的路由
- 天瑞云短信发送需要添加 IP 白名单

## TODO
