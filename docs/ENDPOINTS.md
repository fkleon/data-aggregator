# Collections

## Artworks

### `/artworks`

A list of all artworks sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#artworks).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `artists`
  * `categories`
  * `copyrightRepresentatives`
  * `parts`
  * `sets`
  * `dates`
  * `catalogues`
  * `committees`
  * `terms`
  * `images`
  * `publications`
  * `tours`

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks?limit=2  
Example output:

```
{
    "pagination": {
        "total": 105802,
        "limit": 2,
        "offset": 0,
        "total_pages": 52901,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/artworks?page=2&limit=2"
    },
    "data": [
        {
            "id": 198902,
            "title": "Ostrich Cup",
            "lake_guid": "25fe1500-b236-f7d3-5c58-f5c503c2047f",
            "main_reference_number": "2009.113",
            "date_start": 1589,
            "date_end": 1590,
            ...
        },
        {
            "id": 199168,
            "title": "Building Socialism Under the Banner of Lenin (Pod znamenem Lenina, za sotsialisticheskoe stroitel\u2019st)",
            "lake_guid": "b3cb0996-d616-441f-6e2b-75d4306d1b41",
            "main_reference_number": "2011.873",
            "date_start": 1929,
            "date_end": 1930,
            ...
        }
    ]
}
```

### `/artworks/essentials`

A list of essential artworks sorted by last updated date in descending order. This is a subset of the `artworks/` endpoint that represents approximately 400 of our most well-known works. This can be used to get a shorter list of artworks that will have most of its metadata filled out for testing purposes.

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `artists`
  * `categories`
  * `copyrightRepresentatives`
  * `parts`
  * `sets`
  * `dates`
  * `catalogues`
  * `committees`
  * `terms`
  * `images`
  * `publications`
  * `tours`

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/essentials?limit=2  
Example output:

```
{
    "pagination": {
        "total": 413,
        "limit": 2,
        "offset": 0,
        "total_pages": 207,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/artworks\/essentials?page=2&limit=2"
    },
    "data": [
        {
            "id": 225016,
            "title": "A Siren Beside a Ship",
            "lake_guid": "979d52ef-94ec-4e30-8c8e-29a7c6b70829",
            "main_reference_number": "2016.336",
            "date_start": 2013,
            "date_end": 2014,
            ...
        },
        {
            "id": 129884,
            "title": "Starry Night and the Astronauts",
            "lake_guid": "2313c50f-3ca2-c794-4797-9b2cee8aafeb",
            "main_reference_number": "1994.36",
            "date_start": 1971,
            "date_end": 1972,
            ...
        }
    ]
}
```

### `/artworks/search`

Search artworks data in the aggregator. Artworks in the groups of essentials are boosted so they'll show up higher in results.

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/search?q=monet  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 4943,
        "limit": 10,
        "offset": 0,
        "total_pages": 495,
        "current_page": 1
    },
    "data": [
        {
            "_score": 23.046413,
            "api_id": "16499",
            "api_model": "artworks",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/artworks\/16499",
            "id": 16499,
            "title": "Jesus Mocked by the Soldiers",
            "timestamp": "2017-10-27T11:23:12-05:00"
        },
        {
            "_score": 20.159664,
            "api_id": "16571",
            "api_model": "artworks",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/artworks\/16571",
            "id": 16571,
            "title": "Arrival of the Normandy Train, Gare Saint-Lazare",
            "timestamp": "2017-10-26T17:33:56-05:00"
        },
        {
            "_score": 19.088053,
            "api_id": "14598",
            "api_model": "artworks",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/artworks\/14598",
            "id": 14598,
            "title": "The Beach at Sainte-Adresse",
            "timestamp": "2017-10-27T11:24:13-05:00"
        }
    ],
    "suggest": {
        "autocomplete": [
            "Monet and Stacks of Wheat\nMonet and Stacks of Whea",
            "Monet and the Railroad",
            "Monet's Water Garden",
            "Monet, Claude"
        ],
        "phrase": [
            "<em>month<\/em>",
            "<em>don't<\/em>",
            "<em>Don't<\/em>",
            "<em>Donut<\/em>",
            "<em>Bonnet<\/em>"
        ]
    },
    "aggregations": {
        "count_api_model": [
            {
                "key": "artworks",
                "doc_count": 4943
            }
        ]
    }
}
```

### `/artworks/{id}`

A single artworks by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628?limit=2  
Example output:

```
{
    "data": {
        "id": 111628,
        "title": "Nighthawks",
        "lake_guid": "80a016ca-a836-a86b-04bb-cf4c4af574cf",
        "main_reference_number": "1942.51",
        "date_start": 1941,
        "date_end": 1942,
        ...
    }
}
```

### `/artworks/{id}/artists`

The artists for a given artworks. Served from the API as a type of `agent`, so their output schema is the same.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628/artists?limit=2  
Example output:

```
{
    "data": [
        {
            "id": 34996,
            "title": "Hopper, Edward",
            "lake_guid": "cba02485-5b76-1e48-bb85-2f9d0f3e3c57",
            "birth_date": 1882,
            "birth_place": null,
            "death_date": 1967,
            ...
        }
    ]
}
```

### `/artworks/{id}/copyrightRepresentatives`

The copyrightrepresentatives for a given artworks. Served from the API as a type of `agent`, so their output schema is the same.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628/copyrightRepresentatives?limit=2  
Example output:

```
{
    "data": []
}
```

### `/artworks/{id}/categories`

The categories for a given artworks.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628/categories?limit=2  
Example output:

```
{
    "data": [
        {
            "id": 151,
            "title": "light and shadow",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 801,
            "title": "Art Resource",
            "parent_id": null,
            "is_in_nav": false,
            "description": "Art Resource is a website where you can license high resolution images from The Art Institute of Chicago.",
            "sort": 0,
            ...
        },
        {
            "id": 109,
            "title": "Art Institute Icons",
            "parent_id": null,
            "is_in_nav": true,
            "description": "As an encyclopedic museum of art, the Art Institute has works from around the globe representing over 5,000 years of human artistic creation. In the Art Institute Icons theme, find iconic works of art that demonstrate the diversity and distinction of the museum\u2019s holdings.",
            "sort": 60,
            ...
        },
        {
            "id": 152,
            "title": "figural paintings",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 191,
            "title": "Featured Objects",
            "parent_id": null,
            "is_in_nav": true,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 48,
            "title": "American Modernism",
            "parent_id": "2",
            "is_in_nav": true,
            "description": null,
            "sort": 80,
            ...
        },
        {
            "id": 2,
            "title": "American",
            "parent_id": null,
            "is_in_nav": true,
            "description": "<p>The Department of American Art includes more than 1,000 paintings and sculptures from the 18th century to 1950 and nearly 2,500 decorative art objects from the 17th century to the present. Strengths in the collection include the Alfred Stieglitz Collection and significant groups of work by John Singer Sargent, James McNeill Whistler, Mary Cassatt and Winslow Homer.  Modernist holdings include iconic images by Grant Wood, Georgia O'Keeffe, Edward Hopper and the Mexican muralist Diego Rivera.<\/p>",
            "sort": 20,
            ...
        },
        {
            "id": 144,
            "title": "Edward Hopper",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 147,
            "title": "architecture",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 83,
            "title": "Featured Works",
            "parent_id": "11",
            "is_in_nav": true,
            "description": null,
            "sort": 10,
            ...
        },
        {
            "id": 365,
            "title": "Art Access: Modern and Contemporary Art",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 149,
            "title": "New York City",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 87,
            "title": "American Modernism",
            "parent_id": "11",
            "is_in_nav": true,
            "description": null,
            "sort": 50,
            ...
        },
        {
            "id": 41,
            "title": "Featured Works",
            "parent_id": "2",
            "is_in_nav": true,
            "description": null,
            "sort": 10,
            ...
        },
        {
            "id": 11,
            "title": "Modern",
            "parent_id": null,
            "is_in_nav": true,
            "description": "Considered one of the finest and most comprehensive in the world, the Art Institute's extraordinary collection of modern art includes nearly 1,000 works by artists from Europe and the Americas. The modern collection boasts some of the greatest icons of the period, including Picasso's <em>Old Guitarist<\/em>; Matisse's <em>Bathers by a River<\/em>; Br\u00e2ncusi's <em>Golden Bird<\/em>; Magritte's <em>Time Transfixed<\/em>; O'Keeffe's <em>Black Cross, New Mexico<\/em>; Orozco's <em>Zapata<\/em>; Wood's <em>American Gothic<\/em>; Ivan Albright's <em>Picture of Dorian Gray<\/em>; and Lachaise's <em>Woman (Elevation)<\/em>.",
            "sort": 120,
            ...
        },
        {
            "id": 612,
            "title": "The City in Art",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 150,
            "title": "views through windows",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        },
        {
            "id": 44,
            "title": "Paintings, 1900-1955",
            "parent_id": "2",
            "is_in_nav": true,
            "description": null,
            "sort": 40,
            ...
        }
    ]
}
```

### `/artworks/{id}/images`

The images for a given artworks.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628/images?limit=2  
Example output:

```
{
    "data": [
        {
            "id": "39d43108-e690-2705-67e2-a16dc28b8c7f",
            "title": "G42375",
            "description": null,
            "content": null,
            "artist": "",
            "artist_id": null,
            ...
        }
    ]
}
```

### `/artworks/{id}/parts`

The parts for a given artworks.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628/parts?limit=2  

### `/artworks/{id}/sets`

The sets for a given artworks.

Example request: http://aggregator-data-test.artic.edu/api/v1/artworks/111628/sets?limit=2  

## Agents

### `/agents`

A list of all agents sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#agents).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/agents?limit=2  
Example output:

```
{
    "pagination": {
        "total": 11309,
        "limit": 2,
        "offset": 0,
        "total_pages": 5655,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/agents?page=2&limit=2"
    },
    "data": [
        {
            "id": 34750,
            "title": "Grooms, Red",
            "lake_guid": "d0badd8a-e2e3-e729-5ae7-5cde63d4ad7e",
            "birth_date": 1937,
            "birth_place": null,
            "death_date": null,
            ...
        },
        {
            "id": 68565,
            "title": "Huys, Franz",
            "lake_guid": "dc30f7f9-a86b-4c30-db5f-4d790184a851",
            "birth_date": 1522,
            "birth_place": null,
            "death_date": 1562,
            ...
        }
    ]
}
```

### `/agents/search`

Search agents data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/agents/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 13985,
        "limit": 10,
        "offset": 0,
        "total_pages": 1399,
        "current_page": 1
    },
    "data": [
        {
            "_score": 12.113433,
            "api_id": "92975",
            "api_model": "agents",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/agents\/92975",
            "id": 92975,
            "title": "Quimbaya",
            "timestamp": "2017-10-26T17:24:42-05:00"
        },
        {
            "_score": 11.77696,
            "api_id": "111317",
            "api_model": "agents",
            "api_link": "http:\/\/ec2-13-59-173-130.us-east-2.compute.amazonaws.com\/api\/v1\/agents\/111317",
            "id": "collections.agents.111317",
            "title": "Ivanov, Viktor S.",
            "timestamp": "2017-09-15T12:20:38-05:00"
        },
        {
            "_score": 11.525646,
            "api_id": "111810",
            "api_model": "agents",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/agents\/111810",
            "id": 111810,
            "title": "Rossetti, Cesare",
            "timestamp": "2017-10-26T17:24:09-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "agents",
                "doc_count": 13985
            }
        ]
    }
}
```

