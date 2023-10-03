.. _top:
.. title:: Products

`Back to index <index.rst>`_

========
Products
========

.. contents::
    :local:


Get product list
````````````````

.. code-block:: php
    
    $result = $client->products->get([
        'countryCode' => 'NL',
        'searchTerm' => 'laptop',
        'categoryId' => '4770',
        'filterRanges' => [
            [
                'rangeId' => 'PRICE',
                'min' => 0,
                'max' => 0
            ]
        ],
        'filterValues' => [
            [
                'filterValueId' => '30639'
            ]
        ],
        'sort' => 'RELEVANCE',
        'page' => 1
    ]);


Get product list filters
````````````````````````

.. code-block:: php
    
    $result = $client->products->getListFilters([
        'category-id' => '10505',
    ]);


Get product assets
``````````````````

.. code-block:: php
    
    $ean = '5035223124276';
    $result = $client->products->getAssetsByEan($ean);


Get a list of competing offers by EAN
`````````````````````````````````````

.. code-block:: php
    
    $ean = '9789463160315';
    $result = $client->products->getCompetingOffersByEan($ean, [
        'page' => 1,
        'country-code' => 'NL',
        'best-offer-only' => false,
        'condition' => 'ALL'
    ]);


Get product placement
`````````````````````

.. code-block:: php
    
    $ean = '4042448804839';
    $result = $client->products->getPlacementByEan($ean, [
        'country-code' => 'NL'
    ]);


Get price star boundaries by EAN
````````````````````````````````

.. code-block:: php
    
    $ean = '8719743071568';
    $result = $client->products->getPriceStarBoundariesByEan($ean);


Get product ids by EAN
``````````````````````

.. code-block:: php
    
    $ean = '8712836327641';
    $result = $client->products->getIdsByEan($ean);


Get product ratings
```````````````````

.. code-block:: php
    
    $ean = '5030917181740';
    $result = $client->products->getRatingsByEan($ean);


`Back to top <#top>`_