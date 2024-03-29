<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantSalesOrder\Persistence;

use Generated\Shared\Transfer\MerchantOrderItemTransfer;
use Generated\Shared\Transfer\MerchantOrderTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

interface MerchantSalesOrderEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantOrderTransfer $merchantOrderTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantOrderTransfer
     */
    public function createMerchantOrder(MerchantOrderTransfer $merchantOrderTransfer): MerchantOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\MerchantOrderItemTransfer $merchantOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantOrderItemTransfer
     */
    public function createMerchantOrderItem(
        MerchantOrderItemTransfer $merchantOrderItemTransfer
    ): MerchantOrderItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\MerchantOrderItemTransfer $merchantOrderItemTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantOrderItemTransfer
     */
    public function updateMerchantOrderItem(
        MerchantOrderItemTransfer $merchantOrderItemTransfer
    ): MerchantOrderItemTransfer;

    /**
     * @param int $idMerchantOrder
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     *
     * @return \Generated\Shared\Transfer\TotalsTransfer
     */
    public function createMerchantOrderTotals(int $idMerchantOrder, TotalsTransfer $totalsTransfer): TotalsTransfer;

    /**
     * @param int $idMerchantOrder
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     *
     * @return \Generated\Shared\Transfer\TotalsTransfer
     */
    public function updateMerchantOrderTotals(int $idMerchantOrder, TotalsTransfer $totalsTransfer): TotalsTransfer;
}