### `/agents/{id}`

A single agents by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/agents?limit=2  
Example output:

```
{
    "pagination": {
        "total": 11309,
        "limit": 2,
        "offset": 0,
        "total_pages": 5655,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/agents?page=2&limit=2"
    },
    "data": [
        {
            "id": 34750,
            "title": "Grooms, Red",
            "lake_guid": "d0badd8a-e2e3-e729-5ae7-5cde63d4ad7e",
            "birth_date": 1937,
            "birth_place": null,
            "death_date": null,
            ...
        },
        {
            "id": 68565,
            "title": "Huys, Franz",
            "lake_guid": "dc30f7f9-a86b-4c30-db5f-4d790184a851",
            "birth_date": 1522,
            "birth_place": null,
            "death_date": 1562,
            ...
        }
    ]
}
```

Artists are a subset of agents filtered by `agent_type` with values `Individual`. The following endpoints are available with the same parameters and output as their corresponding `/agents` endpoints:

* `/artists`
* `/artists/{id}`
Venues are a subset of agents filtered by `agent_type` with values `Corporate Body`. The following endpoints are available with the same parameters and output as their corresponding `/agents` endpoints:

* `/venues`
* `/venues/{id}`
## Departments

### `/departments`

A list of all departments sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#departments).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/departments?limit=2  
Example output:

```
{
    "pagination": {
        "total": 32,
        "limit": 2,
        "offset": 0,
        "total_pages": 16,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/departments?page=2&limit=2"
    },
    "data": [
        {
            "id": 1,
            "title": "Unknown",
            "lake_guid": "a6295a34-c3a9-b51f-d9dc-c2d13be2aa75",
            "last_updated_citi": "2017-09-05T16:47:55-05:00",
            "last_updated_fedora": "2017-10-04T13:36:33-05:00",
            "last_updated_source": "2017-10-04T13:36:33-05:00",
            ...
        },
        {
            "id": 3,
            "title": "Prints and Drawings",
            "lake_guid": "922e5173-2c3d-b6c1-f223-bb591cafbb79",
            "last_updated_citi": "2017-09-05T16:47:55-05:00",
            "last_updated_fedora": "2017-05-17T14:40:40-05:00",
            "last_updated_source": "2017-10-04T13:36:32-05:00",
            ...
        }
    ]
}
```

### `/departments/search`

Search departments data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/departments/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 799,
        "limit": 10,
        "offset": 0,
        "total_pages": 80,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "999820051",
            "api_model": "departments",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/departments\/999820051",
            "id": 999820051,
            "title": "Molestiae Art",
            "timestamp": "2017-10-26T17:15:12-05:00"
        },
        {
            "_score": 1,
            "api_id": "999821069",
            "api_model": "departments",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/departments\/999821069",
            "id": 999821069,
            "title": "Quidem Art",
            "timestamp": "2017-10-26T17:15:12-05:00"
        },
        {
            "_score": 1,
            "api_id": "999623617",
            "api_model": "departments",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/departments\/999623617",
            "id": 999623617,
            "title": "Error Art",
            "timestamp": "2017-10-26T17:15:13-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "departments",
                "doc_count": 799
            }
        ]
    }
}
```

### `/departments/{id}`

A single departments by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/departments/4?limit=2  
Example output:

```
{
    "data": {
        "id": 4,
        "title": "Textiles",
        "lake_guid": "cbb32062-dd50-8711-0513-f7d19801938c",
        "last_updated_citi": "2017-09-05T16:47:54-05:00",
        "last_updated_fedora": "2017-10-04T13:36:37-05:00",
        "last_updated_source": "2017-10-04T13:36:37-05:00",
        ...
    }
}
```

## Object Types

### `/object-types`

A list of all object-types sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#object-types).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/object-types?limit=2  
Example output:

```
{
    "pagination": {
        "total": 25,
        "limit": 2,
        "offset": 0,
        "total_pages": 13,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/object-types?page=2&limit=2"
    },
    "data": [
        {
            "id": 2,
            "title": "Sculpture",
            "lake_guid": "47d48584-6c98-3d10-9efd-25db337a470e",
            "last_updated_citi": "2016-10-11T07:59:44-05:00",
            "last_updated_fedora": "2017-03-08T18:24:39-06:00",
            "last_updated_source": "2017-05-27T15:44:27-05:00",
            ...
        },
        {
            "id": 3,
            "title": "Painting",
            "lake_guid": "fca7d2b6-3583-3ffb-a491-54326a5715bc",
            "last_updated_citi": "2017-02-14T01:22:25-06:00",
            "last_updated_fedora": "2017-02-23T21:32:35-06:00",
            "last_updated_source": "2017-03-28T01:38:08-05:00",
            ...
        }
    ]
}
```

### `/object-types/{id}`

A single object-types by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/object-types/3?limit=2  
Example output:

```
{
    "data": {
        "id": 3,
        "title": "Painting",
        "lake_guid": "fca7d2b6-3583-3ffb-a491-54326a5715bc",
        "last_updated_citi": "2017-02-14T01:22:25-06:00",
        "last_updated_fedora": "2017-02-23T21:32:35-06:00",
        "last_updated_source": "2017-03-28T01:38:08-05:00",
        ...
    }
}
```

## Categories

### `/categories`

A list of all categories sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#categories).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/categories?limit=2  
Example output:

```
{
    "pagination": {
        "total": 790,
        "limit": 2,
        "offset": 0,
        "total_pages": 395,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/categories?page=2&limit=2"
    },
    "data": [
        {
            "id": 1,
            "title": "African",
            "parent_id": null,
            "is_in_nav": true,
            "description": "<p>The Art Institute\u2019s African collection includes over 400 works that highlight the diversity of tradition-based arts on the continent, with emphasis on the sculptural traditions of West and Central Africa. Included are masks and figural sculpture, beadwork, furniture, regalia, and textiles from countries including Burkina Faso, C\u00f4te d\u2019Ivoire, Democratic Republic of Congo, Ghana, Ethiopia, Mali, Morocco, Nigeria, and South Africa. The Art Institute\u2019s collection of over 80 African ceramics is the largest in an American art museum.<\/p>",
            "sort": 10,
            ...
        },
        {
            "id": 513,
            "title": "typography",
            "parent_id": null,
            "is_in_nav": false,
            "description": null,
            "sort": 0,
            ...
        }
    ]
}
```

### `/categories/search`

Search categories data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/categories/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 2343,
        "limit": 10,
        "offset": 0,
        "total_pages": 235,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "999940019",
            "api_model": "categories",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/categories\/999940019",
            "id": 999940019,
            "title": "Et",
            "timestamp": "2017-10-26T17:15:14-05:00"
        },
        {
            "_score": 1,
            "api_id": "999424227",
            "api_model": "categories",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/categories\/999424227",
            "id": 999424227,
            "title": "Velit",
            "timestamp": "2017-10-26T17:15:14-05:00"
        },
        {
            "_score": 1,
            "api_id": "999118426",
            "api_model": "categories",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/categories\/999118426",
            "id": 999118426,
            "title": "Ratione",
            "timestamp": "2017-10-26T17:15:14-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "categories",
                "doc_count": 2343
            }
        ]
    }
}
```

### `/categories/{id}`

A single categories by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/categories/3?limit=2  
Example output:

```
{
    "data": {
        "id": 3,
        "title": "Art of the Americas",
        "parent_id": null,
        "is_in_nav": true,
        "description": "<p>The Amerindian collection primarily focuses upon Mesoamerican and Andean ceramics, sculpture, textiles, and metalwork. Native North American Indian works, particularly from the Plains Indians, the Southwest, and California, are also on view.<\/p>",
        "sort": 60,
        ...
    }
}
```

## Agent Types

### `/agent-types`

A list of all agent-types sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#agent-types).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/agent-types?limit=2  
Example output:

```
{
    "pagination": {
        "total": 25,
        "limit": 2,
        "offset": 0,
        "total_pages": 13,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/agent-types?page=2&limit=2"
    },
    "data": [
        {
            "id": 16,
            "title": "itaque perspiciatis",
            "lake_guid": "d3c4f09e-f009-34be-8d73-0279167d1fde",
            "last_updated_citi": "2016-09-21T00:45:34-05:00",
            "last_updated_fedora": "2017-07-03T06:37:42-05:00",
            "last_updated_source": "2016-11-12T02:28:49-06:00",
            ...
        },
        {
            "id": 18,
            "title": "necessitatibus id",
            "lake_guid": "584f4376-370f-325d-9944-91f6e74a0f36",
            "last_updated_citi": "2017-03-26T09:18:41-05:00",
            "last_updated_fedora": "2017-04-25T21:02:36-05:00",
            "last_updated_source": "2017-04-03T16:03:22-05:00",
            ...
        }
    ]
}
```

