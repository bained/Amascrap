<?php
class Products{

	private $db;

	public function __construct($database) {
		$this->db = $database;
		// $this->traktor = $traktor;
	}

	public function count_all_products(){
		$qry = $this->db->prepare(
			'SELECT COUNT(id) FROM products');
		$qry->execute();
		$result = $qry->fetchColumn();
		return $result;
	}

	public function add($post, $traktor){
		if(!isset($post) || !$post) return false;

		// $img_name = id().'.jpg';
		$img_name = $post['code'].'.jpg';
		$img_download = $this->grab_image($post['smallimg'] ,DIR_SM_IMG.$img_name);

		$addedon = time();
		if($this->check_code($post['code']) == true) return "Кода вече е вкаран в ДБ!";

		$qry = $this->db->prepare(
			'INSERT INTO products
				(name, code, price, smallimg, longurl, shorturl, addedon, latestprice, lastupdate)
			VALUES
				(:name, :code, :price, :smallimg, :longurl, :shorturl, :addedon, :latestprice, :lastupdate)
			');
		try {
			$qry->execute(array(
				':name'=>$post['name'],
				':code'=>$post['code'],
				':price'=>$post['price'],
				// ':smallimg'=>$post['smallimg'],
				':smallimg'=>$img_name,
				':longurl'=>$post['longurl'],
				':shorturl'=>$post['shorturl'],
				':addedon'=>$addedon,
				':latestprice'=>$post['price'],
				':lastupdate'=>$addedon
			));

			$lstId = $this->db->lastInsertId();

			$traktor->addpoint($lstId, $addedon, $post['price']);
		} catch (PDOException $e){
			return $e->getMessage();
		}

		return false;
	}

	public function update_product_price($code, $price, $traktor){
		$qry = $this->db->prepare(
			'UPDATE products
				SET latestprice=:price, lastupdate=:lastupdate
			WHERE code=:code
			');
		try {
			$qry->execute(array(
				':code'=>$code,
				':price'=>$price,
				':lastupdate'=>timestamp()
			));

			$changed_id = $this->getidbycode($code);

			$traktor->addpoint($changed_id, timestamp(), $price);
		} catch (PDOException $e){
			return $e->getMessage();
		}

		return false;
	}

	// Make Latest Price --> First Price
	public function ch_first_price($code, $price){
		$qry = $this->db->prepare(
			'UPDATE products
				SET price=:price
			WHERE code=:code
			');
		try {
			$qry->execute(array(
				':code'=>$code,
				':price'=>$price
			));
		} catch (PDOException $e){
			return $e->getMessage();
		}
		return false;
	}

	public function getidbycode($code){
		$qry = $this->db->prepare('SELECT id FROM products WHERE code=:code');
		$qry->execute(array(':code'=>$code));
		$result = $qry->fetch(PDO::FETCH_ASSOC);
		return $result['id'];
	}

	public function productFullUpdate($product, $key, $traktor){
		if(!$product || !$key) return "Missing product!";

		$img_name = $key.'.jpg';
		$img_download = $this->grab_image($product['smallimg'], DIR_SM_IMG.$img_name);

		$qry = $this->db->prepare(
			'UPDATE products
				SET 
					name=:name,
					latestprice=:price,
					smallimg=:smallimg,
					lastupdate=:lastupdate
			WHERE code=:code
			');
		try {
			$qry->execute(array(
				':code'=>$key,
				':name'=>$product['name'],
				':price'=>$product['price'],
				':smallimg'=>$img_name,
				':lastupdate'=>timestamp()
			));

			$changed_id = $this->getidbycode($key);
			$traktor->addpoint($changed_id, timestamp(), $product['price']);
			return false;
		} catch (PDOException $e){
			return $e->getMessage();
		}
	}


	public function delete_product($code, $traktor){
		if(!$code) return false;
		$savedto = DIR_SM_IMG.$code.'.jpg';
		$id = $this->getidbycode($code);

		if($error = $this->delete_product_wcode($code)){
			return $error;
		}
		if($error = $this->delete_file($savedto)){
			return $error;
		}
		if($error = $traktor->deletepoints($id)){
			return $error;
		}

		else return false;
	}


	public function delete_product_wcode($code){
		$qry = $this->db->prepare(
			'DELETE FROM products
			WHERE code=:code
			');
		try {
			$qry->execute(array(
				':code'=>$code
			));
		} catch (PDOException $e){
			return $e->getMessage();
		}

		return false;
	}

	public function delete_file($savedto=''){
		if(!$savedto || !file_exists($savedto)) return "ERROR: File not found!";
		if(unlink($savedto)) return false;
		else return 'ERROR: Can not deleting file!';
	}





	public function get($id){
		$qry = $this->db->prepare(
			'SELECT * FROM products WHERE id=:id');
		$qry->execute(array(':id'=>$id));
		$result = $qry->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getAll(){
		$qry = $this->db->prepare(
			'SELECT * FROM products');
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getAllLimit($limit, $order){
		switch ($order) {
			case 'name':
			case 'price':
			case 'latestprice':
				$ascdesc = 'ASC';
				break;
			
			default:
				$ascdesc = 'DESC';
				break;
		}
		$qry = $this->db->prepare(
			"SELECT * FROM products 
				ORDER BY $order
				$ascdesc
				$limit
			");
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);

		if($result){
			foreach ($result as $key=>$product) {
				$up = '<span class="up_arrow">&#8679;</span>';
				$down = '<span class="down_arrow">&#8681;</span>';

				if($product['latestprice'] > $product['price']){
					$result[$key]['arrow'] = $up;
				} elseif ($product['latestprice'] < $product['price']) {
					$result[$key]['arrow'] = $down;
				} else {
					$result[$key]['arrow'] = false;
				}

			}
		}

		return $result;
	}

	public function get_all_codes(){
		$qry = $this->db->prepare(
			'SELECT code FROM products');
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_COLUMN, 0);
		return $result;
	}

	public function get_all_prc_codes(){
		$qry = $this->db->prepare(
			'SELECT code FROM products WHERE price <> latestprice');
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_COLUMN, 0);
		return $result;
	}	

	public function check_code($code){
		$qry = $this->db->prepare(
			'SELECT id FROM products WHERE code=:code
		');
		$qry->execute(array(':code'=>$code));
		$result = $qry->fetch(PDO::FETCH_ASSOC);
		if($result) return true;
		else return false;
	}

	public function grab_image($url,$saveto){
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$raw=curl_exec($ch);
		curl_close ($ch);
		if(file_exists($saveto)){
		    unlink($saveto);
		}
		$fp = fopen($saveto,'x');
		fwrite($fp, $raw);
		fclose($fp);
	}

	public function prcchanged($order){

		switch ($order) {
			case 'name':
			case 'price':
			case 'latestprice':
				$ascdesc = 'ASC';
				break;
			
			default:
				$ascdesc = 'DESC';
				break;
		}

		$qry = $this->db->prepare(
			"SELECT * FROM products WHERE price <> latestprice ORDER BY $order");
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);

		if($result){
			foreach ($result as $key=>$product) {
				$up = '<span class="up_arrow">&#8679;</span>';
				$down = '<span class="down_arrow">&#8681;</span>';

				if($product['latestprice'] > $product['price']){
					$result[$key]['arrow'] = $up;
				} elseif ($product['latestprice'] < $product['price']) {
					$result[$key]['arrow'] = $down;
				} else {
					$result[$key]['arrow'] = false;
				}

			}
		}

		return $result;
	}


}

?>