<section>
	<div class="container-fluid">
	  <div class="row justify-content-center">
		<div class="col-md-6">
		  <div class="block heading empty-heading text-center empty_basket">
				<div class="card">
					<div class="card-body">
						<h3 class="pb-3">Your sales basket is empty</h3>
						<form action="<?=SITE_URL?>search" method="post">
							<div class="form-group empty_cart">
							<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=$searchbox_placeholder?>">
							</div>
						</form>
						<div class="h4 text-center text-muted pt-3 pb-3">OR</div>
            			<a href="<?=SITE_URL?>sell" class="btn btn-primary btn-lg pl-5 pr-5">CHOOSE YOUR DEVICE TYPE OR BRAND</a>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</section>