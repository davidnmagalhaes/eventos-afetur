function highlightEdit(editableObj) {
	$(editableObj).css("background","#FFF");
} 

function saveInlineEdit(editableObj,column,id) {
	// no change change made then return false
	if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
	return false;
	// send ajax to update value
	$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
	$.ajax({
		url: "saveInlineEdit2.php",
		cache: false,
		data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id,
		success: function(response)  {
			console.log(response);
			// set updated value as old value
			$(editableObj).attr('data-old_value',editableObj.innerHTML);
			$(editableObj).css("background","#FDFDFD");			
		}          
   });
}