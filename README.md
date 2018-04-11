# 梦途科技论坛系统
基于Laravel 5.6

mysql > 5.5 编码格式为：utf8m64_unicode

PHP7.0
####安装
1, composer install

2, npm install

3, 配置env文件各项配置 php artisan key:generate

4, php artisan migrate 导入数据表

5, php artisan db:seed 填充后台数据
######注意,当env中环境配置
 DB_SEED_MOCK=false 代表是否填充假数据

5, 开启redis,运行php artisan queue:listen
   运行队列
     
6，编辑schedule.bat,startSchtasks.bat两个文件，将其中文件目录替换即可，单击startSchtasks.bat开启定时任务

