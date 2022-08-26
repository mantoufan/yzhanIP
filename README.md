# yzhanIP
Get the client real IP when using CDN like Cloudflare, return whether the IP is a search engine crawler like GoogleBot   
获取客户端真实 IP，适用 CDN 如 Cloudflare，并返回该 IP 是不是搜索引擎爬虫，如 Google 漫游器  

## Usage 使用
1. Install 安装
```shell
composer require mantoufan/yzhanip
```
2. Usage 使用
```php
$yzhanIP = new Mantoufan/YZhanIP();
$res = $yzhanIP->get();
$ip = $res->ip; // 199.36.156.1 
$crawler = $res->crawler; // google, If not a crawler, return null
```
3. Custom White IP List (Optional) 自定义 IP 白名单  
CDN passes the client's real IP through a custom HTTP   
To avoid forging HTTP headers to impersonate CDN,  
only trust custom HTTP headers from CDN node IP requests  
CDN 通过自定义 HTTP 头，传递客户端真实 IP  
避免伪造 HTTP 头冒充 CDN，只信任来自于 CDN 节点 IP 请求的自定义 HTTP 头  
```php
$yzhanIP = new Mantoufan/YZhanIP();
$yzhanIP->setWhiteList(array(
  'nodes' => array(  
    'ips' => array( // Nodes IPList Name -> IPv4 + IPv6
      'cloudflare' => array( // Get IPs from URL
        'IPv4' => 'https://www.cloudflare.com/ips-v4', // URL including IPv4, such as CDN node IP
        'IPv6' => 'https://www.cloudflare.com/ips-v6', // URL including IPv6, such as CDN node IP
      ),
      'qianxin' => array(
        'IPv4' => array( // Write IPs directly
          '36.27.212.0', // Single IP
          '36.27.212.1-36.27.212.255', // Support - 
          '123.129.232.0/24' // Support CIDR
        ),
        'IPv6' => array(),
      )
    ),
    'headers' => array( // Header Name -> Nodes IPList Name
      'CF_CONNECTING_IP' => array('cloudflare'), // Filter used cloudflare
      'TRUE_CLIENT_IP' => array('cloudflare', 'qianxin'), // Filter used cloudflare or qianxin
      'X_REAL_IP' => null, // No filtering
    )
  )
  'crawlers'=> array(
    'ips' => array( // Crawlers IPList Name -> IPv4 + IPv6
      'google' => array(
        'IPv4' => 'https://developers.google.com/static/search/apis/ipranges/googlebot.json',
        'IPv6' => 'https://developers.google.com/static/search/apis/ipranges/googlebot.json',
      )
    )
    'uas' => array( // User Agent Keywrod -> Crawlers IPList Name
      'Googlebot' => 'google' /* Case insensitive
      only if the user agent contains Googlebot,
      will check if the IP is in Crawlers IPList */
    )
  )
));
```