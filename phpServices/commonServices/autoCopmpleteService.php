<?php

function getdrugList($queryString, $drugType){
	
	$sql ="SELECT d.`drugID`, d.`typeID`, d.`companyID`, CONCAT(d.drugName, ' - ',  d.`strength`) As displayName, d.drugName, d.strength
			FROM `drug` d 
			WHERE d.`drugName` LIKE '" . $queryString . "%' AND d.typeID = '$drugType'
			LIMIT 10";
	$result=mysql_query($sql);
	 $data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}

function getDiseaseList($queryString){

	$res=  mysql_query("select * from disease WHERE name LIKE '" . $queryString . "%'  ORDER BY name LIMIT 10");
		
	$data = array();
	while ($row=mysql_fetch_array($res)){
		array_push($data,$row);
	}
	echo json_encode($data);
		
}

function getInvList($queryString){
	
	$sql = "SELECT i.`id` , i.`name`
			FROM `inv` i
			WHERE i.`name` LIKE '" . $queryString . "%' LIMIT 10 ORDER BY `name`";

	$result=mysql_query($sql);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}

	echo json_encode($data);
}

function getInvListForSetting($queryString){

	$sql = "SELECT i.`id` , i.`name`
	FROM `inv` i
	WHERE i.`name` LIKE '" . $queryString . "%' LIMIT 10";

	$data ="<p id='searchresults'>";

	while($row1=  mysql_fetch_array($result)){
		$name=$row1['name'];
			
		$data.= '<a href="javascript:autocompleteInvForSetting(\''.$name.'\')">';
			
		$data.= '<span class="searchheading">'.$name.'</span>';
	}

	$data.= "</p>";
	echo $data;
}

function getAdvcieList($queryString, $type, $lang){

	$sql = "SELECT a.`id` , a.`type` , a.`lang` , a.`advice` , a.`pdf`
			FROM `advice` a
			WHERE a.lang = '$lang' AND a.type = '$type' AND  a.`advice` LIKE '" . $queryString . "%'
			
			UNION 

			SELECT a.`id` , a.`type` , a.`lang` , a.`advice` , a.`pdf`
			FROM `advice` a
			WHERE a.lang = '$lang' AND a.type = 0 AND  a.`advice` LIKE '" . $queryString . "%' LIMIT 10";

	$result=mysql_query($sql);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
}
function getDiet($queryString){

    $sql = "SELECT `contentDetailID`, `detail` FROM `contentdetail` 
            WHERE `contentType` = 'DIET' 
            AND `detail` LIKE '" . $queryString . "%' LIMIT 10";

    $result=mysql_query($sql);
    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }

    echo json_encode($data);
}
?>