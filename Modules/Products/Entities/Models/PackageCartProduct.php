<?php 

/* 
* To change this license header, choose License Headers in Project Properties. 
* To change this template file, choose Tools | Templates 
* and open the template in the editor. */ 

/** 
* Description of Package 
* 
* @author sergio 
*/ 

namespace Modules\Products\Entities\Models; 

class PackageCartProduct { 
	private $product_id; 
	private $quantity; 
	private $price; 
	private $points; 
	private $sku; 
	private $name; 
	private $description; 
	private $shortDecription; 
	private $priceQuantity; 

	function getProduct_id() { 
		return $this->product_id; 
	}

	function getQuantity() { 
		return $this->quantity; 
	} 

	function getPrice() { 
		return $this->price; 
	} 

	function getPoints() { 
		return $this->points; 
	} 

	function getSku() { 
		return $this->sku; 
	} 

	function getName() { 
		return $this->name; 
	} 

	function getDescription() { 
		return $this->description; 
	} 

	function getShortDecription() { 
		return $this->shortDecription; 
	} 

	function getPriceQuantity() { 
		return $this->priceQuantity; 
	} 

	function setProduct_id($product_id) { 
		$this->product_id = $product_id; 
	} 

	function setQuantity($quantity) { 
		$this->quantity = $quantity; 
	} 

	function setPrice($price) { 
		$this->price = $price; 
	} 

	function setPoints($points) { 
		$this->points = $points; 
	} 

	function setSku($sku) { 
		$this->sku = $sku; 
	} 

	function setName($name) { 
		$this->name = $name; 
	} 

	function setDescription($description) { 
		$this->description = $description; 
	} 

	function setShortDecription($shortDecription) { 
		$this->shortDecription = $shortDecription; 
	} 

	function setPriceQuantity($priceQuantity) { 
		$this->priceQuantity = $priceQuantity; 
	}	
}