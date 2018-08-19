
/*----------------------------------------------------
Tab
----------------------------------------------------*/
$(function() {
    $("#tab li").click(function() {
        var num = $("#tab li").index(this);
        $(".results-wrap").addClass('disnon');
        $(".results-wrap").eq(num).removeClass('disnon');
        $("#tab li").removeClass('select');
        $(this).addClass('select');
    });
});

/*----------------------------------------------------
for Smart Phone
----------------------------------------------------*/
$(function () {
	if($("#target").css("display") == "none"){
		$("#sort_on").click(function () {
			$("form").slideToggle();
			return true;
		});
	}
});