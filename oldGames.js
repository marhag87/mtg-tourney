var uid = -1;

function getOldGames(LIMIT){
	$.get("getOldGames.php",{limit: LIMIT, tourney_id: $("#tourneyList").val()},function(data){
		$('#oldGames').html(data);
	});
}

function getEditGameForm(gameId){
	$.get("getEditGameForm.php",{game_id: gameId},function(data){
		$('#oldGames').html(data);
	});
}

function deleteGame(gameId){
	var answerYes = confirm("Delete game?")
	if (answerYes){
		$.get("deleteGame.php",{game_id: gameId},function(data){
			if (data == "ok"){
				menu('oldGames');
			} else {
				alert(data);
			}
		});
	}
}