.. _top:
.. title:: Inventory

`Back to index <index.rst>`_

=========
Inventory
=========

.. contents::
    :local:


Get inventory
`````````````

.. code-block:: php
    
    $result = $client->inventory->get([
        'page' => 1,
        'quantity' => 0,
        'stock' => 'SUFFICIENT',
        'state' => 'REGULAR',
        'query' => '0000007740404'
    ]);


`Back to top <#top>`_