<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$terms_pg_data = get_inbuild_page_data('terms-and-conditions');
echo $terms_pg_data['data']['content'];
?>