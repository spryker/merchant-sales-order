<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantSalesOrder\Business;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MerchantOrderCollectionTransfer;
use Generated\Shared\Transfer\MerchantOrderCriteriaTransfer;
use Generated\Shared\Transfer\MerchantOrderTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer;

interface MerchantSalesOrderFacadeInterface
{
    /**
     * Specification:
     * - Requires OrderTransfer.idSalesOrder.
     * - Requires OrderTransfer.orderReference.
     * - Requires OrderTransfer.items.
     * - Iterates through the order items of given order looking for merchant reference presence.
     * - Skips all the order items without merchant reference.
     * - Creates a new merchant order for each unique merchant reference found.
     * - Creates a new merchant order item for each order item with merchant reference and assign it to a merchant order accordingly.
     * - Creates a new merchant order totals and assign it to a merchant order accordingly.
     * - Returns a collection of merchant orders filled with merchant order items and merchant order totals.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantOrderCollectionTransfer
     */
    public function createMerchantOrderCollection(OrderTransfer $orderTransfer): MerchantOrderCollectionTransfer;

    /**
     * Specification:
     * - Finds all the merchant orders using MerchantOrderCriteriaTransfer.
     * - Returns a collection of found merchant orders.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantOrderCriteriaTransfer $merchantCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantOrderCollectionTransfer
     */
    public function getMerchantOrderCollection(
        MerchantOrderCriteriaTransfer $merchantCriteriaFilterTransfer
    ): MerchantOrderCollectionTransfer;

    /**
     * Specification:
     * - Returns a merchant order found using MerchantOrderCriteriaTransfer.
     * - Returns NULL if merchant order is not found.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantOrderCriteriaTransfer $merchantCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantOrderTransfer|null
     */
    public function findMerchantOrder(
        MerchantOrderCriteriaTransfer $merchantCriteriaFilterTransfer
    ): ?MerchantOrderTransfer;

    /**
     * Specification:
     * - Expands SpySalesOrderItemEntityTransfer with ItemTransfer.merchantReference if exists.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer $salesOrderItemEntityTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer
     */
    public function expandOrderItemWithMerchant(
        SpySalesOrderItemEntityTransfer $salesOrderItemEntityTransfer,
        ItemTransfer $itemTransfer
    ): SpySalesOrderItemEntityTransfer;

    /**
     * Specification:
     * - Expands order with merchant references of order items.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function expandOrderWithMerchants(OrderTransfer $orderTransfer): OrderTransfer;
}
