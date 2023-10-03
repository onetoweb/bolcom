.. _top:
.. title:: Orders

`Back to index <index.rst>`_

======
Orders
======

.. contents::
    :local:


Get a list of orders
````````````````````

.. code-block:: php
    
    $result = $client->orders->get([
        'page' => 1,
        'fulfilment-method' => 'FBR',
        'status' => 'OPEN',
        'change-interval-minute' => 60,
    ]);


Cancel an order item by an order item id
````````````````````````````````````````

.. code-block:: php
    
    $result = $client->orders->cancelOrderItem([
        'orderItems' => [
            [
                'orderItemId' => '6107434013',
                'reasonCode' => 'OUT_OF_STOCK'
            ]
        ]
    ]);


Get an order by order id
````````````````````````

.. code-block:: php
    
    $orderId = '1042823870';
    $result = $client->orders->getById($orderId);


`Back to top <#top>`_