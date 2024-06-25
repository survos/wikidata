<?php

namespace Wikidata;

class SearchResult
{
  /**
   * @var string
   */
  public $id;

  /**
   * @var string
   */
  public $label;

  /**
   * @var string
   */
  public $wiki_url;

  /**
   * @var string
   */
  public $description;

  /**
   * @var array of strings
   */
  public $aliases;

  /**
   * @param array $data
   * @param string $lang
   */
  public function __construct($data, public $lang = 'en')
  {
    $this->parseData($data);
  }

  private function parseData($data): void
  {
    $this->id = $data['id'] ?? null;
    $this->label = $data['label'] ?? null;
    $this->aliases = $data['aliases'] ?? [];
    $this->description = $data['description'] ?? null;
    $this->wiki_url = $data['wiki_url'] ?? null;
  }
}
