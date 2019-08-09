<?php

namespace Prasudiro\ApiTokoOnline\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurlController extends Controller
{
	public function __construct()
	{
		//
	}

	public function index()
	{
		//Golden is silent
	}

	public function cuRLShopee($site_url, $headers, $post, $method)
	{
		$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $site_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close ($ch);

    return $result;
	}	

	public function cuRLTokped($site_url, $headers, $post, $method)
	{
		$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $site_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close ($ch);

    return $result;
	}

	public function testing($value)
	{
		return "Value yang dikirim adalah: ".$value;
	}
}