### `/agent-types/{id}`

A single agent-types by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/agent-types/36?limit=2  
Example output:

```
{
    "data": {
        "id": 36,
        "title": "Artist",
        "lake_guid": "3f952f4e-1164-3656-877c-9d195faba4b9",
        "last_updated_citi": "2016-11-22T00:31:50-06:00",
        "last_updated_fedora": "2017-08-07T04:44:13-05:00",
        "last_updated_source": "2017-08-31T20:18:26-05:00",
        ...
    }
}
```

## Galleries

### `/galleries`

A list of all galleries sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#galleries).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`

Example request: http://aggregator-data-test.artic.edu/api/v1/galleries?limit=2  
Example output:

```
{
    "pagination": {
        "total": 100,
        "limit": 2,
        "offset": 0,
        "total_pages": 50,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/galleries?page=2&limit=2"
    },
    "data": [
        {
            "id": 214592,
            "title": "Hintz Hall",
            "lake_guid": "5cb07e36-9330-339a-9a3c-dc5a92ae7e68",
            "is_closed": false,
            "number": "434A",
            "floor": "1",
            ...
        },
        {
            "id": 818766,
            "title": "Heaney Memorial Garden",
            "lake_guid": "fbbe6951-6f30-3cbd-8acc-5f6d1ead0e51",
            "is_closed": false,
            "number": "460",
            "floor": "LL",
            ...
        }
    ]
}
```

### `/galleries/search`

Search galleries data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/galleries/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 1520,
        "limit": 10,
        "offset": 0,
        "total_pages": 152,
        "current_page": 1
    },
    "data": [
        {
            "_score": 11.4849825,
            "api_id": "23972",
            "api_model": "galleries",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/galleries\/23972",
            "id": 23972,
            "title": "Gallery 297B",
            "timestamp": "2017-10-26T17:31:52-05:00"
        },
        {
            "_score": 1,
            "api_id": "22475",
            "api_model": "galleries",
            "api_link": "http:\/\/ec2-13-59-173-130.us-east-2.compute.amazonaws.com\/api\/v1\/galleries\/22475",
            "id": "collections.galleries.22475",
            "title": "Klocko Reading Room",
            "timestamp": "2017-09-15T12:20:42-05:00"
        },
        {
            "_score": 1,
            "api_id": "27057",
            "api_model": "galleries",
            "api_link": "http:\/\/ec2-13-59-173-130.us-east-2.compute.amazonaws.com\/api\/v1\/galleries\/27057",
            "id": "collections.galleries.27057",
            "title": "Reichel Study Room",
            "timestamp": "2017-09-15T12:20:42-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "galleries",
                "doc_count": 1520
            }
        ]
    }
}
```

### `/galleries/{id}`

A single galleries by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/galleries/400844?limit=2  
Example output:

```
{
    "data": {
        "id": 400844,
        "title": "Heidenreich Study Room",
        "lake_guid": "170cb92c-e7e5-32b2-b656-e37c72c23fff",
        "is_closed": false,
        "number": "450",
        "floor": "1",
        ...
    }
}
```

## Exhibitions

### `/exhibitions`

A list of all exhibitions sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#exhibitions).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `artworks`
  * `venues`

Example request: http://aggregator-data-test.artic.edu/api/v1/exhibitions?limit=2  
Example output:

```
{
    "pagination": {
        "total": 100,
        "limit": 2,
        "offset": 0,
        "total_pages": 50,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/exhibitions?page=2&limit=2"
    },
    "data": [
        {
            "id": 200730,
            "title": "Rem Illo Id",
            "lake_guid": "8dab04d6-6f94-3fbc-8f9c-8f275633fd87",
            "description": "Aut est voluptatem nesciunt veniam perspiciatis est dolor. Ad modi quis dolore iusto sed dignissimos iste nisi. Aut excepturi voluptatem officiis neque hic.",
            "type": "AIC & Other Venues",
            "department": "Conservation",
            ...
        },
        {
            "id": 945699,
            "title": "Vel Ducimus Magni",
            "lake_guid": "86af2d52-c803-3053-9b5f-0830b13df2a0",
            "description": "Consequatur eius pariatur excepturi et voluptates. Enim in impedit vel et voluptatibus. Voluptatibus molestiae adipisci sit dignissimos qui iste facere quisquam.",
            "type": "Rotation",
            "department": "Flaxman Library",
            ...
        }
    ]
}
```

### `/exhibitions/search`

Search exhibitions data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/exhibitions/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 5305,
        "limit": 10,
        "offset": 0,
        "total_pages": 531,
        "current_page": 1
    },
    "data": [
        {
            "_score": 11.813478,
            "api_id": "4788",
            "api_model": "exhibitions",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/exhibitions\/4788",
            "id": 4788,
            "title": "Guild of Boston Artists",
            "timestamp": "2017-10-27T14:07:21-05:00"
        },
        {
            "_score": 11.813478,
            "api_id": "4796",
            "api_model": "exhibitions",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/exhibitions\/4796",
            "id": 4796,
            "title": "Art Students' League of Chicago 23rd Annual",
            "timestamp": "2017-10-27T14:07:33-05:00"
        },
        {
            "_score": 11.813478,
            "api_id": "6596",
            "api_model": "exhibitions",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/exhibitions\/6596",
            "id": 6596,
            "title": "The Age of Louis XV: French Paintings from 1710-1774",
            "timestamp": "2017-10-27T14:09:19-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "exhibitions",
                "doc_count": 5305
            }
        ]
    }
}
```

### `/exhibitions/{id}`

A single exhibitions by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/exhibitions/903287?limit=2  
Example output:

```
{
    "data": {
        "id": 903287,
        "title": "Consectetur Enim Dolorem",
        "lake_guid": "0db48908-6dd4-3e2d-b252-83d0615ec503",
        "description": "Alias velit voluptatem adipisci in. Ut illo nihil qui. Fugit tenetur excepturi eius voluptatem dolorem.",
        "type": "AIC & Other Venues",
        "department": "Exhibition",
        ...
    }
}
```

### `/exhibitions/{id}/artworks`

The artworks for a given exhibitions.

Example request: http://aggregator-data-test.artic.edu/api/v1/exhibitions/903287/artworks?limit=2  
Example output:

```
{
    "data": [
        {
            "id": 207567,
            "title": "Pum Litar River Morrisville Mo",
            "lake_guid": "e3a06b30-f618-5360-7315-44357505bf7a",
            "main_reference_number": "2010.741",
            "date_start": 1961,
            "date_end": 1964,
            ...
        },
        {
            "id": 11910,
            "title": "Siena",
            "lake_guid": "ae9220fa-759e-c273-c0bc-3c603b30c6cb",
            "main_reference_number": "1932.709",
            "date_start": 1904,
            "date_end": 1905,
            ...
        }
    ]
}
```

### `/exhibitions/{id}/venues`

The venues for a given exhibitions.

Example request: http://aggregator-data-test.artic.edu/api/v1/exhibitions/903287/venues?limit=2  
Example output:

```
{
    "data": [
        {
            "id": 339335,
            "title": "Bernier, Faye",
            "lake_guid": "d44712cb-d94c-3ef4-99b4-b9ca0269b62c",
            "birth_date": 1995,
            "birth_place": "Heard Island and McDonald Islands",
            "death_date": 1994,
            ...
        },
        {
            "id": 339335,
            "title": "Bernier, Faye",
            "lake_guid": "d44712cb-d94c-3ef4-99b4-b9ca0269b62c",
            "birth_date": 1995,
            "birth_place": "Heard Island and McDonald Islands",
            "death_date": 1994,
            ...
        }
    ]
}
```

## Images

### `/images`

A list of all images sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#images).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`
  * `artworks`

Example request: http://aggregator-data-test.artic.edu/api/v1/images?limit=2  
Example output:

```
{
    "pagination": {
        "total": 120010,
        "limit": 2,
        "offset": 0,
        "total_pages": 60005,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/images?page=2&limit=2"
    },
    "data": [
        {
            "id": "3e7b379d-791a-3794-82b2-e2e465858c3e",
            "title": "Dolor Tempora Ullam",
            "description": "Molestias doloribus itaque corporis et odit sit fuga in. Voluptas ullam est non aliquid voluptatibus inventore consequatur. At sit aut provident dolor nihil repellat eum.",
            "content": null,
            "artist": "Folly Cove Designers",
            "artist_id": 108547,
            ...
        },
        {
            "id": "811dd047-c71d-350b-af62-7c0575db7bcb",
            "title": "Nemo Ut Ratione",
            "description": "Molestiae perspiciatis pariatur quae. Facilis dolore laborum voluptatem perspiciatis. Dicta sit ducimus qui voluptas voluptate nostrum quia. Quidem autem molestias quasi modi nihil.",
            "content": null,
            "artist": "Rich, Linda",
            "artist_id": 36369,
            ...
        }
    ]
}
```

### `/images/search`

