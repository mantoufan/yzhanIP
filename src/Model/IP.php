<?php
namespace YZhanIP\Model;
use YZhanIP\TYPE\Primitive;
class IP {
  private $start = 0;
  private $end = 0;
  private $raw = null;
  private $type = null;
  public function __construct(string $start, string $end = null, string $type = null, string $raw = null) {
    $this->start = $start;
    if ($end === null) $this->end = &$this->start;
    else $this->end = $end;
    $this->type = $type;
    $this->raw = $raw;
  }
  public function __toString(): string {
    if ($this->isIPv4() || $this->isIPv6()) return inet_ntop($this->start);
    return inet_ntop($this->start) . '-' . inet_ntop($this->end);
  }
  public function toString(): string {
    return $this->__toString();
  }
  public function toRaw(): string {
    return $this->raw ? $this->raw : $this->__toString();
  }
  public function in(IP $ip): bool {
    return $this->start >= $ip->getStart() && $this->end <= $ip->getEnd();
  }
  public function getStart(): string {
    return $this->start;
  }
  public function getEnd(): string {
    return $this->end;
  }
  public function getType(): string {
    return $this->type;
  }
  public function isIPv4(): bool {
    return $this->type === Primitive::IPV4;
  }
  public function isIPv4CIDR(): bool {
    return $this->type === Primitive::IPV4CIDR;
  }
  public function isIPv4Interval(): bool {
    return $this->type === Primitive::IPV4INTERVAL;
  }
  public function isIPv4Wildcard(): bool {
    return $this->type === Primitive::IPV4WILDCARD;
  }
  public function isIPv6(): bool {
    return $this->type === Primitive::IPV6;
  }
  public function isIPv6CIDR(): bool {
    return $this->type === Primitive::IPV6CIDR;
  }
  public function isIPv6Interval(): bool {
    return $this->type === Primitive::IPV6INTERVAL;
  }
  public function isIPv6Wildcard(): bool {
    return $this->type === Primitive::IPV6WILDCARD;
  }
  public function isIP(): bool {
    return $this->isIPv4() || $this->isIPv6();
  }
  public function isIPCIDR(): bool {
    return $this->isIPv4CIDR() || $this->isIPv6CIDR();
  }
  public function isIPInterval(): bool {
    return $this->isIPv4Interval() || $this->isIPv6Interval();
  }
  public function isIPWildcard(): bool {
    return $this->isIPv4Wildcard() || $this->isIPv6Wildcard();
  }
  public function isIPRange(): bool {
    return $this->isIPCIDR() || $this->isIPInterval() || $this->isIPWildcard();
  }
}
?>