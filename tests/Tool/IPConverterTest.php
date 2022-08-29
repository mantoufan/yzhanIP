<?php
use YZhanIP\Tool\IPConverter;
use YZhanIP\Data\IPData;
use PHPUnit\Framework\TestCase;
class IPConverterTest extends TestCase {
  public function testIP2Bit() {
    $this->assertFalse(IPConverter::IP2Bit('127.0.0'));
    $this->assertEquals(IPConverter::IP2Bit(IPData::IPV4), '01111111000000000000000000000001');
    $this->assertFalse(IPConverter::IP2Bit('2001:4860:4801:88'));
    $this->assertEquals(IPConverter::IP2Bit(IPData::IPV6), '00100000000000010100100001100000010010000000000100000000000000000000000000000000000000000000000000000000000000001010111110001000');
  }
  public function testBit2IP() {
    $this->assertFalse(IPConverter::Bit2IP('1'));
    $this->assertEquals(IPConverter::Bit2IP('01111111000000000000000000000001'), IPData::IPV4);
    $this->assertEquals(IPConverter::Bit2IP('00100000000000010100100001100000010010000000000100000000000000000000000000000000000000000000000000000000000000001010111110001000'), IPData::IPV6);
  }
  public function testIPCIDR2IPRange() {
    $ipRange = IPConverter::IPCIDR2IPRange(IPData::IPV4CIDR);
    $IPv4CIDRInterval = explode('-', IPData::IPV4CIDRINTERVAL);
    $this->assertEquals($ipRange->getFirst(), $IPv4CIDRInterval[0]);
    $this->assertEquals($ipRange->getLast(), $IPv4CIDRInterval[1]);
    $ipRange = IPConverter::IPCIDR2IPRange(IPData::IPV6CIDR);
    $IPv6CIDRInterval = explode('-', IPData::IPV6CIDRINTERVAL);
    $this->assertEquals($ipRange->getFirst(), $IPv6CIDRInterval[0]);
    $this->assertEquals($ipRange->getLast(), $IPv6CIDRInterval[1]);
  }
}
?>