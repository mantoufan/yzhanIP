<?php
use YZhanIP\Tool\IPTracer;
use PHPUnit\Framework\TestCase;
use YZhanIP\Data\IPData;
use YZhanIP\Data\URLData;
class IPTracerTest extends TestCase {
  public function testIsCloudflareNode() {
    $this->assertTrue(IPTracer::IsCloudflareNode(IPData::IPV4CLOUDFALRE));
    $this->assertTrue(IPTracer::IsCloudflareNode(IPData::IPV4CLOUDFALRECIDR));
    $this->assertTrue(IPTracer::IsCloudflareNode(IPData::IPV6CLOUDFALRE));
    $this->assertTrue(IPTracer::IsCloudflareNode(IPData::IPV6CLOUDFALRECIDR));
  }
  public function testIsGoogleBot() {
    $this->assertTrue(IPTracer::IsGoogleBot(IPData::IPV4GOOGLEBOT));
    $this->assertTrue(IPTracer::IsGoogleBot(IPData::IPV4GOOGLEBOTCIDR));
    $this->assertTrue(IPTracer::IsGoogleBot(IPData::IPV6GOOGLEBOT));
    $this->assertTrue(IPTracer::IsGoogleBot(IPData::IPV6GOOGLEBOTCIDR));
  }

  public function testInUrl() {
    $this->assertTrue(IPTracer::IsInUrl(array(
      IPData::IPV4CLOUDFALRE,
      IPData::IPV6CLOUDFALRE,
      IPData::IPV4CLOUDFALRECIDR,
      IPData::IPV6CLOUDFALRECIDR
    ), array(
      URLData::CLOUDFALRENODEIPV4,
      URLdata::CLOUDFALRENODEIPV6
    )));
  }
}
?>