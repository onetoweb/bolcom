.. _top:
.. title:: Insights

`Back to index <index.rst>`_

========
Insights
========

.. contents::
    :local:


Get offer insights
``````````````````

.. code-block:: php
    
    $result = $client->insights->getOfferInsights([
        'offer-id' => '7aec42a4-8c2b-4c38-ac3c-5e5a3f54341e',
        'period' => 'MONTH',
        'number-of-periods' => 24,
        'name' => 'PRODUCT_VISITS'
    ]);


Get performance indicators
``````````````````````````

.. code-block:: php
    
    $result = $client->insights->getPerformanceIndicators([
        'name' => 'CANCELLATIONS',
        'year' => 2023,
        'week' => 10
    ]);


Get sales forecast
``````````````````

.. code-block:: php
    
    $result = $client->insights->getSalesForecast([
        'offer-id' => '91c28f60-ed1d-4b85-e053-828b620a4ed5',
        'weeks-ahead' => 12
    ]);


Get search terms
````````````````

.. code-block:: php
    
    $result = $client->insights->getSearchTerms([
        'search-term' => 'Mondkapje',
        'period' => 'WEEK',
        'number-of-periods' => 2,
        'related-search-terms' => false
    ]);


`Back to top <#top>`_