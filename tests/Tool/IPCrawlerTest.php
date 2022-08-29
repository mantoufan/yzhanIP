<?php
use YZhanIP\Tool\IPCrawler;
use PHPUnit\Framework\TestCase;
use YZhanIP\Data\URLData;
class IPCrawlerTest extends TestCase {
  public function testConstruct() {
    $timeOut = 9;
    $ipCrawler = new IPCrawler(URLData::GOOGLEBOT, array(
      'timeOut' => $timeOut
    ));
    $options = $ipCrawler->getOptions();
    $this->assertEquals($ipCrawler->getUrl(), URLData::GOOGLEBOT);
    $this->assertEquals($options['timeOut'], $timeOut);
    $this->assertEquals($ipCrawler->getPath(), $options['cacheDir'] . '/' . $options['cacheKey'] . '.php');
    return $ipCrawler;
  }
  /**
   * @depends testConstruct
   */
  public function testGet($ipCrawler) {
    $path = $ipCrawler->getPath();
    if (is_file($path)) unlink($path);
    $ips = $ipCrawler->get();
    $this->assertTrue(is_file($path));
    $this->assertTrue(count($ips) > 180);
  }

  public function testUpdateBeforeGetCloudflareIPv4() {
    $timeOut = 9;
    $ipCrawler = new IPCrawler(URLData::CLOUDFALRENODEIPV4, array(
      'timeOut' => $timeOut
    ));
    $ipCrawler->update();
    $path = $ipCrawler->getPath();
    $this->assertTrue(is_file($path));
    $this->assertTrue(time() - filemtime($path) < $timeOut);
    $ips = $ipCrawler->get();
    $this->assertTrue(count($ips) > 6);
  }

  public function testUpdateBeforeGetCloudflareIPv6() {
    $timeOut = 9;
    $ipCrawler = new IPCrawler(URLData::CLOUDFALRENODEIPV6, array(
      'timeOut' => $timeOut
    ));
    $ipCrawler->update();
    $path = $ipCrawler->getPath();
    $this->assertTrue(is_file($path));
    $this->assertTrue(time() - filemtime($path) < $timeOut);
    $ips = $ipCrawler->get();
    $this->assertTrue(count($ips) > 6);
  }
}
?>