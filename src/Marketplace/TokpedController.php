<?php

namespace Prasudiro\ApiTokoOnline\Marketplace;

use App\Http\Controllers\Controller;
use Prasudiro\ApiTokoOnline\Api\CurlController;
use Request;
use Session;

class TokpedController extends Controller
{
	public $data;

  public function __construct()
	{
		$this->middleware('web');
	}

	public function index()
	{
		//Golden is silent
	}

	//OAuth 2.0 get token
  public function tokped_oauth2($client_id, $secret_id)
  {
  	$site_url  = 'https://accounts.tokopedia.com/token';
    $auth_code = base64_encode($client_id.":".$secret_id);

    $headers 	= ['Authorization: Basic '.$auth_code,
          			'Content-Type: application/x-www-form-urlencoded'
        			];

    $post = 'grant_type=client_credentials';

		$curl 	= new CurlController;
		$result = $curl->cuRLShopee($site_url, $headers, $post, "POST");

    return $result;
  }

  //Check expired oauth2 (tokopedia)
  public function check_oauth2($token, $fsid)
  {
  	$site_url = 'https://fs.tokopedia.net/inventory/v1/fs/'.$fsid.'/product/list';
    $headers  = ['Authorization: Bearer '.$token,
                 'Cache-control: no-cache',
              ];

    $post     = ['rows' => 1, 'start' => 1];
    
		$curl 	= new CurlController;
		$result = $curl->cuRLShopee($site_url, $headers, $post, "POST");
    $result = json_decode($result);
    $return = isset($result) ? TRUE : FALSE ;

    return $return;
  }

  //GET token
  public function get_token($client_id, $secret_id, $fsid)
  {
    $token        = Session::get('tokped_token');

    if ($token) 
    {
      $check_oauth2 = $this->check_oauth2($token, $fsid);

      if ($check_oauth2 === FALSE) 
      {    
        $refresh_token = json_decode($this->tokped_oauth2($client_id, $secret_id));
        
        if (isset($refresh_token->access_token)) 
        {
          $new_token = Session::put('tokped_token', $refresh_token->access_token);
        }
      }
    }
    else
    {
      $tokped_auth = array();      
      $result      = json_decode($this->tokped_oauth2($client_id, $secret_id));
      
      if (isset($result->access_token)) 
      {
        $tokped_auth = array('key'   => 'api_tokped_token_live',
                             'value' => $result->access_token,
                    );
      }

      $save_token = Session::put('tokped_token', $result->access_token);
    } 

    $token = Session::get('tokped_token');

    return $token;
  }

	public function Client($data)
	{		
		$data['url']						= 'https://fs.tokopedia.net/inventory/v1/fs/';
		$data['timestamp']		 	= time();
    $data['fs_id']					= (float)$data['fs_id'];
    $data['shopid']		      = (float)$data['shopid'];
		$data['client_id']     	= $data['client_id'];
    $data['client_secret']	= $data['client_secret'];

    return $data;
  }

  //Get Item List
  public function GetProductList($data, $item)
  {
		$data 	= $this->Client($data);

		$site_url				= $data['url'];
  	$client_id 			= $data['client_id'];
  	$client_secret	= $data['client_secret'];
    $fsid           = $data['fs_id'];
    $timestamp      = $data['timestamp'];       

  	$token  	= $this->get_token($client_id, $client_secret, $fsid);
    $site_url = $site_url.$fsid.'/product/list';
    $headers  = ['Authorization: Bearer '.$token];
    $post 		= ['rows' => $item[0], 'start' => $item[1]];

		$curl 	= new CurlController;
    $result = $curl->cuRLTokped($site_url, $headers, $post, "GET");

    return $result;
  }

  //Get Item Variant
  public function GetProductVariant($data, $item)
  {
		$data 	= $this->Client($data);

		$site_url				= $data['url'];
  	$client_id 			= $data['client_id'];
  	$client_secret	= $data['client_secret'];
    $fsid           = $data['fs_id'];
    $timestamp      = $data['timestamp'];

  	$token  	= $this->get_token($client_id, $client_secret, $fsid);
    $site_url = $site_url.$fsid.'/product/variant/'.$item[0];
    $headers  = ['Authorization: Bearer '.$token];
    $post 		= ['rows' => $item[1], 'start' => $item[2]];

		$curl 	= new CurlController;
    $result = $curl->cuRLTokped($site_url, $headers, $post, "GET");

    return $result;
  }

  //Get Item Variant
  public function GetOrderList($data, $item, $option)
  {
		$data 	= $this->Client($data);

		$site_url				= $data['url'];
  	$client_id 			= $data['client_id'];
  	$client_secret	= $data['client_secret'];
    $fsid           = $data['fs_id'];
    $timestamp      = $data['timestamp'];

  	$token  	= $this->get_token($client_id, $client_secret, $fsid);
    $site_url = 'https://fs.tokopedia.net/v1/order/list?fs_id='.$fsid;
    $headers  = ['Authorization: Bearer '.$token];
    $post 		= ['status' => $item[0], 'from_date' => $item[1], 'to_date' => $item[2], 'per_page' => $option[0], 'page' => $option[1]];

		$curl 	= new CurlController;
    $result = $curl->cuRLTokped($site_url, $headers, $post, "GET");

    return $result;
  }

}
