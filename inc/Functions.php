<?php
function WolfyAPI($api){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $api);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: ".WOLFY_COOKIE));
	$result = curl_exec($ch);
	curl_close($ch);
	return json_decode($result);
}

function getLeaderBoard($type, $limit, $search){
	$fori = round($limit/50);
	$start = "0";

	$data = [];
	for($i=0; $i < $fori; $i++) {
		$res = WolfyAPI("https://wolfy.fr/api/leaderboard/load/".$type."/".$start);
		foreach($res as $mydata){
			if($mydata->id == $search){
				return $mydata;
				break;
			}
		}
		$start = $start+50;
	}
}

function getInfo($search) {
	global $bdd;

	/*SEARCH SYSTEM */
	try{
		$pseudo = $search;
		$re = WolfyAPI('https://wolfy.fr/api/leaderboard/player/'.$pseudo);
		if(!isset($re->user->id)){
			throw new Exception();
		}
	}catch (Exception $e) {
		$pseudo = getLeaderBoard('eternal', '30000', $search)->username;
		$re = WolfyAPI('https://wolfy.fr/api/leaderboard/player/'.$pseudo);
	}

	if(!isset($re->user->id)){
		return null;
	}

	/* DATA */
	$re->user->niveau = WolfyLVL($re->user->xp);
	
	$req = $bdd->prepare('SELECT * FROM users WHERE uuid = ? ORDER BY id DESC LIMIT 1');
	$req->execute(array($re->user->id));
	if($req->rowcount() <= 0){
		$req = $bdd->prepare('INSERT INTO users SET uuid = ?, params = ?, date = ?');
		$req->execute(array($re->user->id,json_encode($re),time()));
	}else{
		$t = $req->fetch();
		if(json_decode($t['params']) != $re){
			$req = $bdd->prepare('INSERT INTO users SET uuid = ?, params = ?, date = ?');
			$req->execute(array($re->user->id,json_encode($re),time()));
		}
	}

	return $re;
}

function WolfyLVL($xp){
	$lvl = array(
		"0" => "0",
		"1" => "30",
		"2" => "80",
		"3" => "160",
		"4" => "330",
		"5" => "690",
		"6" => "1340",
		"7" => "2320",
		"8" => "3870",
		"9" => "6000",
		"10" => "9010",
		"11" => "13100",
		"12" => "18600",
		"13" => "25600",
		"14" => "34100",
		"15" => "45100",
		"16" => "60100",
		"17" => "80100",
		"18" => "110100",
		"19" => "150100",
		"20" => "200100",
		"21" => "260100",
		"22" => "330100"
	);
	foreach($lvl as $i => $num){
		if($xp >= $num  AND $xp < $lvl[$i+1]){
			return $i+1;
		}
	}
}
function Ranking($rank = null){
	$arr = array(
		"10" 	=>	array(
						"background-skin-1" 	=> "#f7f7f700",
						"background-skin-2" 	=> "#f7f7f7",
						"background-lvl-1" 		=> "#f7f7f7",
						"background-lvl-2" 		=> "#5a5a5a",
						"background-lvl-3" 	    => "#000",
						"background-rank-1" 	=> "#000",
						"image" 				=> "nograde.png"
					),
		"20" 	=>	array(
						"background-skin-1" 	=> "#5e53d500",
						"background-skin-2" 	=> "#ce9ffc",
						"background-lvl-1" 		=> "#ce9ffc",
						"background-lvl-2" 		=> "#5e53d5",
						"background-lvl-3" 		=> "#5e53d5",
						"background-rank-1" 	=> "#5e53d5",
						"image" 				=> "alpha.png"
					),
		"40" 	=>	array(
						"background-skin-1" 	=> "#ff864200",
						"background-skin-2" 	=> "#ffe483",
						"background-lvl-1" 		=> "#ffe483",
						"background-lvl-2" 		=> "#ff8642",
						"background-lvl-3" 		=> "#ffe483",
						"background-rank-1" 	=> "#ffe483",
						"image" 				=> "cele.png"
					),
		"60" 	=>	array(
						"background-skin-1" 	=> "#31712600",
						"background-skin-2" 	=> "#82f595",
						"background-lvl-1" 		=> "#82f595",
						"background-lvl-2" 		=> "#317126",
						"background-lvl-3" 		=> "#317126",
						"background-rank-1" 	=> "#317126",
						"image" 				=> "equipe.png"
					),
		"80" 	=>	array(
						"background-skin-1" 	=> "#317ada00",
						"background-skin-2" 	=> "#77d4f6",
						"background-lvl-1" 		=> "#77d4f6",
						"background-lvl-2" 		=> "#317ada",
						"background-lvl-3" 		=> "#317ada",
						"background-rank-1" 	=> " #317ada",
						"image" 				=> "modo.png"
					),
		"100" 	=>	array(
						"background-skin-1" 	=> "#f58282",
						"background-skin-2" 	=> "#a7354a",
						"background-lvl-1" 		=> "#f58282",
						"background-lvl-2" 		=> "#a7354a",
						"background-lvl-3" 		=> "#a7354a",
						"background-rank-1" 	=> "#a7354a",
						"image" 				=> "admin.png"
					),
	);

	return $arr[$rank];
}




