<script>
//== Class Definition
var SnippetFormValidation = function() {
    var handleProfileFormSubmit = function() {
        $('#m_form_submit').click(function(e) {
            //e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
					name: {
                        required: true,
                    }
                }
            });

            if (!form.valid()) {
                return;
            }
			return;
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleProfileFormSubmit();
        }
    };
}();

var BootstrapSwitch = function () {
    //== Private functions
    var demos = function () {
        // minimum setup
        $('[data-switch=true]').bootstrapSwitch();
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetFormValidation.init();
	BootstrapSwitch.init();
});
</script>

<script type="text/javascript" src="plugins/parsleyjs/parsley.min.js"></script>
<script src="plugins/nestable/jquery.nestable.js"></script>

<script type="text/javascript">
!function($) {
	"use strict";

	var Nestable = function() {};

	Nestable.prototype.updateOutput = function (e) {
		var list = e.length ? e : $(e.target),
			output = list.data('output');
		if (window.JSON) {
			var sorting_order = window.JSON.stringify(list.nestable('serialize'));
			
			output.val(sorting_order); //, null, 2));
			
			console.log(sorting_order);
									
			$('#sorting_order').html(sorting_order);
			 
		} else {
			alert('JSON browser support required for this demo.');
			output.val('JSON browser support required for this demo.');
		}
	},
	//init
	Nestable.prototype.init = function() {
		$('#nestable_list_3').nestable({
			group: 1
		}).on('change', this.updateOutput);

		this.updateOutput($('#nestable_list_3').data('output', $('#sorting_order')));
	},
	//init
	$.Nestable = new Nestable, $.Nestable.Constructor = Nestable
}(window.jQuery),

//initializing 
function($) {
	"use strict";
	$.Nestable.init()
}(window.jQuery);

$(document).ready(function () {
	if($("#description").length > 0) {
		tinymce.init({
			selector: "textarea#description",
			theme: "modern",
			height:200,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
			style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			]
		});
	}

	$(".sortorder").TouchSpin({
		verticalbuttons: true,
		buttondown_class: "btn btn-default",
		buttonup_class: "btn btn-default",
		verticalupclass: 'ion-plus-round',
		verticaldownclass: 'ion-minus-round'
	});
});

function check_default(id){
	$(".radio_"+id).on('change', function() {
		$(".radio_"+id).not(this).prop('checked', false);  
	});
}

function clear_default(id){
	$(".radio_"+id).prop('checked', false);
}

function remove_row(obj) {
	swal({
		title: "Are you sure?",
		text: "You want to delete this field permanently?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, Please Delete!",
		cancelButtonText: "No Thanks!",
		closeOnConfirm: false
	}).then(function (e) {
		if(e.value) {
			$(obj).parent().parent().parent().remove();
			swal.close();
		}
	});
}

function add_fields(){
	var no_of_fields = $("#no_of_fields").val();
	no_of_fields = Number(no_of_fields)+Number(1);

	field_structure = $("#field_structure").html();
	field_structure = field_structure.replace(/f-no/g, no_of_fields);
	
	$('.fields div.active').removeClass('active');
	$(".fields").append(field_structure);	
	$('#tab_titles a.active').removeClass('active');

	var tab_title_ = '<li id="tab_f-no" class="dd-item dd3-item nav-item" data-id="f-no"><div class="dd-handle-new"><i class="fa fa-list"></i></div><a class="dd3-content nav-link active" href="#field_f-no" onclick="up_current_tab(f-no)" data-toggle="tab" aria-expanded="false"><span id="tab_title_f-no">Field Label</span></a></li>';
	tab_title_ = tab_title_.replace(/f-no/g, no_of_fields);
	$("#tab_titles").append(tab_title_);
	
	//$('#input_type_'+no_of_fields).selectpicker();
	$("#no_of_fields").val(no_of_fields);
	$("#current_field").val(no_of_fields);
	
	$.Nestable.init();
}

function showOtherTab() {
	$("#m_tabs_general").removeClass("active");
	$("#general_tab").removeClass("active");
	
	$("#m_tabs_fields").addClass("active");
	$("#add_fields_tabs").addClass("active");
}

function StepTrack(step) {
	$("#step_track").val(step);
	return false;
}

function add_group_fields(){
	var no_of_fields = $("#no_of_fields").val();
	no_of_fields = Number(no_of_fields)+Number(1);
	
	var custom_groups = [];
	$('input[name="custom_groups"]:checked').each(function(i){
	  custom_groups[i] = $(this).val();
	});
	custom_groups = custom_groups.toString();
	
	$.post("action.php",{action:"get_group_fields", custom_groups:custom_groups,no_of_fields:no_of_fields},function(res) {
		
		var data = JSON.parse(res);
		if(data.success==1) {
			
			$("#tab_titles").append(data.lis);
			$.Nestable.init();
			$.post("action.php",{action:"get_group_fields2", custom_groups:custom_groups,no_of_fields:no_of_fields},function(field_structure) {
				$(".fields").append(field_structure);
				
				$('.to-selectpicker').each(function() {
					$(this).removeClass("to-selectpicker");
					//$(this).selectpicker();
				});
				
				$('.to-filestyle').each(function(){
					$(this).removeClass("to-filestyle");
				});
				
				for(no_of_fields;no_of_fields<=data.no_of_fields;no_of_fields++) {
					$("#sortable_"+no_of_fields).sortable();
					$("#sortable_"+no_of_fields).disableSelection();
				}
			});
			
			$("#no_of_fields").val(data.no_of_fields);
		 	$('#myModal').modal('toggle');
			
		} else if(data.error==1) {
			
		}
	});
	return false;
}

