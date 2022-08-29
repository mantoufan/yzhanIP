<?php
use YZhanIP\Type\IPRange;
use PHPUnit\Framework\TestCase;
use YZhanIP\Data\IPData;
class IPRangeTest extends TestCase {
  public function testConstruct() {
    list($first, $last) = explode('-', IPData::IPV4INTERVAL);
    $ipRange = new IPRange($first, $last);
    $this->assertEquals($ipRange->getFirst(), $first);
    $this->assertEquals($ipRange->getLast(), $last);
    list($first, $last) = explode('-', IPData::IPV6INTERVAL);
    $ipRange = new IPRange($first, $last);
    $this->assertEquals($ipRange->getFirst(), $first);
    $this->assertEquals($ipRange->getLast(), $last);
  }
}
?>