<?php

namespace Wikidata\Tests;

use Wikidata\Property;

class PropertyTest extends TestCase
{
  protected $property;

  public function setUp(): void
  {
    $this->property = new Property($this->dummyProperties);
  }

  public function testGetPropertyId(): void
  {
    $id = str_replace('http://www.wikidata.org/prop/', '', $this->dummyProperties[0]['prop']);

    $this->assertEquals($id, $this->property->id);
  }

  public function testGetPropertyLabel(): void
  {
    $this->assertEquals($this->dummyProperties[0]['propertyLabel'], $this->property->label);
  }

  public function testGetPropertyValues(): void
  {
    $values = $this->property->values;

    $this->assertInstanceOf(\Illuminate\Support\Collection::class, $values);

    $this->assertInstanceOf(\Wikidata\Value::class, $values->first());
  }
}
