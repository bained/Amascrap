<?php
function id(){$ID=md5(rand() * time()); return $ID;}

function timestamp(){
	return time();
}

function gmtimestamp($tstmp){
	return gmdate("d.m.y", $tstmp);
}

function jstime($tstmp){
    return ($tstmp*1000);
}

// Cut the string without breaking any words
function cutstring($string, $max_length){
    if (strlen($string) > $max_length){
        $string = substr($string, 0, $max_length);
        $pos = strrpos($string, " ");
        if($pos === false) {
                return substr($string, 0, $max_length)."...";
        }
            return substr($string, 0, $pos)."...";
    }else{
        return $string;
    }
}

function checkRemoteImg($url_img)
{
    $external_link = $url_img;
    if (@getimagesize($external_link)) {
        return true;
    } else {
        return false;
    }
}

function short_link($code){
    if($code)
        return '<a href="http://www.amazon.co.uk/dp/'.$code.'" target="_blank">'.$code.'</a>';
    else
        return $code;
}

?>