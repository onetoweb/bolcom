.. _top:
.. title:: Subscriptions

`Back to index <index.rst>`_

=============
Subscriptions
=============

.. contents::
    :local:


Retrieve Event Notification Subscriptions
`````````````````````````````````````````

.. code-block:: php
    
    $result = $client->subscriptions->get();


Create Event Notification Subscription
``````````````````````````````````````

.. code-block:: php
    
    $result = $client->subscriptions->create([
        'resources' => [
            'PROCESS_STATUS'
        ],
        'url' => 'https://www.example.com/push',
        'subscriptionType' => 'WEBHOOK'
    ]);


Retrieve public keys for push notification signature validation
```````````````````````````````````````````````````````````````

.. code-block:: php
    
    $result = $client->subscriptions->getSignatureKeys();


Send test push notification for subscriptions
`````````````````````````````````````````````

.. code-block:: php
    
    $subscriptionId = '54321';
    $result = $client->subscriptions->test($subscriptionId);


Retrieve Specific Event Notification Subscription
`````````````````````````````````````````````````

.. code-block:: php
    
    $subscriptionId = '1234';
    $result = $client->subscriptions->getById($subscriptionId);


Update Event Notification Subscription
``````````````````````````````````````

.. code-block:: php
    
    $subscriptionId = '1234';
    $result = $client->subscriptions->update($subscriptionId, [
        'resources' => [
            'PROCESS_STATUS'
        ],
        'url' => 'https://www.example.com/push',
        'subscriptionType' => 'WEBHOOK'
    ]);


Remove Event Notification Subscription
``````````````````````````````````````

.. code-block:: php
    
    $subscriptionId = '1234';
    $result = $client->subscriptions->delete($subscriptionId);


`Back to top <#top>`_