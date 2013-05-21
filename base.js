//TODO
//Check if all functions print errors
//Find alternative to transify (doesn't work in firefox)
//Edit games
//Random deck in custom deck chooser
//Deck wins per person (who makes the most winning decks)
//Sort by other than wins in stats
//Rethink stats page (json)
//Deck won against other decks
//Player -||-
//Less random decks (less played = more chance to get)
//"alter table gamepart add foreign key (game_id) references game (id) on delete cascade;" after reverting database

//Look at mysqli
//Try not to run queries in loops
//http://www.sitepoint.com/mysql-mistakes-php-developers/
//No * in selects
//Check indexes

var history = "playing";

function getTourneyList(){
	$.get("getTourneyList.php",function(data){
		$('#tourneyMenu').html(data);
		$("#tourneyList").change(function(){
			menu(history);
		});
	});
}

function menu(content){
	$(".content").hide();
	switch (content){
		case "playing":
			getPlayersAvailable();
			getPlayersPlaying();
			$("#allDecks").html("");
			$("#playersPlaying").show();
			$("#playersAvailable").show();
			break;
		case "oldGames":
			getOldGames(true);
			$("#oldGames").show();
			$("#oldGamesButton").show();
			break;
		case "stats":
			getDeckWins();
			getPlayerWins();
			$("#deckWins").show();
			$("#playerWins").show();
			break;
		case "decks":
			getAllDecks();
			$("#allDecks").show();
			break;
		case "customDeckList":
			$("#customDeckList").show();
			break;
		case "tourney":
			getAllTourneys();
			$("#allTourneys").show();
			break;
		default:
			content = "404";
			$("#error").html("404 - not found");
			$("#error").show();
	}
	changeHistory(content);
}

function changeHistory(page){
	history = page;
}
function shuffleImages(){
	var images = new Array(109,173,49,93,54,76,"146b",152,46,78,105,99,116,17,"181a",31,122,232,12,28,33,47,203,61,79,98,121,134,139,142,165,175,174,186,190,222,4);
	images = shuffle(images);
	$("#backgroundCard1").attr("src", "images/cards/"+images.pop()+".jpg")
	$("#backgroundCard2").attr("src", "images/cards/"+images.pop()+".jpg")
	$("#backgroundCard3").attr("src", "images/cards/"+images.pop()+".jpg")
	$("#backgroundCard4").attr("src", "images/cards/"+images.pop()+".jpg")
}

shuffle = function(v){
    for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
    return v;
};
