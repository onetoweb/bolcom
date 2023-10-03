.. _top:
.. title:: Product Content

`Back to index <index.rst>`_

===============
Product Content
===============

.. contents::
    :local:


Get catalog product details by EAN
``````````````````````````````````

.. code-block:: php
    
    $ean = '0842776106209';
    $result = $client->productContent->getByEan($ean);


Get chunk recommendations
`````````````````````````

.. code-block:: php
    
    $result = $client->productContent->getChunkRecommendations([
        'productContents' => [[
            'attributes' => [
                [
                    'id' => 'Name',
                    'values' => [[
                        'value' => 'Google Chromecast 3'
                    ]]
                ], [
                    'id' => 'Description',
                    'values' => [[
                        'value' => 'De Chromecast is een compacte media player waarmee je gemakkelijk muziek, films en internetpagina\'s vanaf je smartphone, tablet of laptop op je televisie kan streamen.'
                    ]]
                ]
            ]
        ]]
    ]);


Create content for a product
````````````````````````````

.. code-block:: php
    
    $result = $client->productContent->create([
        'language' => 'nl',
        'attributes' => [
            [
                'id' => 'EAN',
                'values' => [
                    [
                        'value' => '0811571018314'
                    ]
                ]
            ], [
                'id' => 'Weight',
                'values' => [
                    [
                        'value' => '13.7',
                        'unitId' => 'mm'
                    ]
                ]
            ]
        ],
        'assets' => [
            [
                'url' => 'https://www.example.com/image.jpg',
                'labels' => [
                    'FRONT'
                ]
            ]
        ]
    ]);


Get an upload report by upload id
`````````````````````````````````

.. code-block:: php
    
    $uploadId = '3f2cc9f9-79de-472c-aeb7-fef416b77928';
    $result = $client->productContent->getUploadReport($uploadId);


`Back to top <#top>`_