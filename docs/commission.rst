.. _top:
.. title:: Commission

`Back to index <index.rst>`_

==========
Commission
==========

.. contents::
    :local:


Get all commissions and reductions by EAN in bulk
`````````````````````````````````````````````````

.. code-block:: php
    
    $result = $client->commission->getCommissionBulk([
        'commissionQueries' => [[
            'ean' => '0000007740404',
            'condition' => 'NEW',
            'unitPrice' => 59
        ]]
    ]);


Get all commissions and reductions by EAN per single EAN
````````````````````````````````````````````````````````

.. code-block:: php
    
    $ean = '0000007740404';
    $result = $client->commission->getCommission($ean, [
        'condition' => 'NEW',
        'unit-price' => 59
    ]);


`Back to top <#top>`_