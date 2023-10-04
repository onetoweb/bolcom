.. _top:
.. title:: Returns

`Back to index <index.rst>`_

=======
Returns
=======

.. contents::
    :local:


Get returns
```````````

.. code-block:: php
    
    $result = $client->returns->get([
        'page' => 1,
        'handled' => true,
        'fulfilment' => 'FBR'
    ]);


Create a return
```````````````

.. code-block:: php
    
    $result = $client->returns->create([
        'orderItemId' => 1044796550,
        'quantityReturned' => 1,
        'handlingResult' => 'RETURN_RECEIVED'
    ]);


Get a return by return id
`````````````````````````

.. code-block:: php
    
    $returnId = '15892026';
    $result = $client->returns->getById($returnId);


Handle a return by rma id
`````````````````````````

.. code-block:: php
    
    $rmaId = '86129741';
    $result = $client->returns->handleByRmaId($rmaId, [
        'handlingResult' => 'RETURN_RECEIVED',
        'quantityReturned' => 3
    ]);


`Back to top <#top>`_