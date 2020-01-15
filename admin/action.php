<?php
include("_config/config.php");
include("include/functions.php");

if(isset($_REQUEST)) {
    if($_REQUEST['action']=="save_group") {
        if($_REQUEST['id']=="") {
            $id = save_data("groups",$_POST);
            $_SESSION['success'] = "Group Added Successfully";
            header("location:groups.php");
        } else {
            $id = $_REQUEST['id'];
            save_data("groups",$_POST,$id);
            $_SESSION['success'] = "Group Added Successfully";
            header("location:groups.php");
        }
    }
    elseif($_REQUEST['action']=="add_custom_fields") {
        $target_dir = "../images/";
        $sorting_order = json_decode($_REQUEST['sorting_order'],true);
        $field_order = array();

        $i=1;
        foreach($sorting_order as $key=>$val) {
            $field_order[$val['id']] = $i++;
        }
        $_REQUEST['group_id'] = implode(",",$_REQUEST['group_id']);
        if(isset($_REQUEST['id']) && $_REQUEST['id']!="") {
            $sql_fld = "update custom_group set name = '".$_REQUEST['name']."', status = '".$_REQUEST['status']."', group_id = '".$_REQUEST['group_id']."' where id = '".$_REQUEST['id']."'";
            mysqli_query($db,$sql_fld);
            $cus_grp_id = $_REQUEST['id'];
        } else {
            $sql_fld = "insert into custom_group (name,status,group_id,user_id) values ('".$_REQUEST['name']."','".$_REQUEST['status']."','".$_REQUEST['group_id']."','".$_SESSION['id']."')";
            mysqli_query($db,$sql_fld);
            $cus_grp_id = mysqli_insert_id($db);
        }

        $sql_cus_fld = "select id from custom_fields where custom_group_id = '".$cus_grp_id."'";
        $exe_cus_fld = mysqli_query($db,$sql_cus_fld);
        $no_of_fields = mysqli_num_rows($exe_cus_fld);
        if($no_of_fields>0) {
            while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
                $sql_cus_opt = "delete from custom_options where field_id = '".$row_cus_fld['id']."'";
                $exe_cus_opt = mysqli_query($db,$sql_cus_opt);
            }
            mysqli_query($db,"delete from custom_fields where custom_group_id = '".$cus_grp_id."'");
        }

        if(isset($_REQUEST['field']) && count($_REQUEST['field'])) {
            foreach($_REQUEST['field'] as $k=>$field) {
                if(!isset($field['is_required']) || $field['is_required']!="1") {
                    $field['is_required']=0;
                }
				
                $f_icon = "";
                $file_name_f = @$_FILES['field']['name'][$k]['icon'];
                $file_tmp_name_f = @$_FILES['field']['tmp_name'][$k]['icon'];
                if(isset($file_name_f) && $file_name_f!="") {
                    $uploadOk = 1;
                    $filename = basename($file_name_f);
                    $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
					
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    $filename = date("YmdHis").rand(1,9999).".".$imageFileType;
                    $target_file = $target_dir . $filename;
                    if($uploadOk == 1) {
                        if(move_uploaded_file($file_tmp_name_f, $target_file)) {
                            $f_icon = $filename;
                        }
                    }
                } else {
                    $f_icon = $field['icon_hidden'];
                }
				
                $sql_fld = "insert into custom_fields (title,input_type,is_required,sort_order,custom_group_id,tooltip,icon) values ('".mysqli_real_escape_string($db,$field['title'])."','".$field['input_type']."','".$field['is_required']."','".$field_order[$k]."','".$cus_grp_id."','".mysqli_real_escape_string($db,$field['tooltip'])."','".$f_icon."')";
                mysqli_query($db,$sql_fld);
                $field_id = mysqli_insert_id($db);

                if(isset($field['options']) && count($field['options']>0)) {
                    $oi=1;
                    foreach($field['options'] as $option) {
                        if(!isset($option['is_default']) || $option['is_default']!="1") {
                            $option['is_default']=0;
                        }
						
                        $icon = "";
                        $file_name = @$_FILES['field']['name'][$k]['options'][$oi]['icon'];
                        $file_tmp_name = @$_FILES['field']['tmp_name'][$k]['options'][$oi]['icon'];
                        if(isset($file_name) && $file_name!="") {
                            $uploadOk = 1;
                            $filename = basename($file_name);
                            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
							
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                $uploadOk = 0;
                            }

                            $filename = date("YmdHis").rand(1,9999).".".$imageFileType;
                            $target_file = $target_dir . $filename;
                            if($uploadOk == 1) {
                                if(move_uploaded_file($file_tmp_name, $target_file)) {
                                    $icon = $filename;
                                }
                            }
                        } else {
                            $icon = $option['icon_hidden'];
                        }

                        $sql_opt = "insert into custom_options (label,add_sub,price_type,price,field_id,is_default,sort_order,tooltip,icon) values ('".mysqli_real_escape_string($db,$option['label'])."','".$option['add_sub']."','".$option['price_type']."','".$option['price']."','".$field_id."','".$option['is_default']."','".$oi."','".mysqli_real_escape_string($db,$option['tooltip'])."','".$icon."')";
                        mysqli_query($db,$sql_opt) or die(mysqli_error($db));
                        $oi++;
                    }
                }
            }
        }
        header("location:add_custom_fields.php?id=".$cus_grp_id);
    }
	elseif($_REQUEST['action']=="add_products") {
        	$_SESSION['step_track'] = $_REQUEST['step_track'];
			$target_dir = "../images/";
            $brand_id = $_REQUEST['brand_id'];
			$device_id = $_REQUEST['device_id'];
            $cat_id = $_REQUEST['cat_id'];
            $title=mysqli_real_escape_string($db,$_REQUEST['title']);
            $meta_title=mysqli_real_escape_string($db,$_REQUEST['meta_title']);
            $meta_desc=mysqli_real_escape_string($db,$_REQUEST['meta_desc']);
            $meta_keywords=mysqli_real_escape_string($db,$_REQUEST['meta_keywords']);
            $price=$_REQUEST['price'];
            $top_seller=$_REQUEST['top_seller'];
            $tooltip_device=mysqli_real_escape_string($db,$_REQUEST['tooltip_device']);
            $published = $_REQUEST['published'];
			$ordering = $_REQUEST['ordering'];
			/*$sef_url=createSlug(mysqli_real_escape_string($db,$_REQUEST['sef_url']));
			$models=mysqli_real_escape_string($db,$_REQUEST['models']);
			$searchable_words=mysqli_real_escape_string($db,$_REQUEST['searchable_words']);
			$heading_text=mysqli_real_escape_string($db,$_REQUEST['heading_text']);
			$description=mysqli_real_escape_string($db,$_REQUEST['description']);
			$meta_canonical_url=mysqli_real_escape_string($db,$_REQUEST['meta_canonical_url']);

			$released_year_month = $_REQUEST['released_year_month'];
			if($released_year_month!="") {
				$exp_released_year_month = explode("/",$released_year_month);
				$released_year_month = $exp_released_year_month['1'].'-'.$exp_released_year_month['0'];
			}*/

            if($_FILES['model_img']['name']) {
				if(!file_exists('../images/mobile/'))
					mkdir('../images/mobile/',0777);

				$image_ext = pathinfo($_FILES['model_img']['name'],PATHINFO_EXTENSION);
				if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
					if($post['old_image']!="")
						unlink('../images/mobile/'.$post['old_image']);

					$image_tmp_name=$_FILES['model_img']['tmp_name'];
					$image_name=date('YmdHis').'.'.$image_ext;
					$imageupdate=", model_img='".$image_name."'";
					move_uploaded_file($image_tmp_name,'../images/mobile/'.$image_name);
				} else {
					$msg="Image type must be png, jpg, jpeg, gif";
					$_SESSION['success_msg']=$msg;
					if($post['id']) {
						setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
					} else {
						setRedirect(ADMIN_URL.'edit_mobile.php');
					}
					exit();
				}
			}

            if(isset($_REQUEST['id']) && $_REQUEST['id']!="" && $_REQUEST['id']!="0") {
                $sql_fld = "update mobile set brand_id='".$brand_id."', title='".$title."', meta_title='".$meta_title."', meta_desc='".$meta_desc."', meta_keywords='".$meta_keywords."', device_id='".$device_id."', price='".$price."'".$imageupdate.", tooltip_device='".$tooltip_device."', top_seller='".$top_seller."', published='".$published."', cat_id='".$cat_id."', ordering='".$ordering."' where id = '".$_REQUEST['id']."'";
                mysqli_query($db,$sql_fld);
                $product_id = $_REQUEST['id'];
            } else {
				$sef_url=createSlug($title);
                $sql_fld = "insert into mobile (brand_id,title,meta_title,meta_desc,meta_keywords,device_id,price,model_img,tooltip_device,top_seller,published,cat_id,ordering) values ('".$brand_id."','".$title."','".$meta_title."','".$meta_desc."','".$meta_keywords."','".$device_id."','".$price."','".$image_name."','".$tooltip_device."','".$top_seller."','".$published."','".$cat_id."','".$ordering."')";
                mysqli_query($db,$sql_fld);
                $product_id = mysqli_insert_id($db);
            }

            $sorting_order = json_decode($_REQUEST['sorting_order'],true);
            $field_order = array();

            $i=1;
            foreach($sorting_order as $key=>$val) {
                $field_order[$val['id']] = $i++;
            }

            $sql_cus_fld = "select id from product_fields where product_id = '".$product_id."'";
            $exe_cus_fld = mysqli_query($db,$sql_cus_fld);
            $no_of_fields = mysqli_num_rows($exe_cus_fld);
            if($no_of_fields>0) {
                while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
                    $sql_cus_opt = "delete from product_options where product_field_id = '".$row_cus_fld['id']."'";
                    $exe_cus_opt = mysqli_query($db,$sql_cus_opt);
                }
                mysqli_query($db,"delete from product_fields where product_id = '".$product_id."'");
            }
			
            if(isset($_REQUEST['field']) && count($_REQUEST['field'])) {
                foreach($_REQUEST['field'] as $k=>$field) {
                    if(!isset($field['is_required']) || $field['is_required']!="1") {
                        $field['is_required']=0;
                    }

                    $f_icon = "";
                    $file_name_f = @$_FILES['field']['name'][$k]['icon'];
                    $file_tmp_name_f = @$_FILES['field']['tmp_name'][$k]['icon'];
                    if(isset($file_name_f) && $file_name_f!="") {
                        $uploadOk = 1;
                        $filename = basename($file_name_f);
                        $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }

                        $filename = date("YmdHis").rand(1,9999).".".$imageFileType;
                        $target_file = $target_dir . $filename;
                        if($uploadOk == 1) {
                            if(move_uploaded_file($file_tmp_name_f, $target_file)) {
                                $f_icon = $filename;
                            }
                        }
                    } else {
                        $f_icon = $field['icon_hidden'];
                    }
					
                    $sql_fld = "insert into product_fields (title,input_type,is_required,sort_order,product_id,tooltip,icon) values ('".mysqli_real_escape_string($db,$field['title'])."','".$field['input_type']."','".$field['is_required']."','".$field_order[$k]."','".$product_id."','".mysqli_real_escape_string($db,$field['tooltip'])."','".$f_icon."')";
                    mysqli_query($db,$sql_fld);
                    $product_field_id = mysqli_insert_id($db);
					
                    if(isset($field['options']) && count($field['options']>0)) {
                        $oi=1;
                        foreach($field['options'] as $option) {
                            if(!isset($option['is_default']) || $option['is_default']!="1") {
                                $option['is_default']=0;
                            }

                            $icon = "";
                            $file_name = @$_FILES['field']['name'][$k]['options'][$oi]['icon'];
                            $file_tmp_name = @$_FILES['field']['tmp_name'][$k]['options'][$oi]['icon'];
                            if(isset($file_name) && $file_name!="") {
                                $uploadOk = 1;
                                $filename = basename($file_name);
                                $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                                    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $uploadOk = 0;
                                }

                                $filename = date("YmdHis").rand(1,9999).".".$imageFileType;
                                $target_file = $target_dir . $filename;
                                if($uploadOk == 1) {
                                    if(move_uploaded_file($file_tmp_name, $target_file)) {
                                        $icon = $filename;
                                    }
                                }
                            } else {
                                $icon = $option['icon_hidden'];
                            }
                            $sql_opt = "insert into product_options (label,add_sub,price_type,price,product_field_id,is_default,sort_order,tooltip,icon) values ('".mysqli_real_escape_string($db,$option['label'])."','".$option['add_sub']."','".$option['price_type']."','".$option['price']."','".$product_field_id."','".$option['is_default']."','".$oi."','".mysqli_real_escape_string($db,$option['tooltip'])."','".$icon."')";
                            mysqli_query($db,$sql_opt);   
                            $oi++;
                        }
                    }
                }
            }
			
		 $msg = "Model has been successfully added.";
		 $_SESSION['success_msg'] = $msg;
         header("location:add_product.php?id=".$product_id); 
         die();
    }
    elseif($_REQUEST['action']=="get_group_fields") {
        $custom_group_ids = $_REQUEST['custom_groups'];
        $sql_cus_fld = "select * from custom_fields where custom_group_id in (".$custom_group_ids.") order by sort_order";
        $exe_cus_fld = mysqli_query($db,$sql_cus_fld);
        $no_of_fields = mysqli_num_rows($exe_cus_fld);
        $fid=$_REQUEST['no_of_fields'];
        $lis = "";
        while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)){
            //$fid = $row_cus_fld['id'];
            if($fid==1){ $active = "active"; }else{ $active = ""; }
            $lis .= '<li id="tab_'.$fid.'" class="'.$active.' dd-item dd3-item nav-item" data-id="'.$fid.'">';
            $lis .= '<div class="dd-handle-new"><i class="fa fa-list"></i></div>';
           // $lis .= '<div class="dd3-content">';
			$lis .= '<a class="dd3-content nav-link" href="#field_'.$fid.'" onclick="up_current_tab('.$fid.')" data-toggle="tab" aria-expanded="false"><span id="tab_title_<?=$fid?>">'.$row_cus_fld['title'].'</span></a>';
			//$lis .= '</div>';
		    $lis .= '</li>';      
            $fid++;
        }
        echo json_encode(array("success"=>1,"no_of_fields"=>--$fid,"lis"=>$lis));
    }
    elseif($_REQUEST['action']=="get_group_fields2") {
		$custom_group_ids = $_REQUEST['custom_groups'];
		$sql_cus_fld = "select * from custom_fields where custom_group_id in (".$custom_group_ids.") order by sort_order";
		$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
		$fid=$_REQUEST['no_of_fields'];
		while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
			//$fid = $row_cus_fld['id']; ?>
			<div class="tab-pane <?=($fid==1?"active":"")?>" id="field_<?=$fid;?>" role="tabpanel">
				<div class="m-form__group form-group row">
					<div class="col-sm-7">

						<label for="title_<?=$fid?>">Title *</label>
						<input name="field[<?=$fid?>][title]" required="" id="title_<?=$fid;?>" type="text" class="form-control m-input m-input--square" onkeyup="up_title('<?=$fid;?>')" onkeydown="up_title('<?=$fid;?>')" value="<?php echo $row_cus_fld['title']; ?>" />
					</div>
					<div class="col-sm-5">
						<label for="input_type_<?=$fid?>">Input Type *</label>
						<select name="field[<?=$fid?>][input_type]" id="input_type_<?=$fid?>" class="form-control m-input" data-style="btn-default" onchange="change_input_type('<?=$fid;?>')">
							<option <?php if($row_cus_fld['input_type']=="text"){ echo "selected"; } ?> value="text">Text Field</option>
							<option <?php if($row_cus_fld['input_type']=="textarea"){ echo "selected"; } ?> value="textarea">Text Area</option>
							<option <?php if($row_cus_fld['input_type']=="select"){ echo "selected"; } ?> value="select">Drop-down List</option>
							<option <?php if($row_cus_fld['input_type']=="radio"){ echo "selected"; } ?> value="radio">Radio Buttons</option>
							<option <?php if($row_cus_fld['input_type']=="checkbox"){ echo "selected"; } ?> value="checkbox">Checkboxes</option>
							<option <?php if($row_cus_fld['input_type']=="datepicker"){ echo "selected"; } ?> value="datepicker">Date Picker</option>
							<option <?php if($row_cus_fld['input_type']=="file"){ echo "selected"; } ?> value="file">Upload Files</option>
						</select>
					</div>
				</div>
				<div class="m-form__group form-group row">
					<div class="col-sm-7">
						<label for="tooltip_<?=$fid?>">Tooltip</label>
						<div class="m-input-icon m-input-icon--right">
							<input name="field[<?=$fid?>][tooltip]" id="tooltip_<?=$fid?>" type="text" class="form-control" value="<?php echo @$row_cus_fld['tooltip']; ?>" />
							<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
						</div>
					</div>
					
					<div class="col-sm-2">
						<label for="tooltip">Icon</label>
						<button class="btn btn-md" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
						<input name="field[<?=$fid?>][icon]" id="icon_<?=$fid?>" type="file" class="filestyle" data-input="false" style="display:none;">
					</div>
					<div class="col-sm-3">
						<label for="">&nbsp;</label>
						<?php
						if($row_cus_fld['icon']!="") { ?>
							<img src="../images/<?=$row_cus_fld['icon']?>" style="display:block;" width="40" /><i class="fa fa-trash" onclick="deleteImage(this);"></i>
						<?php
						} ?>
						<input name="field[<?=$fid?>][icon_hidden]" value="<?=$row_cus_fld['icon']?>" type="hidden" />
					</div>
				</div>
				<div class="m-form__group form-group">
					<div class="m-checkbox-inline">
						<label class="m-checkbox">
							<input name="field[<?=$fid?>][is_required]" id="is_required_<?=$fid?>" value="1" type="checkbox" <?php if($row_cus_fld['is_required']==1){ echo "checked"; } ?>>
							 Require customer selection <span></span>
						 </label>
					</div>
				</div>

				<div id="type_options_<?=$fid?>">
					<?php
					//$sql_cus_opt = mysqli_query($db,"SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."' ORDER BY sort_order");
					$sql_cus_opt = mysqli_query($db,"SELECT * FROM custom_options WHERE field_id = '".$row_cus_fld['id']."' ORDER BY sort_order");
					$no_of_dd_options = mysqli_num_rows($sql_cus_opt);
					if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio" || $row_cus_fld['input_type']=="checkbox")
					{ ?>
						<div class="m-form__group form-group">
							<button type="button" class="btn btn-md btn-success" id="add_more_options_<?=$fid?>" onclick="add_more_options('<?=$fid;?>')"> <i class="fa fa-plus"></i>  Add New Option</button>
						</div>
						<div class="m-form__group form-group row dd_header">
							<div class="col-sm-2">
								<label for="">Title</label>
							</div>
							<div class="col-sm-3">
								<label for="">Price Modifier</label>
							</div>
							<div class="col-sm-3">
								<label for="">Tooltip</label>
							</div>
							<div class="col-sm-2">
								<label for="">Icon</label>
							</div>
							<div class="col-sm-1">
								<label for="">Default</label>
								<a href="javascript:void(0);" onclick="clear_default('<?=$fid;?>')"><i class="fa fa-times"></i></a>
							</div>
							<div class="col-sm-1">
								&nbsp;
							</div>
							<input id="no_of_dd_options_<?=$fid?>" value="<?=$no_of_dd_options?>" type="hidden" />
						</div>
					<?php    
					} ?>
					
					<div id="dd_options_<?=$fid;?>">    
						<?php
						if($no_of_dd_options>0) {
							$oid=1;
							echo '<ul id="sortable_'.$fid.'">';
							while($row_cus_opt = mysqli_fetch_assoc($sql_cus_opt)) { ?>
								<li class="ui-state-default m--margin-bottom-20" data-id="<?=$oid;?>">
									<div class="m-form__group form-group row">
										<div class="col-sm-2">
											<input name="field[<?=$fid?>][options][<?=$oid?>][label]" required="" id="dd_label_<?=$fid;?>_<?=$oid;?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['label']?>" />
										</div>
										<div class="col-sm-3">
											<div class="row">
												<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
												<select name="field[<?=$fid?>][options][<?=$oid?>][add_sub]" id="dd_add_sub_<?=$fid;?>_<?=$oid;?>" class="form-control m-input">
													<option <?php if($row_cus_opt['add_sub']=="+"){ echo "selected"; } ?> value="+">+</option>
													<option <?php if($row_cus_opt['add_sub']=="-"){ echo "selected"; } ?> value="-">-</option>
												</select>
												</div>
												<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
												<select name="field[<?=$fid?>][options][<?=$oid?>][price_type]" id="dd_price_type_<?=$fid;?>_<?=$oid;?>" class="form-control m-input">
													<option <?php if($row_cus_opt['price_type']=="1"){ echo "selected"; } ?> value="1">Fixed</option>
													<option <?php if($row_cus_opt['price_type']=="0"){ echo "selected"; } ?> value="0">%</option>
												</select>
												</div>
												<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
												<input name="field[<?=$fid?>][options][<?=$oid?>][price]" id="dd_price_<?=$fid;?>_<?=$oid;?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['price']?>" placeholder="0.00" />
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="m-input-icon m-input-icon--right">
						
											<input name="field[<?=$fid?>][options][<?=$oid?>][tooltip]" id="dd_tooltip_<?=$fid?>_<?=$oid?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['tooltip']?>" />
											<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="row">
												<div class="col-sm-6" style="padding-left:2px;padding-right:2px;">
													<button class="btn btn-sm" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
													<input name="field[<?=$fid?>][options][<?=$oid?>][icon]" id="dd_icon_<?=$fid;?>_<?=$oid;?>" class="filestyle" type="file" data-input="false" style="display: none;">
													<input name="field[<?=$fid?>][options][<?=$oid?>][icon_hidden]" class="icon_hidden" value="<?=$row_cus_opt['icon']?>" type="hidden">
												</div>
												
												<?php
												if($row_cus_opt['icon']!="") { ?>
													<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
													<img src="../images/<?=$row_cus_opt['icon']?>" style="display:block;" width="30"/>
													</div>
													<div class="col-sm-2" style="padding-left:2px;padding-right:2px;">
														<i class="fa fa-trash text-danger" onclick="deleteImageOpt(this);"></i>
													</div>
												<?php
												} ?>
											</div>
										</div>
										<div class="col-sm-1">
											<label class="m-radio">
												<input name="field[<?=$fid?>][options][<?=$oid?>][is_default]" id="is_default_<?=$fid?>_<?=$oid?>" <?php if($row_cus_opt['is_default']=="1"){echo "checked";}?> value="1" type="radio" class="radio_class radio_<?=$fid?>" onclick="check_default('<?=$fid;?>')" />
												<span></span>
											</label>
										</div>
										<div class="col-sm-1">
											<i class="fa fa-trash trash" style="cursor:pointer;" onclick="remove_row(this)"></i>
										</div>
									</div>
								</li>
							<?php
							$oid++;
							} ?>
							</ul>
						<?php
						} ?>
					</div>
					<?php
					if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio" || $row_cus_fld['input_type']=="checkbox") { ?>
						<div class="m-form__group form-group">
							<button type="button" class="btn btn-md btn-success" id="add_more_options_<?=$fid;?>" onclick="add_more_options('<?=$fid;?>')"> <i class="fa fa-plus"></i>  Add New Option</button>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		<?php
		$fid++;
		}
    }
    elseif($_REQUEST['action']=="order") {   
		$sql = "insert into orders (name,email,phone_number,address,other,picture,product_id) values('".$_REQUEST['name']."','".$_REQUEST['email']."','".$_REQUEST['phone_number']."','".$_REQUEST['address']."','".json_encode($_REQUEST['other'])."','".json_encode($_REQUEST['picture'])."','".$_REQUEST['id']."')";
		$exe = mysqli_query($db,$sql) or die(mysqli_error($db));
		header("location:morden.php?id=".$_REQUEST['id']);
    }
}

function save_data($table,$data,$id="") {
    unset($data['id']);
    unset($data['action']);

    global $db;

    if($id=="") {
        $cols = "";
        $vals = "";
        foreach($data as $col=>$val) {
            $cols .= "$col,";
            $vals .= "'".$val."',";
        }

        $cols = trim($cols,",");
        $vals = trim($vals,",");
        $sql = "insert into $table ($cols) values ($vals)";
        $exe = mysqli_query($db,$sql) or die(mysqli_error($db));
        return mysqli_insert_id($db);
    } else {
        $cols = "";
        foreach($data as $col=>$val) {
            $cols .= "$col='".$val."',";
        }

        $cols = trim($cols,",");
        $sql = "update $table set $cols where id = '".$id."'";
        $exe = mysqli_query($db,$sql) or die(mysqli_error($db));
        return 1;
    }
}
?>