function returnSeries(input, offset){
	$.ajax({
		url:"./functions/comicQueries.php",
		type: "POST",
		dataType: "json",
		data:{
			action:'searchResults',
			searchWord:input,
			offset:offset
		}
	}).done(function(result){
		//$('#content').empty();
		//console.log(result.length);
		if(result!='No results'){
			$(result).each(function(index, element){
				var object = "<a data-seriesid='" + element.id + "' class='seriesPreview' href='viewSeries.php?id=" + element.id + "'><div class='block card'><img src='" + element.seriesCover + "'/><p>" + element.seriesName + " (" + element.seriesStartYear + ")</p></div></a>";
				$('#content').append(object);
			});
			//console.log(result);
		}else{
			//console.log('hola');
			$('#content').append("<p id='noResults'>No Results Found</p>");
		}
	});	

}
function loadSeries(seriesID){
	$.ajax({
		url:"./functions/comicQueries.php",
		type: "POST",
		dataType: "json",
		data:{
			action:'returnComicSeries',
			seriesID:seriesID
		}
	}).done(function(result){
		console.log(result);
		//$( "#ajaxLoader").hide();
		if(result!='No results'){
			$(result).each(function(index, element){
				var object = "<a data-comicid='" + element.id + "' class='comicPreview' href='viewComic.php?id=" + element.id + "'><div class='block card'><img src='" + element.coverimg + "'/><p> #" + element.issue + "</p></div></a>";
				$('#content').append(object);
			});
			//console.log(result);
		}else{
			//console.log('hola');
			$('#content').append("<p id='noResults'>No Issues Uploaded</p>");
		}
	});	
}