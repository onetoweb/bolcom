.. _top:
.. title:: Replenishments

`Back to index <index.rst>`_

==============
Replenishments
==============

.. contents::
    :local:


Get replenishments
``````````````````

.. code-block:: php
    
    $result = $client->replenishments->get([
        'ean' => '0000007740404',
        'start-date' => '2021-01-01',
        'end-date' => '2021-01-02',
        'state' => 'ANNOUNCED',
        'page' => 1,
    ]);


Create a replenishment
``````````````````````

.. code-block:: php
    
    $result = $client->replenishments->create([
        'reference' => 'MYREF02',
        'pickupAppointment' => [
            'address' => [
                'streetName' => 'Utrechtseweg',
                'houseNumber' => '99',
                'zipCode' => '3702 AA',
                'city' => 'Zeist',
                'countryCode' => 'NL',
                'attentionOf' => 'Station'
            ],
            'pickupTimeSlot' => [
                'fromDateTime' => '2024-01-21T09:30:00+01:00',
                'untilDateTime' => '2024-01-21T11:30:00+01:00'
            ],
            'commentToTransporter' => 'Custom reference'
        ],
        'labelingByBol' => false,
        'numberOfLoadCarriers' => 1,
        'lines' => [
            [
                'ean' => '0846127026185',
                'quantity' => 1
            ]
        ]
    ]);


Get delivery dates
``````````````````

.. code-block:: php
    
    $result = $client->replenishments->getDeliveryDates();


Post pickup time slots
``````````````````````

.. code-block:: php
    
    $result = $client->replenishments->createPickupTimeSlots([
        'address' => [
            'streetName' => 'Utrechtseweg',
            'houseNumber' => '99',
            'houseNumberExtension' => 'A',
            'zipCode' => '3702 AA',
            'city' => 'Zeist',
            'countryCode' => 'NL'
        ],
        'numberOfLoadCarriers' => 2
    ]);


Request product destinations
````````````````````````````

.. code-block:: php
    
    $result = $client->replenishments->getProductDestinations([
        'eans' => [
            [
                'ean' => '9781529105100'
            ], [
                'ean' => '9318478007195'
            ]
        ]
    ]);


Get product destinations by product destinations id
```````````````````````````````````````````````````

.. code-block:: php
    
    $productDestinationsId = '6f0d7145-543e-4320-afb7-f43dd69b04dc';
    $result = $client->replenishments->getProductDestinationsByDestinationsId($productDestinationsId);


Post product labels
```````````````````

.. code-block:: php
    
    $result = $client->replenishments->createProductLabels( [
        'labelFormat' => 'AVERY_J8159',
        'products' => [
            [
                'ean' => '0846127026185',
                'quantity' => 5
            ],
            [
                'ean' => '8716393000627',
                'quantity' => 2
            ]
        ]
    ]);


Get a replenishment by replenishment id
```````````````````````````````````````

.. code-block:: php
    
    $replenishmentId = '2312208179';
    $result = $client->replenishments->getById($replenishmentId);


Update a replenishment by replenishment id
``````````````````````````````````````````

.. code-block:: php
    
    $replenishmentId = '2312208179';
    $result = $client->replenishments->update($replenishmentId, [
        'deliveryInfo' => [
            'expectedDeliveryDate' => '2024-01-29'
        ]
    ]);


Get load carrier labels
```````````````````````

.. code-block:: php
    
    $replenishmentId = '2312208179';
    $result = $client->replenishments->getLoadCarrierLabelsById($replenishmentId);


Get pick list
`````````````

.. code-block:: php
    
    $replenishmentId = '2312208179';
    $result = $client->replenishments->getPickListById($replenishmentId);


`Back to top <#top>`_