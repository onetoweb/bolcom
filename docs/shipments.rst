.. _top:
.. title:: Shipments

`Back to index <index.rst>`_

=========
Shipments
=========

.. contents::
    :local:


Get shipment list
`````````````````

.. code-block:: php
    
    $result = $client->shipments->get([
        'page' => 1,
        'fulfilment-method' => 'FBR',
    ]);


Create a shipment
`````````````````

.. code-block:: php
    
    $result = $client->shipments->create([
        'orderItems' => [
            [
                'orderItemId' => '6107331383',
                'quantity' => 1
            ],
            [
                'orderItemId' => '6107331307',
                'quantity' => 3
            ]
        ],
        'transport' => [
            'transporterCode' => 'TNT',
            'trackAndTrace' => '3SBOLD1234567'
        ]
    ]);


Get a list of invoice requests
``````````````````````````````

.. code-block:: php
    
    $result = $client->shipments->getInvoicesRequests([
        'shipment-id' => '544644695',
    ]);


Upload an invoice for shipment id
`````````````````````````````````

.. code-block:: php
    
    $result = $client->shipments->getInvoicesRequests([
        'shipment-id' => '544644695',
    ]);


Get a shipment by shipment id
`````````````````````````````

.. code-block:: php
    
    $shipmentId = '953992381';
    $result = $client->shipments->getById($shipmentId);


`Back to top <#top>`_