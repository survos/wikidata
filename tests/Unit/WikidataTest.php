<?php

namespace Wikidata\Tests;

use Exception;
use Wikidata\Wikidata;

class WikidataTest extends TestCase
{
  protected Wikidata $wikidata;

  public function setUp(): void
  {
    $this->wikidata = new Wikidata();
  }

  public function testSearchByTerm(): void
  {
    $results = $this->wikidata->search('London');

    $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

    $result = $results->first();

    $this->assertInstanceOf(\Wikidata\SearchResult::class, $result);

    $this->assertEquals(true, property_exists($result, 'id'));
    $this->assertEquals(true, property_exists($result, 'lang'));
    $this->assertEquals(true, property_exists($result, 'label'));
    $this->assertEquals(true, property_exists($result, 'aliases'));
    $this->assertEquals(true, property_exists($result, 'description'));
    $this->assertEquals(true, property_exists($result, 'wiki_url'));
  }

  public function testSearchOnAnotherLanguage(): void
  {
    $results = $this->wikidata->search('London', 'fr');

    $this->assertEquals('fr', $results->first()->lang);
  }

  public function testSearchWithLimit(): void
  {
    $results = $this->wikidata->search('car', 'en', 10);

    $this->assertEquals(10, $results->count());
  }

  public function testSearchResultsCouldBeEmpty(): void
  {
    $results = $this->wikidata->search('asdfgh');


    $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

    $this->assertEquals(true, $results->isEmpty());
  }

  public function testSearchByPropertyIdAndValue(): void
  {
    $results = $this->wikidata->searchBy('P646', '/m/02mjmr');

    $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

    $result = $results->first();

    $this->assertInstanceOf(\Wikidata\SearchResult::class, $result);

    $this->assertEquals(true, property_exists($result, 'id'));
    $this->assertEquals(true, property_exists($result, 'lang'));
    $this->assertEquals(true, property_exists($result, 'label'));
    $this->assertEquals(true, property_exists($result, 'aliases'));
    $this->assertEquals(true, property_exists($result, 'description'));
    $this->assertEquals(true, property_exists($result, 'wiki_url'));
  }

  public function testSearchByThrowExceptionIfSecondPropertyMissing(): void
  {
    $this->expectException(Exception::class);

    $this->wikidata->searchBy('P646');
  }

  public function testSearchByThrowExceptionIfPropertyIdInvalid(): void
  {
    $this->expectException(Exception::class);

    $this->wikidata->searchBy('Pasd', '/m/02mjmr');
  }

  public function testSearchByPropertyIdAndEntityId(): void
  {
    $results = $this->wikidata->searchBy('P39', 'Q11696');

    $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

    $result = $results->first();

    $this->assertInstanceOf(\Wikidata\SearchResult::class, $result);
  }

  public function testGetEntityById(): void
  {
    $entity = $this->wikidata->get('Q44077');

    $this->assertInstanceOf(\Wikidata\Entity::class, $entity);

    $this->assertEquals(true, property_exists($entity, 'id'));
    $this->assertEquals(true, property_exists($entity, 'lang'));
    $this->assertEquals(true, property_exists($entity, 'label'));
    $this->assertEquals(true, property_exists($entity, 'aliases'));
    $this->assertEquals(true, property_exists($entity, 'description'));
    $this->assertEquals(true, property_exists($entity, 'wiki_url'));
  }

  public function testGetEntityOnAnotherLanguage(): void
  {
    $entity = $this->wikidata->get('Q44077', 'es');

    $this->assertEquals('es', $entity->lang);
  }

  public function testGetEntityThrowExceptionIfEntityIdInvalid(): void
  {
    $this->expectException(Exception::class);

    $this->wikidata->get('P1234');
  }
}