Search images data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/images/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 415578,
        "limit": 10,
        "offset": 0,
        "total_pages": 41558,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "0b3a43fc-01dc-3b5e-9d4a-7ce605f916e4",
            "api_model": "images",
            "api_link": "http:\/\/ec2-18-220-104-145.us-east-2.compute.amazonaws.com\/api\/v1\/images\/0b3a43fc-01dc-3b5e-9d4a-7ce605f916e4",
            "id": "collections.images.0b3a43fc-01dc-3b5e-9d4a-7ce605f916e4",
            "title": "Dolor Qui Sequi",
            "timestamp": "2017-09-05T16:49:17-05:00"
        },
        {
            "_score": 1,
            "api_id": "8e6095c8-c17f-3974-b16a-92b11b67ae0c",
            "api_model": "images",
            "api_link": "http:\/\/ec2-18-220-104-145.us-east-2.compute.amazonaws.com\/api\/v1\/images\/8e6095c8-c17f-3974-b16a-92b11b67ae0c",
            "id": "collections.images.8e6095c8-c17f-3974-b16a-92b11b67ae0c",
            "title": "Dolorum Voluptatibus Reprehenderit",
            "timestamp": "2017-09-05T16:49:17-05:00"
        },
        {
            "_score": 1,
            "api_id": "f3ac7bee-c908-39bd-955d-a706e40d10c7",
            "api_model": "images",
            "api_link": "http:\/\/ec2-18-220-104-145.us-east-2.compute.amazonaws.com\/api\/v1\/images\/f3ac7bee-c908-39bd-955d-a706e40d10c7",
            "id": "collections.images.f3ac7bee-c908-39bd-955d-a706e40d10c7",
            "title": "Placeat Asperiores Harum",
            "timestamp": "2017-09-05T16:49:15-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "images",
                "doc_count": 415578
            }
        ]
    }
}
```

### `/images/{id}`

A single images by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/images/0d6cca51-bbe1-350b-87df-bb2b4c0c9720?limit=2  
Example output:

```
{
    "data": {
        "id": "0d6cca51-bbe1-350b-87df-bb2b4c0c9720",
        "title": "Eum Vel Et",
        "description": "Doloribus deleniti amet excepturi fugit nisi. Id sed architecto qui nesciunt non. Iusto qui doloribus id et consequatur perferendis temporibus.",
        "content": null,
        "artist": "Deutch, Stephen",
        "artist_id": 34246,
        ...
    }
}
```

## Videos

### `/videos`

A list of all videos sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#videos).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`

Example request: http://aggregator-data-test.artic.edu/api/v1/videos?limit=2  
Example output:

```
{
    "pagination": {
        "total": 312,
        "limit": 2,
        "offset": 0,
        "total_pages": 156,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/videos?page=2&limit=2"
    },
    "data": [
        {
            "id": "041d4172-97de-d924-72e4-6919223778f9",
            "title": "Video: Monet and the Cloud Machines",
            "description": "An exploration of Monet's fascination with depicting the smoke and steam from the cloud machines, or steam engines, pulling into Paris's Gare Saint-Lazare.  ",
            "content": "http:\/\/www.artic.edu\/aic\/collections\/citi\/resources\/531.flv",
            "artist": "Monet, Claude",
            "artist_id": 35809,
            ...
        },
        {
            "id": "162dd4e7-4915-6bf7-3a69-aec1ebb4eea4",
            "title": "Video: Caillebotte and the Impressionist Exhibitions",
            "description": "Learn about Caillebotte's participation in and organization of the Impressionist exhibitions.  ",
            "content": "http:\/\/www.artic.edu\/aic\/collections\/citi\/resources\/543.flv",
            "artist": "Caillebotte, Gustave",
            "artist_id": 3829,
            ...
        }
    ]
}
```

### `/videos/search`

Search videos data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/videos/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 1012,
        "limit": 10,
        "offset": 0,
        "total_pages": 102,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "813ecdc8-d3ac-3182-a8b7-e64646f914a5",
            "api_model": "videos",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/videos\/813ecdc8-d3ac-3182-a8b7-e64646f914a5",
            "id": "813ecdc8-d3ac-3182-a8b7-e64646f914a5",
            "title": "Consequatur Ad Nemo",
            "timestamp": "2017-10-26T17:11:53-05:00"
        },
        {
            "_score": 1,
            "api_id": "e5216d3e-5791-33ee-a419-7142bcf30bc6",
            "api_model": "videos",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/videos\/e5216d3e-5791-33ee-a419-7142bcf30bc6",
            "id": "e5216d3e-5791-33ee-a419-7142bcf30bc6",
            "title": "Impedit Magni Fugiat",
            "timestamp": "2017-10-26T17:11:53-05:00"
        },
        {
            "_score": 1,
            "api_id": "abfaf15a-f96f-30bc-a2f2-8ad268848375",
            "api_model": "videos",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/videos\/abfaf15a-f96f-30bc-a2f2-8ad268848375",
            "id": "abfaf15a-f96f-30bc-a2f2-8ad268848375",
            "title": "Debitis Enim Eos",
            "timestamp": "2017-10-26T17:11:53-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "videos",
                "doc_count": 1012
            }
        ]
    }
}
```

### `/videos/{id}`

A single videos by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/videos/8199a3c6-99fa-582d-449a-bc9221db54da?limit=2  
Example output:

```
{
    "data": {
        "id": "8199a3c6-99fa-582d-449a-bc9221db54da",
        "title": "Video: Cassatt and the Modern Woman",
        "description": "An introduction to Cassatt's paintings of women involved in morning activities in the privacy of their bourgeois homes.  ",
        "content": "http:\/\/www.artic.edu\/aic\/collections\/citi\/resources\/530.flv",
        "artist": "Cassatt, Mary",
        "artist_id": 33890,
        ...
    }
}
```

## Links

### `/links`

A list of all links sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#links).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`

Example request: http://aggregator-data-test.artic.edu/api/v1/links?limit=2  
Example output:

```
{
    "pagination": {
        "total": 146,
        "limit": 2,
        "offset": 0,
        "total_pages": 73,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/links?page=2&limit=2"
    },
    "data": [
        {
            "id": "1ac6c73b-e560-5fc9-05fb-8e2c30eccdc0",
            "title": "Text: The Bartletts and the Grande Jatte:  Collecting Modern Painting in the 1920s",
            "description": "The fascinating story of the collectors' love of modern art and their acquisiton of  Seurat's famous painting in 1924.",
            "content": null,
            "artist": "",
            "artist_id": null,
            ...
        },
        {
            "id": "1c4ea5e7-7179-2bec-379f-069bfa1bde19",
            "title": "Self-Guide: Color and Pigment in Impressionist Paintings",
            "description": "A self-guide for students through the Impressionist and Post-Impressionist galleries of the Art Institute, with emphasis on the artists' use of color and pigment. ",
            "content": "http:\/\/www.artic.edu\/aic\/education\/sciarttech\/global_pages\/g3.4.html",
            "artist": "",
            "artist_id": null,
            ...
        }
    ]
}
```

### `/links/search`

Search links data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/links/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 846,
        "limit": 10,
        "offset": 0,
        "total_pages": 85,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "5caabfd8-310a-3158-a968-fcabe183006b",
            "api_model": "links",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/links\/5caabfd8-310a-3158-a968-fcabe183006b",
            "id": "5caabfd8-310a-3158-a968-fcabe183006b",
            "title": "Voluptas Dolorem Fugiat",
            "timestamp": "2017-10-26T17:09:43-05:00"
        },
        {
            "_score": 1,
            "api_id": "0c3d028e-b69f-3ce0-b8ca-bf8f21182cfe",
            "api_model": "links",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/links\/0c3d028e-b69f-3ce0-b8ca-bf8f21182cfe",
            "id": "0c3d028e-b69f-3ce0-b8ca-bf8f21182cfe",
            "title": "Non Officiis Veritatis",
            "timestamp": "2017-10-26T17:09:43-05:00"
        },
        {
            "_score": 1,
            "api_id": "5669f4c6-7862-3b4b-99f2-fa9937066e5a",
            "api_model": "links",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/links\/5669f4c6-7862-3b4b-99f2-fa9937066e5a",
            "id": "5669f4c6-7862-3b4b-99f2-fa9937066e5a",
            "title": "Eaque Magni Reiciendis",
            "timestamp": "2017-10-26T17:09:43-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "links",
                "doc_count": 846
            }
        ]
    }
}
```

### `/links/{id}`

A single links by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/links/3990a5f5-2ae9-3c7b-2fb8-1b0438962cd3?limit=2  
Example output:

```
{
    "data": {
        "id": "3990a5f5-2ae9-3c7b-2fb8-1b0438962cd3",
        "title": "Student Tours: Visit Information",
        "description": "Information on planning a student tour: application dates, reservation and museum contact information. ",
        "content": "http:\/\/www.artic.edu\/aic\/students\/tours\/index.html",
        "artist": "",
        "artist_id": null,
        ...
    }
}
```

## Sounds

### `/sounds`

A list of all sounds sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#sounds).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`

Example request: http://aggregator-data-test.artic.edu/api/v1/sounds?limit=2  
Example output:

```
{
    "pagination": {
        "total": 1020,
        "limit": 2,
        "offset": 0,
        "total_pages": 510,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sounds?page=2&limit=2"
    },
    "data": [
        {
            "id": "84dee0a5-1774-0440-7868-e031e490451a",
            "title": "Audio Lecture: Artists Connect: Sumakshi Singh Connects with Richard Tuttle",
            "description": "<p>In her talk from April 7, 2007, artist Sumakshi Singh discusses the impact of minimalist works by Richard Tuttle on her own intricately detailed installations and experimental performances.<\/p> <p>Artists Connect is a regularly scheduled series of lectures given by Chicago-area artists.  In these illustrated talks, artists describe their own work in relation to one or several works in the collection of the Art Institute. <\/p>",
            "content": "http:\/\/www.artic.edu\/aic\/collections\/citi\/resources\/705_singh.mp3",
            "artist": "Tuttle, Richard",
            "artist_id": 47750,
            ...
        },
        {
            "id": "9c37b5e9-e139-d744-80d6-f15bd2b592e1",
            "title": "438.wav",
            "description": null,
            "content": null,
            "artist": "",
            "artist_id": null,
            ...
        }
    ]
}
```

### `/sounds/search`

