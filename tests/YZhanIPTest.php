<?php
use PHPUnit\Framework\TestCase;
use YZhanIP\Data\IPData;
use YZhanIP\YZhanIP;

class YZhanIPTest extends TestCase {
  public function constructProvider() {
    $ipv4 = new YZhanIP(IPData::IPV4);
    $ipv4INTERVAL = new YZhanIP(IPData::IPV4INTERVAL);
    $ipv4WILDCARD = new YZhanIP(IPData::IPV4WILDCARD);
    $ipv4CIDR = new YZhanIP(IPData::IPV4CIDR);
    $ipv6 = new YZhanIP(IPData::IPV6);
    $ipv6INTERVAL = new YZhanIP(IPData::IPV6INTERVAL);
    $ipv6WILDCARD = new YZhanIP(IPData::IPV6WILDCARD);
    $ipv6CIDR = new YZhanIP(IPData::IPV6CIDR);
    $ipv4MIXED = new YZhanIP(array(IPData::IPV4, IPData::IPV4INTERVAL, IPData::IPV4WILDCARD));
    $ipv6MIXED = new YZhanIP(array(IPData::IPV6, IPData::IPV6INTERVAL, IPData::IPV6WILDCARD));
    return array(
      array($ipv4, $ipv4INTERVAL, IPData::IPV4, IPData::IPV4),
      array($ipv4INTERVAL, $ipv4WILDCARD, IPData::IPV4INTERVAL, IPData::IPV4INTERVAL),
      array($ipv4WILDCARD, $ipv4CIDR, IPData::IPV4WILDCARDINTERVAL, IPData::IPV4WILDCARD),
      array($ipv6, $ipv6INTERVAL, IPData::IPV6, IPData::IPV6),
      array($ipv6INTERVAL, $ipv6WILDCARD, IPData::IPV6INTERVAL, IPData::IPV6INTERVAL),
      array($ipv6WILDCARD, $ipv6CIDR, IPData::IPV6WILDCARDINTERVAL, IPData::IPV6WILDCARD),
      array($ipv4MIXED, $ipv4CIDR, 
            implode(',', array(IPData::IPV4, IPData::IPV4INTERVAL, IPData::IPV4WILDCARDINTERVAL)),
            implode(',', array(IPData::IPV4, IPData::IPV4INTERVAL, IPData::IPV4WILDCARD)),
      ),
      array($ipv6MIXED, $ipv6CIDR, 
            implode(',', array(IPData::IPV6, IPData::IPV6INTERVAL, IPData::IPV6WILDCARDINTERVAL)),
            implode(',', array(IPData::IPV6, IPData::IPV6INTERVAL, IPData::IPV6WILDCARD)),
      ),
      array($ipv4, IPData::IPV4INTERVAL, IPData::IPV4, IPData::IPV4),
      array($ipv4INTERVAL, IPData::IPV4WILDCARD, IPData::IPV4INTERVAL, IPData::IPV4INTERVAL),
      array($ipv4WILDCARD, IPData::IPV4CIDR, IPData::IPV4WILDCARDINTERVAL, IPData::IPV4WILDCARD),
      array($ipv6, IPData::IPV6INTERVAL, IPData::IPV6, IPData::IPV6),
      array($ipv6INTERVAL, IPData::IPV6WILDCARD, IPData::IPV6INTERVAL, IPData::IPV6INTERVAL),
      array($ipv6WILDCARD, IPData::IPV6CIDR, IPData::IPV6WILDCARDINTERVAL, IPData::IPV6WILDCARD),
    );
  }
  /** @dataProvider constructProvider */
  public function testGetIPs(YZhanIP $ip) {
    $this->assertEquals(count($ip->getIPs()), count(explode(',', $ip->toString())));
  }
  /** @dataProvider constructProvider */
  public function testIn(YZhanIP $ip, $cip) {
    $this->assertTrue($ip->in($cip));
  }
  /** @dataProvider constructProvider */
  public function testFilter(YZhanIP $ip, $cip) {
    $this->assertEquals($ip->filter($cip)->toString(), $ip->toString());
    $this->assertEquals($ip->filter($cip)->toRaw(), $ip->toRaw());
  }
  /** @dataProvider constructProvider */
  public function testToString(YZhanIP $ip, $_, string $str) {
    $this->assertEquals($ip->toString(), $str);
  }
  /** @dataProvider constructProvider */
  public function testToRaw(YZhanIP $ip, $_, $__, string $raw) {
    $this->assertEquals($ip->toRaw(), $raw);
  }
}
?>