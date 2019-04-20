<?php


namespace App\Managers\File\Types;


class FileDat {
	/**
	 * @var string
	 */
	const CLIENT_DAT = "001";
	/**
	 * @var string
	 */
	const SALE_DAT = "003";
	/**
	 * @var string
	 */
	const SALESMAN_DAT = "002";
	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var array
	 */
	private $vendedores;

	/**
	 * @var \stdClass
	 */
	private $objResult;
	/**
	 * FileDat constructor.
	 * @param $file
	 */
	public function __construct($file) {
		$this->file = $file;
		$this->vendedores = [];
		$this->objResult = [
			'client' => [
				'count' => 0
			],
			'sale' => [
				'count' => 0,
				'moreexpresive' => [],
				'lessexpresive' => []
			],
			'salesman' => [
				'count' => 0,
				'sale_list' => []
			]
		];
	}


	/**
	 * @return \stdClass
	 */
	public function analyze() {
		$rows = explode("\n", $this->file);
		foreach ($rows as $row){
			$this->processLine($row);
		}
		$this->objResult['sale']['sale_list'] = $this->vendedores;
		$this->orderSales($this->objResult['sale']['sale_list']);
		$this->objResult['sale']['moreexpresive'] = $this->moreExpressiveSale();
		$this->objResult['sale']['lessexpresive'] = $this->lessExpressiveSale();

		return json_decode(json_encode($this->objResult));
	}

	/**
	 * @return array
	 */
	private function moreExpressiveSale(){
		return !empty($this->objResult['sale']['sale_list'][0])?
			$this->objResult['sale']['sale_list'][0] : [];
	}

	/**
	 * @return array
	 */
	private function lessExpressiveSale(){
		return !empty($end = end($this->objResult['sale']['sale_list']))
			? $end : [];
	}
	/**
	 * @param $row
	 */
	private function processLine($row) {
		$m = explode('ç',$row);
		if(!empty($m[0])) {
			$id = $m[0];
			switch ($id) {
				case self::CLIENT_DAT:
					$this->objResult['client']['count'] += 1;
					break;
				case self::SALE_DAT:
					$this->objResult['sale']['count'] += 1;
					$this->filterSaleItem($row);
					break;
				case self::SALESMAN_DAT:
					$this->objResult['salesman']['count'] += 1;
					break;
			}
		}
	}

	/**
	 * @param $row
	 */
	private function filterSaleItem ($row) {
		$venda = explode('ç',$row);
		preg_match("/\[(.*?)\]/", $row,$mat);
		$items = [];
		$head = true;
		$qtd = true;
		if(!empty($sales = $mat[1])){
			foreach(explode(',',$sales) as $item){
				$line = explode('-',$item);
				if($head){// id do item
					$items = $line;
					$head = false;
					continue;
				}
				elseif ($qtd){//adiciona a quantidade nos items do array
					foreach ($line as $key=> $l) {
						$items[$key] = [
							'id' => $items[$key],
							'qtd' => $l
						];
					}
					$qtd = false;
					continue;
				}
				else{// adiciona o valor dos items
					foreach ($line as $key=> $l) {
						$items[$key]['valor'] = $l;
					}
					$qtd = false;
				}
			}
		}
		$this->vendedores[] = [
			'salesman' => $venda[1],
			'name' => end($venda),
			'items' => $items
		];

	}

	/**
	 * - First is the more expressive sale
	 * - Last is the less expressive sale
	 * @param $sale_list
	 */
	private function orderSales(&$sale_list) {
		usort($sale_list, function($a,$b){
			$ta = array_map(function($item){
				return (floatval(str_replace(" ","",$item['qtd'])) *
					floatval(str_replace(' ','',$item['valor'])));
			}, $a['items']);
			$tb = array_map(function($item){
				return (floatval(str_replace(" ","",$item['qtd'])) *
					floatval(str_replace(' ','',$item['valor'])));
			}, $b['items']);
			return array_sum($ta) < array_sum(	$tb);
		});
	}

}
