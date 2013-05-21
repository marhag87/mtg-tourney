function getAllTourneys(){
	$.get("getAllTourneys.php",function(data){
		$("#allTourneys").html(data)
	});
}

function deleteTourney(){
	var answerYes = confirm("Delete tourney?")
	if (answerYes){
		$.get("deleteTourney.php",{tourney_id: $("input[class=editTourneyRadio]:radio:checked").val()},function(data){
			if (data == "ok") {
				getTourneyList();
				menu('tourney');
			} else {
				if (data.indexOf("a foreign key constraint fails") >= 0) {
					alert("The tournament is used somewhere. Ask Martin to delete it.");
				} else {
					alert(data);
				}
			}
		});
	}
}

function editTourneyForm(isNew){
	if (!isNew){
		var radios = $("input[class=editTourneyRadio]:checked");
		if (radios.length < 1) {
			alert("You need to select a tourney");
			return;
		}
		tourney_id = radios[0].value;
		$.get("editTourneyForm.php",{new: isNew, id: tourney_id},function(data){
			$('#editTourneyForm').html(data);
		});
	} else {
		$.get("editTourneyForm.php",{new: isNew},function(data){
			$('#editTourneyForm').html(data);
		});
	}
	$('#editTourneyForm').show();
	$('#allTourneys').hide();
}

function editTourney(tourneyName,random,tourneyId){
	random = random?true:false;
	var players = new Array();
	$.each($("input[class=editTourneyPlayerCheckbox]:checked"),function(n,v){
		players.push($(v).val());
	});
	var decks = new Array();
	$.each($("input[class=editTourneyDeckCheckbox]:checked"),function(n,v){
		decks.push($(v).val());
	});
	if (players.length < 2) {
		alert("You need at least two players");
		return;
	}
	if (decks.length < 2) {
		alert("You need at least two decks");
		return;
	}
	$.get("editTourney.php",{name: tourneyName,randomAllowed: random,player_id: players, deck_id: decks,tourney_id: tourneyId},function(data){
		if (data == "ok") {
			getTourneyList();
			menu('tourney');
		} else {
			alert(data);
		}
	});
}