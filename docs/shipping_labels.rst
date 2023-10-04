.. _top:
.. title:: Shipping Labels

`Back to index <index.rst>`_

===============
Shipping Labels
===============

.. contents::
    :local:


Create a shipping label
```````````````````````

.. code-block:: php
    
    $result = $client->shippingLabels->create([
        'orderItems' => [
            [
                'orderItemId' => '2095052647',
                'quantity' => 3
            ]
        ],
        'shippingLabelOfferId' => '8f956bfc-fabe-45b4-b0e1-1b52a0896b74'
    ]);


Get delivery options
````````````````````

.. code-block:: php
    
    $result = $client->shippingLabels->getDeliveryOptions([
        'orderItems' => [
            [
                'orderItemId' => '2095052647',
                'quantity' => 1
            ]
        ]
    ]);


Get a shipping label
````````````````````

.. code-block:: php
    
    $shippingLabelId = 'c628ba4f-f31a-4fac-a6a0-062326d0dbbd';
    $result = $client->shippingLabels->getById($shippingLabelId);


`Back to top <#top>`_