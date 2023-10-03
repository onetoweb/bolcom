.. _top:
.. title:: Invoices

`Back to index <index.rst>`_

========
Invoices
========

.. contents::
    :local:


Get invoices
````````````

.. code-block:: php
    
    $result = $client->invoices->get([
        'period-start-date' => '2019-03-01',
        'period-end-date' => '2019-03-31'
    ]);


Get an invoice by invoice id
````````````````````````````

.. code-block:: php
    
    $invoiceId = '4500022543921';
    $result = $client->invoices->getById($invoiceId);


Get an invoice specification by invoice id
``````````````````````````````````````````

.. code-block:: php
    
    $invoiceId = '4500022543921';
    $result = $client->invoices->getSpecificationById($invoiceId);


`Back to top <#top>`_