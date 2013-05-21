function getPlayersPlaying(){
	$.get("getPlayersPlaying.php",{tourney_id: $("#tourneyList").val()},function(data){
		$('#playersPlaying').html(data);
	});
}

function getPlayersAvailable(){
	$.get("getPlayersAvailable.php",{tourney_id: $("#tourneyList").val()},function(data){
		$('#playersAvailable').html(data);
	});
}

function getRandomStarter(gameId){
	$.get("getRandomStarter.php",{game_id: gameId},function(data){
		alert(data);
	});
}

function newGame(useRandomDeck){
	var boxes = $("input[class=playersAvailableCheckbox]:checked");
	if (boxes.length <= 1){
		alert("You need at least two players");
		return;
	}
	var players = new Array();
	$.each(boxes,function(i,box){
		players.push(box.id);
	});
	if (useRandomDeck){
		$.get("sendNewGame.php",{players_id: players, tourney_id: $("#tourneyList").val()},function(data){
			if (data == "ok"){
				menu('playing');
			} else {
				alert(data);
			}
		});
	} else {
		$.get("getCustomDeckList.php",{players_id: players, tourney_id: $("#tourneyList").val()},function(data){
			$('#customDeckList').html(data);
			menu('customDeckList');
		});
	}
}

function submitCustomDeckList(){
	var players = new Array();
	var decks = new Array();
	var unique = true;
	$(":input[class=customDeckSelector]").each(function (n,v){
		players.push($(v).attr("id"));
		console.log($.inArray($(v).val(),decks));
		if ($.inArray($(v).val(),decks) != -1){
			unique = false;
		}
		decks.push($(v).val());
	});
	if (unique){
		$.get("sendNewCustomGame.php",{player_id: players,deck_id: decks, tourney_id: $("#tourneyList").val()},function(data){
			if (data == "ok"){
				menu('playing');
			} else {
				alert(data);
			}
		});
	} else {
		alert("Not unique");
	}
}

function sendScore(game_ID){
	var game = $('.form_game_'+game_ID+'_score');
	var scores = new Array();
	var players = new Array();
	$.each(game,function(i,input){
		SCORE = input.value?input.value:0;
		scores.push(SCORE);
		players.push(input.id);
	});
	$.get("sendScore.php",{game_id: game_ID,score: scores,player_id: players},function(data){
		if (data == 'ok'){
			menu('playing');
		}
	});
}
