var SummernoteDemo={
	init:function(){
		$(".summernote").summernote({
			height:150,
			callbacks: {
				onChange: function (contents) {
					if($('.summernote').summernote('isEmpty')) {
						$(".summernote").summernote('code', ''); 
					}
					/*if(contents == "<p><br></p>") {
						$(".summernote").summernote('code', '');
					}*/
				}
			}
		});
		
		$(".summernote2").summernote({
			height:150,
			callbacks: {
				onChange: function (contents) {
					if($('.summernote2').summernote('isEmpty')) {
						$(".summernote2").summernote('code', ''); 
					}
					/*if(contents == "<p><br></p>") {
						$(".summernote").summernote('code', '');
					}*/
				}
			}
		});
	}
};

jQuery(document).ready(function(){SummernoteDemo.init()});