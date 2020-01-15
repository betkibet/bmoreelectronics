
var activeChannel;
var client;
var generalChannel;
var messagingClient;
var activeChannelPage;
var typingMembers=[];
var updateChannel;
var messageUpdateFlag=false;
var firstMessageAction=true;
 

/*$(window).on("beforeunload", function(onject) { 

 
 localStorage.setItem("guestuser","")
 return confirm("fdsafdasfdsa")
 
 
});
*/

$(document).ready(function(){

 
   
   			$("#chatmessage").bind('scroll', function(){
										var y = $(this).scrollTop();
										
										if (y == 0) {
										$(".loader").show();
										second_time_scrollingData();
										}  
										
										
							});

		  $('#MessageArea').on('keydown', function(event) {
						 if (event.keyCode == 13)
						{
								if (!event.shiftKey) 
								{
								messgeSend();
								}
						}
						 else
						{
						  generalChannel.typing();
						}
      
			});
		  getToken();

          
});
//====================set Cookies and get Cookies=============
  function setCookie(key, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
//===================================================================
function getToken()
{
	//var guestuser = $.cookie("guestuser");
	var guestuser=getCookie('guestuser');
if(guestuser !="" || guestuser !=null)
{
	$(".loader1").show();
  $.ajax({
    url: 'http://twilio-bulksms.webgrowthindia.com/twilio_chat_token.php',
    type: 'GET',
    data: {id:guestuser,type:"cust"},
    dataType: 'json',
    contentType: 'application/x-www-form-urlencoded',
    success: function (data) {

		var token=data.token; 
    //client = new Twilio.Chat.Client(token, { logLevel: 'debug' });
     
     client = new Twilio.Chat.Client(token, { logLevel: 'silent' });

    //  client = new Twilio.Chat.Client(token, { logLevel: 'debug' });
     setTimeout(function() {

       client.initialize().then(function(status){
        console.log(localStorage.getItem("guestuser") )

 
    $("#overlay").hide();
    $(".popup").hide();
   localHistoryLoad();


console.log("twilio Initialization ready mode");

   


      },function(error)
      {
        console.log("initialize error",error);
		$("#overlay").show();
   $(".popup").show();
   $(".loader1").hide();
      });
         


 }, 10);


    },
    error: function(error) {
      
      alert(JSON.stringify(error));
        console.log("error");
    }
}); 

}
else
{
  $("#overlay").show();
   $(".popup").show();
   $(".loader1").hide();

}

}


//=====================================First time Channel Create in localStoratge wise add particular store=============

function loginIsGuestUser()
{


  var guestuser=$("#login-name").val();
 var timestamp = jQuery.now();
 var channelName=guestuser.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'') +"_"+ timestamp ;
 
 console.log("channelName",channelName)
 
			 if(guestuser != "")
			{
						$(".loader1").show();
						
						$("#overlay").show();
						 $(".popup").hide();
						 
									  $.ajax({
										url: 'http://twilio-bulksms.webgrowthindia.com/twilio_chat_token.php',
										type: 'GET',
										data: {id:channelName,type:"cust"},
										dataType: 'json',
										contentType: 'application/x-www-form-urlencoded',
										success: function (data) {
									
													var token=data.token; 
											   client = new Twilio.Chat.Client(token, { logLevel: 'silent' });
									
											//  client = new Twilio.Chat.Client(token, { logLevel: 'debug' });
															setTimeout(function() {
													
														 client.initialize().then(function(status){
																		console.log(localStorage.getItem("guestuser") )
																					
																			localStorage.setItem("guestuser", channelName);
																			//$.cookie("guestuser", channelName, { expires : 1 });
																			setCookie('guestuser',channelName);
																			setCookie('firstpopup','firstpopup');
																			client.getChannelByUniqueName(guestuser).then(function(channel) {
																							console.log("channel",channel)
																							generalChannel = channel;
																							
																							if (!generalChannel) {
																							// If it doesn't exist, let's create it
																							
																							} else {
																							
																							setupChannel(generalChannel);
																							}
																					},function (error){
																					
																					console.log("shreyash generate error ",error)
																					client.createChannel({
																						uniqueName: channelName,
																						friendlyName:guestuser,
																						attributes:{created_id:'100',topic_id:'20',vehicle_id:'10',subc_id:'139'},
																						isPrivate: false
																						}).then(function(channel) {
																						generalChannel = channel;
																						$("#overlay").hide();
																						$(".popup").hide();
																						setupChannel(generalChannel);
																					});
																					});
																					
																					
																					
																					
																					
																					console.log("twilio Initialization ready mode");
							
							   
							
							
															  },function(error)
															  {
																console.log("initialize error",error)
															  });
									 
							
							
											 }, 10);
										
						
							},
							error: function(error) {
							  
							  alert(JSON.stringify(error));
								console.log("error");
							}
						}); 
			
			 
			 
			 
			} 
 
}
//==========================localStorage Store data rettrives ==============
function localHistoryLoad()
{
     //var guestuser=localStorage.getItem("guestuser");

 		//var guestuser = $.cookie("guestuser");
			var guestuser=getCookie('guestuser');
			localStorage.setItem("guestuser", getCookie('guestuser'));
        console.log("Local Storage data = ",guestuser)
          client.getChannelByUniqueName(guestuser).then(function(channel) {
            console.log("channel",channel)
            generalChannel = channel;
           
                    generalChannel = channel;
                    setupChannel(generalChannel);
               
        },function (error){

          console.log("error",error)
        });


}