Search sounds data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/sounds/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 1720,
        "limit": 10,
        "offset": 0,
        "total_pages": 172,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "2e999957-0ee3-3b3f-a322-f69403e22bad",
            "api_model": "sounds",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sounds\/2e999957-0ee3-3b3f-a322-f69403e22bad",
            "id": "2e999957-0ee3-3b3f-a322-f69403e22bad",
            "title": "Minus Consectetur Adipisci",
            "timestamp": "2017-10-26T17:11:51-05:00"
        },
        {
            "_score": 1,
            "api_id": "e871ae8e-8258-3506-8b79-1d1ebd77970c",
            "api_model": "sounds",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sounds\/e871ae8e-8258-3506-8b79-1d1ebd77970c",
            "id": "e871ae8e-8258-3506-8b79-1d1ebd77970c",
            "title": "Molestiae Veniam Doloremque",
            "timestamp": "2017-10-26T17:11:51-05:00"
        },
        {
            "_score": 1,
            "api_id": "ffd70ddb-5502-3f11-a444-51ec843d529a",
            "api_model": "sounds",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sounds\/ffd70ddb-5502-3f11-a444-51ec843d529a",
            "id": "ffd70ddb-5502-3f11-a444-51ec843d529a",
            "title": "Repudiandae Nisi In",
            "timestamp": "2017-10-26T17:11:51-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "sounds",
                "doc_count": 1720
            }
        ]
    }
}
```

### `/sounds/{id}`

A single sounds by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/sounds/0dc99580-0a4c-c047-31e9-f42d29ac020e?limit=2  
Example output:

```
{
    "data": {
        "id": "0dc99580-0a4c-c047-31e9-f42d29ac020e",
        "title": "Audio Lecture: Sally Mann at the Art Institute of Chicago",
        "description": "<p>Tune in as contemporary photographer Mann answers questions from an audience of nearly 400 on opening day of the Art Institute exhibition <em>So the Story Goes<\/em>. Mann responds to questions ranging from printing techniques to subject matter, from disbelief in photographic \"truth\" to a Southern weakness for the romantic.<\/p>",
        "content": "http:\/\/www.artic.edu\/aic\/collections\/citi\/resources\/691_mann.mp3",
        "artist": "Mann, Sally",
        "artist_id": 44721,
        ...
    }
}
```

## Texts

### `/texts`

A list of all texts sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#texts).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`

Example request: http://aggregator-data-test.artic.edu/api/v1/texts?limit=2  
Example output:

```
{
    "pagination": {
        "total": 601,
        "limit": 2,
        "offset": 0,
        "total_pages": 301,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/texts?page=2&limit=2"
    },
    "data": [
        {
            "id": "19151aeb-f37d-7cde-c3d1-11f55f702cd8",
            "title": "Examination: Van Gogh's <em>Self Portrait<\/em>",
            "description": "An exploration of the lively brushwork and color in van Gogh's intense self-portrait.  ",
            "content": "Prior to leaving the Netherlands for Paris in February 1886, Vincent van Gogh \nhad rendered the harsh beauty of peasant life in images such as <em>The Potato Eaters <\/em>(1885; Amsterdam, Van Gogh Museum), the great work of his early Realist phase. However, sudden exposure to French avant-garde painting prompted him to rethink his artistic means. Rejecting the bleak palette and crude forms he had employed in his previous paintings, van Gogh set about assimilating the art of the Impressionists, notably their broken brushwork and vibrant use of color. Simultaneously, he came to terms with the quasi-scientific method of Georges Seurat, whose <em>Sunday on La Grande Jatte\u20141884<em> he discovered at the final Impressionist exhibition, which opened a few months after his arrival in the capital. In 1888 van Gogh went to Arles, where he devised a highly personal style characterized by decorative clarity, expressive drawing, and violent chromatic contrasts. But it was during his two-year Paris sojourn that he laid the foundation for the achievement of his final years. <br><br>\nIn this transitional period, van Gogh\u2014who had never before executed a self-portrait\u2014produced at least twenty-four images of himself, in which we can measure his adaptation of new ideas to his own expressive ends. The format of the Art Institute\u2019s example evokes traditional conventions of the genre, but the technique is thoroughly modern. The face is rendered in brusque strokes of bright color, and the coat and background are a vibrating flux of dots and dashes. Juxtaposing complementary colors, for example red and green (in the beard, as well as the background), van Gogh demonstrated his awareness of Neo-Impressionist practice. He would soon abandon Pointillist handling, but Seurat\u2019s poetic notion of a \"harmony of contrasts\" would continue to haunt his imagination. \n",
            "artist": "Gogh, Vincent van",
            "artist_id": 40610,
            ...
        },
        {
            "id": "0de7088d-00e1-5d1f-2e42-8fd0dfe6cc1a",
            "title": "Overview: Twachtman's Seasonal Exploration and Depiction of <em>The White Bridge<\/em>",
            "description": " An overview of Twachtman's paintings of his Connecticut property and a look at his joyous image of springtime and of human construction in harmony with nature.    ",
            "content": "For John Henry Twachtman, Cos Cob, Connecticut, was a source of never-ending artistic inspiration. He purchased property there in 1889, and, over the following decade, made improvements to his house and surrounding land. In 1895 he added a trellised, white footbridge, which spanned Horseneck Brook. Twachtman carefully selected the proportions and color of the structure to enhance the site\u2019s inherent aesthetic qualities. He then made at least five paintings of the bridge from different vantage points, exploring its relationship to both the man-made and natural world. These works are contemporaneous with Claude Monet\u2019s pictures of the Japanese bridge over his water-lily pond at Giverny; although Twachtman was less methodical (and less prolific) than Monet, he worked with a similarly palpable love of place. <br><br>\n The Art Institute\u2019s <em>White Bridge<\/em> is a vivid, joyous image of springtime that complements <em>Icebound<\/em>, Twachtman\u2019s rendition of the same brook in winter. Delineated with bright, white paint, the bridge crosses over the reflective surface of the water and stands out sharply through transparent trees in the foreground. The light, feathery strokes that compose the bridge echo those used to trace the limbs and branches of the surrounding hemlocks. The artist thus used brushwork to unify forms on the surface of the canvas, as he had made an effort to integrate the bridge itself into the Cos Cob setting. Twachtman\u2019s desire to show human construction in harmony with nature indicates his concern\u2014widespread at the turn of the twentieth century\u2014about the effects of urban and industrial growth. A witness to (and participant in) the suburbanization of rural Connecticut, Twachtman lamented the threat posed to the pastoral landscape he loved.\n",
            "artist": "Twachtman, John Henry",
            "artist_id": 37048,
            ...
        }
    ]
}
```

### `/texts/search`

Search texts data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/texts/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 1301,
        "limit": 10,
        "offset": 0,
        "total_pages": 131,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "92734517-a9bf-3089-a6a5-eb73bbb3281c",
            "api_model": "texts",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/texts\/92734517-a9bf-3089-a6a5-eb73bbb3281c",
            "id": "92734517-a9bf-3089-a6a5-eb73bbb3281c",
            "title": "Et Eos Sit",
            "timestamp": "2017-10-26T17:11:59-05:00"
        },
        {
            "_score": 1,
            "api_id": "dced5fdb-9ea9-3673-bb93-d67ddce0be10",
            "api_model": "texts",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/texts\/dced5fdb-9ea9-3673-bb93-d67ddce0be10",
            "id": "dced5fdb-9ea9-3673-bb93-d67ddce0be10",
            "title": "Aut Sed Consectetur",
            "timestamp": "2017-10-26T17:12:00-05:00"
        },
        {
            "_score": 1,
            "api_id": "8926c86f-a8ec-3c89-99c7-ed2855b957a8",
            "api_model": "texts",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/texts\/8926c86f-a8ec-3c89-99c7-ed2855b957a8",
            "id": "8926c86f-a8ec-3c89-99c7-ed2855b957a8",
            "title": "Placeat Dolorum Est",
            "timestamp": "2017-10-26T17:12:00-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "texts",
                "doc_count": 1301
            }
        ]
    }
}
```

### `/texts/{id}`

A single texts by the given identifier. {id} is the identifier from our collections managements system.

Example request: http://aggregator-data-test.artic.edu/api/v1/texts/28f4641e-c040-7669-6036-f6fce1e25514?limit=2  
Example output:

```
{
    "data": {
        "id": "28f4641e-c040-7669-6036-f6fce1e25514",
        "title": "Examination: Rodin's <em>Adam<\/em>",
        "description": "An exploration of Rodin's ability to convey physical and emotional torment in his towering sculpture of Adam.  ",
        "content": "With his right leg raised and his torso tensed and wrenched into an unnatural position, Auguste Rodin\u2019s <em>Adam<\/em> appears horribly disfigured, despite his idealized proportions and serene facial expression. His right arm and hand, perhaps drawn from Michelangelo\u2019s figure of Adam at the center of the Sistine Chapel ceiling, point emphatically downward, as if to indicate the fall of man, while his left hand desperately clutches his right knee. \"I . . . tried to express the inner feelings of the man by the mobility of the muscles,\" wrote the artist about this piece. The rigid musculature of the figure\u2019s hands and legs, the twisted trunk of the body, and the emphatic straining of the head, as neck and shoulder collapse into a nearly horizontal plane, all serve to convey a sense of physical pain, certainly related to the emotional torment of having been banished by God from Paradise. <br><br>\n Rodin originally intended his towering, contorted sculpture of <em>Adam<\/em> and its pendant, <em>Eve<\/em>, to flank the <em>Gates of Hell<\/em>, a monumental bronze doorway of bas-reliefs illustrating various cantos from Dante\u2019s <em>Divine Comedy<\/em>. The doorway\u2014capped by looming representations of the three shades, which repeat the basic form of Adam\u2014was commissioned by the French government in 1880 for a new museum of decorative arts in Paris. The museum was never built, and Rodin left the portal unfinished at his death. Nevertheless, the project became well known during the artist\u2019s lifetime, for he cast individual figures and groups, some of which appeared in a large exhibition of works by Rodin and Claude Monet held at the prestigious Parisian gallery of Georges Petit in 1889.\n\n",
        "artist": "Rodin, Auguste",
        "artist_id": 36418,
        ...
    }
}
```

# Shop

## Shop Categories

### `/shop-categories`

A list of all shop-categories sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#shop-categories).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `children`

Example request: http://aggregator-data-test.artic.edu/api/v1/shop-categories?limit=2  
Example output:

```
{
    "pagination": {
        "total": 100,
        "limit": 2,
        "offset": 0,
        "total_pages": 50,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/shop-categories?page=2&limit=2"
    },
    "data": [
        {
            "id": 774,
            "title": "Ea in deleniti error pariatur",
            "link": "https:\/\/www.collins.com\/dolor-nobis-et-occaecati-qui-qui-et-et-aut",
            "parent_id": 59,
            "type": "top-category",
            "source_id": 76,
            ...
        },
        {
            "id": 23,
            "title": "Tenetur voluptatem sed impedit pariatur",
            "link": "http:\/\/www.hintz.net\/deserunt-rerum-eaque-vero-fugiat.html",
            "parent_id": 497,
            "type": "color",
            "source_id": 91,
            ...
        }
    ]
}
```

### `/shop-categories/search`

Search shop-categories data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/shop-categories/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 0,
        "limit": 10,
        "offset": 0,
        "total_pages": 0,
        "current_page": 1
    },
    "data": [],
    "aggregations": {
        "count_api_model": []
    }
}
```

