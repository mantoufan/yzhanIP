<?php
use YZhanIP\Type\Primitive;
use YZhanIP\Tool\IPParser;
use PHPUnit\Framework\TestCase;
use YZhanIP\Exception\IPParserException;
use YZhanIP\Data\IPData;
class IPParserTest extends TestCase {
  const COPYNUM = 3;
  public function testIsIPv4() {
    $this->assertTrue(IPParser::IsIPv4(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV4));
  }
  public function testIsIPv4CIDR() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV4CIDR));
    $this->assertTrue(IPParser::IsIPv4CIDR(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV4CIDR));
  }
  public function testIsIPv4Interval() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV4INTERVAL));
    $this->assertTrue(IPParser::IsIPv4Interval(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV4INTERVAL));
  }
  public function testIsIPv4Wildcard() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV4WILDCARD));
    $this->assertTrue(IPParser::IsIPv4Wildcard(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV4WILDCARD));
  }
  public function testIsIPv6() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV6));
    $this->assertTrue(IPParser::IsIPv6(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV6));
  }
  public function testIsIPv6CIDR() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV6CIDR));
    $this->assertTrue(IPParser::IsIPv6CIDR(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV6CIDR));
  }
  public function testIsIPv6Interval() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV6INTERVAL));
    $this->assertTrue(IPParser::IsIPv6Interval(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPv6Wildcard(IPData::IPV6INTERVAL));
  }
  public function testIsIPv6Wildcard() {
    $this->assertFalse(IPParser::IsIPv4(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPv4CIDR(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPv4Interval(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPv4Wildcard(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPv6(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPv6CIDR(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPv6Interval(IPData::IPV6WILDCARD));
    $this->assertTrue(IPParser::IsIPv6Wildcard(IPData::IPV6WILDCARD));
  }
  public function testIsIP() {
    $this->assertTrue(IPParser::IsIP(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPCIDR(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPInterval(IPData::IPV4));
    $this->assertFalse(IPParser::IsIPWildcard(IPData::IPV4));
    $this->assertTrue(IPParser::IsIP(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPCIDR(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPInterval(IPData::IPV6));
    $this->assertFalse(IPParser::IsIPWildcard(IPData::IPV6));
  }
  public function testIsIPCIDR() {
    $this->assertFalse(IPParser::IsIP(IPData::IPV4CIDR));
    $this->assertTrue(IPParser::IsIPCIDR(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPInterval(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIPWildcard(IPData::IPV4CIDR));
    $this->assertFalse(IPParser::IsIP(IPData::IPV6CIDR));
    $this->assertTrue(IPParser::IsIPCIDR(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPInterval(IPData::IPV6CIDR));
    $this->assertFalse(IPParser::IsIPWildcard(IPData::IPV6CIDR));
  }
  public function testIsIPInterval() {
    $this->assertFalse(IPParser::IsIP(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPCIDR(IPData::IPV4INTERVAL));
    $this->assertTrue(IPParser::IsIPInterval(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIPWildcard(IPData::IPV4INTERVAL));
    $this->assertFalse(IPParser::IsIP(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPCIDR(IPData::IPV6INTERVAL));
    $this->assertTrue(IPParser::IsIPInterval(IPData::IPV6INTERVAL));
    $this->assertFalse(IPParser::IsIPWildcard(IPData::IPV6INTERVAL));
  }
  public function testIsIPWildcard() {
    $this->assertFalse(IPParser::IsIP(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPCIDR(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIPInterval(IPData::IPV4WILDCARD));
    $this->assertTrue(IPParser::IsIPWildcard(IPData::IPV4WILDCARD));
    $this->assertFalse(IPParser::IsIP(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPCIDR(IPData::IPV6WILDCARD));
    $this->assertFalse(IPParser::IsIPInterval(IPData::IPV6WILDCARD));
    $this->assertTrue(IPParser::IsIPWildcard(IPData::IPV6WILDCARD));
  }
  public function testGetType() {
    $this->assertEquals(IPParser::GetType(IPData::IPV4), Primitive::IPV4);
    $this->assertEquals(IPParser::GetType(IPData::IPV4CIDR), Primitive::IPV4CIDR);
    $this->assertEquals(IPParser::GetType(IPData::IPV4INTERVAL), Primitive::IPV4INTERVAL);
    $this->assertEquals(IPParser::GetType(IPData::IPV4WILDCARD), Primitive::IPV4WILDCARD);
    $this->assertEquals(IPParser::GetType(IPData::IPV6), Primitive::IPV6);
    $this->assertEquals(IPParser::GetType(IPData::IPV6CIDR), Primitive::IPV6CIDR);
    $this->assertEquals(IPParser::GetType(IPData::IPV6INTERVAL), Primitive::IPV6INTERVAL);
    $this->assertEquals(IPParser::GetType(IPData::IPV6WILDCARD), Primitive::IPV6WILDCARD);
    $this->expectException(IPParserException::class);
    IPParser::GetType(IPData::IPINVAILD);
  }
  public function testParse() {
    $this->assertEquals(IPParser::Parse(IPData::IPV4)->toRaw(), IPData::IPV4);
    $this->assertEquals(IPParser::Parse(IPData::IPV4CIDR)->toRaw(), IPData::IPV4CIDR);
    $this->assertEquals(IPParser::Parse(IPData::IPV4INTERVAL)->toRaw(), IPData::IPV4INTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV4WILDCARD)->toRaw(), IPData::IPV4WILDCARD);
    $this->assertEquals(IPParser::Parse(IPData::IPV6)->toRaw(), IPData::IPV6);
    $this->assertEquals(IPParser::Parse(IPData::IPV6CIDR)->toRaw(), IPData::IPV6CIDR);
    $this->assertEquals(IPParser::Parse(IPData::IPV6INTERVAL)->toRaw(), IPData::IPV6INTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV6WILDCARD)->toRaw(), IPData::IPV6WILDCARD);
    $this->assertEquals(IPParser::Parse(IPData::IPV4)->toString(), IPData::IPV4);
    $this->assertEquals(IPParser::Parse(IPData::IPV4CIDR)->toString(), IPData::IPV4CIDRINTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV4INTERVAL)->toString(), IPData::IPV4INTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV4WILDCARD)->toString(), IPData::IPV4WILDCARDINTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV6)->toString(), IPData::IPV6);
    $this->assertEquals(IPParser::Parse(IPData::IPV6CIDR)->toString(), IPData::IPV6CIDRINTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV6INTERVAL)->toString(), IPData::IPV6INTERVAL);
    $this->assertEquals(IPParser::Parse(IPData::IPV6WILDCARD)->toString(), IPData::IPV6WILDCARDINTERVAL);
    $this->expectException(IPParserException::class);
    IPParser::Parse(IPData::IPINVAILD);
  }
  public function contentProvider(): array {
    $ips = array(
      IPDATA::IPV4, IPDATA::IPV4CIDR, IPDATA::IPV4INTERVAL, IPDATA::IPV4WILDCARD,
      IPDATA::IPV6, IPDATA::IPV6CIDR, IPDATA::IPV6INTERVAL, IPDATA::IPV6WILDCARD
    );
    $ipsCopy = array();
    $i = 0;
    while ($i++ < self::COPYNUM) array_push($ipsCopy, ...$ips);
    shuffle($ipsCopy);
    return array(array(json_encode($ipsCopy, JSON_UNESCAPED_SLASHES)));
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv4(string $content) {
    $ips = IPParser::MatchAllIPv4($content);
    $this->assertContains(IPData::IPV4, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv4CIDR(string $content) {
    $ips = IPParser::MatchAllIPv4CIDR($content);
    $this->assertContains(IPData::IPV4CIDR, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv4Interval(string $content) {
    $ips = IPParser::MatchAllIPv4Interval($content);
    $this->assertContains(IPData::IPV4INTERVAL, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv4Wildcard(string $content) {
    $ips = IPParser::MatchAllIPv4Wildcard($content);
    $this->assertContains(IPData::IPV4WILDCARD, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv6(string $content) {
    $ips = IPParser::MatchAllIPv6($content);
    $this->assertContains(IPData::IPV6, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv6CIDR(string $content) {
    $ips = IPParser::MatchAllIPv6CIDR($content);
    $this->assertContains(IPData::IPV6CIDR, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv6Interval(string $content) {
    $ips = IPParser::MatchAllIPv6Interval($content);
    $this->assertContains(IPData::IPV6INTERVAL, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPv6Wildcard(string $content) {
    $ips = IPParser::MatchAllIPv6Wildcard($content);
    $this->assertContains(IPData::IPV6WILDCARD, $ips);
    $this->assertCount(self::COPYNUM, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIP(string $content) {
    $ips = IPParser::MatchAllIP($content);
    $this->assertContains(IPData::IPV4, $ips);
    $this->assertContains(IPData::IPV6, $ips);
    $this->assertCount(self::COPYNUM << 1, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPCIDR(string $content) {
    $ips = IPParser::MatchAllIPCIDR($content);
    $this->assertContains(IPData::IPV4CIDR, $ips);
    $this->assertContains(IPData::IPV6CIDR, $ips);
    $this->assertCount(self::COPYNUM << 1, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPInterval(string $content) {
    $ips = IPParser::MatchAllIPInterval($content);
    $this->assertContains(IPData::IPV4INTERVAL, $ips);
    $this->assertContains(IPData::IPV6INTERVAL, $ips);
    $this->assertCount(self::COPYNUM << 1, $ips);
  }
  /** @dataProvider contentProvider */
  public function testMatchAllIPWildcard(string $content) {
    $ips = IPParser::MatchAllIPWildcard($content);
    $this->assertContains(IPData::IPV4WILDCARD, $ips);
    $this->assertContains(IPData::IPV6WILDCARD, $ips);
    $this->assertCount(self::COPYNUM << 1, $ips);
  }
}
?>