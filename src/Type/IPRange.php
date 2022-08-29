<?php
namespace YZhanIP\Type;
class IPRange {
  private $first = null;
  private $last = null;
  public function __construct($first, $last) {
    $this->first = $first;
    $this->last = $last;
  }
  public function getFirst(): string {
    return $this->first;
  }
  public function getLast(): string {
    return $this->last;
  }
}
?>