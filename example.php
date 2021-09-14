<?php

require 'vendor/autoload.php';

Symfony\Component\ErrorHandler\Debug::enable();

use Onetoweb\Bolcom\Client;

// params
$clientId = 'client_id';
$secret = 'secret';

// get client
$client = new Client($clientId, $secret);

// set limit reached callBack
$client->setLimitReachedCallBack(function(int $seconds) {
    sleep($seconds);
});


/**
 * Example requests
 * 
 * @see https://api.bol.com/retailer/public/redoc/v5
 */

// get commissions (bulk)
// https://api.bol.com/retailer/public/redoc/v5#operation/get-commissions
$commissions = $client->post('/retailer/commission', [
    'commissionQueries' => [[
        'ean' => '0000007740404',
        'condition' => 'NEW',
        'unitPrice' => 59
    ]]
]);

// get commission
// https://api.bol.com/retailer/public/redoc/v5#operation/get-commission
$ean = '0000007740404';
$commission = $client->get("/retailer/commission/$ean", [
    'unit-price' => 59
]);

// get insights offer
// https://api.bol.com/retailer/public/redoc/v5#operation/get-offer-insights
$insightsOffer = $client->get('/retailer/insights/offer', [
    'offer-id' => '00000000-0000-0000-0000-000000000000',
    'period' => 'MONTH',
    'number-of-periods' => 24,
    'name' => 'PRODUCT_VISITS, BUY_BOX_PERCENTAGE',
    
]);

// get performance indicators
// https://api.bol.com/retailer/public/redoc/v5#operation/get-performance-indicator
$performanceIndicators = $client->get('/retailer/insights/performance/indicator', [
    'name' => 'CANCELLATIONS, FULFILMENT, RETURNS',
    'year' => '2021',
    'week' => '01'
]);

// get sales forecast
// https://api.bol.com/retailer/public/redoc/v5#operation/get-sales-forecast
$salesForecast = $client->get('/retailer/insights/sales-forecast', [
    'offer-id' => '00000000-0000-0000-0000-000000000000',
    'weeks-ahead' => 12
]);

// get inventory
// https://api.bol.com/retailer/public/redoc/v5#operation/get-inventory
$inventory = $client->get('/retailer/inventory');

// get invoices
// https://api.bol.com/retailer/public/redoc/v5#operation/get-invoices
$invoices = $client->get('/retailer/invoices');

// get invoice
// https://api.bol.com/retailer/public/redoc/v5#operation/get-invoice
$invoiceId = '1000000000000';
$invoice = $client->get("/retailer/invoices/$invoiceId");

// get invoice specification
// https://api.bol.com/retailer/public/redoc/v5#operation/get-invoice-specification
$invoiceId = '1000000000000';
$invoiceSpecification = $client->get("/retailer/invoices/$invoiceId/specification");

// create a new offer
// https://api.bol.com/retailer/public/redoc/v5#operation/post-offer
$processStatus = $client->post('/retailer/offers', [
    'ean' => '0000007740404',
    'condition' => [
        'name' => 'AS_NEW',
        'category' => 'SECONDHAND',
        'comment' => ''
    ],
    'pricing' => [
        'bundlePrices' => [[
            'quantity' => 1,
            'unitPrice' => 9.99
        ]]
    ],
    'stock' => [
        'amount' => 1,
        'managedByRetailer' => false,
    ],
    'fulfilment' => [
        'method' => 'FBB'
    ]
]);

// request an offer export file
// https://api.bol.com/retailer/public/redoc/v5#operation/post-offer-export
$processStatus = $client->post('/retailer/offers/export', [
    'format' => 'CSV'
]);

// get order export
// https://api.bol.com/retailer/public/redoc/v5#operation/get-offer-export
$reportId = '00000000-0000-0000-0000-000000000000';
$offerExport = $client->get("/retailer/offers/export/$reportId");
file_put_contents('/path/to/filename.csv', $offerExport);

// get offer
// https://api.bol.com/retailer/public/redoc/v5#operation/get-offer
$offerId = '00000000-0000-0000-0000-000000000000';
$offer = $client->get("/retailer/offers/$offerId");

// update offer
// https://api.bol.com/retailer/public/redoc/v5#operation/put-offer
$offerId = '00000000-0000-0000-0000-000000000000';
$processStatus = $client->put("/retailer/offers/$offerId", [
    'reference' => 'REF12345',
    'fulfilment' => [
        'method' => 'FBB'
    ]
]);

