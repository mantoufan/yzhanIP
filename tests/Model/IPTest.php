<?php
use YZhanIP\Data\IPData;
use YZhanIP\Model\IP;
use YZhanIP\Type\Primitive;
use PHPUnit\Framework\TestCase;
class IPTest extends TestCase {
  public function testIP() {
    $start = inet_pton(IPData::IPV4);
    $ip = new IP($start, null, Primitive::IPV4, IPData::IPV4);
    $this->assertEquals($ip->getStart(), $ip->getEnd());
    $this->assertEquals($ip->getType(), Primitive::IPV4);
    $this->assertEquals($ip->toRaw(), IPData::IPV4);
    $this->assertEquals($ip->toString(), IPData::IPV4);
    $this->assertTrue($ip->isIPv4());
    $this->assertFalse($ip->isIPv4CIDR());
    $this->assertFalse($ip->isIPv4Interval());
    $this->assertFalse($ip->isIPv4Wildcard());
    $this->assertFalse($ip->isIPv6());
    $this->assertFalse($ip->isIPv6CIDR());
    $this->assertFalse($ip->isIPv6Interval());
    $this->assertFalse($ip->isIPv6Wildcard());
    $this->assertTrue($ip->isIP());
    $this->assertFalse($ip->isIPCIDR());
    $this->assertFalse($ip->isIPInterval());
    $this->assertFalse($ip->isIPWildcard());
  }
  public function testIPRange() {
    list($startRaw, $endRaw) = explode('-', IPData::IPV6INTERVAL);
    $start = inet_pton($startRaw);
    $end = inet_pton($endRaw);
    $ip = new IP($start, $end, Primitive::IPV6INTERVAL, IPData::IPV6INTERVAL);
    $this->assertEquals($ip->getStart(), $start);
    $this->assertEquals($ip->getEnd(), $end);
    $this->assertEquals($ip->getType(), Primitive::IPV6INTERVAL);
    $this->assertEquals($ip->toRaw(), IPData::IPV6INTERVAL);
    $this->assertEquals($ip->toString(), IPData::IPV6INTERVAL);
    $this->assertFalse($ip->isIPv4());
    $this->assertFalse($ip->isIPv4CIDR());
    $this->assertFalse($ip->isIPv4Interval());
    $this->assertFalse($ip->isIPv4Wildcard());
    $this->assertFalse($ip->isIPv6());
    $this->assertFalse($ip->isIPv6CIDR());
    $this->assertTrue($ip->isIPv6Interval());
    $this->assertFalse($ip->isIPv6Wildcard());
    $this->assertFalse($ip->isIP());
    $this->assertFalse($ip->isIPCIDR());
    $this->assertTrue($ip->isIPInterval());
    $this->assertFalse($ip->isIPWildcard());
  }
  public function ipProvider() {
    $ipv4 = new IP(inet_pton(IPData::IPV4), null, Primitive::IPV4, IPData::IPV4);
    $this->assertTrue($ipv4->in($ipv4));
    list($first, $last) = explode('-', IPData::IPV4INTERVAL);
    $ipv4Interval = new IP(inet_pton($first), inet_pton($last), Primitive::IPV4INTERVAL, IPData::IPV4INTERVAL);
    $ipv6Full = new IP(inet_pton(IPData::IPV6FULL), null, Primitive::IPV6, IPData::IPV6FULL);
    list($first, $last) = explode('-', IPData::IPV6INTERVAL);
    $ipv6Interval = new IP(inet_pton($first), inet_pton($last), Primitive::IPV6INTERVAL, IPData::IPV6INTERVAL);
    return array(
      array($ipv4, $ipv4Interval, IPData::IPV4, IPData::IPV4INTERVAL, IPData::IPV4, IPData::IPV4INTERVAL),
      array($ipv6Full, $ipv6Interval, IPData::IPV6, IPData::IPV6INTERVAL, IPData::IPV6FULL, IPData::IPV6INTERVAL),
    );
  }
  /** @dataProvider ipProvider */
  public function testIn(IP $ip, IP $cip) {
    $this->assertTrue($ip->in($cip));
    $this->assertFalse($cip->in($ip));
  }
  /** @dataProvider ipProvider */
  public function testToString(IP $ip, IP $cip, string $ipStr, string $cipStr) {
    $this->assertEquals($ip->toString(), $ipStr);
    $this->assertEquals($cip->toString(), $cipStr);
  }
  /** @dataProvider ipProvider */
  public function testToRaw(IP $ip, IP $cip, $_, $__, string $ipRaw, string $cipRaw) {
    $this->assertEquals($ip->toRaw(), $ipRaw);
    $this->assertEquals($cip->toRaw(), $cipRaw);
  }
}
?>