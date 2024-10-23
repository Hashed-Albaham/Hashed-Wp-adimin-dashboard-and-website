# مشروع موقع WordPress / WordPress Website Project

هذا المشروع يستخدم WordPress و WP Bakery لإنشاء موقع ويب مخصص مع ميزات إضافية.  
This project uses WordPress and WP Bakery to create a customized website with additional features.

## المتطلبات الأساسية / Prerequisites

قبل البدء، تأكد من أنك قد قمت بتثبيت:  
Before you begin, ensure you have installed:

- [PHP](https://www.php.net/downloads) (الإصدار 7.4 أو أعلى)  
  (Version 7.4 or higher)
- [MySQL](https://www.mysql.com/downloads/) (الإصدار 5.7 أو أعلى) أو [MariaDB](https://mariadb.org/download/)  
  (Version 5.7 or higher or MariaDB)
- [Apache](https://httpd.apache.org/download.cgi) أو [Nginx](https://nginx.org/en/download.html)  
  (Apache or Nginx)
- [WordPress](https://wordpress.org/download/)  
  (Latest version of WordPress)
- [WP Bakery Page Builder](https://wpbakery.com/)  
  (WP Bakery Page Builder)

## خطوات التثبيت / Installation Steps

### 1. تحميل WordPress / Download WordPress

- قم بزيارة [موقع WordPress الرسمي](https://wordpress.org/download/) وقم بتحميل آخر إصدار.  
  (Visit the [official WordPress site](https://wordpress.org/download/) and download the latest version.)

### 2. إعداد قاعدة البيانات / Set Up Database

- قم بإنشاء قاعدة بيانات جديدة في MySQL أو MariaDB باستخدام الأوامر التالية:  
  (Create a new database in MySQL or MariaDB using the following commands:)

```sql
CREATE DATABASE mydatabase;  
CREATE USER 'myuser'@'localhost' IDENTIFIED BY 'mypassword';  
GRANT ALL PRIVILEGES ON mydatabase.* TO 'myuser'@'localhost';  
FLUSH PRIVILEGES;
```



استبدل mydatabase, myuser, و mypassword بالقيم المناسبة.
(Replace mydatabase, myuser, and mypassword with appropriate values.)

3. تحميل ملفات WordPress / Upload WordPress Files

قم بفك ضغط ملفات WordPress في مجلد السيرفر الخاص بك (مثل htdocs لمشغل Apache).
(Extract the WordPress files to your server directory (like htdocs for Apache).)


4. تثبيت WordPress / Install WordPress

افتح متصفح الويب وانتقل إلى عنوان موقعك (مثل http://localhost/mywebsite).
(Open a web browser and navigate to your site address (like http://localhost/mywebsite).)

اتبع التعليمات لإعداد WordPress. استخدم معلومات قاعدة البيانات التي أنشأتها مسبقًا.
(Follow the instructions to set up WordPress. Use the database information you created earlier.)


5. تثبيت WP Bakery / Install WP Bakery

قم بشراء وتثبيت WP Bakery من الموقع الرسمي.
(Purchase and install WP Bakery from the official site.)

بعد التثبيت، يمكنك الوصول إلى واجهة التحرير عن طريق النقر على "تحرير باستخدام WP Bakery" عند تحرير الصفحات.
(After installation, you can access the editing interface by clicking "Edit with WP Bakery" when editing pages.)


التخصيص / Customization

1. إضافة إضافات / Add Plugins

انتقل إلى "إضافات" في لوحة التحكم الخاصة بـ WordPress.
(Go to "Plugins" in the WordPress dashboard.)

انقر على "إضافة جديد" وابحث عن الإضافات التي ترغب في تثبيتها، ثم قم بتنشيطها.
(Click on "Add New" and search for the plugins you want to install, then activate them.)


2. تخصيص المظهر / Customize Appearance

استخدم خيارات التخصيص المدمجة في WordPress لتغيير المظهر وإعداد القوائم.
(Use the built-in customization options in WordPress to change themes and set up menus.)


3. إنشاء الصفحات / Create Pages

استخدم WP Bakery لإنشاء صفحات مخصصة بسهولة باستخدام سحب وإفلات العناصر.
(Use WP Bakery to easily create custom pages using drag-and-drop elements.)


المصادر / Resources

دليل تثبيت WordPress
(WordPress Installation Guide)

WP Bakery Documentation
(WP Bakery Documentation)

PHP Documentation
(PHP Documentation)

MySQL Documentation
(MySQL Documentation)
