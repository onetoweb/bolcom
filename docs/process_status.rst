.. _top:
.. title:: Process Status

`Back to index <index.rst>`_

==============
Process Status
==============

.. contents::
    :local:


Get process status
``````````````````

.. code-block:: php
    
    $result = $client->processStatus->get([
        'entity-id' => '987654321',
        'event-type' => 'CONFIRM_SHIPMENT',
        'page' => 1
    ]);


Get multiple process statuses by id
```````````````````````````````````

.. code-block:: php
    
    // array with process status id's
    $processStatusIds = [
        '987654321'
    ];
    $result = $client->processStatus->getMultiple($processStatusIds);


Get process status by id
````````````````````````

.. code-block:: php
    
    $id = '987654321';
    $result = $client->processStatus->getById($id);


`Back to top <#top>`_