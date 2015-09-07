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
//set_time_limit(1200);
session_start();
try
{
 $HT = new CHPPConnection('R1syuW5e7N5JBOHbo4krM4', 'EBmWvvEVyZFXSfxj4EgYJxhqoP1z9GEabvND4Jejhrf');
 $HT->setOauthToken('R8OFojnsTRHwZm2T');
 $HT->setOauthTokenSecret('gchCLG3BkTPmBXDe');
 //$HT = $_SESSION['HT'];
 //echo 'about to search' . '<br/>';
 for($serieNo=1; $serieNo<257; $serieNo++){	
 	$result = $HT->searchSerieByName('V.' . $serieNo);
 	//echo 'test:       ' . $result->getResult(1)->getValue().'<br/>'; 
 	//echo 'test:       ' . $result->getResult(1)->getId().'<br/>'; 
 	$league = $HT->getLeague($result->getResult(1)->getId());
 	//echo 'League:     ' . $league->getLeagueName().'<br/>';
 	for($i=1; $i<9; $i++){
		$team = $league->getTeam($i);
 		//echo 'Team:       ' . $team->getTeamName().'<br/>'; 
 		$teamId = $team->getTeamId();
 		//get type of last match
 		$nMatches =  $HT->getSeniorTeamMatches($teamId)->getNumberMatches();
 		for($ii=$nMatches; $ii>0; $ii--){
			$type = $HT->getSeniorTeamMatches($teamId)->getMatch($ii)->getType();
			$status = $HT->getSeniorTeamMatches($teamId)->getMatch($ii)->getStatus();
 			$matchId = $HT->getSeniorTeamMatches($teamId)->getMatch($ii)->getId();
                        //type1: league match    
 			//echo 'type:   ' . $type . '<br/>';
                        //echo 'status: ' . $status . '<br/>';
                        if($type==1 and $status=='FINISHED') break;
 		}
 		
                $match = $HT->getSeniorMatchDetails($matchId);
 		$homeTeam = $match->getHomeTeam();
               	
 		if($homeTeam->getId()==$teamId){
          		//echo 'Home Team:       ' . $homeTeam->getName() . '<br/>';
 			//echo 'Midfield:        ' . $homeTeam->getMidfieldRating().'<br/>';
            $midfield[$homeTeam->getName()]=$homeTeam->getMidfieldRating();

 			//echo 'Right Defense:   ' . $homeTeam->getRightDefenseRating().'<br/>';
 			//echo 'Central Defense: ' . $homeTeam->getCentralDefenseRating().'<br/>';
 			//echo 'Left Defense:    ' . $homeTeam->getLeftDefenseRating().'<br/>';
 			//echo 'Right Attack:    ' . $homeTeam->getRightAttackRating().'<br/>';
 			//echo 'Central Attack:  ' . $homeTeam->getCentralAttackRating().'<br/>';
 			//echo 'Left Attack:     ' . $homeTeam->getLeftAttackRating().'<br/>';
 		}
          	else{
 			$awayTeam = $match->getAwayTeam();
                        //echo 'Away Team:       ' . $awayTeam->getName() . '<br/>';
 			//echo 'Midfield:        ' . $awayTeam->getMidfieldRating().'<br/>';
            $midfield[$awayTeam->getName()]=$awayTeam->getMidfieldRating();
			//echo 'Right Defense:   ' . $awayTeam->getRightDefenseRating().'<br/>';
 			//echo 'Central Defense: ' . $awayTeam->getLeftDefenseRating().'<br/>';
			//echo 'Right Attack:    ' . $awayTeam->getRightAttackRating().'<br/>';
			//echo 'Central Attack:  ' . $awayTeam->getCentralAttackRating().'<br/>';
 			//echo 'Left Attack:     ' . $awayTeam->getLeftAttackRating().'<br/>';
 		}
        }    
    }
    
    arsort($midfield);
    
    echo 'number of teams scanned: ' . count($midfield);
    echo "<table style='width:50%'>";
    echo "<tr>";
    echo	"<td></td>";

    echo	"<td> Team       </td>";
    echo    "<td> Midfield Value </td>";
    echo "</tr>";   
    $i=0;
    foreach($midfield as $x=>$x_value) {
    $i+=1;
    echo "<tr>";
    echo "<td>  $i       </td>";
    echo	"<td> $x       </td>";
    echo    "<td> $x_value </td>";
    echo "</tr>";    
    }
	echo "</table>";
}
 
catch(HTError $e)
{
 echo $e->getMessage();
}   

?>