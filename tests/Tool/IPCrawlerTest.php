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
    return $ipCrawler;
  }
  /**
   * @depends testConstruct
   */
  public function testGet($ipCrawler) {
    $ipCrawler->clearCache();
    $ips = $ipCrawler->get();
    $this->assertTrue(count($ips) > 180);
  }

  public function testUpdateBeforeGetCloudflareIPv4() {
    $ipCrawler = new IPCrawler(URLData::CLOUDFALRENODEIPV4, array('timeOut' => 9));
    $ipCrawler->update();
    $ips = $ipCrawler->get();
    $this->assertTrue(count($ips) > 6);
  }

  public function testUpdateBeforeGetCloudflareIPv6() {
    $ipCrawler = new IPCrawler(URLData::CLOUDFALRENODEIPV6, array('timeOut' => 9));
    $ipCrawler->update();
    $ips = $ipCrawler->get();
    $this->assertTrue(count($ips) > 6);
  }
}
?>