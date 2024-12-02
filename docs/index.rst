.. title:: Index

===========
Basic Usage
===========

Setup client

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\Bolcom\Client;
    
    // params
    $clientId = 'client_id';
    $secret = 'secret';
    
    // optional params
    $version = 10;
    $demo = false;
    
    // get client
    $client = new Client($clientId, $secret, $version, $demo);
    
    // set limit reached callBack
    $client->setLimitReachedCallBack(function(int $seconds) {
        sleep($seconds);
    });


=========
Endpoints
=========

You can use one of the built in endpoints see examples below:

* `Commission <commission.rst>`_
* `Insights <insights.rst>`_
* `Inventory <inventory.rst>`_
* `Invoices <invoices.rst>`_
* `Offers <offers.rst>`_
* `Orders <orders.rst>`_
* `Process Status <process_status.rst>`_
* `Product Content <product_content.rst>`_
* `Products <products.rst>`_
* `Promotions <promotions.rst>`_
* `Replenishments <replenishments.rst>`_
* `Retailers <retailers.rst>`_
* `Returns <returns.rst>`_
* `Shipments <shipments.rst>`_
* `Shipping Labels <shipping_labels.rst>`_
* `Subscriptions <subscriptions.rst>`_
* `Transports <transports.rst>`_
