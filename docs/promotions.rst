.. _top:
.. title:: Promotions

`Back to index <index.rst>`_

==========
Promotions
==========

.. contents::
    :local:


Get a list of promotions
````````````````````````

.. code-block:: php
    
    $result = $client->promotions->get([
        'promotion-type' => 'AWARENESS',
        'page' => 1,
    ]);


Get a promotion by promotion id
```````````````````````````````

.. code-block:: php
    
    $promotionId = '533736';
    $result = $client->promotions->getById($promotionId);


Get a list of products
``````````````````````

.. code-block:: php
    
    $promotionId = '544860';
    $result = $client->promotions->getProductsById($promotionId, [
        'page' => 1
    ]);


`Back to top <#top>`_