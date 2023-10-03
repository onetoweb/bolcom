.. _top:
.. title:: Offers

`Back to index <index.rst>`_

======
Offers
======

.. contents::
    :local:


Create a new offer
``````````````````

.. code-block:: php
    
    $result = $client->offers->create([
        'ean' => '0000007740404',
        'condition' => [
            'name' => 'AS_NEW',
            'category' => 'SECONDHAND',
            'comment' => 'Heeft een koffie vlek op de kaft.'
        ],
        'reference' => 'REF12345',
        'onHoldByRetailer' => false,
        'unknownProductTitle' => 'Unknown Product Title',
        'pricing' => [
            'bundlePrices' => [
                [
                    'quantity' => 1,
                    'unitPrice' => 9.99
                ]
            ]
        ],
        'stock' => [
            'amount' => 6,
            'managedByRetailer' => false
        ],
        'fulfilment' => [
            'method' => 'FBR',
            'deliveryCode' => '24uurs-23'
        ]
    ]);


Request an offer export file
````````````````````````````

.. code-block:: php
    
    $result = $client->offers->export([
        'format' => 'CSV'
    ]);


Retrieve an offer export file by report id
``````````````````````````````````````````

.. code-block:: php
    
    $reportId = '2d8599c8-b214-448f-961e-783d7f0c8c3d';
    $result = $client->offers->exportByReportId($reportId);


Request an unpublished offer report
```````````````````````````````````

.. code-block:: php
    
    $result = $client->offers->getUnpublished([
        'format' => 'CSV'
    ]);


Retrieve an unpublished offer report by report id
`````````````````````````````````````````````````

.. code-block:: php
    
    $offerId = '3f2bb9f5-79dd-472c-aeb7-fef416b77928';
    $result = $client->offers->getUnpublishedById($offerId);


Retrieve an offer by its offer id
`````````````````````````````````

.. code-block:: php
    
    $offerId = '13722de8-8182-d161-5422-4a0a1caab5c8';
    $result = $client->offers->getById($offerId);


Update an offer
```````````````

.. code-block:: php
    
    $offerId = '13722de8-8182-d161-5422-4a0a1caab5c8';
    $result = $client->offers->update($offerId, [
        'reference' => 'REF12345',
        'onHoldByRetailer' => false,
        'unknownProductTitle' => 'Unknown Product Title',
        'fulfilment' => [
            'method' => 'FBR',
            'deliveryCode' => '24uurs-23'
        ]
    ]);


Delete offer by id
``````````````````

.. code-block:: php
    
    $offerId = '13722de8-8182-d161-5422-4a0a1caab5c8';
    $result = $client->offers->delete($offerId);


Update price(s) for offer by id
```````````````````````````````

.. code-block:: php
    
    $offerId = '13722de8-8182-d161-5422-4a0a1caab5c8';
    $result = $client->offers->updatePrice($offerId, [
        'pricing' => [
            'bundlePrices' => [[
                'quantity' => 1,
                'unitPrice' => 9.99
            ]]
        ]
    ]);


Update stock for offer by id
````````````````````````````

.. code-block:: php
    
    $offerId = '13722de8-8182-d161-5422-4a0a1caab5c8';
    $result = $client->offers->updateStock($offerId, [
        'amount' => 6,
        'managedByRetailer' => false
    ]);


`Back to top <#top>`_