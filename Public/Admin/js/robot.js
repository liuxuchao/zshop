
$(function() {
  $("#addMessage").click(function() {
    
    var content = $("#content").val();
    if ( content == "" ) {
      return false;
    } 
    $("#content").html('');
    var to_user_id = $("#to_user_id").val();

    $.ajax({
      dataType:"json",
      type : "post",
      url: "/Admin/Robot/addMessageAjax",
      data: {content:content,to_user_id:to_user_id},
      success: function(data){
        if('success' == data.msg){
          var msg = data.data;
          var html = getMsgHtml(msg);
          $("#msgPanel").append(html);
          return;
        }
      }
    });
  });

  $("#getHistory").click(function(){
    var to_user_id = $("#to_user_id").val();
    var cur_page = $("#page").val();
    var nex_page = parseInt(cur_page)+1;
    $("#page").val(nex_page);

    $.ajax({
      dataType:"json",
      type : "post",
      url: "/Admin/Robot/getHistoryAjax",
      data: {page:nex_page,to_user_id:to_user_id},
      success: function(data){
        if('success' == data.msg){
          var msgList = data.data;
          for (var i = msgList.length - 1; i >= 0; i--) {
            var html = getMsgHtml(msgList[i]);
            $("#msgPanel").prepend(html);  
          }          
          return;
        }
      }
    });
  });

  function getMsgHtml(msgData){
    var html = '';
    if(msgData.from_user_id != '0'){
      html += '<div class="activity blue">';
      html +='<span><img width="30px" class="avatar" src="'+ICON_URL+'" alt=""></span>';
    }else{
      html += '<div class="activity alt blue">';
      html +='<span></span>';
    }
   
    html += '<div class="activity-desk"><div class="panel"><h4>'+msgData.create_time+'</h4><div class="alert alert-info fade in"><div class="arrow-alt"></div>';
      if (msgData.content_type == 1){
        html += '<p>'+msgData.content+'</p>';
      } else {
        html += '<img height="200"  src="'+DOMAIN+msgData.content+'">';
      }
      html += '</div></div></div></div>';
      return html;

  }
  
});