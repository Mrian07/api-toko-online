<?php

namespace Prasudiro\ApiTokoOnline\Marketplace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prasudiro\ApiTokoOnline\Api\CurlController;

class ShopeeController extends Controller
{
	public $data;

  public function __construct()
	{
		//
	}

	public function index()
	{
		//Golden is silent
	}

	public function HashShopeeAPI($body, $secret_key)
	{
		$result = hash_hmac('sha256', $body, $secret_key);

		return $result;
	}

	public function authAPI($auth)
	{
		$result = [
					      'Authorization: '.$auth,
					      'User-Agent: shopee-php/v1/',
					      'Content-Type: application/json',
					    ];

		return $result;
	}

	public function Client($data)
	{		
		$data['url']						= 'https://partner.shopeemobile.com/api/v1';
		$data['timestamp']		 	= time();
		$data['partner_id']     = (float)$data['partner_id'];
    $data['shopid']		      = (float)$data['shopid'];
    $data['secret_key']			= $data['secret_key'];

    return $data;
  }

  //Information Shop
	public function GetShopInfo($data)
	{
		$data = $this->Client($data);

		$site_url  = $data['url'].'/shop/get';

    $post = array(
              'partner_id'  => $data['partner_id'],
              'shopid'      => $data['shopid'],
              'timestamp'   => $data['timestamp'],
            );

    $post = json_encode($post);
    $body = $site_url . '|' . $post;

    $auth 	 = $this->HashShopeeAPI($body, $data['secret_key']);
    $headers = $this->authAPI($auth);

		$curl 	= new CurlController;
		$result = $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

	//Performance Shop
	public function Performance($data)
	{
		$data = $this->Client($data);

		$site_url  = $data['url'].'/shop/performance';

    $post = array(
              'partner_id'  => $data['partner_id'],
              'shopid'      => $data['shopid'],
              'timestamp'   => $data['timestamp'],
            );

    $post = json_encode($post);
    $body = $site_url . '|' . $post;

    $auth 	 = $this->HashShopeeAPI($body, $data['secret_key']);
    $headers = $this->authAPI($auth);

		$curl 	= new CurlController;
		$result = $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

	//Get Item List
	public function GetItemsList($data,$item)
	{
		$data 			= $this->Client($data);
		$site_url  	= $data['url'].'/items/get';

		$post = array(
            'partner_id'  								=> $data['partner_id'],
            'shopid'      								=> $data['shopid'],
            'timestamp'   								=> $data['timestamp'],
            'pagination_offset'           => $item[0],
            'pagination_entries_per_page' => $item[1],
          );

    $post 			= json_encode($post);
    $body 			= $site_url . '|' . $post;
		$auth 	 	 	= $this->HashShopeeAPI($body, $data['secret_key']);
    $headers 	 	= $this->authAPI($auth);

		$curl 	 		= new CurlController;
		$result  		= $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

	//Get Item Detail
	public function GetItemDetail($data, $item)
	{
		$data 			= $this->Client($data);
		$site_url  	= $data['url'].'/item/get';

		$post = array(
            'partner_id'	=> $data['partner_id'],
            'shopid'			=> $data['shopid'],
            'timestamp'		=> $data['timestamp'],
            'item_id'			=> (float)$item[0],
          );

		// print_r($post);exit();

    $post 			= json_encode($post);
    $body 			= $site_url . '|' . $post;
		$auth 	 	 	= $this->HashShopeeAPI($body, $data['secret_key']);
    $headers 	 	= $this->authAPI($auth);

		$curl 	 		= new CurlController;
		$result  		= $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

	//Update Variation Stock
	public function UpdateVariationStock($data, $item)
	{
		$data 			= $this->Client($data);
		$site_url  	= $data['url'].'/items/update_variation_stock';

		$post = array(
            'partner_id'		=> $data['partner_id'],
            'shopid'				=> $data['shopid'],
            'timestamp'			=> $data['timestamp'],
            'item_id'				=> (float)$item[0],
            'variation_id'	=> (float)$item[1],
            'stock'					=> (float)$item[2],
          );

		// print_r($post);exit();

    $post 			= json_encode($post);
    $body 			= $site_url . '|' . $post;
		$auth 	 	 	= $this->HashShopeeAPI($body, $data['secret_key']);
    $headers 	 	= $this->authAPI($auth);

		$curl 	 		= new CurlController;
		$result  		= $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

	//Get Order List by Status
	public function GetOrdersByStatus($data, $item)
	{
		$data 			= $this->Client($data);
		$site_url  	= $data['url'].'/orders/get';

		$post = array(
            'partner_id'									=> $data['partner_id'],
            'shopid'											=> $data['shopid'],
            'timestamp'										=> $data['timestamp'],
            'order_status'								=> $item[0],
            'pagination_offset'           => 0,
            'pagination_entries_per_page' => 100,
          );

    $post 			= json_encode($post);
    $body 			= $site_url . '|' . $post;
		$auth 	 	 	= $this->HashShopeeAPI($body, $data['secret_key']);
    $headers 	 	= $this->authAPI($auth);

		$curl 	 		= new CurlController;
		$result  		= $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

	//Get Order Detail
	public function GetOrderDetails($data, $item)
	{
		$data 			= $this->Client($data);
		$site_url  	= $data['url'].'/orders/detail';

		$post = array(
            'partner_id'									=> $data['partner_id'],
            'shopid'											=> $data['shopid'],
            'timestamp'										=> $data['timestamp'],
            'ordersn_list'								=> [$item[0]],
          );
		
    $post 			= json_encode($post);
    $body 			= $site_url . '|' . $post;
		$auth 	 	 	= $this->HashShopeeAPI($body, $data['secret_key']);
    $headers 	 	= $this->authAPI($auth);

		$curl 	 		= new CurlController;
		$result  		= $curl->cuRLShopee($site_url, $headers, $post, "GET");

		return $result;
	}

}
