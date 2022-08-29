<?php
namespace YZhanIP\Tool;
use YZhanIP\Tool\IPCrawler;
use YZhanIP\Data\URLData;
use YZhanIP\Exception\IPTracerException;
use YZhanIP\YZhanIP;
class IPTracer {
  static public function IsInUrl($ip, array $urls, array $opt = null) {
    $ips = array();
    foreach ($urls as $url) {
      $ipCrawler = new IPCrawler($url, array_merge(array(
        'timeOut' => 9
      ), (array)$opt));
      $ipList = $ipCrawler->get();
      if ($ipList === null) throw new IPTracerException('Failed to fetch IP');
      $ips = array_merge($ips, $ipList);
    }
    return (new YZhanIP($ip))->in(new YZhanIP($ips));
  }
  static public function IsCloudflareNode(string $ip, array $opt = null) {
    return self::IsInUrl($ip, array(URLData::CLOUDFALRENODEIPV4, URLData::CLOUDFALRENODEIPV6), $opt);
  }
  static public function IsGoogleBot(string $ip, array $opt = null) {
    return self::IsInUrl($ip, array(URLData::GOOGLEBOT), $opt); 
  }
}
?>