<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$active_page_data['menu_name']?></a></li>
		</ul>
	</div>
</div>
  
<!-- Main -->
<div id="main" class="<?=$active_page_data['css_page_class']?>">

	<?php
	if($active_page_data['image'] != "") { ?>
	  <section>
		<?php
		if($active_page_data['image_text'] != "") {
			echo '<h2>'.$active_page_data['image_text'].'</h2>';
		} ?>

		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	  </section>
	<?php
	} ?>

	<section id="" class="sectionbox gray-bg">
		<div class="wrap">
			<?php
			if($active_page_data['show_title'] == '1') {
				echo '<h2 class="page_title">'.lastwordstrongorspan($active_page_data['title'],'span').'</h2>';
			}
			echo $active_page_data['content'];
			?>
		</div>
	</section>
</div>
<!-- /.main -->