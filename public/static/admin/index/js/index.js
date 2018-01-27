$(document).ready(function(){
	// $("#client1").modal('show');
	//点击新建弹出速建选择框
	$(".container .add").click(function(event) {
		event.preventDefault();
		$(this).hide().siblings().show();
	});
	//关闭速建选择框
	$(".container .add_info .top a").click(function(event) {
		event.preventDefault();
		$(this).parents(".add_info").hide().siblings().show();
	});
	//注册下拉选择框选择改变值
    $('.dropdown-menu').on('click', function(e) {
    var $target = $(e.target);
    $('#text').text($target.text())
})
});