### `/shop-categories/{id}`

A single shop-categories by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/shop-categories/377?limit=2  
Example output:

```
{
    "data": {
        "id": 377,
        "title": "Quaerat quisquam aut eum maxime",
        "link": "http:\/\/vonrueden.com\/",
        "parent_id": 239,
        "type": "color",
        "source_id": 54,
        ...
    }
}
```

## Products

### `/products`

A list of all products sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#products).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `categories`

Example request: http://aggregator-data-test.artic.edu/api/v1/products?limit=2  
Example output:

```
{
    "pagination": {
        "total": 100,
        "limit": 2,
        "offset": 0,
        "total_pages": 50,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/products?page=2&limit=2"
    },
    "data": [
        {
            "id": 12,
            "title": "Et Blanditiis Debitis Beatae Ut Dolores",
            "title_display": "Et Blanditiis <em>Debitis Beatae<\/em> Ut Dolores",
            "sku": "70439092",
            "link": "http:\/\/miller.info\/dicta-itaque-voluptas-rem-totam-repudiandae-voluptatum-ratione-aut",
            "image": "http:\/\/lorempixel.com\/640\/480\/?86964",
            ...
        },
        {
            "id": 534,
            "title": "Facere Dolorem Ut Suscipit Nihil Omnis",
            "title_display": "Facere Dolorem <em>Ut Suscipit<\/em> Nihil Omnis",
            "sku": "59372002",
            "link": "http:\/\/king.com\/labore-aliquid-iste-id-reiciendis-totam-dignissimos-libero",
            "image": "http:\/\/lorempixel.com\/640\/480\/?29069",
            ...
        }
    ]
}
```

### `/products/search`

Search products data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/products/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 380,
        "limit": 10,
        "offset": 0,
        "total_pages": 38,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "260",
            "api_model": "products",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/products\/260",
            "id": "shop.products.260",
            "title": "Quae Qui Temporibus Doloremque Et Cum",
            "timestamp": "2017-10-16T00:44:07-05:00"
        },
        {
            "_score": 1,
            "api_id": "335",
            "api_model": "products",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/products\/335",
            "id": "shop.products.335",
            "title": "Est Nihil Aut Vitae Animi Voluptate",
            "timestamp": "2017-10-16T00:44:07-05:00"
        },
        {
            "_score": 1,
            "api_id": "25",
            "api_model": "products",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/products\/25",
            "id": "shop.products.25",
            "title": "Minima Soluta Facere Autem Esse Rerum",
            "timestamp": "2017-10-16T00:44:07-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "products",
                "doc_count": 380
            }
        ]
    }
}
```

### `/products/{id}`

A single products by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/products/797?limit=2  
Example output:

```
{
    "data": {
        "id": 797,
        "title": "Dolorem Voluptate Dolores Natus Et Sint",
        "title_display": "Dolorem Voluptate <em>Dolores Natus<\/em> Et Sint",
        "sku": "16587290",
        "link": "http:\/\/ward.com\/",
        "image": "http:\/\/lorempixel.com\/640\/480\/?19356",
        ...
    }
}
```

# Events and Membership

## Events

### `/events`

A list of all events sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#events).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/events?limit=2  
Example output:

```
{
    "pagination": {
        "total": 54,
        "limit": 2,
        "offset": 0,
        "total_pages": 27,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/events?page=2&limit=2"
    },
    "data": [
        {
            "id": 14191,
            "title": "Cauleen Smith and Lisa Lowe",
            "type_id": 47,
            "start_at": "2017-09-29T16:00:00-05:00",
            "end_at": "2017-09-29T17:00:00-05:00",
            "resource_id": 4,
            ...
        },
        {
            "id": 14144,
            "title": "At Home in Chicago: A Look at Historic Interiors and Social Customs",
            "type_id": 88,
            "start_at": "2017-09-20T11:00:00-05:00",
            "end_at": "2017-09-20T14:00:00-05:00",
            "resource_id": 85,
            ...
        }
    ]
}
```

### `/events/search`

Search events data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/events/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 479,
        "limit": 10,
        "offset": 0,
        "total_pages": 48,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "80613",
            "api_model": "events",
            "api_link": "http:\/\/data-aggregator.dev\/api\/v1\/events\/80613",
            "id": "membership.events.80613",
            "title": "Ullam est est",
            "timestamp": "2017-09-21T20:48:36-05:00"
        },
        {
            "_score": 1,
            "api_id": "15260",
            "api_model": "events",
            "api_link": "http:\/\/data-aggregator.dev\/api\/v1\/events\/15260",
            "id": "membership.events.15260",
            "title": "Impedit exercitationem aut",
            "timestamp": "2017-09-21T20:48:36-05:00"
        },
        {
            "_score": 1,
            "api_id": "35864",
            "api_model": "events",
            "api_link": "http:\/\/data-aggregator.dev\/api\/v1\/events\/35864",
            "id": "membership.events.35864",
            "title": "Asperiores molestiae iusto",
            "timestamp": "2017-09-21T20:48:36-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "events",
                "doc_count": 479
            }
        ]
    }
}
```

### `/events/{id}`

A single events by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/events/14156?limit=2  
Example output:

```
{
    "data": {
        "id": 14156,
        "title": "Painting and Whiteness",
        "type_id": 92,
        "start_at": "2017-09-20T11:30:00-05:00",
        "end_at": "2017-09-20T13:30:00-05:00",
        "resource_id": 81,
        ...
    }
}
```

## Members

### `/members/{id}?zip=XXX`

A single member by the given identifier. Will only provide results if a valid verification parameter is passed.

#### Available parameters:

* `zip` - The zip code matching the requested member record
* `email` - The email address matching the requested member record
* `phone` - The phone number matching the requested member record
# Mobile

## Tours

### `/tours`

A list of all tours sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#tours).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `stops`

Example request: http://aggregator-data-test.artic.edu/api/v1/tours?limit=2  
Example output:

```
{
    "pagination": {
        "total": 8,
        "limit": 2,
        "offset": 0,
        "total_pages": 4,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/tours?page=2&limit=2"
    },
    "data": [
        {
            "id": 2193,
            "title": "The Essentials Tour",
            "image": "http:\/\/aicweb10.artic.edu\/sites\/default\/files\/tour-images\/english%20%281%29.jpg",
            "description": "Discover the stories behind some of the museum\u2019s most iconic artworks.",
            "intro": "Indulge in the sunlit bank of the River Seine in Georges Seurat\u2019s \"A Sunday on La Grande Jatte\" or make a late-night stop at a New York City diner in Edward Hopper\u2019s \"Nighthawks\" in this tour of the museum\u2019s iconic collection. Founded in 1879, the Art Institute of Chicago is home to a massive collection spanning nearly all of human history. As you explore centuries of art, this tour highlights some essential landmarks\u2014with lesser known, but equally engaging artworks\u2014along the way. The soundtrack features the music of Andrew Bird, another Chicago essential.",
            "weight": null,
            ...
        },
        {
            "id": 2219,
            "title": "Visita a lo esencial",
            "image": "http:\/\/aicweb10.artic.edu\/sites\/default\/files\/tour-images\/espanol.jpg",
            "description": "Descubra las historias detr\u00e1s de algunas de las obras de arte m\u00e1s ic\u00f3nicas del museo.",
            "intro": "Disfrute el banco del R\u00edo Sena ba\u00f1ado de sol en \u201cUn domingo en La Grande Jatte\u201d de Georges Seurat o haga una parada nocturna en una cafeter\u00eda de Nueva York en \u201cNighthawks\u201d de Edward Hopper en esta visita a la ic\u00f3nica colecci\u00f3n del museo. El Art Institute of Chicago, fundado en 1879, alberga una enorme colecci\u00f3n que abarca casi toda la historia de la humanidad. A medida que explora siglos de arte, esta visita resalta algunos hitos esenciales, con obras de arte menos conocidas, pero igualmente interesantes, en todo el recorrido. La pista musical presenta la m\u00fasica de Andrew Bird, otra persona esencial en Chicago.",
            "weight": null,
            ...
        }
    ]
}
```

### `/tours/search`