//============================================== first time intialization chennel setup=============
  function setupChannel(generalChannel) {


$("#overlay").hide();
$(".popup").hide();
$(".loader1").hide();

			console.log("generalChannel",generalChannel.sid);
			memmberAddAdminInCustomer(generalChannel.sid);
			  generalChannel.join().then(function(channel) {
							console.log("join",channel)
				  		// $chatWindow.removeClass('loader');
						$(".loader1").hide();
				});
    		  generalChannel.on('messageAdded',AddnewMessages);
      //========================================Fisrt time Typing start here(Two function=>1)start and eding =======================
        generalChannel.on('typingStarted', function(member) {
					   	console.log("typingStarted success")
						  typingMembers.push(member.identity);
						  updateTypingIndicator();
      },function(erro){
        				console.log("typingStarted error",erro)
      });
     
	 	generalChannel.on('typingEnded', function(member) {
						console.log("typingEnded success")
						typingMembers.splice(typingMembers.indexOf(member.identity), 1 );
					   
						updateTypingIndicator();
		},function(error){
	
		  console.log("typingEnded eror",error)
		});
//============================================================Message Removed===============================================================
				 generalChannel.on('messageRemoved', function(RemoveMessageFlag){
							console.log("removeMessage",RemoveMessageFlag.state.index);
							
							$("#message_"+RemoveMessageFlag.state.index).remove();
						  

              });
				//============================================================Message updated===================================
			  generalChannel.on('messageUpdated', function(messageUpdatedFlag){
				console.log("messageUpdated",messageUpdatedFlag);
				
				$("#editmessage_"+messageUpdatedFlag.index).text(messageUpdatedFlag.body);
				 
			   
			   
			 
			
				
			
			
			  });
	//============================================Frist time channel get message===============================
   //===================================twilio channel message get frist time ==================================================================
				
				generalChannel.getMessages(20).then(function(messages) {
								console.log("messages",messages);
								activeMessageChannel=messages;
								
								if (messages.hasPrevPage == false) {
								
								
								Scrolldisable = true;
								} else {
								
								Scrolldisable = false;
								
								}
								msgI=0;
								LoopMessageShow(messages)
				 
				
							 
							 
						 
							 
								
				});
	  
}
   
//========================================Send new messages================================================

function messgeSend()
{
			var message=$("#MessageArea").val();
			if(message !="")
			{
					if(messageUpdateFlag == true)
					{
						messageUpdateFlag=false;
						updateChannel.updateBody(message).then(function(message)
							{
								$("#MessageArea").val("")								 
																		
							})
					}
					else
					{
						  var  messageAttributes={       
								
								StaffuserName:localStorage.getItem("guestuser") ,
								ServerDate:"",
								sms_unique_id:"",  
							   }
								console.log(messageAttributes);
							  generalChannel.sendMessage(message,messageAttributes).then(function(message){
										console.log("message send");
										$("#MessageArea").val("")
										
							  });
					}
			}
     
    }
