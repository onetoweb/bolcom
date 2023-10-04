.. _top:
.. title:: Transports

`Back to index <index.rst>`_

==========
Transports
==========

.. contents::
    :local:


Add transport information by transport id
`````````````````````````````````````````

.. code-block:: php
    
    $transportId = '358612589';
    $result = $client->transports->update($transportId, [
        'transporterCode' => 'TNT',
        'trackAndTrace' => '3SAOLD1234567'
    ]);


`Back to top <#top>`_