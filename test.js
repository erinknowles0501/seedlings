$(document).ready(function() {

$("#submit").click(function() {

	var name = $("#nameField").val();
	var data = {"name": name};

  $.post("babies.json",	data).done(function() {
	alert("its been done");
});
	
	console.log(name);

});







});