//====================================first time add message===============
function AddnewMessages(message)
{
  				/*	console.log("new-messages",message)
					  if(message.state.attributes.StaffuserName == localStorage.getItem("guestuser"))
					  {
							$("#chatmessage").append("<li style='text-align: left;'>"+message.state.body+"</li>");
					  }
					  else if(message.state.attributes.StaffuserName== "admin")
					  {
							$("#chatmessage").append("<li style='text-align: right;'>"+message.state.body+"</li>");
					
					  }
					  client.on('channelUpdated', updateChannels);*/
					  
			generalChannel.getMessages(1).then(function(messagesPaginator){
						
					const ImageURL = messagesPaginator.items[0];
					
							if(message.state.attributes.StaffuserName == localStorage.getItem("guestuser"))
							{
										 
										if (message.type === 'media')
										{
													 ImageURL.media.getContentUrl().then(function(url){
														console.log("IMAGE url",url);
													if(message.state.media.state.contentType == "image/jpeg" || message.state.media.state.contentType == "image/png")
													{
														//==============image print 
														var temp='<div class="m-messenger__wrapper" id="message_'+message.state.index+'" >'
																+'<div class="m-messenger__message m-messenger__message--out">'
																+'<div class="m-messenger__message-body">'
																+'<div class="modify-btn">'
																+'<a id="'+message.state.index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
																+'<i class="la la-close"></i>'
																+'</a>'
																+'</div>'
																+'<div class="m-messenger__message-arrow"></div>'
																+'<div class="m-messenger__message-content">'
																+'<div class="m-messenger__message-text"><img src="'+url+'" height="100px" width="100px"/></div>'
																+'</div>'
																+'</div>'
																+'</div>'
																+'</div>';
													$("#chatmessage").append(temp);
														 
														//$("#chatmessage").append("<li id='message_"+message.state.index+"' class='classleft'><img src='"+url+"' /> <div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
													}
													else
													{
														//= ==========Any file print hre admin side ======
														 var temp='<div class="m-messenger__wrapper" id="message_'+message.state.index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													
													+'<a id="'+message.state.index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text"><a src="'+url+'"/></a></div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").append(temp);
													//$("#chatmessage").append("<li id='message_"+message.state.index+"' class='classleft'><a href='"+url+"' >file</a><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div> </li>");
													}
													 
										
											});

										}
										else
										{
											// -------------simple text print ================
											
												 var temp='<div class="m-messenger__wrapper" id="message_'+message.state.index+'" >'
														+'<div class="m-messenger__message m-messenger__message--out">'
														+'<div class="m-messenger__message-body">'
														+'<div class="modify-btn">'
														+'<a id="'+message.state.index+'" onclick="MessageEdit(this.id);" class="edit btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill" >'
														+'<i class="la la-pencil"></i>'
														+'</a>'
														+'<a id="'+message.state.index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
														+'<i class="la la-close"></i>'
														+'</a>'
														+'</div>'
														+'<div class="m-messenger__message-arrow"></div>'
														+'<div class="m-messenger__message-content">'
														+'<div class="m-messenger__message-text" id="editmessage_'+message.state.index+'">'+message.state.body+'</div>'
														+'</div>'
														+'</div>'
														+'</div>'
														+'</div>';
														$("#chatmessage").append(temp);
															var firstpopup=getCookie('firstpopup');
														if(firstpopup=="firstpopup")
														{
														setTimeout(function(){ 
																			
													
												 												
														var temp='<div class="m-messenger__wrapper" id="firstshowPopup">'
																+'<div class="m-messenger__message m-messenger__message--in">'
																 
																+'<div class="m-messenger__message-body">'
																 
																+'<div class="m-messenger__message-content">'
																 
																+'<div class="m-messenger__message-text"><input type="text" id="phoneMessage" placeholder="phone number" /><button onclick="popupSendPhoneNumber();">send</button></div>'
																+'</div>'
																+'</div>'
																+'</div>'
																+'</div>';
														$("#chatmessage").append(temp);
														setCookie('firstpopup','firstpopup11');
																			
																			
																			}, 2000);	
															
														}
											 
											 
												
											
											 
											//$("#chatmessage").append("<li id='message_"+message.state.index+"' class='classleft'>"+message.state.body+"<div id='"+message.state.index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+message.state.index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
										}
							
							}
							else
							{
										if (message.type === 'media')
										{
											 ImageURL.media.getContentUrl().then(function(url){
												 console.log("IMAGE url",url);
												if(message.state.media.state.contentType == "image/jpeg" || message.state.media.state.contentType == "image/png")
													{
														var temp='<div class="m-messenger__wrapper">'
														+'<div class="m-messenger__message m-messenger__message--in">'
														+'<div class="m-messenger__message-pic">'
														+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
														+'</div>'
														+'<div class="m-messenger__message-body">'
														+'<div class="m-messenger__message-arrow"></div>'
														+'<div class="m-messenger__message-content">'
														+'<div class="m-messenger__message-username">'
														+'<img src="'+url+'" height="100px" width="100px"/>'
														+'</div>'
														+'<div class="m-messenger__message-text">'
														+'</div>'
														+'</div>'
														+'</div>'
														+'</div>'
														+'</div>';
												$("#chatmessage").append(temp);
														//$("#chatmessage").append("<li class='classright'><img src='"+url+"' /> </li>");
													}
													else
													{
														var temp='<div class="m-messenger__wrapper">'
															+'<div class="m-messenger__message m-messenger__message--in">'
															+'<div class="m-messenger__message-pic">'
															+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
															+'</div>'
															+'<div class="m-messenger__message-body">'
															+'<div class="m-messenger__message-arrow"></div>'
															+'<div class="m-messenger__message-content">'
															+'<div class="m-messenger__message-username">'
															 
															+'<a href="'+url+'" >file</a>' 
															+'</div>'
															+'<div class="m-messenger__message-text">'
															+'</div>'
															+'</div>'
															+'</div>'
															+'</div>'
															+'</div>';
														 $("#chatmessage").append(temp);
														//$("#chatmessage").append("<li class='classright'><a href='"+url+"' >file</a> </li>");
													}									  
											});

										}
										else
										{
											
											if(message.state.attributes.note == "note")
											{
												//$("#chatmessage").append("<li style='text-align: right; color:yellow;'>"+message.state.body+"</li>");
											}
											else
											{
												var temp='<div class="m-messenger__wrapper">'
													+'<div class="m-messenger__message m-messenger__message--in">'
													+'<div class="m-messenger__message-pic">'
													+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
													+'</div>'
													+'<div class="m-messenger__message-body">'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-username">'
													 
													+'</div>'
													+'<div class="m-messenger__message-text">'+message.state.body+'</div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").append(temp);
												//$("#chatmessage").append("<li class='classright'>"+message.state.body+"</li>");
											}
											
										 
										}							
							}
					})
					$("html, body").animate({ scrollTop: $(document).height() }, 1000);
					
					 client.on('channelUpdated', updateChannels);

}
//=================================Twilio channel Update ====================================================
function updateChannels()
{
}
//==============================this function used indication chat tping show =================
function updateTypingIndicator() {
			 var typingIndicationMessage='Typing: ';
			 
			var names = Array.from(typingMembers).slice(0,3);
			
			if (typingMembers.length) {
			  	typingIndicationMessage += names.join(', ');
			}
		  
			if (typingMembers.size > 3) {
			 	 typingIndicationMessage += ', and ' + (typingMembers.size-3) + 'more';
			}
		  
			if (typingMembers.length) {
			 	 typingIndicationMessage += '...';
			} else {
			  	typingIndicationMessage = '';
			}
		  // console.log(this.typingIndicationMessage);
			$('#typing-indicator').text(typingIndicationMessage);
		   
  }
