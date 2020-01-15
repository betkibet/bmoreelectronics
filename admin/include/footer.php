<div class="m-grid__item m-footer ">
	<div class="m-container m-container--fluid m-container--full-height m-page__container">
		<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
			<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
				<span class="m-footer__copyright">
					<?=date('Y');?> &copy; <strong> <?=ADMIN_PANEL_NAME?></strong>
				</span>
			</div>
	</div>
</div>

<?php
if($file_name!="mobile") { ?>
<script src="js/bootstrap/bootstrap.min.js"></script>
<?php
} ?>

<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script src="assets/demo/default/custom/crud/datatables/basic/basic.js" type="text/javascript"></script>

<?php /*?><script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script><?php */?>
<script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<?php /*?><script src="assets/app/js/dashboard.js" type="text/javascript"></script><?php */?>

<script src="assets/demo/default/custom/crud/forms/widgets/summernote.js" type="text/javascript"></script>
<script src="assets/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>

<?php
if($custom_phpjs_path!="") {
	include($custom_phpjs_path);
} ?>

<script>
jQuery(document).ready(function() {
	$('.datepicker').datepicker({
		todayHighlight: true,
		autoclose: true,
	});
});
</script>

</body>
</html>

<?php
//Close db connection of mysql
mysqli_close($db); ?>
