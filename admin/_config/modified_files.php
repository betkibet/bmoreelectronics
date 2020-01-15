connect_db.php

//$db_user = 'buybackpowerswif_buyback';
$db_user = 'root';
//$db_password = 'm@70a=4@w)xa';
$db_password = 'Kitalale@2010';

config.php
$folder_name = "buyback";

.htaccess
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]