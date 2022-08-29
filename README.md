# YZhanIP  
![Packagist License](https://img.shields.io/packagist/l/mantoufan/yzhanip?v=1)  ![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/mantoufan/yzhanip)  ![Test Coverage](./badge-coverage.svg)  
Crawl, match, parse IP or IP range, check if IP or range is in another range  
Support IPv4, IPv6, IP Interval, Wildcard and CIDR  
Check if IP is Cloudflare node IP, Google bot IP  
爬取，正则匹配，解析 IP 和 IP 范围，检测 IP 或范围是否在另一个范围中  
支持 IPv4，IPv6，区间、通配符或 CIDR 表示的 IP 范围  
检测 IP 是否是 Cloudflare 节点或 Google 漫游器 IP  

## Install 安装
```shell
composer require mantoufan/yzhanip
```
## Usage 使用
### In 包含
```php
use YZhanIP\YZhanIP;
```
#### Check if an IP is included in an IP range
#### 检测一个 IP 是否被 IP 范围包含
```php
(new YZhanIP('127.0.0.1'))->in(new YZhanIP('127.0.0.*')); // true, new YZhanIP can be omitted
(new YZhanIP('127.0.0.1'))->in('127.0.0.1-127.0.0.30'); // true
(new YZhanIP('127.0.0.1'))->in('127.0.0.*'); // true
(new YZhanIP('127.0.0.1'))->in('127.0.0.1/21'); // true
(new YZhanIP('2001:4860:4801::af88'))->in('2001:4860:4801::af88-2001:4860:4801::afff'); // true
(new YZhanIP('2001:4860:4801::af88'))->in('2001:4860:*::af88'); // true
(new YZhanIP('2001:4860:4801::af88'))->in('2001:4860:4801::af88/7'); // true
```
#### Check if an IP range is included in an IP range
#### 检测一个 IP 范围被另一个 IP 范围包含
```php
(new YZhanIP('127.0.0.1-127.0.0.30'))->in('127.0.0.*'); // true
(new YZhanIP('127.0.0.*'))->in('127.0.0.1/21'); // true
(new YZhanIP('2001:4860:4801::af88-2001:4860:4801::afff'))->in('2001:4860:*::af88'); // true
(new YZhanIP('2001:4860:*::af88'))->in('2001:4860:4801::af88/7'); // true
```
#### Check if a mixed array of IP / IP ranges is included in another mixed array of IP / IP ranges
#### 检测一组 IP / IP 范围混合数组被另一组 IP / IP 范围混合数组包含
```php
(new YZhanIP(['127.0.0.1', '127.0.0.1-127.0.0.30', '127.0.0.*']))->in('127.0.0.1/21'); // true
(new YZhanIP(['2001:4860:4801::af88', '2001:4860:4801::af88-2001:4860:4801::afff', '2001:4860:*::af88']))->in('2001:4860:4801::af88/7'); // true
```
### ToString 转为字符串
#### IP: to minimal form IP range: Wildcard / CIDR to Interval
#### IP：转为最简形式，IP 范围：区间、通配符、CIDR 转为区间
```php
(new YZhanIP(['127.0.0.*', '127.0.0.1/21']))->toString(); // 127.0.0.0-127.0.0.255,127.0.0.0-127.0.7.255
(new YZhanIP('2001:4860:4801:0000:0000:0000:0000:af88'))->toString(); // 2001:4860:4801::af88
(new YZhanIP(['2001:4860:*::af88', '2001:4860:4801::af88/7']))->toString(); // 2001:4860::af88-2001:4860:ffff::af88,2000::-21ff:ffff:ffff:ffff:ffff:ffff:ffff:ffff
```
#### To Raw String
#### 返回原始字符串
```php
(new YZhanIP('2001:4860:4801:0000:0000:0000:0000:af88'))->toRaw(); // 2001:4860:4801:0000:0000:0000:0000:af88
(new YZhanIP(['127.0.0.*', '127.0.0.1/21']))->toRaw(); // 127.0.0.*,127.0.0.1/21
(new YZhanIP(['2001:4860:*::af88', '2001:4860:4801::af88/7']))->toRaw(); // 2001:4860:*::af88,2001:4860:4801::af88/7
```
### Filter 过滤
#### Retain items in a set of IP / IP ranges that are included in another set of IP / IP ranges
#### 保留一组 IP / IP 范围中被另一组 IP / IP 范围中包含的项
```php
(new YZhanIP(['127.0.0.1', '65.0.0.1', '2001:4860:4801::af88', '3001::af88', '127.0.0.*', '2001:4860:4801::af88-2001:4860:4801::afff']))->filter(['127.0.0.1/21', '2001:4860:4801::af88/7'])->toRaw(); // 127.0.0.1,2001:4860:4801::af88,127.0.0.*,2001:4860:4801::af88-2001:4860:4801::afff
```
### Tracer 溯源
```php
use YZhanIP\Tool\IPTracer;
```
#### Check if the IP / IP range is Cloudflare node IP
#### 检测 IP / IP 范围 是否是 Cloudflare 节点 IP
```php
IPTracer::IsCloudflareNode('173.245.48.1'); // true
IPTracer::IsCloudflareNode('173.245.48.0/20'); // true
IPTracer::IsCloudflareNode('2400:cb00::1'); // true
IPTracer::IsCloudflareNode('2400:cb00::/32'); // true
```
#### Check if the IP / IP range is Googlebot IP
#### 检测 IP / IP 范围 是否是 Google 漫游器 IP
```php
IPTracer::IsGoogleBot('66.249.64.97'); // true
IPTracer::IsGoogleBot('66.249.64.0/27'); // true
IPTracer::IsGoogleBot('2001:4860:4801:48::1'); // true
IPTracer::IsGoogleBot('2001:4860:4801:10::/64'); // true
```
#### Check if the IP / IP range is in the URL content  
#### 检测 IP / IP 范围 是否在指定 URL 的内容中出现  
```php
IPTracer::IsInUrl(['173.245.48.1', '2400:cb00::1', '2400:cb00::/32'], ['https://www.cloudflare.com/ips-v4', 'https://www.cloudflare.com/ips-v6']); // true
```
### Crawler 爬取
```php
use YZhanIP\Tool\IPCrawler;
```
#### Extract IP / IP range array from URL
#### 从 URL 中提取 IP / IP 范围为数组
```php
$url = '{URL with IP and IP range inside}';
$ipCrawler = new IPCrawler($url, array( // The following are Default Config, no Modification no Statement
  'cacheDir' => sys_get_temp_dir(),
  'cacheKey' => 'yzhanip' . md5($url),
  'cacheMaxAge' => 86400, // Unit: s
  'timeOut' => 6,
));
// $ipCrawler = new IPCrawler($url); // use Default Config
$ipCrawler->get() // array('{IP}', '{IP Range}' ...)
```
#### Update Cache
#### 更新缓存
```php
$ipCrawler->update();
```
### Parser 解析
```php
use YZhanIP\Tool\IPParser;
```
#### Get the type of IP / IP range
#### 检测 IP / IP 范围的类型
```php
IPParser::GetType('127.0.0.1'); // IPV4
IPParser::GetType('127.0.0.1/21'); // IPV4CIDR
IPParser::GetType('127.0.0.1-127.0.0.30'); // IPV4INTERVAL
IPParser::GetType('127.0.0.*'); // IPV4WILDCARD
IPParser::GetType('2001:4860:4801::af88'); // IPV6
IPParser::GetType('2001:4860:4801::af88/7'); // IPV6CIDR
IPParser::GetType('2001:4860:4801::af88-2001:4860:4801::afff'); // IPV6INTERVAL
IPParser::GetType('2001:4860:*::af88'); // IPV6WILDCARD 
```
#### Check the type of IP / IP range
#### 判断 IP / IP 范围的类型
```php
IPParser::IsIPv4('127.0.0.1'); // true
IPParser::IsIPV4CIDR('127.0.0.1/21'); // true
IPParser::IsIPv4Interval('127.0.0.1-127.0.0.30'); // true
IPParser::IsIPv4Wildcard('127.0.0.*'); // true
IPParser::IsIPv6('2001:4860:4801::af88'); // true
IPParser::IsIPV6CIDR('2001:4860:4801::af88/7'); // true
IPParser::IsIPv6Interval('2001:4860:4801::af88-2001:4860:4801::afff'); // true
IPParser::IsIPv6Wildcard('2001:4860:*::af88'); // true
IPParser::IsIP('127.0.0.1'); // true
IPParser::IsIP('2001:4860:4801::af88'); // true
IPParser::IsIPCIDR('127.0.0.1/21'); // true
IPParser::IsIPCIDR('2001:4860:4801::af88/7'); // true
IPParser::IsIPInterval('127.0.0.1-127.0.0.30'); //  true
IPParser::IsIPInterval('2001:4860:4801::af88-2001:4860:4801::afff'); // true
IPParser::IsIPWildcard('127.0.0.*'); // true
IPParser::IsIPWildcard('2001:4860:*::af88'); // true
```
#### Get an IP / IP range array from HTML / TXT / JSON etc.
#### 从 HTML / TXT / JSON 等内容中提取 IP / IP 范围为数组
```php
/** $content is mixed content of IPv4 IPv6 IPRange */
IPParser::MatchAllIPv4($content); // array('127.0.0.1')
IPParser::MatchAllIPv4CIDR($content); // array('127.0.0.1/21')
IPParser::MatchAllIPv4Interval($content); // array('127.0.0.1-127.0.0.30')
IPParser::MatchAllIPv4Wildcard($content); // array('127.0.0.*')
IPParser::MatchAllIPv6($content); // array('2001:4860:4801::af88')
IPParser::MatchAllIPv6CIDR($content); // array('2001:4860:4801::af88/7')
IPParser::MatchAllIPv6Interval($content); // array('2001:4860:4801::af88-2001:4860:4801::afff')
IPParser::MatchAllIPv6Wildcard($content); // array('2001:4860:*::af88')
IPParser::MatchAllIP($content); // array('127.0.0.1', 2001:4860:4801::af88')
IPParser::MatchAllIPCIDR($content); // array('127.0.0.1/21', '2001:4860:4801::af88/7')
IPParser::MatchAllIPInterval($content); // array('127.0.0.1-127.0.0.30', '2001:4860:4801::af88-2001:4860:4801::afff')
IPParser::MatchAllIPWildcard($content); // array('127.0.0.*', '2001:4860:*::af88')
IPParser::MatchAll($content); // array('127.0.0.1', 2001:4860:4801::af88', '127.0.0.1/21', '2001:4860:4801::af88/7', '127.0.0.1-127.0.0.30', '2001:4860:4801::af88-2001:4860:4801::afff', '127.0.0.*', '2001:4860:*::af88')
```
### Converter 转换
```php
use YZhanIP\Tool\IPConverter;
```
#### Convert IP to binary string
#### IP 转换为二进制字符串
```php
IPConverter::IP2Bit('127.0.0.1'); // 01111111000000000000000000000001
IPConverter::IP2Bit('2001:4860:4801::af88'); // 00100000000000010100100001100000010010000000000100000000000000000000000000000000000000000000000000000000000000001010111110001000
```
#### Convert binary string to IP
#### 二进制字符串转换为 IP
```php
IPConverter::Bit2IP('01111111000000000000000000000001'); // 127.0.0.1
IPConverter::Bit2IP('00100000000000010100100001100000010010000000000100000000000000000000000000000000000000000000000000000000000000001010111110001000'); // 2001:4860:4801::af88
```
#### Convert CIDR to IP range  
#### CIDR 转 IP 范围
```php
$ipv4Range = IPConverter::IPCIDR2IPRange('127.0.0.1/24');
$ipv4Range->getFirst(); // 127.0.0.0
$ipv4Range->getLast(); // 127.0.7.255
$ipv6Range = IPConverter::IPCIDR2IPRange('2001:4860:4801::af88/7');
$ipv6Range->getFirst(); // 2000::
$ipv6Range->getLast(); // 21ff:ffff:ffff:ffff:ffff:ffff:ffff:ffff
```