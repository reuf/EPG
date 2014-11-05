<?php

echo testData();

const TBL_DAN = "tx_bhrt_epg_dan";
const TBL_EMISIJA = "tx_bhrt_epg_emisija";

function testData(){

	$result['columns'] = 15;
	$result['kanal'] = 'Televizija';
	$result['datum'] = '06.05.2013';
	for ($i=1; $i <= $result['columns']; $i++) {
		$result['vrijeme_'.$i] = "12:2".rand(1, 1000);
		$result['naslov_'.$i] = "Naslov".rand(1, 1000);
		$result['tip_'.$i] = "Film";
		$result['kratki_opis_'.$i] = "Opis".rand(1, 1000);
		$result['dugi_opis_'.$i] = "dugi_opis".rand(1, 1000);
		$result['ostalo_'.$i] = "ostalo".rand(1, 1000);
		$result['rejting_'.$i] = "16+";
	}
	return json_encode($result);
}

function prepeareData(){

	$broj_emisija_forma = $_REQUEST['broj_emisija'];
	$kanal = $_REQUEST['kanal'];
	$broj_emisija_baza = SELECT COUNT(*) AS broj_emisija FROM EPGEMISIJA WHERE fkepgdan =
									(SELECT id FROM EPGDAN WHERE epgdatum = $date_item)
									AND epgkanal=="1";

	//INSERT OR UPDATE/DELETE

	if ($broj_emisija_baza == $broj_emisija_forma){
		for($i = 1; i <= $broj_emisija_forma; $i++){
			update
	} else if ($broj_emisija_forma < $broj_emisija_baza){

		for ($i = 1; i <= $broj_emisija_forma; $i++){
			update
		}

		for ( $i = $broj_emisija+1 <= $broj_emisija_baza ){
			delete
		}
	} else if ($broj_emisija_baza < $broj_emisija_forma){

		$id_dana = select id from epgdan where date = date
		if ($id_dana == 0) {
			insert date into epgdan
				for ( $i = $broj_emisija+1 <= $broj_emisija_baza ){
					for{
						insertset fkepgdan = id
					}
				}
		}
		else {
			for ($i = 1; i <= $broj_emisija_forma; $i++){
				update
			}
		}
	}
}

function getDatumID($datum){
	$result="";
	$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 'id', self::TBL_DAN, 'date =  '.$datum);
	if ($res) {
            $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ($res);
            if ($row !== false) {
            	return $row['id'];
            }
        }

}

function getBrojEmisija($datum, $kanal){
	$result="";
	$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 'id', self::TBL_EMISIJA, 'date =  '.$datum.' AND kanal = '.$kanal);
	if ($res) {
		return $GLOBALS ['TYPO3_DB']->sql_num_rows ($res);
    }
}

function getTVandRadio($datum){
	$result="";

	$result['radio'] = getDataFromDB($datum, "televizija");
	$result['televizija'] = getDataFromDB($datum, "radio");

	return json_encode($result);
}

