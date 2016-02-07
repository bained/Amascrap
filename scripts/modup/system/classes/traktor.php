<?php
class Traktor{

	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

public function addpoint($id, $dtime, $price){
	$qry = $this->db->prepare(
		'INSERT INTO traktor
			(id, dtime, price)
		VALUES
			(:id, :dtime, :price)
		');
	try {
		$qry->execute(array(
			':id'=>$id,
			':dtime'=>$dtime,
			':price'=>$price
		));
	} catch (PDOException $e){
		return $e->getMessage();
	}

	return false;
}

public function getallpoints($id){
	$qry = $this->db->prepare(
		'SELECT dtime, price FROM traktor WHERE id=:id ORDER BY dtime ASC'
	);

	$qry->execute(array(':id'=>$id));
	$result = $qry->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}

public function deletepoints($id){
	$qry = $this->db->prepare(
		'DELETE FROM traktor WHERE id=:id'
	);
	try {
		$qry->execute(array(
			':id'=>$id
		));
	} catch (PDOException $e){
		return $e->getMessage();
	}
	return false;
}

public function formatdatearray($array){
	$jsn_return = "";
	foreach ($array as $dateprice) {
		// $dt = date('Y, n, j, ', $dateprice['dtime']).(int)(date('i', $dateprice['dtime']));
		$dt = date(
			date('Y, ', $dateprice['dtime']).
			(date('n', $dateprice['dtime'])-1).", ".
			date('j, ', $dateprice['dtime']).
			date('G, ', $dateprice['dtime']).
			(int)(date('i', $dateprice['dtime']))
		);
		$jsn_return .= '[new Date('.$dt.'), '.$dateprice['price'].']';
		if (next($array)==true) $jsn_return .= ', ';
		else $jsn_return .= "\n";
	}
	return $jsn_return;
}


}