Search tours data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/tours/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 108,
        "limit": 10,
        "offset": 0,
        "total_pages": 11,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "9994722",
            "api_model": "tours",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/tours\/9994722",
            "id": 9994722,
            "title": "Et aut minima",
            "timestamp": "2017-10-27T17:15:46-05:00"
        },
        {
            "_score": 1,
            "api_id": "9991187",
            "api_model": "tours",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/tours\/9991187",
            "id": 9991187,
            "title": "Amet rem veritatis",
            "timestamp": "2017-10-27T17:15:46-05:00"
        },
        {
            "_score": 1,
            "api_id": "9999687",
            "api_model": "tours",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/tours\/9999687",
            "id": 9999687,
            "title": "Nulla dolores nemo",
            "timestamp": "2017-10-27T17:15:46-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "tours",
                "doc_count": 108
            }
        ]
    }
}
```

### `/tours/{id}`

A single tours by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/tours/2280?limit=2  
Example output:

```
{
    "data": {
        "id": 2280,
        "title": "Zhang Peili: Record. Repeat.",
        "image": "http:\/\/aicweb10.artic.edu\/sites\/default\/files\/tour-images\/Untitled.jpg",
        "description": "View the career of an artist who pioneered the use of video in China.",
        "intro": "Considered the first Chinese artist to work in video, Zhang Peili is a pioneering figure in the history of contemporary art. Zhang's distinctive videos focus on the repetition of actions\u2014breaking a mirror, reading, washing, looking out the window, and dancing\u2014that are familiar yet rendered disorienting through Zhang's use of perspective, close-ups, and framing.&nbsp;This exhibition traces the development of his practice from early experiments with video in the late 1980s to new digital formats in the 2000s.",
        "weight": null,
        ...
    }
}
```

## Mobile Sounds

### `/mobile-sounds`

A list of all mobile-sounds sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#mobile-sounds).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/mobile-sounds?limit=2  
Example output:

```
{
    "pagination": {
        "total": 524,
        "limit": 2,
        "offset": 0,
        "total_pages": 262,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/mobile-sounds?page=2&limit=2"
    },
    "data": [
        {
            "id": 1536,
            "title": "Arrangement in Flesh Color and Brown: Portrait of Arthur Jerome Eddy",
            "link": "http:\/\/aicweb10.artic.edu\/sites\/default\/files\/audio\/742.mp3",
            "transcript": "&quot;Narrator:  For James McNeill Whistler, the title of a painting really mattered. \nSarah Kelly:  You&#039;ll notice that Whistler titled this portrait, &quot;Arrangement in Flesh Color and Brown,&quot; and only then has the subtitle, &quot;Portrait of Arthur Jerome Eddy.&quot; He wanted to emphasize that it was simply a chosen arrangement of line and of color, rather than Arthur Jerome Eddy. And Eddy was very much agreeable to this. \nNarrator:  Sarah Kelly, Associate Curator at the Art Institute of Chicago. \nSarah Kelly:  Arthur Jerome Eddy is a very important person to the Art Institute of Chicago. He was a Chicago lawyer, and he saw Whistler&#039;s works at the 1893 World&#039;s Columbian Exhibition here in Chicago, where Whistler actually was given center stage. And he was so impressed that he went off and asked Whistler to paint his portrait. He then went from championing Whistler to championing modern art. He became a very influential collector of modern paintings, so the core collection of German expressionist painting came from Arthur Jerome Eddy. He also published a book about modern art. So he was very influential in promoting modern art in America, and particularly in Chicago.&quot;",
            "last_updated": "2017-09-22T16:23:12-05:00",
            ...
        },
        {
            "id": 1537,
            "title": "Bust of a Youth (Saint John the Baptist?)",
            "link": "http:\/\/aicweb10.artic.edu\/sites\/default\/files\/audio\/750.mp3",
            "transcript": "&quot;&lt;music&gt;\nNarrator:  Bruce Boucher, Curator of European sculpture. \nBruce Boucher:  Francesco Mochi&#039;s Bust of a Youth is one of our signature pieces, and it is one of the most beautiful Baroque sculptures in the collection. It shows a youth, an adolescent, with corkscrew curls and drapery that suggests he may or may not be the young Saint John the Baptist. But it is a portrait of adolescence, he has a rather dreamy expression and his lips are parted as if he is about to speak, or has just said something. It&#039;s the kind of animated expression that Baroque sculptors like Mochi would use, to try to transcend the limitations of marble as a medium. \n&lt;music&gt;\nBruce Boucher:  He could carve marble like butter. And if you look at these curls, you could put your finger through them, they are really a tour de force of sculpture. What is Baroque about this, is the way in which.. the sculptor is trying to engage us in a kind of imaginary discourse with the sitter. The figure&#039;s head is turned sharply to the side, his eyes are focused, his mouth is open. There&#039;s a sense of movement about it, which distinguishes it from a Renaissance sculpture, which would probably have been much more passive and less engaged with us as spectators.&quot;",
            "last_updated": "2017-09-22T16:23:12-05:00",
            ...
        }
    ]
}
```

### `/mobile-sounds/{id}`

A single mobile-sounds by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/mobile-sounds/1545?limit=2  
Example output:

```
{
    "data": {
        "id": 1545,
        "title": "Trompe-l'Oeil Still Life with a Flower Garland and a Curtain",
        "link": "http:\/\/aicweb10.artic.edu\/sites\/default\/files\/audio\/757.mp3",
        "transcript": "&quot;Narrator:  Painted in the Netherlands in 1658, this masterly still life held a fascinating secret for many years. Curator Martha Wolff.\nMartha Wolff:  This painting is signed by Adriaen van der Spelt, a still life painter whose work is rather rare. But fairly recently, we realized that it&#039;s in fact a collaboration between van der Spelt and a more famous painter named Frans van Mieris who contributed the beautiful blue satin curtain that is drawn across part of the picture.\nNarrator:  The young artists had both just joined the Painters Gild in the City of Leiden, so this picture was probably a demonstration in their skill in the art of illusion.\nMartha Wolff:  And also a reflection of actual usage at the time, because Dutch collectors would use curtains to protect particularly exquisite pictures from light and also to give the viewer the thrill of pulling back the curtain and seeing what was displayed behind it. And you have multiple layers of illusion here because you have first the stone arch and then you have the garland that&#039;s draped in front of it, and then you have the curtain. And one of the most wonderful things is really the brass rod which plays off of the frame of the picture. It stands in front of it.&quot;",
        "last_updated": "2017-09-22T16:23:12-05:00",
        ...
    }
}
```

# Digital Scholarly Catalogs

## Publications

### `/publications`

A list of all publications sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#publications).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/publications?limit=2  
Example output:

```
{
    "pagination": {
        "total": 50,
        "limit": 2,
        "offset": 0,
        "total_pages": 25,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/publications?page=2&limit=2"
    },
    "data": [
        {
            "id": 5649,
            "title": "Molestiae iste nobis",
            "link": "http:\/\/www.mcglynn.com\/",
            "last_updated_source": "2017-03-14T15:06:34-05:00",
            "last_updated": "2017-10-16T01:15:42-05:00",
            ...
        },
        {
            "id": 1596,
            "title": "Dolorem consequatur nostrum",
            "link": "http:\/\/hudson.org\/at-quidem-tempora-quo-natus.html",
            "last_updated_source": "2016-11-21T17:52:51-06:00",
            "last_updated": "2017-10-16T01:15:42-05:00",
            ...
        }
    ]
}
```

### `/publications/search`

Search publications data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/publications/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 175,
        "limit": 10,
        "offset": 0,
        "total_pages": 18,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "782",
            "api_model": "publications",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/publications\/782",
            "id": "dsc.publications.782",
            "title": "Laudantium nostrum dolores",
            "timestamp": "2017-10-16T01:15:41-05:00"
        },
        {
            "_score": 1,
            "api_id": "5826",
            "api_model": "publications",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/publications\/5826",
            "id": "dsc.publications.5826",
            "title": "Ut accusamus ducimus",
            "timestamp": "2017-10-16T01:15:41-05:00"
        },
        {
            "_score": 1,
            "api_id": "8410",
            "api_model": "publications",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/publications\/8410",
            "id": "dsc.publications.8410",
            "title": "Quos aut voluptatem",
            "timestamp": "2017-10-16T01:15:41-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "publications",
                "doc_count": 175
            }
        ]
    }
}
```

### `/publications/{id}`

A single publications by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/publications/6566?limit=2  
Example output:

```
{
    "data": {
        "id": 6566,
        "title": "Dicta aut odit",
        "link": "http:\/\/doyle.com\/commodi-placeat-animi-itaque-dignissimos-reiciendis-nisi",
        "last_updated_source": "2017-06-27T22:30:31-05:00",
        "last_updated": "2017-10-16T01:15:42-05:00",
        ...
    }
}
```

## Sections

### `/sections`

A list of all sections sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#sections).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource

Example request: http://aggregator-data-test.artic.edu/api/v1/sections?limit=2  
Example output:

