<?php

namespace Wikidata;

use Illuminate\Support\Collection;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public const API_ENDPOINT = 'https://www.wikidata.org/w/api.php';


    public function __construct(private ?HttpClientInterface $client=null)
    {
        if (!$this->client) {
            $this->client = HttpClient::create();
        }
    }

    /**
     * Get all entities by their ids from wikidata api
     *
     * @param array|string $ids The IDs of the entities to get the data from (eg.: Q2, Q2|Q3)
     * @param string $lang Language (default: en)
     * @param array|string $props Array of the properties to get back from each entity (supported: aliases, claims, datatype, descriptions, info, labels, sitelinks, sitelinks/urls)
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEntities(array|string $ids, string $lang = 'en', array|string $props = []): Collection
    {
        $ids = is_array($ids) ? implode('|', $ids) : $ids;

        $props = $props ? implode('|', $props) : null;

        $response = $this->client->request('GET', self::API_ENDPOINT, [
            'query' => [
                'action' => 'wbgetentities',
                'format' => 'json',
                'languages' => $lang,
                'ids' => $ids,
                'sitefilter' => $lang . 'wiki',
                'props' => $props,
            ],
        ]);

        $results = json_decode($response->getContent(), true);

        $data = $results['entities'] ?? [];

        return collect($data);
    }

    /**
     * Searches for entities using labels and aliases
     *
     * @param string $query
     * @param string $lang Language (default: en)
     * @param int $limit Max count of returning items (default: 10)
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchEntities($query, $lang = 'en', int $limit = 10)
    {
        $response = $this->client->request('GET', self::API_ENDPOINT, [
            'query' => [
                'action' => 'wbsearchentities',
                'format' => 'json',
                'strictlanguage' => true,
                'language' => $lang,
                'uselang' => $lang,
                'search' => $query,
                'limit' => $limit,
                'props' => '',
            ],
        ]);

        $results = json_decode($response->getContent(), true);

        $data = $results['search'] ?? [];

        return collect($data);
    }
}
