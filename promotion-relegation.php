<html lang="en">
<head>
<title>About</title>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no" />
<link rel="icon" href="images/favicon.ico">
<link rel="shortcut icon" href="images/favicon.ico" />
<link rel="stylesheet" href="css/style.css">

<?php
//$HT = $_SESSION['HT'];
//token:  R8OFojnsTRHwZm2T
//secret: gchCLG3BkTPmBXDe

//
//team values for league. 
//best values, average values and so on. 
//implemented method for displaying latest midfield values in a league match:
//1) loop through out leagues
//2) select the team in the league by standings order
//3) search for last league match played
//4) check if home or away team
//5) pick the right team and display the midfield rating
//6) pick the following team in standings and repeat from point 3)  
include 'PHT.php';
session_start();
try
{
 $HT = new CHPPConnection('R1syuW5e7N5JBOHbo4krM4', 'EBmWvvEVyZFXSfxj4EgYJxhqoP1z9GEabvND4Jejhrf');
 $HT->setOauthToken('R8OFojnsTRHwZm2T');
 $HT->setOauthTokenSecret('gchCLG3BkTPmBXDe');
 $do_fifth = true;
 $do_sixth = false;
 //$HT = $_SESSION['HT'];
 //echo 'about to search' . '<br/>';
 if($do_sixth){
    for($serieNo=1; $serieNo<1024; $serieNo++){	
        //get the serie one by one
        $result = $HT->searchSerieByName('VI.' . $serieNo);
 		//echo 'test:       ' . $result->getResult(1)->getValue().'<br/>'; 
 		//echo 'test:       ' . $result->getResult(1)->getId().'<br/>'; 
 		$league = $HT->getLeague($result->getResult(1)->getId());
 		//echo 'League:     ' . $league->getLeagueName().'<br/>';
 		//for($i=1; $i<9; $i++){
        //get only the first team in the serie.
        //1) team name
        //2) team points
        //3) goals difference (to add)
        $team = $league->getTeam(1);
 		$teamName = $team->getTeamName();
        $teamPoints6[$teamName] = $team->getPoints();
        //echo 'Team:       ' . $team->getTeamName().'<br/>'; 
     	//$teamId = $team->getTeamId();
     }
    
    asort($teamPoints6);
    
    //echo 'number of teams scanned: ' . count($);
    echo "<table style='width:50%'>";
    echo "<tr>";
    echo "<td> 'Team'   </td>";
    echo "<td> 'Points' </td>";
    echo "</tr>";
    $i=0;
    foreach($teamPoints6 as $x=>$x_value) {
    $i+=1;
    echo "</tr>";
    echo "<td>  $i       </td>";
    echo "<td>  $x       </td>";
    echo "<td>  $x_value </td>";
    echo "</tr>"; 
        }
    }

 else if($do_fifth){
    for($serieNo=1; $serieNo<257; $serieNo++){	
        //get the serie one by one
        $result = $HT->searchSerieByName('V.' . $serieNo);
 		//echo 'test:       ' . $result->getResult(1)->getValue().'<br/>'; 
 		//echo 'test:       ' . $result->getResult(1)->getId().'<br/>'; 
 		$league = $HT->getLeague($result->getResult(1)->getId());
 		//echo 'League:     ' . $league->getLeagueName().'<br/>';
 		//for($i=1; $i<9; $i++){
        //get only the first team in the serie.
        //1) team name
        //2) team points
        //3) goals difference (to add)
        $team = $league->getTeam(1);
 		$teamName = $team->getTeamName();
        $teamPoints5[$teamName] = $team->getPoints();
        //get teams series IV
        $result2 = $HT->searchSerieByName('IV.' . $serieNo);
 		$league2 = $HT->getLeague($result->getResult(1)->getId());
		$team2 = $league2->getTeam(8);
 		$teamName2 = $team2->getTeamName();
        $teamPoints4[$teamName2] = $team2->getPoints();
        $team2 = $league2->getTeam(7);
 		$teamName2 = $team2->getTeamName();
        $teamPoints4[$teamName2] = $team2->getPoints();

	}
    
    asort($teamPoints5);
    arsort($teamPoints4);
    $keys5 = array_keys($teamPoints5);
    $keys4 = array_keys($teamPoints4);

    //echo 'number of teams scanned: ' . count($);
    //create table and header
    echo "<table style='width:50%'>";
    echo "<tr>";
    echo "<td>   </td>";
    echo "<td> Team V series</td>";
    echo "<td> Points </td>";
    echo "<td> Team IV series</td>";
    echo "<td> Points </td>";
    echo "</tr>";
    //foreach($teamPoints5 as $x=>$x_value) {
    for($i=0; $i<count($keys5); $i++){
    	echo "</tr>";
        $teamName5 = $keys5[$i]; 
        $teamName4 = $keys4[$i];
    	echo "<td>  $i     </td>";
        echo "<td>  $keys5[$i]       </td>";
    	echo "<td>  $teamPoints5[$teamName5] </td>";
        echo "<td>  $keys4[$i]       </td>";
    	echo "<td>  $teamPoints4[$teamName4] </td>";
	    echo "</tr>"; 
        }
    }
    
} 
catch(HTError $e)
{
 echo $e->getMessage();
}   

?>