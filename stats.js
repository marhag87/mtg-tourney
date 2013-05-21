function getPlayerWins(){
	$.get("getPlayerWins.php",{tourney_id: $("#tourneyList").val()},function(data){
		$('#playerWins').html(data);
	});
}

function getDeckWins(){
	$.get("getDeckWins.php",{tourney_id: $("#tourneyList").val()},function(data){
		$('#deckWins').html(data);
	});
}

function getPlayerDeckWins(playerId,that){
	$(".playerWinsName").css('background-color','');
	$(that).css('background-color','darkgrey');
	$.get("getPlayerDeckWins.php",{player_id: playerId, tourney_id: $("#tourneyList").val()},function(data){
		$('#deckWins').html(data);
		var scores = new Array();
		$.each($(".playerDeckWinsNumber"),function(n,v){
			scores.push(parseInt($(v).html()));
			$("#playerDeckWinsNumber"+n).css('background-color',myColor[n%myColor.length]);
		});
		//$(".playerDeckWinsNumber").transify({opacityOrig: 0.5});
		plotData(scores);
		$('#winsStats').show();
	});
}

function getDeckPlayerWins(deckId,that){
	$(".deckWinsName").css('background-color','');
	$(that).css('background-color','darkgrey');
	$.get("getDeckPlayerWins.php",{deck_id: deckId, tourney_id: $("#tourneyList").val()},function(data){
		$('#playerWins').html(data);
		var scores = new Array();
		$.each($(".deckPlayerWinsNumber"),function(n,v){
			scores.push(parseInt($(v).html()));
			$("#deckPlayerWinsNumber"+n).css('background-color',myColor[n%myColor.length]);
		});
		//$(".deckPlayerWinsNumber").transify({opacityOrig: 0.5});
		plotData(scores);
		plotGraphData();
		$('#winsStats').show();
		$('#winsStatsGraph').show();
		$('#graphLengther').show();
	});
}