// delete offer
// https://api.bol.com/retailer/public/redoc/v5#operation/delete-offer
$offerId = '00000000-0000-0000-0000-000000000000';
$processStatus = $client->delete("/retailer/offers/$offerId");

// update offer price
// https://api.bol.com/retailer/public/redoc/v5#operation/update-offer-price
$offerId = '00000000-0000-0000-0000-000000000000';
$processStatus = $client->put("/retailer/offers/$offerId/price", [
    'pricing' => [
        'bundlePrices' => [[
            'quantity' => 1,
            'unitPrice' => 8.99
        ]]
    ],
]);

// update offer stock
// https://api.bol.com/retailer/public/redoc/v5#operation/update-offer-stock
$offerId = '00000000-0000-0000-0000-000000000000';
$processStatus = $client->put("/retailer/offers/$offerId/stock", [
    'amount' => 2,
    'managedByRetailer' => false
]);

// get orders
// https://api.bol.com/retailer/public/redoc/v5#operation/get-orders
$orders = $client->get('/retailer/orders', [
    'status' => 'ALL'
]);

// cancel order item
// https://api.bol.com/retailer/public/redoc/v5#operation/cancel-order-item
$processStatus = $client->put('/retailer/orders/cancellation', [
    'orderItems' => [[
        'orderItemId' => '2012345678',
        'reasonCode' => 'BAD_CONDITION'
    ]]
]);

// ship order item
// https://api.bol.com/retailer/public/redoc/v5#operation/ship-order-item
$processStatus = $client->put('/retailer/orders/shipment', [
    'orderItems' => [[
        'orderItemId' => '2012345678'
    ]],
    'shipmentReference' => 'B321SR',
    'shippingLabelId' => '00000000-0000-0000-0000-000000000000',
    'transport' => [
        'transporterCode' => 'TNT',
        'trackAndTrace' => '3SBOL0987654321'
    ]
]);

// get order
// https://api.bol.com/retailer/public/redoc/v5#operation/get-order
$orderId = 'A2K8290LP8';
$order = $client->get("/retailer/orders/$orderId");

// get process statuses for entity
// https://api.bol.com/retailer/public/redoc/v5#operation/get-process-status-entity-id
$processStatuses = $client->get('retailer/process-status', [
    'entity-id' => '00000000-0000-0000-0000-000000000000',
    'event-type' => 'CREATE_OFFER'
]);

// get process statuses (bulk)
// https://api.bol.com/retailer/public/redoc/v5#operation/get-process-status-bulk
$processStatuses = $client->post('/retailer/process-status', [
    'processStatusQueries' => [
        [
            'processStatusId' => '1234567'
        ], [
            'processStatusId' => '1234568'
        ]
    ]
]);

// get process status
// https://api.bol.com/retailer/public/redoc/v5#operation/get-process-status
$processStatusId = '1234567';
$processStatus = $client->get("/retailer/process-status/$processStatusId");

// create product content
// https://api.bol.com/retailer/public/redoc/v5#operation/post-product-content
$processStatus = $client->post('/retailer/content/product', [
    'language' => 'nl',
    'productContents' => [[
        'internalReference' => 'USER-REFERENCE',
        'attributes' => [[
            'id' => 'width',
            'values' => [[
                'value' => '14.5',
                'unitId' => 'mm'
            ]],
        ]]
    ]]
]);

// get validation report
// https://api.bol.com/retailer/public/redoc/v5#operation/get-validation-report
$uploadId = '00000000-0000-0000-0000-000000000000';
$validationReport = $client->get("/retailer/content/validation-report/$uploadId");

// get replenishments
// https://api.bol.com/retailer/public/redoc/v5#operation/get-replenishments
$replenishments = $client->get('/retailer/replenishments');

// create replenishment
// https://api.bol.com/retailer/public/redoc/v5#operation/post-replenishment
$replenishments = $client->post('/retailer/replenishments', [
    'reference' => 'REFERENCE1',
    'deliveryInfo' => [
        'expectedDeliveryDate' => '2022-01-01',
        'transporterCode' => 'POSTNL'
    ],
    'labelingByBol' => false,
    'numberOfLoadCarriers' => 1,
    'lines' => [[
        'ean' => '0000007740404',
        'quantity' => 1
    ]]
]);

