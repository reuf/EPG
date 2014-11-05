<?php

// $name=$_POST;
// echo json_encode($name);

$name=$_POST;
// echo $name['kanal']." bitch ".$name['datum'];
// echo var_dump($name);
echo json_encode($name);
define("TELEVIZIJA", 1);
define("RADIO", 2);

function unserializeForm($str) {
    $returndata = array();
    $strArray = explode("&", $str);
    $i = 0;
    foreach ($strArray as $item) {
        $array = explode("=", $item);
        $returndata[$array[0]] = $array[1];
    }

    return $returndata;
}

function get_data_from_db($postData){
	$result;
	$epg_kanal = $postData['kanal'];
	$epg_datum = $postData['datum'];
	$broj_kolona_forma = $postData['columns'];
	for ($i=1; $i <= $broj_kolona_forma; $i++) {
		$result['vrijeme_'+$i] = query_get_column($i);
		$result['naslov_'+$i] = query_get_column($i);
		$result['tip_'+$i] = query_get_column($i);
		$result['kratki_opis_'+$i] = query_get_column($i);
		$result['dugi_opis_'+$i] = query_get_column($i);
		$result['ostalo_'+$i] = query_get_column($i);
		$result['rejting_'+$i] = query_get_column($i);
	}
	$result['kanal']="1";
	$result['datum']="06.05.2013";
	return json_encode($result);

}


EPGDAN
id INT 11
epgdatum DATE

EPGEMISIJA
id INT 11
vrijeme VARCHAR
naslovemisije VARCHAR
kratkiopis VARCHAR
dugiopis TEXT
ostalo VARCHAR
epgtipemisije INT 11
epgrprating INT 11
epgkanal INT 11
fkepgdan INT 11

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

GET ALL

$get_all = select * from broj_emisija where epgdatum = (select id from epgdan where epgdatum=epgdatum) and kanala = kanal;


function writeDataDB($postData){

}

function getDataRadio(){

}

function getDataTelevision(){

}

function getDataDB

epgkanal INT 11
fkepgdan INT 11





$start_date = gmdate("01.m.Y", time());
				$end_date = gmdate("d.m.Y", time());

				if (isset($_REQUEST['min']))
				{
				   if(!empty($_REQUEST['min']))
				   {
					     $start_date = $_REQUEST['min'];
				   }
				}

				if (isset($_REQUEST['max']))
				{
				   if(!empty($_REQUEST['max']))
				   {
					     $end_date = $_REQUEST['max'];
				   }
				}

				$content =
				'
					<style type="text/css" title="currentStyle">
						@import "../fileadmin/js/lib/dt/media/css/demo_page.css";
						@import "../fileadmin/js/lib/dt/media/css/demo_table.css";
						@import "../fileadmin/js/lib/dt/extras/TableTools/media/css/TableTools.css";
					</style>
					<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
					<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  					<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
					<script type="text/javascript" charset="utf-8" src="../fileadmin/js/lib/dt/media/js/jquery.dataTables.js"></script>
					<script type="text/javascript" charset="utf-8" src="../fileadmin/js/lib/dt/extras/TableTools/media/js/ZeroClipboard.js"></script>
					<script type="text/javascript" charset="utf-8" src="../fileadmin/js/lib/dt/extras/TableTools/media/js/TableTools.js"></script>
					<script type="text/javascript" charset="utf-8" src="../typo3conf/ext/ss_payment_transactions/mod1/dt.js"></script>

					<div id="container" style="width=900px">
						<h1>Listing tranzakcija</h1>
						<form>
						<table border="0" cellspacing="5" cellpadding="5">
							<tr>
								<td>Od Datuma:</td>
								<td><input type="text" id="min" name="min" value="'.$start_date.'"></td>
							</tr>
							<tr>
								<td>Do Datuma:</td>
								<td><input type="text" id="max" name="max" value="'.$end_date.' "></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" value="Prikaži" style="width: 12em"></td>
							</tr>
						</table>
						</form>
						<div id="demo">
						<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
							<thead>
								<tr>
									<th>Transaction ID</th>
									<th>Bank</th>
									<th>UserID</th>
									<th>Start Time</th>
									<th>Finish Time</th>
									<th>Service</th>
									<th>RRN</th>
									<th>Amount</th>
									<th>Transaction Description</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Transaction ID</th>
									<th>Bank</th>
									<th>UserID</th>
									<th>Start Time</th>
									<th>Finish Time</th>
									<th>Service</th>
									<th>RRN</th>
									<th>Amount (KM)</th>
									<th>Transaction Description</th>
								</tr>
							</tfoot>
							<tbody>';

							list($day, $month, $year) = explode('.', $start_date);
							$timeStampStart = mktime(0, 0, 0, $month, $day, $year);
							list($day, $month, $year) = explode('.', $end_date);
							$timestampEnd = mktime(0, 0, 0, $month, $day, $year);

							$res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( '*', self::PAYMENTS, 'finnish_time BETWEEN '.$timeStampStart.' AND '.$timestampEnd);
							if ($res) {
					            $data = array();
					            for($i=0; $i<$GLOBALS ['TYPO3_DB']->sql_num_rows ($res); $i++){
					                // Fetch array
					                $row = $GLOBALS ['TYPO3_DB']->sql_fetch_assoc ($res);
					                if ($row !== false) {
					                $content .= '<tr class="someClass">'.
					                			'<td>'.$row['transc_id'].'</td>'.
					                			'<td>'.$row['bank'].'</td>'.
					                			'<td>'.$row['userid'].'</td>'.
					                			'<td><nobr>'.gmdate("d.m.Y-\T\:H:i:s", $row['start_time']).'</nobr></td>'.
					                			'<td><nobr>'.gmdate("d.m.Y-\T\:H:i:s", $row['finnish_time']).'</nobr></td>'.
					                			'<td>'.$row['service'].'</td>'.
					                			'<td>'.$row['rrn'].'</td>'.
					                			'<td>'.number_format(round(($row['amount'] / 100), 2 ), 2, '.', '').'</td>'.
					                			'<td>'.$row['transc_desc'].'</td>'.
					                			'</tr>';

					                }
					            }
					        $content .= '</tbody>
							</table>
							</div>
							</div>';

					        } else {
					            $content = array("obavijest"=>"Trenutno nema tranzakcija");
					        }

				$this->content .= $this->doc->section('', $content, 0, 1);
				break;

				?>