function deleteImage(obj){
	$(obj).prev().remove();
	$(obj).next().val("");
	$(obj).remove();
}

function deleteImageOpt(obj){
	$(obj).parent().prev().remove();
	$(obj).parent().parent().find(".icon_hidden").val("");
	$(obj).remove();
}

function deleteTooltip(obj){
	$(obj).prev().val("");
}

function up_current_tab(id){
	$('#tab_titles li.active').removeClass('active');
	$("#current_field").val(id);
}

function del_current_tab() {
	swal({
		title: "Are you sure?",
		text: "You want to delete this field permanently?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#27ae60",
		confirmButtonText: "Yes, Please Delete!",
		cancelButtonText: "No Thanks!",
		closeOnConfirm: false
	}).then(function (e) {
		if(e.value) {
			id = $("#current_field").val();
			$.when($("#tab_"+id).remove()).then($('ol#tab_titles li:first').addClass("active"));
			$.when($("#field_"+id).remove()).then($('div#tab_contents div:first').addClass("active"));
			
			var tab_ele = $('ol#tab_titles li:first').attr("id");
			if(typeof tab_ele !== 'undefined'){
				tab_id = tab_ele.split("_");
				$("#current_field").val(tab_id['1']);
			}
			swal.close();
		}
	});
}

function add_more_options(f){
	var no_of_dd_options = $("#no_of_dd_options_"+f).val();
	no_of_dd_options = Number(no_of_dd_options)+Number(1);
	
	dd_options_structure = $("#dd_options_structure").html();
	dd_options_structure = dd_options_structure.replace(/o-no/g, no_of_dd_options);
	dd_options_structure = dd_options_structure.replace(/f-no/g, f);
	
	//$("#dd_options_"+f).append(dd_options_structure);
	$("#sortable_"+f).append(dd_options_structure);
	
	//$('#dd_price_type_'+f+'_'+no_of_dd_options).selectpicker();
	//$('#dd_add_sub_'+f+'_'+no_of_dd_options).selectpicker();

	//$('#dd_icon_'+f+'_'+no_of_dd_options).filestyle({input: false});
	
	$("#no_of_dd_options_"+f).val(no_of_dd_options);
}

function add_more_radios(f){
	var no_of_radio_options = $("#no_of_radio_options").val();
	no_of_radio_options = Number(no_of_radio_options)+Number(1);
	
	radio_options_structure = $("#radio_options_structure").html();
	radio_options_structure = radio_options_structure.replace(/o-no/g, no_of_radio_options);
	radio_options_structure = radio_options_structure.replace(/f-no/g, f);
	
	$("#radio_options_"+f).append(radio_options_structure);
	$("#no_of_radio_options").val(no_of_radio_options);
}

function add_more_checkboxs(f){
	var no_of_checkbox_options = $("#no_of_checkbox_options").val();
	no_of_checkbox_options = Number(no_of_checkbox_options)+Number(1);
	
	checkbox_options_structure = $("#checkbox_options_structure").html();
	checkbox_options_structure = checkbox_options_structure.replace(/o-no/g, no_of_checkbox_options);
	checkbox_options_structure = checkbox_options_structure.replace(/f-no/g, f);
	
	$("#checkbox_options_"+f).append(checkbox_options_structure);
	$("#no_of_checkbox_options").val(no_of_checkbox_options);
}

function change_input_type(f){
	var structure = "";
	var input_type = $("#input_type_"+f).val();
	if(input_type=="select" || input_type=="radio" || input_type=="checkbox"){
		structure = $("#dd_structure").html();
	}
	/* else if(input_type=="radio"){
		structure = $("#radio_structure").html();
	}else if(input_type=="checkbox"){
		structure = $("#checkbox_structure").html();
	} */
	
	structure = structure.replace(/f-no/g, f);
	$("#type_options_"+f).html(structure);
	
	$("#add_more_options_"+f).click();
	$("#dd_label_"+f+"_1").val("Option 1");
	
	$("#sortable_"+f).sortable();
	$("#sortable_"+f).disableSelection();	
}

$(document).ready(function() {
	$('form').parsley();
});

$(function () {
	$('#form_step_1').parsley().on('field:validated', function () {
		var ok = $('.parsley-error').length === 0;
		$('.alert-info').toggleClass('hidden', !ok);
		$('.alert-warning').toggleClass('hidden', ok);
	})
	.on('form:submit', function () {
		//return false; // Don't submit form for this demo
	});
	
	$('#form_step_2').parsley().on('field:validated', function () {
		var ok = $('.parsley-error').length === 0;
		$('.alert-info').toggleClass('hidden', !ok);
		$('.alert-warning').toggleClass('hidden', ok);
	})
	.on('form:submit', function () {
		//return false; // Don't submit form for this demo
	});
});
</script>