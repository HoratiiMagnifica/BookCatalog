Краткая инструкция по развёртыванию приложения.
1. Загружаем Laravel вместе с vendor на хостинг (обычно с помощью ftp)
2. После загрузки в корне проекта необходимо создать файл .htaccess и разместить в нем код:
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

3. Готово!
