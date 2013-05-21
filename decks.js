function getAllDecks(){
	$.get("getAllDecks.php",function(data){
		$('#allDecks').html(data);
	});
}

function editDeckForm(isNew){
	if (!isNew){
		var radios = $("input[class=editDeckRadio]:checked");
		if (radios.length < 1) {
			alert("You need to select a deck");
			return;
		}
		deck_id = radios[0].value;
		$.get("editDeckForm.php",{new: isNew, id: deck_id},function(data){
			$('#editDeckForm').html(data);
		});
	} else {
		$.get("editDeckForm.php",{new: isNew},function(data){
			$('#editDeckForm').html(data);
		});
	}
	$('#editDeckForm').show();
	$('#allDecks').hide();
}

function editDeck(deckName,owner,avail,deckId){
	avail = avail?true:false;
	$.get("editDeck.php",{name: deckName,owner_id: owner,available: avail,deck_id: deckId},function(data){
		if (data == "ok") menu('decks');
	});
}

function deleteDeck(){
	var answerYes = confirm("Delete deck?")
	if (answerYes){
		$.get("deleteDeck.php",{deck_id: $("input[class=editDeckRadio]:radio:checked").val()},function(data){
			if (data == "ok"){
				menu('decks');
			} else {
				if (data.indexOf("a foreign key constraint fails") >= 0) {
					alert("The deck is used somewhere. Ask Martin to delete it.");
				} else {
					alert(data);
				}
			}
		});
	}
}