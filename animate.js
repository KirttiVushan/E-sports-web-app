$("#button").click(function()
{
	$("#button").fadeOut("fast");
	$("#register").css("visibility","visible");
});

$("#log").click(function()
{
	
	$("#login").css("visibility","visible");
	$("#signin").css("visibility","hidden");
});
$("#sign").click(function()
{
	
	$("#signin").css("visibility","visible");
	$("#login").css("visibility","hidden");
	
	
});