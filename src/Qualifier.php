<?php

namespace Wikidata;

class Qualifier
{
  /**
   * @var string Qualifier Id
   */
  public $id;

  /**
   * @var string Qualifier label
   */
  public $label;

  /**
   * @var string Qualifier value
   */
  public $value;

  /**
   * @param array $data
   */
  public function __construct(array $data)
  {
    $this->parseData($data);
  }

  /**
   * Parse input data
   * 
   * @param array $data
   */
  private function parseData(array $data): void
  {
    $this->id = get_id($data['qualifier']);
    $this->label = $data['qualifierLabel'];
    $this->value = $data['qualifierValueLabel'];
  }
}
