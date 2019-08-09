API Toko Online (Indonesian Marketplace) v.1.0

Currently Support:
- Shopee
- Tokopedia

Currently Support Request:
- GetShopInfo
- Performance
- GetItemsList / GetProductList
- GetItemDetail / GetProductVariant
- UpdateVariationStock
- GetOrdersByStatus / GetOrderList
- GetOrderDetails

How To Use:

Add Provider:
    Prasudiro\ApiTokoOnline\ApiTokoOnlineServiceProvider::class,
	
Add Aliases:
	'ShopeeAPI' => Prasudiro\ApiTokoOnline\Facades\ShopeeAPI::class,
	'TokpedAPI' => Prasudiro\ApiTokoOnline\Facades\TokpedAPI::class,

$client = ShopeeAPI::Client(array('partner_id'    => 'YOUR_PARTNER_ID',
								  'client_secret' => 'YOUR_CLIENT_SECRET',
								  'shopid'        => 'YOUR_SHOPID'
              ));
      
$result = ShopeeAPI::GetItemDetail($client,[1234567890]);