function getDataFromDB($datum, $kanal){

	$result="";
	$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( '*', self::TBL_EMISIJA, 'date =  '.$datum.' AND kanal = '.$kanal.' order by id');
	if ($res) {
        $data = array();
        for($i=1; $i <= $GLOBALS ['TYPO3_DB']->sql_num_rows ($res); $i++){
            // Fetch array
            $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ($res);
            if ($row !== false) {

            	$result['vrijeme_'.$i] = $row['vrijeme'];
				$result['naslov_'.$i] = $row['naslov'];
				$result['tip_'.$i] = $row['tip'];
				$result['kratki_opis_'.$i] = $row['kratki_opis'];
				$result['dugi_opis_'.$i] = $row['dugi_opis'];
				$result['ostalo_'.$i] = $row['ostalo'];
				$result['rejting_'.$i] = $row['rejting'];
            }
        }
}

function getDataFromDB($datum, $kanal){

	$result="";

	$datum="";
	$kanal="";
	$br_redova="";

	if (isset($_REQUEST['datum']))
	{
	   if(!empty($_REQUEST['datum']))
	   {
		    $datum = $_REQUEST['datum'];
	   }
	}
	$result['datum']=$datum

	if (isset($_REQUEST['kanal']))
	{
	   if(!empty($_REQUEST['kanal']))
	   {
		     $kanal = $_REQUEST['kanal'];
	   }
	}
	$result['kanal']=$kanal;

	//select from db where datum=datum and kanala=kanal;
	//select number of columns

	if (isset($_REQUEST['columns']))
	{
	   if(!empty($_REQUEST['columns']))
	   {
		     $br_redova = $_REQUEST['columns'];
	   }
	}

	for ($i=1; $i <= $br_redova; $i++) {
		if (isset($_REQUEST['vrijeme_'.$i]))
		{
		   if(!empty($_REQUEST['vrijeme_'.$i]))
		   {
			    $result['vrijeme_'.$i]  = mysql_real_escape_string($_REQUEST['vrijeme_'.$i]);
		   }
		}

		if (isset($_REQUEST['naslov_'.$i]))
		{
		   if(!empty($_REQUEST['naslov_'.$i]))
		   {
			    $result['naslov_'.$i]  = mysql_real_escape_string($_REQUEST['naslov_'.$i]);
		   }
		}
		if (isset($_REQUEST['tip_'.$i]))
		{
		   if(!empty($_REQUEST['tip_'.$i]))
		   {
			    $result['tip_'.$i]  = mysql_real_escape_string($_REQUEST['tip_'.$i]);
		   }
		}

		if (isset($_REQUEST['kratki_opis_'.$i]))
		{
		   if(!empty($_REQUEST['kratki_opis_'.$i]))
		   {

			    $result['kratki_opis_'.$i]  = mysql_real_escape_string($_REQUEST['kratki_opis_'.$i]);
		   }
		}

		if (isset($_REQUEST['dugi_opis_'.$i]))
		{
		   if(!empty($_REQUEST['dugi_opis_'.$i]))
		   {
			    $result['dugi_opis_'.$i]  = mysql_real_escape_string($_REQUEST['dugi_opis_'.$i]);
		   }
		}

		if (isset($_REQUEST['ostalo_'.$i]))
		{
		   if(!empty($_REQUEST['ostalo_'.$i]))
		   {
			    $result['ostalo_'.$i]  = mysql_real_escape_string($_REQUEST['ostalo_'.$i]);
		   }
		}

		if (isset($_REQUEST['rejting_'.$i]))
		{
		   if(!empty($_REQUEST['rejting_'.$i]))
		   {
			    $result['rejting_'.$i]  = mysql_real_escape_string($_REQUEST['rejting_'.$i]);
		   }
		}

		$result['kanal'] = $kanal;

		return json_encode($result);
	}
}

function writeDataToDBExample(){
	$kanal = ( $_REQUEST['kanal'] == 'televizija' ? 1 : 2 );
	$datum =
	for($i=1; $i <= $_REQUEST(br_kanala); $i++){
        $db_values = array(
            "vrijeme"=>$_REQUEST['vrijeme_'.$i],
            "naslov"=>$_REQUEST['naslov_'.$i],
            "tip"=>$_REQUEST['tip_'.$i],
            "kratki_opis"=>$_REQUEST['kratki_opis_'.$i],
            "dugi_opis"=>$_REQUEST['dugi_opis_'.$i],
            "ostalo"=>$_REQUEST['ostalo_'.$i],
            "rejting"=>$_REQUEST['rejting_'.$i],
            "kanal"=>$_REQUEST['kanal'],
            "fkdatum"=>$_REQUEST['datum']
        );

        $res = $GLOBALS ['TYPO3_DB']->exec_INSERTquery ( self::TBL_EMISIJA, $db_values );
        if($res) {
            continue;
        }
        else return "Insert error = " . $GLOBALS ['TYPO3_DB']->sql_error();
    }
    return "Podaci uspjesno upisani u bazu.";
}


function writeDataToDB(){

	$result="";

	$datum="";
	$timestamp="";
	$kanal="";
	$br_redova_forma= "";
	$br_redova_baza = "";

	if (isset($_REQUEST['datum']))
	{
	   if(!empty($_REQUEST['datum']))
	   {
		    $datum = $_REQUEST['datum'];
		    list($day, $month, $year) = explode('.', $datum);
			$timestamp = mktime(0, 0, 0, $month, $day, $year);
	   }
	}
	$result['datum'] = $datum;

	if (isset($_REQUEST['kanal']))
	{
	   if(!empty($_REQUEST['kanal']))
	   {
		     $kanal = $_REQUEST['kanal'];
	   }
	}
	$result['kanal']=$kanal;

	if (isset($_REQUEST['columns']))
	{
	   if(!empty($_REQUEST['columns']))
	   {
		     $br_redova_forma = $_REQUEST['columns'];
	   }
	}

	$br_redova_baza = getBrojEmisija($datum, $kanal);

	for ($i=1; $i <= $br_redova; $i++) {
		if (isset($_REQUEST['vrijeme_'.$i]))
		{
		   if(!empty($_REQUEST['vrijeme_'.$i]))
		   {
			    $result[$i]['vrijeme']  = mysql_real_escape_string($_REQUEST['vrijeme_'.$i]);
		   }
		}

		if (isset($_REQUEST['naslov_'.$i]))
		{
		   if(!empty($_REQUEST['naslov_'.$i]))
		   {
			    $result[$i]['naslov']  = mysql_real_escape_string($_REQUEST['naslov_'.$i]);
		   }
		}
		if (isset($_REQUEST['tip_'.$i]))
		{
		   if(!empty($_REQUEST['tip_'.$i]))
		   {
			    $result[$i]['tip']  = mysql_real_escape_string($_REQUEST['tip_'.$i]);
		   }
		}

		if (isset($_REQUEST['kratki_opis_'.$i]))
		{
		   if(!empty($_REQUEST['kratki_opis_'.$i]))
		   {

			    $result[$i]['kratki_opis']  = mysql_real_escape_string($_REQUEST['kratki_opis_'.$i]);
		   }
		}

		if (isset($_REQUEST['dugi_opis_'.$i]))
		{
		   if(!empty($_REQUEST['dugi_opis_'.$i]))
		   {
			    $result[$i]['dugi_opis']  = mysql_real_escape_string($_REQUEST['dugi_opis_'.$i]);
		   }
		}

		if (isset($_REQUEST['ostalo_'.$i]))
		{
		   if(!empty($_REQUEST['ostalo_'.$i]))
		   {
			    $result[$i]['ostalo']  = mysql_real_escape_string($_REQUEST['ostalo_'.$i]);
		   }
		}

		if (isset($_REQUEST['rejting_'.$i]))
		{
		   if(!empty($_REQUEST['rejting_'.$i]))
		   {
			    $result[$i]['rejting']  = mysql_real_escape_string($_REQUEST['rejting_'.$i]);
		   }
		}

		$result[$i]['kanal'] = $kanal;

		//INSERT OR UPDATE/DELETE

		if ($br_redova_baza == $br_redova_forma){
			for($i = 1; i <= $br_redova_forma; $i++){
				//update
			}
		} else if ($br_redova_forma < $br_redova_baza){

			for ($i = 1; i <= $br_redova_forma; $i++){
				//update
			}

			for ( $i = $broj_emisija+1 <= $br_redova_baza ){
				delete
			}
		} else if ($br_redova_baza < $br_redova_forma){

			$id_dana = select id from epgdan where date = date
			if ($id_dana == 0) {
				//insert date into epgdan
					for ( $i = $broj_emisija+1 <= $br_redova_baza ){
						for{
							//insertset fkepgdan = id
						}
					}
			}
			else {
				for ($i = 1; i <= $br_redova_forma; $i++){
					//update
				}
			}
		}


		return $result;
}


?>