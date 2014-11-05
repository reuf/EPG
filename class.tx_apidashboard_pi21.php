<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Muhamed Halilovic <muhamed.halilovic@bhtelecom.ba>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */
require_once(PATH_tslib . 'class.tslib_pibase.php');
require_once(PATH_t3lib . 'class.t3lib_div.php');

/**
 * Plugin 'Pi19 - DashBoard - Unos poslovnog korisnika' for the 'api_dashboard' extension.
 *
 * @author    Muhamed Halilovic <muhamed.halilovic@bhtelecom.ba>
 * @package    TYPO3
 * @subpackage    tx_apidashboard
 */
class tx_apidashboard_pi21 extends tslib_pibase
{

    var $prefixId = 'tx_apidashboard_pi21'; // Same as class name
    var $scriptRelPath = 'pi21/class.tx_apidashboard_pi21.php'; // Path to this script relative to the extension dir.
    var $extKey = 'api_dashboard'; // The extension key.
    var $pi_checkCHash = true;

    const TBL_SUGESTIJE = "tx_apidashboard_sugestije";

    /**
     * The main method of the Plugin
     * This plugin is responsible for entering business information for business phonenumber
     *
     * @param    string        $content: The PlugIn content
     * @param    array        $conf: The PlugIn configuration
     * @return    The content that is displayed on the website
     */
    function main($content, $conf)
    {
        $this->conf = $conf;
        $this->pi_setPiVarDefaults();


        $this->pi_loadLL();
        $pi_checkCHash = true;

        // remove the default plugin comments
        $GLOBALS['TSFE']->config['config']['removePluginDivs'] = 1;
        $GLOBALS['TSFE']->config['config']['xmlprologue'] = "none";

        $jrk_data = $GLOBALS["TSFE"]->fe_user->getKey("ses", "jrk_data2");
        $jrk_eventsource = $GLOBALS["TSFE"]->fe_user->getKey("ses","jrk_eventsource");
        $jrk_userservices = $GLOBALS["TSFE"]->fe_user->getKey("ses","jrk_userservices");
        $jrk_customer_info = $GLOBALS["TSFE"]->fe_user->getKey("ses", "jrk_customer_info");

        if (is_null($jrk_data) || empty($jrk_data)) {
            throw new Exception("Korisnik nije autorizovan - nema podataka o sesiji!");
        }

        if(TYPO3_DLOG) t3lib_div::devLog('JRK DATA struktura', 'api_dashboard_pi21', 2, array("jrkdata2"=>$jrk_data));
        if(TYPO3_DLOG) t3lib_div::devLog('JRK CUSTOMER info', 'api_dashboard_pi21', 2, array("jrk_customer_info"=>$jrk_customer_info));

        $page_name = $this->curPageURL();
        $user  = $GLOBALS ["TSFE"]->fe_user->getKey( "ses", "user_mail");
        $naslov    = "";
        $sugestija = "";
        $status    = "0"; // 0 - unresolved, 1 - received, 2 - resolved, etc.
        $datetime  = time();
        $date_only = time();

        $poruka = array ('poruka'=>"");
        // Kontrola naslova
        if( isset($_REQUEST['naslov']) &&
            !empty($_REQUEST['naslov']) &&
            !is_null($_REQUEST['submit']) ) {
            $naslov = mysql_real_escape_string($_REQUEST['naslov']);
        } else {
            $poruka['poruka']="Naslov sugestije ne može biti prazan.";
            return json_encode($poruka);
        }

        // Kontrola teksta sugestije
        if( isset($_REQUEST['sugestija']) &&
            !empty($_REQUEST['sugestija']) &&
            !is_null($_REQUEST['submit']) ) {
            $sugestija = mysql_real_escape_string($_REQUEST['sugestija']);
        } else {
            $poruka['poruka']="Tekst sugestije ne može biti prazan.";
            return json_encode($poruka);
        }

        if( isset($_REQUEST['link']) &&
            !empty($_REQUEST['link']) &&
            !is_null($_REQUEST['submit']) ) {
            $page_name = mysql_real_escape_string($_REQUEST['link']);
        }

        // Kontrola da korisnik nije poslao vise od 5 sugestija dnevno
        $res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ("uid", "tx_apidashboard_sugestije", "username='$user' AND suggestion_timestamp BETWEEN UNIX_TIMESTAMP(CURRENT_DATE()) AND UNIX_TIMESTAMP(CURRENT_DATE() + INTERVAL 1 DAY)");
        $num_rows =$GLOBALS ['TYPO3_DB']->sql_num_rows ($res);
        if ($num_rows > 4 ) {
            $poruka['poruka']="Žao nam je, niste u stanju poslati više od 5 sugestija u roku od 24 sata.";
            return json_encode($poruka);
        }

        // Kontrola da je sugestija uspjesno poslana i upisana u bazu.
        try {
            $this->writeDataToDB($page_name, $user, $naslov, $sugestija, $status, $datetime, $date_only);
            $this->sendMailRequest($naslov, $sugestija, $page_name);
            $poruka['poruka']="Hvala vam na sugestiji.";
            return json_encode($poruka);
        } catch (Exception $e) {
            $poruka['poruka']="Došlo je do greške. Probajte ponovo.";
            return json_encode($poruka);
        }

    }

    function validateData($naslov, $sugestija){
        // TODO
        // Naslov ne veci od 50 karaktera.
        // Sugestija ne veca od 500 karaktera.
    }

    function writeDataToDB($page_name, $user, $naslov, $sugestija, $status, $datetime, $date_only){
        $db_values = array(
            "page_name"=>$page_name,
            "username"=>$user,
            "suggestion_title"=>$naslov,
            "suggestion_text"=>$sugestija,
            "suggestion_status"=>$status,
            "suggestion_timestamp"=>$datetime,
            "date_only"=>$date_only
        );

        $res = $GLOBALS ['TYPO3_DB']->exec_INSERTquery ( self::TBL_SUGESTIJE, $db_values );
        if($res) {
            return "Sugestija uspješno upisana u bazu.";
        }
        else return "Insert error = " . $GLOBALS ['TYPO3_DB']->sql_error();
    }

    function exceedsNumberOfSuggestionsPerDay($user, $date_only){
        $datetime =  1000; // $today TODO  right now - 24 hours
        $res = $GLOBALS ['TYPO3_DB']->exec_SELECTquery ( 'uid', self::TBL_SUGESTIJE, "user='$user' AND date='$date_only'" );
        if($q) return $GLOBALS ['TYPO3_DB']->sql_num_rows($res) >= 5 ? true : false;
        else return "Select error = " . $GLOBALS ['TYPO3_DB']->sql_error();
    }

    function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    function sendMailRequest($subject, $message, $page_name) {
        $from = $GLOBALS ["TSFE"]->fe_user->getKey( "ses", "user_mail");
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= "From: <".$from.">\n";
        //$message .= '<br>Stranica sa koje je poslana sugestija: '.$this->curPageURL().'<br>';
        $message .= '<br>Stranica sa koje je poslana sugestija: '.'http://www.bhtelecom.ba'.$page_name;
        mail('portal@bhtelecom.ba', $subject, $message, $headers);
        mail('muhamed.halil@gmail.com', $subject, $message, $headers);
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/api_dashboard/pi11/class.tx_apidashboard_pi11.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/api_dashboard/pi11/class.tx_apidashboard_pi11.php']);
}

?>