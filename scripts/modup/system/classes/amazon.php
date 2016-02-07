<?php
class Amazon{

	private $db;

	public function __construct($database) {
		$this->db = $database;
	}


/* ZA DEBUGVANE

http://www.amazon.co.uk/Screen-Protector-Suunto-Core-Black/dp/B00LHRJXRG/ref=pd_bxgy_200_2?ie=UTF8&refRID=0Z6XPNABECGBAPQR375S
B00LHRJXRG
*/

public function get_amdata($url){
	$code = trim($this->amazon_code($url));
	if(!$code) return false;
	$short_url = "http://www.amazon.co.uk/dp/$code";
	// $html = $this->get_pg($short_url);
	$html = $this->get_pg_curl($short_url);
	if(!$html) return false;

	$price = $this->get_price($html);
	$name = $this->get_name($html);
	$sm_img = $this->get_sm_img($html);

	return array('name'=>$name, 'code'=>$code, 'price'=>$price, 'smallimg'=>$sm_img, 'shorturl'=>$short_url, 'longurl'=>$url);
}

public function productFullUpdate($code){
	$product = array();
	if(!$code) return false;

	$short_url = "http://www.amazon.co.uk/dp/$code";
	$html = $this->get_pg_curl($short_url);
	if(!$html) return false;

	$price = $this->get_price($html);
	$name = $this->get_name($html);
	$sm_img = $this->get_sm_img($html);

	$product = array('name'=>$name, 'price'=>$price, 'smallimg'=>$sm_img);

	return $product;
}

public function get_all_prices($codes){
	if(!$codes) return false;
	$all_prices = array();
	foreach ($codes as $code) {
		$price = $this->update_price($code);
		if($price){
			$all_prices[$code] = $price;
		} else {
			$all_prices[$code] = '';
		}
	}
	if($all_prices) return $all_prices;
	else return false;
}

public function update_price($code){
	if(!$code) return false;
	$short_url = "http://www.amazon.co.uk/dp/$code";
	$html = $this->get_pg_curl($short_url);
	if(!$html) return false;
	$price = $this->get_price($html);
	if(!$price) return false;

	return $price;
}

public function amazon_code($url){
	if(!$url || filter_var($url, FILTER_VALIDATE_URL) === false) return false;
	$url_path = parse_url($url, PHP_URL_PATH);
	// $amazon_code = preg_replace('@.*(\/gp\/product\/|\/dp\/)(B[A-Z0-9]+).*@', "$2", $url_path);
	$amazon_code = preg_replace('@.*(\/gp\/product\/|\/dp\/)([A-Z0-9]+).*@', "$2", $url_path);

	if(!$amazon_code) return false;
	return $amazon_code;
}



private function get_price($html){
	$price_bool = $this->extr_xpath_val($html, '//td[contains(text(),"Price:")]');

	if($price_bool){
	    $price = $this->extr_xpath_val($html, '//td[contains(text(),"Sale:")]/../td[2]/span[1]');
	    if(!$price)
	    	$price = $this->extr_xpath_val($html, '//td[contains(text(),"Price:")]/../td[2]/span[1]');
	    $price = preg_match('@\d+(?:\.\d+)?@', $price[0], $match);
	} else return false;

	$price_scrap = isset($match[0]) ? $match[0] : false;
	return trim($price_scrap);
}

private function get_name($html){
	$name = $this->extr_xpath_val($html, '//h1[@id="title"]/span/text()');
	if(!$name){
		$name = $this->extr_xpath_val($html, '//h1[@class="parseasinTitle"]//text()');
		if(!$name) return false;
	}
	return trim($name[0]);
}

private function get_sm_img($html){
	// $sm_img = $this->extr_xpath_val($html, '//span[@class="a-button-text"]/img[contains(@src, "ecx.images-amazon.com")]/@src');
	$sm_img = $this->extr_xpath_val($html, '//span[@class="a-button-text"]/img/@src');
	if(!$sm_img){
		$sm_img = $this->extr_xpath_val($html, '//div[@id="thumbs-image"]/img/@src');
		if(!$sm_img) return false;
	}
	return trim($sm_img[0]);
}

private function get_pg($url){
    $rss = @file_get_contents($url);
    return $rss;
}

private function get_pg_curl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0'); 
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 35);
	curl_setopt($ch, CURLOPT_REFERER, "http://www.amazon.co.uk");
	$html = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if($html && !($httpCode == 404))
		return $html;
	else
		return false;
}

private function extr_xpath_val($html, $xp){
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $it = "";
    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query($xp);

    for($x=0; $x<$nodes->length; $x++){
        $tn = trim($nodes->item($x)->nodeValue);
        if(!$tn) continue;
        $it[] = $tn;
    }
    return $it;
}


}

?>