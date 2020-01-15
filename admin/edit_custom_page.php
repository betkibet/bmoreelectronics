<?php
$file_name="custom_page";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch single page data based on page id
$query=mysqli_query($db,'SELECT * FROM pages WHERE id="'.$id.'"');
$page_data=mysqli_fetch_assoc($query);
$exp_position=(array)json_decode($page_data['position']);

//Array of inbuild pages so we can set fix condition of those pages
/*$inbuild_page_array = array('home'=>array('name'=>'Home','title'=>'Home','slug'=>'home','url'=>''),'reviews'=>array('name'=>'Reviews','title'=>'Reviews','slug'=>'reviews','url'=>'reviews'),'affiliates'=>array('name'=>'Affiliates','title'=>'Affiliates','slug'=>'affiliates','url'=>'affiliates'),'contact'=>array('name'=>'Contact us','title'=>'Contact us','slug'=>'contact','url'=>'contact'),'signup'=>array('name'=>'Signup','title'=>'Signup','slug'=>'signup','url'=>'signup'),'login'=>array('name'=>'Login','title'=>'Login','slug'=>'login','url'=>'login'),'blog'=>array('name'=>'Blog','title'=>'Blog','slug'=>'blog','url'=>'blog'),'terms-and-conditions'=>array('name'=>'Terms & Conditions','title'=>'Terms & Conditions','slug'=>'terms-and-conditions','url'=>'terms-and-conditions'),'order-track'=>array('name'=>'Order Track','title'=>'Order Track','slug'=>'order-track','url'=>'order-track'),'instant-sell-model'=>array('name'=>'Instant Sell Model','title'=>'Instant Sell Model','slug'=>'instant-sell-model','url'=>'instant-sell-model'),'offers'=>array('name'=>'Offers','title'=>'Offers','slug'=>'offers','url'=>'offers'));
$inbuild_page_data = $inbuild_page_array[$post['slug']];*/

$menu_name = $page_data['menu_name'];
$title = $page_data['title'];
$url = $page_data['url'];
$finl_url = ($url?$url:$inbuild_page_data['url']);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Template file
require_once("views/page/edit_custom_page.php");

//Footer section
// require_once("include/footer.php"); ?>

