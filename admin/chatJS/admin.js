 
var client;
var generalChannel;
var updateChannel;
var messageUpdateFlag=false;
var typingMembers=[];
var activechannel=false;
var messagingClient;
var activeChannelPage;
var limit = 10;
var offset = 0;
var Scrolldisable=false;

var activeMessageChannel;
var StoreChannel=[];
var msgI=0;
var firstTimeChannelLoad=false;

//===========================================document Ready Function call Here ================================================
$(document).ready(function(){

$("#overlay").show();
$(".loader1").show();
							
							$("#chatmessage").bind('scroll', function(){
										var y = $(this).scrollTop();
										
										if (y == 0) {
										$(".loader").show();
										second_time_scrollingData();
										}  
										
										
							});
							$('#Note_message').on('keydown', function(event){
										if (event.keyCode == 13)
										{
											if (!event.shiftKey) 
											{
											SendNote();
											}
										}
										 
							
							
							});
							$('#message-body-input').on('keydown', function(event){
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

					//       $("#chatmessage").scroll(function() {
					//   var y = $(this).scrollTop();
					 
					//   if (y > 10) {
					//     alert(y)
					//      console.log("shreyash rabadiya botton")
					//   } else {
					//     alert(y)
					//    console.log("shreyash rabadiya top")
					//   }
					// });



});
//==================================================Twilio Token  generate tokent here and initialization here..==========================================
function getToken()
{
				 $.ajax({
					url: 'http://twilio-bulksms.webgrowthindia.com/twilio_chat_token.php',
					type: 'GET',
					data: {id:"1",type:"admin"},
					dataType: 'json',
					contentType: 'application/x-www-form-urlencoded',
					success: function (data) {
									console.log(data.token);
									
									var token=data.token; 
									
									//client = new Twilio.Chat.Client(token, { logLevel: 'debug' });
									client = new Twilio.Chat.Client(token, { logLevel: 'silent' });
									console.log(client);
									// client = new Twilio.Chat.Client(token, { logLevel: 'debug' });
													setTimeout(function() {
													client.initialize().then(function(status){
																	console.log("initialixateion twilio");
																	client.on('channelAdded', NewChannelAdded);
																	client.on('messageAdded',AddnewMessages);
																	client.on('memberJoined',memberJoined);
																	 
																$("#overlay").hide();
																$(".loader1").hide();
												
												
												
												
												},function(erro)
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

//====================================================channel click wise customer channel load ======================
function customergetChannel(chname)

{			if(activechannel)
			{ 
			client.removeListener('channelUpdated', updateChannels);
			 generalChannel.removeListener('typingStarted', function(member) {
						console.log("typingStarted success")
						typingMembers.push(member.identity);
						updateTypingIndicator();
				},function(erro){
				console.log("typingStarted error",erro)
				});
				generalChannel.removeListener('typingEnded', function(member) {
						console.log("typingEnded success")
						typingMembers.splice(typingMembers.indexOf(member.identity), 1 );
						
						updateTypingIndicator();
				},function(error){
				
						console.log("typingEnded eror",error)
				});
			}

 
 
	  setTimeout(function() {
	
				$("#"+chname+" b").text("");
				$("#"+chname+" b").removeClass("m-widget4__number");
				$("#"+chname+" input").val(0);
				$(".m-widget4__item").removeClass("active");
				$("#"+chname).addClass("active");
				
					$("#chatmessage").html("");
				$(".loader").show();
				 client.getChannelByUniqueName(chname).then(function(channel) {
							console.log("channel",channel)
							generalChannel = channel;
						 
					$("#channel-title").text(channel.state.friendlyName);	
								setupChannel(generalChannel);
							 
						},function (error){
				
						  console.log("error",error)
						});
	
	  }, 10);
  
 
}
//============================================== first time intialization chennel setup=============
function setupChannel(generalChannel) {
			activechannel=true;
				generalChannel.join().then(function(channel) {
				console.log("join",channel)
				// $chatWindow.removeClass('loader');
				});
				
				
				//=============================Typinh Indicator for particular channel=========================================
				//========================================Fisrt time Typing start here(Two function=>1)start and eding =======================
				 client.on('channelUpdated', updateChannels);
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
						  
 client.on('channelUpdated', updateChannels);
              });
				//============================================================Message updated===================================
			  generalChannel.on('messageUpdated', function(messageUpdatedFlag){
				console.log("messageUpdated",messageUpdatedFlag);
				
				$("#editmessage_"+messageUpdatedFlag.index).text(messageUpdatedFlag.body);
				 
			   
			   
			  client.on('channelUpdated', updateChannels);
			
				
			
			
			  });
				
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
			var message=$("#message-body-input").val();
			if(message !="")
			{
					if(messageUpdateFlag == true)
					{
						messageUpdateFlag=false;
						updateChannel.updateBody(message).then(function(message)
							{
								$("#message-body-input").val("")								 
																		
							})
					}
					else
					{
						
						var  messageAttributes={       
						
						StaffuserName:"admin",
						ServerDate:"",
						sms_unique_id:"",  
						}
						console.log(messageAttributes);
						generalChannel.sendMessage(message,messageAttributes).then(function(message){
								console.log("message send");
								$("#message-body-input").val("")
								$("#chatmessage").animate({ scrollTop: $(document).height() }, 1000);
								
						});
					}
			
			}

}
//====================================first time add message===============
function AddnewMessages(message)
{
			console.log(message)
			
			if(message.channel.sid == generalChannel.sid)
			{
				generalChannel.getMessages(1).then(function(messagesPaginator){
						
					const ImageURL = messagesPaginator.items[0];
					
							if(message.state.attributes.StaffuserName == "admin")
							{
										if (message.type == 'media')
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
													$("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
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
													$("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
														//$("#chatmessage").append("<li id='message_"+message.state.index+"' class='classleft'><a href='"+url+"' >file</a><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div> </li>");
													}
													 
										
											});

										}
										else
										{
											// -------------simple text print ================
											if(message.state.attributes.note == "note")
											{
												var temp='<div class="m-messenger__wrapper owner_note" id="message_'+message.state.index+'" >'
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
													+'<i class="la la-pencil"></i></div>'
													+'</div>'
													+'</div>'
													+'</div>';
												$("#chatmessage").append(temp);
												$("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
												//$("#chatmessage").append("<li id='message_"+message.state.index+"'  class='classleft note'>"+message.state.body+"<img src='note.png'/><div id='"+message.state.index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+message.state.index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
											}
											else
											{
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
												$("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
												//$("#chatmessage").append("<li id='message_"+message.state.index+"' class='classleft'>"+message.state.body+"<div id='"+message.state.index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+message.state.index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
											}
										}
							
							}
							else
							{
										if (message.type == 'media')
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
												$("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
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
														 $("#chatmessage").animate({ scrollTop: $(this).height() }, 10);
														//$("#chatmessage").append("<li  class='classright'><a href='"+url+"' >file</a> </li>");
													}									  
											});

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
													$("#chatmessage").animate({ scrollTop: $(document).height() }, 10);
										//$("#chatmessage").append("<li class='classright'>"+message.state.body+"</li>");
										}							
							}
					})
					$("#chatmessage").animate({ scrollTop: $(this).height() }, 1000);
			}
			else
			{
			//$("#listOfChannel").html("");
					for(var j=0;j<StoreChannel.length;j++)
					{
							//console.log("message.channel.sid",message.channel.sid);
							//console.log("StoreChannel[i].state.sid",StoreChannel[j].sid)
							if(message.channel.sid == StoreChannel[j].sid)
							{
								console.log("Messagerboxy",message.channel.body)
										var countId=$("#count_"+j).val();
										countId=parseInt(countId)+1;
										console.log("countIdcountId",countId);
										$(".count_"+j).text(countId);
									 
										$(".count_"+j).addClass("m-widget4__number")
										$("#onlineStatus_"+j).removeClass("bg-gray");
										$("#onlineStatus_"+j).addClass("bg-success");
										$("#count_"+j).val(parseInt(countId));
										$("#lastMessage_"+j).text(message.state.body)
										
			
			
							}
	
	 
	 
	
	//$("#listOfChannel").prepend("<li id='"+StoreChannel[j].state.uniqueName+"'onclick='customergetChannel(this.id)' style='color:green;'>"+StoreChannel[j].state.friendlyName+"<span class='count_"+j+"' style='color:red;'>"+txtval+"<span><input type='hidden' id='count_"+j+"' value='"+txtval+"'/></li>");
	
	
					}

		}
		

}
function updateChannels(update)
{
	console.log("update channel",update)
	
	var channelClone=$("#"+update.state.uniqueName).clone();
	$("#"+update.state.uniqueName).remove();
	$("#listOfChannel").prepend(channelClone);
	
}
//=====================================New Channel add new customer append here ============
var coutnID=0;
function NewChannelAdded(channel)
{
		StoreChannel.push(channel);
		
		console.log("new channel genearat ",channel);
		
		//$("#listOfChannel").prepend("<li id='"+channel.state.uniqueName+"'onclick='customergetChannel(this.id)' style='color:green;'>"+channel.state.friendlyName+"<span class='count_"+coutnID+"' style='color:red;'></span><input type='hidden' id='count_"+coutnID+"' value='0'/></li>");
		//coutnID++;
		//var channel_ID=channel.state.uniqueName.split("_")
		     		var temp='<div class="m-widget4__item" id="'+channel.state.uniqueName+'" onclick="customergetChannel(this.id)"><div class="m-widget4__img m-widget4__img--logo"><img src="assets/app/media/img/users/user4.jpg" alt="">'
                         +'<div class="online bg-gray" id="onlineStatus_'+coutnID+'"></div></div>'
                         +'<div class="m-widget4__info" >'
                          +'<span class="m-widget4__title">'+channel.state.friendlyName+'</span>'
                           +'<br>'
                            +'<span class="m-widget4__sub" id="lastMessage_'+coutnID+'"></span>'
                          +'</div>'
                          +'<span class="m-widget4__ext p-3">'
						+'<b class="m--font-brand count_'+coutnID+'">'
						+'</b><input type="hidden" id="count_'+coutnID+'" value="0"/>'
						+'</span>'
                        +'</div>';
						$("#listOfChannel").prepend(temp)
						coutnID++;
						
		
		
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
/////==============================================Image file to send here =================================
function fileControlFileGet(filePath)
{
	
						 console.log("filePath",filePath);
						 const formData = new FormData();
	var  messageAttributes={
					StaffuserName:"admin",
					ServerDate:"",
					sms_unique_id:"",  
					}
					formData.append('file', $('#formInputFile')[0].files[0]);
  					generalChannel.sendMessage(formData,messageAttributes).then(function(message){
						 console.log("message",message);
							$("#chatmessage").animate({ scrollTop: $(document).height() }, 10);
							
					});
	
}
//====================================================fisrt time message list get and (this function implement reson image and message get and show (note for loop not working then call here))=======
function LoopMessageShow(latestPage)
{
	 
	if(msgI <latestPage.items.length)
	{
			if(latestPage.items[msgI].attributes.StaffuserName == "admin")
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
								 var temp='<div class="m-messenger__wrapper owner_note" id="message_'+latestPage.items[msgI].index+'" >'
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
													+'<i class="la la-pencil"></i></div>'
													+'</div>'
													+'</div>'
													+'</div>';
												$("#chatmessage").append(temp);
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
			if(latestPage.items[msgI].attributes.StaffuserName == "admin")
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
								  var temp='<div class="m-messenger__wrapper owner_note" id="message_'+latestPage.items[msgI].index+'" >'
													+'<div class="m-messenger__message m-messenger__message--out">'
													+'<div class="m-messenger__message-body">'
													+'<div class="modify-btn">'
													+'<a id="'+latestPage.items[msgI].index+'" onclick="MessageEdit(this.id);" class="edit btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-pencil"></i>'
													+'</a>'
													+'<a id="'+latestPage.items[msgI].index+'" onClick="MessageDelete(this.id)" class="remove btn m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill">'
													+'<i class="la la-close"></i>'
													+'</a>'
													+'</div>'
													+'<div class="m-messenger__message-arrow"></div>'
													+'<div class="m-messenger__message-content">'
													+'<div class="m-messenger__message-text" id="editmessage_'+latestPage.items[msgI].index+'"><'+latestPage.items[msgI].body+'</div>'
													+'<i class="la la-pencil"></i></div>'
													+'</div>'
													+'</div>'
													+'</div>';
													$("#chatmessage").prepend(temp);
								//$("#chatmessage").prepend("<li id='message_"+latestPage.items[msgI].index+"' class='classleft note'>"+latestPage.items[msgI].body+"<img src='note.png'/><div id='"+latestPage.items[msgI].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+latestPage.items[msgI].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
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
//============================================================OpenPopUp note Box==========================
function NotePopupOpen()
{
	generalChannel.getMessages(100).then(function(messagesPaginator){
			var temp="";
			for(var i=0;i<messagesPaginator.items.length ;i++)
			{
							if(messagesPaginator.items[i].attributes.note == "note")
							{
								$("#noteList").prepend("<li class='classleft note' id='message_"+messagesPaginator.items[i].index+"'>"+messagesPaginator.items[i].body+"<img src='note.png'/><div id='"+messagesPaginator.items[i].index+"' onclick='MessageEdit(this.id);'><img src='edit.png'/></div><div id='"+messagesPaginator.items[i].index+"' onClick='MessageDelete(this.id)'><img src='delete.png'/></div></li>");
								  
							}
			
			}
			
												
	});
	$("#Note_popup").show();
}
//============================================Send Note==========================================
function SendNote()
{
	var message=$("#Note_message").val();
			if(message !="")
			{
					var  messageAttributes={       
					
					StaffuserName:"admin",
					ServerDate:"",
					sms_unique_id:"",
					note:"note",  
					}
					console.log(messageAttributes);
					generalChannel.sendMessage(message,messageAttributes).then(function(message){
							console.log("message send");
							$("#Note_popup").hide();
							$("#Note_message").val("")
							$("#chatmessage").animate({ scrollTop: $(document).height() }, 1000);
							
					});
			
			}
	
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
			 $("#message-body-input").val(message.body);
			 $("#message-body-input").focus();
		  
			console.log('message index=' + message.index + 'message body ' + message.body);
		
	   
	});
}
//============================================================Show browser file=======================
function showBrowserFile()
{
	$("#formInputFile").click();
}
//=========================================Get memeber List ===================================================================================================
function GetMemberList()
{
	/* client.getMembers().then(function(members){
									  console.log(members)
     // this.addMember(members);
     } ); */
	client.getUserChannelDescriptors().then(function(paginator) {
				  for (i = 0; i < paginator.items.length; i++) {
					const channel = paginator.items[i];
					console.log('Channel: ' + channel.friendlyName);
				  }
			});
}
//================================member Joining testing ========================
function memberJoined(joinMemeber)
{
	console.log("joinMemeber",)
}





