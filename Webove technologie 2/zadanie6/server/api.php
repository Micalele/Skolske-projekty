<?php
$rawXml = file_get_contents("meniny.xml");
$xml = simplexml_load_string($rawXml);
$jsonString = json_encode($xml);
$result = json_decode($jsonString,true);
$meniny = $result["zaznam"];
//echo $_GET["search"];

//http://147.175.121.210:8143/zadanie6/server/api/names?date=0101
if ($_GET["search"] == "name"){
    $return = array();
    if (isset($_GET["date"])){
        foreach ($meniny as $item){
            if ($item["den"]==$_GET["date"]){
                if ($item["SK"]!=null) $return["SK"] = $item["SK"];
                if ($item["SKd"]!=null) $return["SKd"] = $item["SKd"];
                if ($item["CZ"]!=null) $return["CZ"] = $item["CZ"];
                if ($item["HU"]!=null) $return["HU"] = $item["HU"];
                if ($item["PL"]!=null) $return["PL"] = $item["PL"];
                if ($item["AT"]!=null) $return["AT"] = $item["AT"];
            }
        }
    }
    echo json_encode($return);
}
//http://147.175.121.210:8143/zadanie6/server/api/dates?country=CZ&name=Karina
if ($_GET["search"] == "date"){
    $return = array();
    if (isset($_GET["country"]) && isset($_GET["name"])){
        foreach ($meniny as $item){
            //echo $item[$_GET["country"]] . "<br>";
            if (isset($item[$_GET["country"]]) && strpos($item[$_GET["country"]], $_GET["name"])!==false){
                $return["den"] = $item["den"];
                break;
            }
        }
    }
    echo json_encode($return);
}
if ($_GET["search"] == "sviatkySK"){
    $return = array();
    foreach ($meniny as $item){
        if ($item["SKsviatky"]!=null){
            $zaznam = array();
            $zaznam["sviatkySK"] = $item["SKsviatky"];
            $zaznam["den"] = $item["den"];
            array_push($return,$zaznam);
        }
    }
    echo json_encode($return);
}
if ($_GET["search"] == "sviatkyCZ"){
    $return = array();
    foreach ($meniny as $item){
        if ($item["CZsviatky"]!=null){
            $zaznam = array();
            $zaznam["sviatkyCZ"] = $item["CZsviatky"];
            $zaznam["den"] = $item["den"];
            array_push($return,$zaznam);
        }
    }
    echo json_encode($return);
}
if ($_GET["search"] == "vlozitMeno"){
    if (isset($_GET["meno"]) && isset($_GET["den"])){
        for ($i = 0; $i < 366; $i++){
            if ($xml->zaznam[$i]->den == $_GET["den"]){
                if ($xml->zaznam[$i]->SKd == "") $xml->zaznam[$i]->SKd =$_GET["meno"];
                else $xml->zaznam[$i]->SKd = $xml->zaznam[$i]->SKd . ", " . $_GET["meno"];
            }
        }
        $xml->asXML('meniny.xml');
    }
}