// create pickup time slots
// https://api.bol.com/retailer/public/redoc/v5#operation/post-pickup-time-slots
$pickupTimeSlots = $client->post('/retailer/replenishments/pickup-time-slots', [
    'address' => [
        'streetName' => 'Dorpstraat',
        'houseNumber' => '1',
        'houseNumberExtension' => 'B',
        'zipCode' => '1111ZZ',
        'city' => 'Utrecht',
        'countryCode' => 'NL'
    ],
    'numberOfLoadCarriers' => 1
]);

// created product labels
// https://api.bol.com/retailer/public/redoc/v5#operation/post-product-labels
$productLabels = $client->post('/retailer/replenishments/product-labels', [
    'labelFormat' => 'AVERY_J8159',
    'products' => [[
        'ean' => '0000007740404',
        'quantity' => 1
    ]]
]);

// get replenishment
// https://api.bol.com/retailer/public/redoc/v5#operation/get-replenishment
$replenishmentId = '2312078154';
$replenishment = $client->get("/retailer/replenishments/$replenishmentId");

// update replenishment
// https://api.bol.com/retailer/public/redoc/v5#operation/put-replenishment
$replenishmentId = '2312078154';
$processStatus = $client->put("/retailer/replenishments/$replenishmentId", [
    'state' => 'CANCELLED'
]);

// get load carrier labels
// https://api.bol.com/retailer/public/redoc/v5#operation/get-load-carrier-labels
$replenishmentId = '2312078154';
$loadCarrierLabels = $client->get('/retailer/replenishments/$replenishmentId/load-carrier-labels', [
    'label-type' => 'WAREHOUSE',
]);
file_put_contents('/path/to/filename.pdf', $loadCarrierLabels);

// get pick list
// https://api.bol.com/retailer/public/redoc/v5#operation/get-pick-list
$replenishmentId = '2312078154';
$pickList = $client->get("/retailer/replenishments/$replenishmentId/pick-list");
file_put_contents('/path/to/filename.pdf', $pickList);

// get returns
// https://api.bol.com/retailer/public/redoc/v5#operation/get-returns
$returns = $client->get('/retailer/returns');

// create return
// https://api.bol.com/retailer/public/redoc/v5#operation/create-return
$processStatus = $client->post('/retailer/returns', [
    'orderItemId' => '2012345678',
    'quantityReturned' => 1,
    'handlingResult' => 'RETURN_RECEIVED'
]);

// get return
// https://api.bol.com/retailer/public/redoc/v5#operation/get-return
$returnId = '1';
$return = $client->get("/retailer/returns/$returnId");

// handle a return
// https://api.bol.com/retailer/public/redoc/v5#operation/handle-return
$rmaId = 1;
$processStatus = $client->put("/retailer/returns/$rmaId", [
    'handlingResult' => 'RETURN_RECEIVED',
    'quantityReturned' => 1
]);

// get shipments
// https://api.bol.com/retailer/public/redoc/v5#operation/get-shipments
$shipments = $client->get('/retailer/shipments');

// get shipment
// https://api.bol.com/retailer/public/redoc/v5#operation/get-shipment
$shipmentId = '541757635';
$shipments = $client->get("/retailer/shipments/$shipmentId");

// create shiping label
// https://api.bol.com/retailer/public/redoc/v5#operation/post-shipping-label
$processStatus = $client->post('/retailer/shipping-labels', [
    'orderItems' => [[
        'orderItemId' => '2012345678'
    ]],
    'shippingLabelOfferId' => '00000000-0000-0000-0000-000000000000'
]);

// get delivery options
// https://api.bol.com/retailer/public/redoc/v5#operation/get-delivery-options
$deliveryOptions = $client->post('/retailer/shipping-labels/delivery-options', [
    'orderItems' => [[
        'orderItemId' => '2012345678'
    ]],
]);

// get shipping label
// https://api.bol.com/retailer/public/redoc/v5#operation/get-shipping-label
$shippingLabelId = '00000000-0000-0000-0000-000000000000';
$shippingLabel = $client->get("/retailer/shipping-labels/$shippingLabelId");
file_put_contents('/path/to/filename.pdf', $shippingLabel);

// add transport information
// https://api.bol.com/retailer/public/redoc/v5#operation/add-transport-information-by-transport-id
$transportId = '987654321';
$processStatus = $client->put("/retailer/transports/$transportId", [
    'transporterCode' => 'TNT',
    'trackAndTrace' => '3SBOL0987654321'
]);