//=======================Add member twilio channel =================
function memmberAddAdminInCustomer(sid)
{
			$.ajax({
						url: 'http://twilio-bulksms.webgrowthindia.com/twilio_chat_add_member.php',
						type: 'POST',
						data: {channel_id:sid,type:"cust"},
						dataType: 'json',
						contentType: 'application/x-www-form-urlencoded',
						success: function (data) 
						{
								console.log("memeberaddd",data)
					
					   },
					  error: function(error) {
						  
						  alert(JSON.stringify(error));
							console.log("error");
				     }
				}); 
}
/////==============================================Image file to send here =================================
function fileControlFileGet(filePath)
{
	
						 console.log("filePath",filePath);
						 const formData = new FormData();
	var  messageAttributes={
					StaffuserName:localStorage.getItem("guestuser"),
					ServerDate:"",
					sms_unique_id:"",  
					}
					formData.append('file', $('#formInputFile')[0].files[0]);
  					generalChannel.sendMessage(formData,messageAttributes).then(function(message){
						 console.log("message",message);
							$("html, body").animate({ scrollTop: $(document).height() }, 1000);
							
					});
	
}
//==============================================================Delete Message and Image ===============================================================================

function MessageDelete(msgIndex)
{
	 
	console.log(msgIndex)
	 var r = confirm("Are you sure you want to delete?");
    if (r == true) {
				 setTimeout(function() {
						 var index=parseInt(msgIndex);
						generalChannel.getMessages(1,index,).then(function(m){
																	  
								console.log("getmessage",m);		  
								
								deleteMessage(m)
						}) 
			
			  }, 10);
    }  
                       
}
function deleteMessage(paginator) {
   
    paginator.items.forEach(function(message){
        console.log('' + message.index + ' ' + message.body);
      message.remove();
       
   
    });
     
}
//=====================================================================Edit Only message and note ======================================================================
function MessageEdit(msgIndex)
{
	console.log(msgIndex)
	 setTimeout(function() {
		 var index=parseInt(msgIndex);
			generalChannel.getMessages(1,index,).then(function(m){
					
					console.log("getmessage",m);		  
					
					EditMessageDisplay(m)
			}) 
	
	  }, 10);
}
function EditMessageDisplay(paginator)
{
	  paginator.items.forEach(function(message){
		   updateChannel=message;
		  messageUpdateFlag=true;
			 $("#MessageArea").val(message.body);
			 $("#MessageArea").focus();
		  
			console.log('message index=' + message.index + 'message body ' + message.body);
		
	   
	});
}
//============================================================Show browser file=======================
function showBrowserFile()
{
	$("#formInputFile").click();
}
/////////==========================Secon time Scrooling data =========================
function second_time_scrollingData()
{

			if(Scrolldisable == true)
			{
				 
				$(".loader").hide();
			}
			else
			{
					activeMessageChannel.prevPage().then(function(messages)
					{
							activeMessageChannel=messages;
							if (messages.hasPrevPage == false) {
							
							
							Scrolldisable = true;
							} else {
							
							Scrolldisable = false;
							
							}
									msgI=messages.items.length -1 
								Scrolling_SecondLoopMessageShow(messages);
					
					});
			
			}


}
//====================================================fisrt time message list get and (this function implement reson image and message get and show (note for loop not working then call here))=======
function LoopMessageShow(latestPage)
{
	console.log("latestPage.length",latestPage.length);
	if(msgI <latestPage.items.length)
	{
			if(latestPage.items[msgI].attributes.StaffuserName == localStorage.getItem("guestuser"))
			{
				
					if (latestPage.items[msgI].type == 'media')
					{
						 latestPage.items[msgI].media.getContentUrl().then(function(url){
							  if(latestPage.items[msgI].state.media.state.contentType =="image/jpeg" || latestPage.items[msgI].state.media.state.contentType =="image/png")
         					 {
								 
										var temp='<div class="m-messenger__wrapper" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text"><img src="'+url+'" height="100px" width="100px"/></div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").append(temp);
													
								// $("#chatmessage").append("<li id='message_"+latestPage.items[msgI].index+"' class='classleft'><img src='"+url+"' /><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								 
								 
									
								 msgI++;
								 LoopMessageShow(latestPage);
								 
							 }
							 else
							 {
								 var temp='<div class="m-messenger__wrapper" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text"><a src="'+url+'"/></a></div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").append(temp);
								// $("#chatmessage").append("<li  id='message_"+latestPage.items[msgI].index+"' class='classleft'><a href='"+url+"' >file</a><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								 msgI++;
								 LoopMessageShow(latestPage);

							 }
						})
					}
					else
					{
							if(latestPage.items[msgI].attributes.note == "note")
							{
								 
								//$("#chatmessage").prepend("<li id='message_"+latestPage.items[msgI].index+"' class='classleft note'> "+latestPage.items[msgI].body+"<img src='note.png'/><div id='"+latestPage.items[msgI].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								 msgI++;
								 LoopMessageShow(latestPage);
							}
							else
							{
								
								 var temp='<div class="m-messenger__wrapper" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													+'<a id="'+latestPage.items[msgI].index+'" onclick="MessageEdit(this.id);" class="edit btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill" >'
													+'<i class="la la-pencil"></i>'
													+'</a>'
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text" id="editmessage_'+latestPage.items[msgI].index+'">'+latestPage.items[msgI].body+'</div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
												$("#chatmessage").append(temp);
							//$("#chatmessage").prepend("<li id='message_"+latestPage.items[msgI].index+"'  class='classleft'>"+latestPage.items[msgI].body+"<div id='"+latestPage.items[msgI].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								 msgI++;
								 LoopMessageShow(latestPage);
							}
					}
			}
			else
			{
				if (latestPage.items[msgI].type == 'media')
					{
						 latestPage.items[msgI].media.getContentUrl().then(function(url){
							  if(latestPage.items[msgI].state.media.state.contentType =="image/jpeg" || latestPage.items[msgI].state.media.state.contentType =="image/png")
         					 {
								// $("#chatmessage").append("<li class='classright'><img src='"+url+"' /> </li>");
								 var temp='<div class="m-messenger__wrapper">'
												+'<div class="m-messenger__message m-messenger__message--in">'
												+'<div class="m-messenger__message-pic">'
												+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
												+'</div>'
												+'<div class="m-messenger__message-body">'
												+'<div class="m-messenger__message-arrow"></div>'
												+'<div class="m-messenger__message-content">'
												+'<div class="m-messenger__message-username">'
												+'<img src="'+url+'" height="100px" width="100px"/>'
												+'</div>'
												+'<div class="m-messenger__message-text">'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>';
												$("#chatmessage").append(temp);
								 msgI++;
								 LoopMessageShow(latestPage);
							 }
							 else
							 {
								  var temp='<div class="m-messenger__wrapper">'
												+'<div class="m-messenger__message m-messenger__message--in">'
												+'<div class="m-messenger__message-pic">'
												+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
												+'</div>'
												+'<div class="m-messenger__message-body">'
												+'<div class="m-messenger__message-arrow"></div>'
												+'<div class="m-messenger__message-content">'
												+'<div class="m-messenger__message-username">'
												 
												+'<a href="'+url+'" >file</a>' 
												+'</div>'
												+'<div class="m-messenger__message-text">'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>';
											 $("#chatmessage").append(temp);
								// $("#chatmessage").append("<li class='classright'><a href='"+url+"' >file</a> </li>");
								 msgI++;
								 LoopMessageShow(latestPage);

							 }
						})
					}
					else
					{
								var temp='<div class="m-messenger__wrapper">'
												+'<div class="m-messenger__message m-messenger__message--in">'
												+'<div class="m-messenger__message-pic">'
												+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
												+'</div>'
												+'<div class="m-messenger__message-body">'
												+'<div class="m-messenger__message-arrow"></div>'
												+'<div class="m-messenger__message-content">'
												+'<div class="m-messenger__message-username">'
												 
												+'</div>'
												+'<div class="m-messenger__message-text">'+latestPage.items[msgI].body+'</div>'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>';
												$("#chatmessage").append(temp);
							//$("#chatmessage").append("<li class='classright'>"+latestPage.items[msgI].body+"</li>");
							msgI++;
								 LoopMessageShow(latestPage);
					}
			}
		
	}
	else
	{
		$(".loader").hide();
		$("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
	}
	
}
//==============================================Second Time after refrshing data get OR agter scrolling wise in here=============================================
function Scrolling_SecondLoopMessageShow(latestPage)
{
	 
	if(msgI <latestPage.items.length && msgI != -1)
	{
			if(latestPage.items[msgI].attributes.StaffuserName == localStorage.getItem("guestuser"))
			{
				
					if (latestPage.items[msgI].type == 'media')
					{
						 latestPage.items[msgI].media.getContentUrl().then(function(url){
							  if(latestPage.items[msgI].state.media.state.contentType =="image/jpeg" || latestPage.items[msgI].state.media.state.contentType =="image/png")
         					 {
								 //$("#chatmessage").prepend("<li id='message_"+latestPage.items[msgI].index+"' class='classleft'><img src='"+url+"' /> <div id='"+latestPage.items[msgI].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								 var temp='<div class="m-messenger__wrapper" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text"><img src="'+url+'" height="100px" width="100px"/></div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").prepend(temp);
								 msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);
								 
							 }
							 else
							 {
								 //$("#chatmessage").prepend("<li id='message_"+latestPage.items[msgI].index+"' class='classleft'><a href='"+url+"' >file</a> <div id='"+latestPage.items[msgI].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								  var temp='<div class="m-messenger__wrapper" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text"><a src="'+url+'"/></a></div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").prepend(temp);
								  msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);

							 }
						})
					}
					else
					{		if(latestPage.items[msgI].attributes.note == "note")
							{ 
								 msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);
							}
							else
							{
							//$("#chatmessage").prepend("<li id='message_"+latestPage.items[msgI].index+"' class='classleft'>"+latestPage.items[msgI].body+"<div id='"+latestPage.items[msgI].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								 var temp='<div class="m-messenger__wrapper" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													+'<a id="'+latestPage.items[msgI].index+'" onclick="MessageEdit(this.id);" class="edit btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill" >'
													+'<i class="la la-pencil"></i>'
													+'</a>'
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text" id="editmessage_'+latestPage.items[msgI].index+'">'+latestPage.items[msgI].body+'</div>'
													+'</div>'
													+'</div>'
													+'</div>'
													+'</div>';
												$("#chatmessage").prepend(temp);
								 msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);
							}
					}
			}
			else
			{
				if (latestPage.items[msgI].type == 'media')
					{
						 latestPage.items[msgI].media.getContentUrl().then(function(url){
							  if(latestPage.items[msgI].state.media.state.contentType =="image/jpeg" || latestPage.items[msgI].state.media.state.contentType =="image/png")
         					 {
								 //$("#chatmessage").prepend("<li class='classright'><img src='"+url+"' /> </li>");
								  var temp='<div class="m-messenger__wrapper">'
												+'<div class="m-messenger__message m-messenger__message--in">'
												+'<div class="m-messenger__message-pic">'
												+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
												+'</div>'
												+'<div class="m-messenger__message-body">'
												+'<div class="m-messenger__message-arrow"></div>'
												+'<div class="m-messenger__message-content">'
												+'<div class="m-messenger__message-username">'
												+'<img src="'+url+'" height="100px" width="100px"/>'
												+'</div>'
												+'<div class="m-messenger__message-text">'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>';
												$("#chatmessage").prepend(temp);
								  msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);
							 }
							 else
							 {
								// $("#chatmessage").prepend("<li class='classright'><a href='"+url+"' >file</a> </li>");
								var temp='<div class="m-messenger__wrapper">'
												+'<div class="m-messenger__message m-messenger__message--in">'
												+'<div class="m-messenger__message-pic">'
												+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
												+'</div>'
												+'<div class="m-messenger__message-body">'
												+'<div class="m-messenger__message-arrow"></div>'
												+'<div class="m-messenger__message-content">'
												+'<div class="m-messenger__message-username">'
												 
												+'<a href="'+url+'" >file</a>' 
												+'</div>'
												+'<div class="m-messenger__message-text">'
												 +'</div>'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>';
											 $("#chatmessage").prepend(temp);
								  msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);

							 }
						})
					}
					else
					{
							//$("#chatmessage").prepend("<li class='classright'>"+latestPage.items[msgI].body+"</li>");
							var temp='<div class="m-messenger__wrapper">'
												+'<div class="m-messenger__message m-messenger__message--in">'
												+'<div class="m-messenger__message-pic">'
												+'<img src="assets/app/media/img/users/user4.jpg" alt=""/>'
												+'</div>'
												+'<div class="m-messenger__message-body">'
												+'<div class="m-messenger__message-arrow"></div>'
												+'<div class="m-messenger__message-content">'
												+'<div class="m-messenger__message-username">'
												 
												+'</div>'
												+'<div class="m-messenger__message-text">'+latestPage.items[msgI].body+'</div>'
												+'</div>'
												+'</div>'
												+'</div>'
												+'</div>';
												$("#chatmessage").prepend(temp);
							 msgI--;
								 Scrolling_SecondLoopMessageShow(latestPage);
					}
			}
		
	}
	else
	{
		 $("#chatmessage").animate({ scrollTop: 1000 }, 10); 
		 $(".loader").hide();
	}
	
}
//=============================================first  time send message in popup box in twilio ===========================================
function popupSendPhoneNumber()
{
	var phonenumber=$("#phoneMessage").val();
	
	if(phonenumber!="")
	{
			 var  messageAttributes={       
								
								StaffuserName:localStorage.getItem("guestuser"),
								ServerDate:"",
								sms_unique_id:"popupmessage",  
							   }
									  console.log(messageAttributes);
							  generalChannel.sendMessage(phonenumber,messageAttributes).then(function(message){
										$("#firstshowPopup").remove();
										
							  });
		
	}
	
	
}

 
