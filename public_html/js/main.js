$(document).ready(function(){
	
	var History = window.History; // Note: We are using a capital H instead of a lower h
    if ( !History.enabled ) {
         // History.js is disabled for this browser.
         // This is because we can optionally choose to support HTML4 browsers or not.
        return false;
    }
	History.Adapter.bind(window,'statechange',function() { // Note: We are using statechange instead of popstate
		var State = History.getState();
		//$('#content').empty();
		//$('#content').load(State.url);
		$.get(State.url, function(response) {
            //$('#content').html($(response).find('#content').html());
			$('#ajaxLoader2').hide();
			$('#content').html($(response).filter("#content").children());
        });
	});

	//$( "#searchField" ).on('keyup', function(e) {
	$( "#searchForm" ).submit(function(e) {
		e.preventDefault();
		
		//$('#content').empty();
		var input = $( "#searchField" ).val().trim();
		if(input.length > 0){
			History.pushState(null, "Comic Home - " + $(this).text(), 'search.php?searchQuery=' + input);
			$('#ajaxLoader2').show();
			//returnSeries(input, 0);
		}else{
			
			 //$( "#searchField" ).effect( "shake" );
		}
	});
	$( "#content" ).on('click', '.seriesPreview',function(e){
		e.preventDefault();	
		if (e.shiftKey) {
			alert("shift+click");
		}
		History.pushState(null, "Comic Home - " + $(this).text(), $(this).attr('href'));
		$('#ajaxLoader2').show();
		//$('#content').empty();
		//loadSeries($(this).data('seriesid'));
		//$( "#ajaxLoader").show();
		//loadSeries($(this).data('seriesid'));
		//$('#theDiv').find('*').not('.className').remove();
	});
	$( "#searchField" ).focus(function() {
		$( "#header" ).css("opacity", 1);
	});
	$(window).scroll(function() { 
		if ($(this).scrollTop() > 100) {
			$( "#header" ).css("opacity", 0.8);
			$( "#searchField" ).blur();
			//$( "body" ).focus();
		} else {
			$( "#header" ).css("opacity", 1);
		}
	});


});
