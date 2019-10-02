<script>
function ajaxComment(id,author="",mail="",url=""){
	layui.use('layer', function(){
		var $ = layui.jquery, layer = layui.layer;
		var serializeJson = $("#comment-form").serializeArray();
		if(!$("#isPage").val()){
			serializeJson.push({"name":"author","value":author});
			serializeJson.push({"name":"mail","value":mail});
			serializeJson.push({"name":"url","value":url});
		}
		$.ajax({
			type: $("#comment-form").attr("method"),
			url: $("#comment-form").attr("action"),
			data: serializeJson,
			success: function(t) {
				if (!$(id, t).length) {
					layer.msg('评论提交失败！');
					return false;
				}
				layer.msg('评论提交成功，无需重复提交！');
			},
			error: function(t) {
				window.location.reload();
			}
		});
	});
}
function ajaxCommentForm(){
	layui.use('layer', function(){
		var $ = layui.jquery, layer = layui.layer;
		if($("#isPage").val()){
			$("#comment-form").submit(function() {
				ajaxComment("#comments");
				return false;
			});
		}else{
			$('#comment-form input[name=\"text\"]').keydown(function() {
				if (event.keyCode == "13") {
					if($("#hasLogin").val()){
						var str='确定要提交评论吗？';
					}else{
						var str='<input placeholder="（必填）昵称" type="text" id="comments_box_author" class="text" value="<?php $this->remember('author'); ?>" required /><input placeholder="<?php echo $this->options->commentsRequireMail ? '（必填）' : '（选填）';echo '邮箱'; ?>" type="email" id="comments_box_mail" class="text" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?> required <?php endif; ?>/><input type="url" id="comments_box_url" class="text" placeholder="<?php echo $this->options->commentsRequireURL ? '（必填）' : '（选填）';echo '网站'; ?>" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL): ?> required <?php endif; ?>/><input type="hidden" id="commentsRequireMail" value="<?=$this->options->commentsRequireMail;?>" /><input type="hidden" id="commentsRequireURL" value="<?=$this->options->commentsRequireURL;?>" />';
					}
					layer.confirm(str, {
						title:"评论",
						btn: ['提交','算了']
					},function(index){
						if($("#comments_box_author").val()==""){
							layer.msg("需要填入昵称");
							layer.close(index);
							return;
						}
						if($("#commentsRequireMail").val()==1&&$("#comments_box_mail").val()==""){
							layer.msg("需要填入邮箱");
							layer.close(index);
							return;
						}
						if($("#commentsRequireURL").val()==1&&$("#commentsRequireURL").val()==""){
							layer.msg("需要填入网站地址");
							layer.close(index);
							return;
						}
						ajaxComment(".comments",$("#comments_box_author").val(),$("#comments_box_mail").val(),$("#comments_box_url").val());
						layer.close(index);
					});
					return false;
				}
			});
		}
	});
}
ajaxCommentForm();
</script>