```
{
    "pagination": {
        "total": 250,
        "limit": 2,
        "offset": 0,
        "total_pages": 125,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sections?page=2&limit=2"
    },
    "data": [
        {
            "id": 4134,
            "title": "Harum exercitationem consequatur",
            "content": "Sint incidunt quis porro animi deserunt reiciendis. Enim ex et occaecati quidem quod. Commodi soluta saepe sit aut odit. Error consequatur blanditiis ullam esse doloribus. Consequatur atque ipsam voluptatum non.\n\nAb ipsum earum repellendus odit optio ratione optio earum. Sit inventore aperiam molestiae at recusandae nobis dolorem rem.\n\nPariatur ipsum illum voluptatem esse eius. Quasi expedita unde ex voluptas sed. Dolor sint et inventore. Ipsum ut ab molestiae modi qui in.\n\nRepellat dicta voluptas voluptas at ullam dignissimos at. Voluptas alias sapiente at consequatur dolor. Officia a facilis odio qui unde.\n\nSit non aliquid commodi mollitia veritatis itaque. Nihil aut ea laboriosam consequatur sed assumenda. Iure eveniet adipisci explicabo pariatur cupiditate et excepturi. Velit ad illo totam officiis labore aut porro.\n\nNecessitatibus unde eos enim. Omnis voluptatem consequatur exercitationem porro in libero. Aut qui consequatur quidem officia soluta. Nesciunt optio assumenda dolore totam voluptatem minima.\n\nSequi dolor saepe nulla facere nesciunt eius. Amet nihil nemo nulla similique ut possimus sit. Alias et ipsa eligendi amet omnis sapiente hic. Ipsam eum explicabo ut veniam deleniti perferendis.\n\nPraesentium et error praesentium rerum. Aut id vel quod est delectus. At voluptas quia incidunt quod perferendis reiciendis.\n\nUllam saepe laborum inventore accusamus aut voluptates maiores. Sit ex nemo sit nesciunt ut nostrum rem. Nam qui hic recusandae. Dicta est odit vitae odit.\n\nAb et quas dolore possimus provident corrupti. Adipisci ut et quos ipsum consequuntur consequatur.",
            "weight": 51,
            "depth": 5,
            "publication": "Repellendus eos reprehenderit",
            ...
        },
        {
            "id": 6702,
            "title": "Quo beatae in",
            "content": "Quasi in quo numquam quia minima. Explicabo cum tenetur in possimus aliquam nihil incidunt dignissimos. Sit corporis qui itaque voluptatibus.\n\nMagni id rerum voluptas minima. Deserunt alias et rerum. Illo enim possimus magnam consequuntur adipisci ut. Ut sed voluptate laudantium odit.\n\nQui ex doloribus voluptate est corrupti sunt et. Enim ex dolore qui temporibus perferendis voluptatem. Sed corrupti quae cupiditate voluptatum officiis modi libero explicabo. Sapiente sed quam ut sit deleniti.\n\nVoluptate quia dolores pariatur rerum praesentium dolor et est. Laborum ea assumenda voluptatibus quo. Quas ratione nulla eligendi harum pariatur aut repellat.\n\nVel alias rerum et magnam. Est vel repellendus quia tempora corrupti veniam veritatis. Possimus pariatur beatae voluptas autem voluptas iusto.\n\nOmnis blanditiis molestiae et corporis minus iste delectus. Consequatur in corrupti in vitae ex qui non sed. Autem eligendi nesciunt quam ipsa. Voluptatem repellat exercitationem saepe facere doloribus sed excepturi animi.\n\nEa et id ratione necessitatibus consequatur. Unde earum voluptate nesciunt totam. Quo modi at itaque asperiores enim maiores. Quo nam velit voluptatibus accusamus fuga facere quos.\n\nAb molestias optio ducimus facilis ut recusandae esse. Hic rerum molestiae molestiae expedita alias dignissimos. Omnis enim nihil odio animi dolor temporibus. Recusandae et perspiciatis voluptate dolore.\n\nRerum ab sed quam inventore. Non quos dolorum autem totam dolorem qui vel.\n\nOfficiis quia velit nesciunt nemo nesciunt ex id qui. Sint architecto molestias dolores quae vel. A accusantium facere earum architecto quam.",
            "weight": 64,
            "depth": 0,
            "publication": "Odio consequatur quia",
            ...
        }
    ]
}
```

### `/sections/search`

Search sections data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/sections/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 399,
        "limit": 10,
        "offset": 0,
        "total_pages": 40,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "4784",
            "api_model": "sections",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sections\/4784",
            "id": "dsc.sections.4784",
            "title": "Dolorem omnis aliquid",
            "timestamp": "2017-10-16T01:19:54-05:00"
        },
        {
            "_score": 1,
            "api_id": "5241",
            "api_model": "sections",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sections\/5241",
            "id": "dsc.sections.5241",
            "title": "Assumenda facere in",
            "timestamp": "2017-10-16T01:19:54-05:00"
        },
        {
            "_score": 1,
            "api_id": "108",
            "api_model": "sections",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sections\/108",
            "id": "dsc.sections.108",
            "title": "A aut assumenda",
            "timestamp": "2017-10-16T01:19:54-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "sections",
                "doc_count": 399
            }
        ]
    }
}
```

### `/sections/{id}`

A single sections by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/sections/59?limit=2  
Example output:

```
{
    "data": {
        "id": 59,
        "title": "Consequatur odit velit",
        "content": "Saepe quod debitis dignissimos rerum sint et. Rerum corrupti omnis quam consequatur quasi ratione. Aliquid ut nisi ut. Saepe voluptas alias labore labore earum ut.\n\nTempore consectetur aut non cumque. Ut fuga minima in placeat aut. Id ullam autem temporibus possimus mollitia non fugiat.\n\nEos sed sit id voluptates perspiciatis ut reprehenderit. Laborum dolor cumque occaecati rerum. Nulla blanditiis velit voluptas et.\n\nSuscipit id esse quos eveniet quidem. Nulla incidunt ea sed quas qui odio temporibus. Illo animi ipsa eligendi.\n\nQuia sit qui reiciendis dolores omnis fugiat rerum. Labore sit nam deserunt odio molestiae perferendis. Qui ut voluptatum labore veniam ab at. Laboriosam aliquid veniam blanditiis enim.\n\nRerum magni optio cupiditate placeat molestiae architecto. Dolores numquam numquam exercitationem.\n\nAb qui quos labore modi perferendis. Iure libero quia aperiam recusandae nulla. Eum et nam repellendus harum aspernatur. Omnis dolor quis sit ut.\n\nAut rerum iure perspiciatis et. Consequatur sit modi sunt ipsam qui est dolores at. Quia qui sapiente omnis inventore. Eum vitae doloremque ipsum.\n\nNatus reprehenderit libero minima omnis temporibus. Temporibus voluptatibus doloribus aliquam. Ex minus dolor itaque saepe dolorum sint. Dolorem possimus accusamus vero aspernatur.\n\nAsperiores eius nihil quis sit aliquam ipsam ut deserunt. Consectetur laborum eaque voluptate totam consequatur. Nihil officia ut debitis eveniet. Sit exercitationem enim dolorum omnis.",
        "weight": 64,
        "depth": 9,
        "publication": "Quos aut voluptatem",
        ...
    }
}
```

# Static Archive

## Sites

### `/sites`

A list of all sites sorted by last updated date in descending order. For a description of all the fields included with this response, see [here](FIELDS.md#sites).

#### Available parameters:

* `ids` - A comma-separated list of resource ids to retrieve
* `limit` - The number of resources to return per page
* `page` - The page of resources to retrieve
* `fields` - A comma-separated list of fields to return per resource
* `include` - A comma-separated list of subresource to embed in the returned resources. Available options are:
  * `artworks`

Example request: http://aggregator-data-test.artic.edu/api/v1/sites?limit=2  
Example output:

```
{
    "pagination": {
        "total": 50,
        "limit": 2,
        "offset": 0,
        "total_pages": 25,
        "current_page": 1,
        "next_url": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sites?page=2&limit=2"
    },
    "data": [
        {
            "id": 6405,
            "title": "Nostrum quia nihil",
            "description": "Quae illum aut molestias est voluptatem qui quod. Omnis assumenda similique ut itaque. Asperiores distinctio provident voluptatem rem nesciunt qui eos nesciunt. Magni est ut est sint laboriosam est quo. Et sint veniam porro minima debitis alias. Illo cupiditate culpa quas et ex.",
            "link": "http:\/\/www.cole.com\/beatae-consequatur-mollitia-ea-optio-sed.html",
            "exhibition": "Eos Natus Voluptas",
            "exhibition_id": 814315,
            ...
        },
        {
            "id": 3342,
            "title": "Sint blanditiis dolores",
            "description": "Repellendus praesentium itaque quis libero id eveniet ut. Exercitationem cum totam autem aperiam. Quis nobis quidem est ipsam. Consequuntur nam fuga pariatur laudantium repellendus aut. Iste aperiam quae voluptas et corrupti in.",
            "link": "http:\/\/www.schimmel.org\/consequatur-eos-quos-enim-exercitationem.html",
            "exhibition": "Iusto Quo Reiciendis",
            "exhibition_id": 593181,
            ...
        }
    ]
}
```

### `/sites/search`

Search sites data in the aggregator. 

#### Available parameters:

* `q` - Your search query
* `query` - For complex queries, you can pass Elasticsearch domain syntax queries here
* `sort` - Used in conjunction with `query`
* `from` - Starting point of results. Pagination via Elasticsearch conventions
* `size` - Number of results to return. Pagination via Elasticsearch conventions
* `facets` - A comma-separated list of "count" aggregation facets to include in the results.

Example request: http://aggregator-data-test.artic.edu/api/v1/sites/search  
Example output:

```
{
    "preference": null,
    "pagination": {
        "total": 125,
        "limit": 10,
        "offset": 0,
        "total_pages": 13,
        "current_page": 1
    },
    "data": [
        {
            "_score": 1,
            "api_id": "880",
            "api_model": "sites",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sites\/880",
            "id": "static-archive.sites.880",
            "title": "Animi in quod",
            "timestamp": "2017-10-16T01:30:17-05:00"
        },
        {
            "_score": 1,
            "api_id": "9424",
            "api_model": "sites",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sites\/9424",
            "id": "static-archive.sites.9424",
            "title": "Dolore qui vero",
            "timestamp": "2017-10-16T01:30:17-05:00"
        },
        {
            "_score": 1,
            "api_id": "5556",
            "api_model": "sites",
            "api_link": "http:\/\/aggregator-data-test.artic.edu\/api\/v1\/sites\/5556",
            "id": "static-archive.sites.5556",
            "title": "Sint sed illo",
            "timestamp": "2017-10-16T01:30:17-05:00"
        }
    ],
    "aggregations": {
        "count_api_model": [
            {
                "key": "sites",
                "doc_count": 125
            }
        ]
    }
}
```

### `/sites/{id}`

A single sites by the given identifier.

Example request: http://aggregator-data-test.artic.edu/api/v1/sites/2842?limit=2  
Example output:

```
{
    "data": {
        "id": 2842,
        "title": "Sequi nisi laudantium",
        "description": "Error optio corrupti consequuntur sapiente debitis. Suscipit placeat labore tempora occaecati maxime consequatur est. Delectus eum voluptatem voluptates quis. Vel qui aut exercitationem ea illum maxime nisi accusamus. Distinctio temporibus veniam vel. Repellendus officia enim necessitatibus sunt fuga. Veniam consequuntur non quisquam sit sapiente porro ipsum.",
        "link": "http:\/\/www.weissnat.net\/",
        "exhibition": "Veritatis Aliquam Dolor",
        "exhibition_id": 505739,
        ...
    }
}
```

> Generated by `php artisan docs:endpoints` on 2017-10-30 10:42:19