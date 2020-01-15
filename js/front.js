    function updateURLto(current_field) {
        
        var pathname = window.location.pathname;
        pathname = pathname.replace(/\/$/, "");
        
        params = pathname.split("/");
        
        console.log(params);
        
        var totl = params.length;
        
        var uri="";
        var step = 1;
        var er = 1;
        for(i=0; i<totl; i++){
            if(params[i]!=""){
                if(step==1){
                    uri = uri + "/"+ params[i];
                    if(params[i]=="morden"){
                        step=2;
                    }
                }else if(step==2){
                    uri = uri + "/"+ params[i];
                    er++;
                    if(er==2){
                        step=3;
                        er = 1;
                    }
                }else if(step==3){
                    if(er==current_field){
                        break;
                    }
                    uri = uri + "/"+ params[i];
                    er++;
                }
            }
            
        }
    
        var newurl = window.location.protocol + "//" + window.location.host + uri;
        window.history.pushState({path:newurl},'',newurl);
            
    }

    function backFeild(){
        lstf = $(".modern-text__row").last().index();
        
        $.each($(".modern-text__row"),function(){
            if($(this).hasClass("opened")){
                if($(this).index()!=1){
                    
                    $(this).prev().addClass("opened");
                    $(this).prev().removeClass("selected");
                    
                    
                    
                    var row_type = $(this).attr("data-row_type");
                    //console.log(row_type);
                    if(row_type=="radio" || row_type=="select"){
                        ele = $(this).find(".radioele:checked");
                        //console.log(ele);
                        price = ele.attr("data-price");
                        type = ele.attr("data-price_type");
                        sign = ele.attr("data-add_sub");
                        
                        //console.log(price+" "+type+" "+sign);
                        
                        if(typeof price !== 'undefined'){
                            if(sign=="+"){
                                sign = "-";
                            }else{
                                sign = "+";
                            }
                            
                            updatePrice(price,sign,type);
                        }
                    }else if(row_type=="checkbox"){
                        $(this).find(".checkboxele:checked").each(function(){
                            var ele = $(this);
                            //console.log(ele);
                            price = ele.attr("data-price");
                            type = ele.attr("data-price_type");
                            sign = ele.attr("data-add_sub");
                            
                            //console.log(price+" "+type+" "+sign);
                            
                            if(typeof price !== 'undefined'){
                                if(sign=="+"){
                                    sign = "-";
                                }else{
                                    sign = "+";
                                }
                                
                                updatePrice(price,sign,type);
                            }
                        });    
                    }
                    
                    
                    
                    $(this).addClass("disabled");
                    $(this).removeClass("selected");
                    $(this).removeClass("opened");
                                   
                    var current_field = $(this).prev().index();
                    //updateURLto(current_field);
                    
                    if($(this).index()!=lstf){
                        $("#get-price-btn").hide();
						$("#quantity-section").hide();
                    }
                    
                    return false;
                }
            }
        })
        
        if(!$(".modern-text__row").hasClass("opened")){
            current_field = $(".modern-text__row").last().index();
            
            $(".modern-text__row").last().removeClass("disabled");
            $(".modern-text__row").last().removeClass("selected");
            $(".modern-text__row").last().addClass("opened");
            
            $("#get-price-btn").hide();
			$("#quantity-section").hide();
           
            //updateURLto(current_field);
            return false;
            
        }
        
    }
    
    function updatePrice(price,sign,type){
        if(type==0){
            var total_price_org = $("#total_price_org").val();
            price = (total_price_org*price)/100;
            var total_price = $(".show_final_amt_val").html();
        }else{
            var total_price = $(".show_final_amt_val").html();
        }
        
        if(sign=="+"){
            total_price = Number(total_price) + Number(price);
        }else{
            total_price = Number(total_price) - Number(price);
        }
        
        $(".show_final_amt").html(total_price);
		$(".show_final_amt_val").html(total_price);
		
    }
    
    function updatePrice_chk(price,sign,type,obj){
        
        if($(obj).is(":checked")){
            
        }else{
           if(sign=="+"){
                sign = "-";
            }else{
                sign = "+";
            } 
        }
        if(type==0){
            var total_price_org = $("#total_price_org").val();
            price = (total_price_org*price)/100;
            var total_price = $(".show_final_amt_val").html();
        }else{
            var total_price = $(".show_final_amt_val").html();
        }
        
        if(sign=="+"){
            total_price = Number(total_price) + Number(price);
        }else{
            total_price = Number(total_price) - Number(price);
        }
        
        $(".show_final_amt").html(total_price);
        $(".show_final_amt_val").html(total_price);
        
        
        var cc = $(obj).parent().parent().parent().find("input:checked").length;
        if(cc>0){
             $(obj).parent().parent().parent().parent().find(".text-danger").html("");
        }
        
    }
     
    function updateURL(param) {
        if(history.pushState) {
            var pathname = window.location.pathname;
            pathname = pathname.replace(/\/$/, "");
            
            var newurl = window.location.protocol + "//" + window.location.host + pathname +"/"+ param;
            window.history.pushState({path:newurl},'',newurl);
        }
    }
    
    function chechdata(){
        $("#payment_amt").val($(".show_final_amt_val").html());
        return true;
    }
    
    function changefile(obj){
		var str  = obj.value;
		$(obj).next().html(str);
        //$(obj).prev().html("");
    }
	
	function selectNewFile(obj) {
		$(obj).parent().html("");
	}
    
    $(document).ready(function(){
        $(".select-area__title").click(function(){
            $("#device").show('slow');
            $(this).parent().parent().parent().removeClass("opened");
        })
        
        $(".modern-block__content button").click(function(){
            $(this).parent().parent().parent().find(".text-danger").html("");
            $(this).parent().siblings().each(function(){
                $(this).find(".capacity-row").removeClass("sel");
            });
            
            var elem = $(this).parent().parent().find("input:checked");
            price = elem.attr("data-price");
            type = elem.attr("data-price_type");
            sign = elem.attr("data-add_sub");
            
            console.log(price+" "+type+" "+sign);           
            if(typeof price !== 'undefined'){
                if(sign=="+"){
                    sign = "-";
                }else{
                    sign = "+";
                }
                updatePrice(price,sign,type);
            }
            
            $(this).next().click();
            $(this).addClass("sel");
        })

        $(".modern-block__content a, .radio_btn").click(function() {
			var is_submit = $(this).attr("data-issubmit");													 
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="radio" || data_input_type == "select") {
				var crt_row_type = $(this).parent().parent().parent().parent().attr("data-row_type");
            	var is_required = $(this).parent().parent().parent().parent().attr("data-required");

				if(is_required=="1"){
					if(crt_row_type=="radio" || crt_row_type=="select"){
						var cc = $(this).parent().find("input:checked").length;
						if(cc==0){
							$(this).parent().parent().next().html("<br />Please choose an option");
							return false;
						}
					}
				}

				crnf = $(this).parent().parent().parent().parent().index();
				lstf = $(".modern-text__row").last().index();
				if(crnf==lstf){
					$("#get-price-btn").show();
					$("#quantity-section").show();
				}

				var row_type = $(this).parent().parent().parent().parent().next().attr("data-row_type");
				if(row_type=="radio" || row_type=="select"){
					if($(this).parent().parent().parent().parent().next().find("input[type='radio']").is(":checked")){
						var elem = $(this).parent().parent().parent().parent().next().find("input:checked");
						elem.prev().addClass("sel");
						elem.click();
						var tab_id = elem.prev().attr("href");
						$(tab_id).addClass("active");
					}else{
						var elem = $(this).parent().parent().parent().parent().next().find("input[data-default='1']");
						elem.prev().addClass("sel");                
						elem.click();
						var tab_id = elem.prev().attr("href");
						$(tab_id).addClass("active");
					}
				} else if(row_type=="checkbox"){
					if($(this).parent().parent().next().find("input[type='checkbox']").is(":checked")){
						$(this).parent().parent().next().find(".checkboxele:checked").each(function(){
							var ele = $(this);
							price = ele.attr("data-price");
							type = ele.attr("data-price_type");
							sign = ele.attr("data-add_sub");
							
							if(typeof price !== 'undefined'){
								updatePrice(price,sign,type);
							}
						});
					} else {
						var elem = $(this).parent().parent().next().find("input[data-default='1']");
						elem.click();
					}
				}

				$(this).parent().parent().parent().parent().removeClass("opened");
				$(this).parent().parent().parent().parent().addClass("selected");
				$(this).parent().parent().parent().parent().next().removeClass("disabled");
				$(this).parent().parent().parent().parent().next().addClass("opened");

				if($(this).next().hasClass("input")) {
					var html = $(this).next().val();
					html = html.substr(0, 7)+"...";
					var urlval = $(this).next().prop("name");
				} else if(crt_row_type=="radio" || crt_row_type=="select") {
					var html = $(this).parent().find("input:checked").attr("value");
					var urlval = html;
				} else if(crt_row_type=="checkbox") {
					var html = $(this).prev().find('input:checked').map(function() {
									return this.value;
								}).get().join(', ');
					var urlval = html;
					//html = html.substr(0, 7)+"...";
				}
				
				//if(crt_row_type=="checkbox") {
					//$(this).parent().parent().parent().next().html(html);
				//} else {
					$(this).parent().parent().parent().next().children(1).html(html);
				//}
			} else {
				var crt_row_type = $(this).parent().parent().attr("data-row_type");
            	var is_required = $(this).parent().parent().attr("data-required");
				
				if(is_required=="1"){
					if($(this).prev().hasClass("input")){
						if($(this).prev().val()==""){
							if($(this).parent().parent().attr("data-row_type")=="file"){
								$(this).prev().prev().html("Please Choose File");
							}else{
								$(this).prev().attr("placeholder","Please Enter Value");
							} 
							return false;
						}
					}
					else if(crt_row_type=="radio" || crt_row_type=="select"){
						var cc = $(this).prev().prev().find("input:checked").length;
						if(cc==0){
							$(this).next().html("<br />Please choose an option");
							return false;
						}
					}
					else if(crt_row_type=="checkbox"){
						var cc = $(this).prev().find("input:checked").length;
						if(cc==0){
							$(this).next().html("<br />Please choose an option");
							return false;
						}
					}
				}
				
				crnf = $(this).parent().parent().index();
				lstf = $(".modern-text__row").last().index();
				if(crnf==lstf){
					$("#get-price-btn").show();
					$("#quantity-section").show();
				}

				var row_type = $(this).parent().parent().next().attr("data-row_type");
				if(row_type=="radio" || row_type=="select"){
					if($(this).parent().parent().next().find("input[type='radio']").is(":checked")){
						var elem = $(this).parent().parent().next().find("input:checked");
						elem.prev().addClass("sel");
						elem.click();
						var tab_id = elem.prev().attr("href");
						$(tab_id).addClass("active");
					} else {
						var elem = $(this).parent().parent().next().find("input[data-default='1']");
						elem.prev().addClass("sel");                
						elem.click();
						var tab_id = elem.prev().attr("href");
						$(tab_id).addClass("active");
					}
				} else if(row_type=="checkbox"){
					if($(this).parent().parent().next().find("input[type='checkbox']").is(":checked")){
						$(this).parent().parent().next().find(".checkboxele:checked").each(function(){
							var ele = $(this);
							price = ele.attr("data-price");
							type = ele.attr("data-price_type");
							sign = ele.attr("data-add_sub");
							
							if(typeof price !== 'undefined'){
								updatePrice(price,sign,type);
							}
						});
					} else {
						var elem = $(this).parent().parent().next().find("input[data-default='1']");
						elem.click();
					}
				}
				
				$(this).parent().parent().removeClass("opened");
				$(this).parent().parent().addClass("selected");
				$(this).parent().parent().next().removeClass("disabled");
				$(this).parent().parent().next().addClass("opened");
				
				if($(this).prev().hasClass("input")){
					var html = $(this).prev().val();
					html = html.substr(0, 7)+"...";
					var urlval = $(this).prev().prop("name");
				}
				else if(crt_row_type=="radio" || crt_row_type=="select")
				{
					var html = $(this).prev().prev().find("input:checked").attr("value");
					var urlval = html;
				}
				else if(crt_row_type=="checkbox")
				{
					var html = $(this).prev().find('input:checked').map(function() {return this.value;}).get().join(', ');
					var urlval = html;
					//html = html.substr(0, 7)+"...";
				}
				
				//if(crt_row_type=="checkbox") {
					//$(this).parent().next().html(html);
				//} else {
					$(this).parent().next().children(1).html(html);
				//}
			}
			
            //updateURL(urlval);
			
			if(is_submit == "yes") {
			   //$("#form_submit").submit();
		    }
        })
        
        $(".modern-block__selected").click(function(){
            
            var current_field = $(this).parent().index();
            var is_submit = $(this).attr("data-issubmit");
			
            var lstf = $(".modern-text__row").last().index();
            if(current_field!=lstf){
                $("#get-price-btn").hide();
				$("#quantity-section").hide();
            }
            
            //updateURLto(current_field);
            
            var i = 1;
            $(".modern-text__row").each(function(){
                if(i<current_field){
                    $(this).addClass("selected");
                }
                if(i==current_field){
                    $(this).addClass("opened");
                    $(this).removeClass("selected");
                }
                if(i>current_field){
                    $(this).addClass("disabled");
                    $(this).removeClass("selected");
                    ///
                    $(this).removeClass("opened");
                    ///
                }
                i++;
            })
            
            ///////////////////
			
            $.each($(".modern-text__row"),function(){
                    
                    console.log($(this).index()+" -- "+ current_field);
                    
                    if($(this).index()==1){
                        var total_price_org = $("#total_price_org").val();
                        $(".show_final_amt").html(total_price_org);
						$(".show_final_amt_val").html(total_price_org);
                    }
                                  
                    if($(this).index() <= current_field){
    
                        var row_type = $(this).attr("data-row_type");
                        //console.log(row_type);
                        if(row_type=="radio" || row_type=="select"){
                            
                            ele = $(this).find(".radioele:checked");
                            console.log(ele);
                            price = ele.attr("data-price");
                            type = ele.attr("data-price_type");
                            sign = ele.attr("data-add_sub");
                            
                            console.log(price+" "+type+" "+sign);
                            
                            if(typeof price !== 'undefined'){
                                updatePrice(price,sign,type);
                            }    
                        } else if(row_type=="checkbox"){
                            $(this).find(".checkboxele:checked").each(function(){
                                var ele = $(this);
                                console.log(ele);
                                price = ele.attr("data-price");
                                type = ele.attr("data-price_type");
                                sign = ele.attr("data-add_sub");
                                
                                console.log(price+" "+type+" "+sign);
                                
                                if(typeof price !== 'undefined'){
                                    updatePrice(price,sign,type);
                                }
                            });    
                        }
                    }
            });
            
            if(is_submit == "yes") {
			   //$("#form_submit").submit();
		    }
        })      
    })