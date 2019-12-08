<?php
	date_default_timezone_set('Europe/Berlin');
	
	//Wenn kein Typ für den Post oder ein leerer Typ übergeben werden--> beenden
	if(((!isset($_POST['type']) || $_POST['type'] == "")) && !isset($_GET['type']))
		die(json_encode(array("STATUS" => 0, "Es wurden nicht alle benötigten Parameter übergeben,1")));

	//Wenn der Typ "neu" ist, aber kein Text, ein leerer Text, kein Titel oder ein leerer Titel übergeben werden --> beenden
	if($_POST['type'] == "new" && (!isset($_POST['post']) || $_POST['post'] == "" || !isset($_POST['title']) || $_POST['title'] == ""))
		die(json_encode(array("STATUS" => 0, "Es wurden nicht alle benötigten Parameter übergeben,2")));
	
	//Wenn der Typ "editieren" ist, aber keine id, eine leere id, kein Text, ein leerer Text, kein Titel oder ein leerer Titel übergeben werden --> beenden	
	if ($_POST['type'] == "edit" && ($_POST['id'] == "" || !isset($_POST['id']) || !isset($_POST['post']) || $_POST['post'] == "" || !isset($_POST['title']) || $_POST['title'] == ""))
		die(json_encode(array("STATUS" => 2, "Es wurden nicht alle benötigten Parameter übergeben,3")));
	
	//Wenn der Typ "kommentar" ist, aber keine id, eine leere id, kein Name, ein leerer Name, keine Mail, eine leere Mail, kein Text oder ein leerer Text übergeben werden --> beenden
	if ($_POST['type'] == "comment" && ($_POST['id'] == "" || !isset($_POST['id']) || !isset($_POST['name']) || $_POST['name'] == "" || !isset($_POST['mail']) || $_POST['mail'] == "" || !isset($_POST['comment']) || $_POST['comment'] == ""))
		die(json_encode(array("STATUS" => 3, "Es wurden nicht alle benötigten Parameter übergeben,4")));
		
	$data = array(); 
	$update = false;
	$data = json_decode(file_get_contents('dat.json'), true);
	
	//Wenn es ein neuer Post ist
	if ($_POST['type'] == "new") {
		//dann Titel, Text, Datum, Kommentare und Anzahl der Kommetare posten 
		$data[] = array('title' => $_POST['title'], 'post' => $_POST['post'], 'created' => date("d.m.Y H:i:s"), 'count_comments' => 0, 'comments' => array());
		$update = true;
	} else if ($_GET['type'] == "show") {
		echo json_encode($data[$_GET['id']]);
	} else if ($_GET['type'] == "delete") {
		array_splice($data,$_GET['id'],1);
		$update = true;
	} else if ($_POST['type'] == "edit") {//Wenn update ist, id suchen und entsprechenden Post mit neuen Daten speichern
		if(array_key_exists($_POST['id'], $data)) {
			$data[$_POST['id']]['title'] = $_POST['title'];
			$data[$_POST['id']]['post'] = $_POST['post'];
			
			$update = true;
		}
	} else if ($_POST['type'] == "comment") { //wenn Kommentar ist, entsprechenden Post suchen, Zähler für Kommentare um 1
		if(array_key_exists($_POST['id'], $data)) { //...erhöhen und Kommentar mit Attributen speichern
			$count = count($data[$_POST['id']]['comments']) + 1;
			
			$data[$_POST['id']]['count_comments'] = $count;
			$data[$_POST['id']]['comments'][] = array('name' => $_POST['name'], 'mail' => $_POST['mail'], 'created' => date("d.m.Y H:i:s"), 'comment' => $_POST['comment']);
			
			$update = true;
		}
	}
	
	//die Daten in die Datei dat.json schreiben
	if ($update)
		file_put_contents("dat.json", json_encode($data));
?>