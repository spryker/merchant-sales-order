<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MerchantSalesOrder;

use ArrayObject;
use Codeception\Actor;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MerchantOrderCriteriaTransfer;
use Generated\Shared\Transfer\MerchantOrderItemTransfer;
use Generated\Shared\Transfer\MerchantOrderTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

/**
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 * @method \Spryker\Zed\MerchantSalesOrder\Business\MerchantSalesOrderFacadeInterface getFacade()
 *
 * @SuppressWarnings(PHPMD)
 */
class MerchantSalesOrderBusinessTester extends Actor
{
    use _generated\MerchantSalesOrderBusinessTesterActions;

    /**
     * @uses \SprykerTest\Zed\Sales\Helper\BusinessHelper::DEFAULT_OMS_PROCESS_NAME
     *
     * @var string
     */
    protected const DEFAULT_OMS_PROCESS_NAME = 'Test01';

    /**
     * @param array $seedData
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function getItemTransfer(array $seedData = []): ItemTransfer
    {
        return (new ItemBuilder($seedData))->build();
    }

    /**
     * @param string $orderReference
     * @param string $merchantReference
     *
     * @return string
     */
    public function getMerchantOrderReference(string $orderReference, string $merchantReference): string
    {
        return sprintf(
            '%s--%s',
            $orderReference,
            $merchantReference,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     * @param string $stateMachine
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function getSaveOrderTransfer(MerchantTransfer $merchantTransfer, string $stateMachine): SaveOrderTransfer
    {
        $this->configureTestStateMachine([$stateMachine]);

        return $this->haveOrder([
            ItemTransfer::MERCHANT_REFERENCE => $merchantTransfer->getMerchantReference(),
            ItemTransfer::UNIT_PRICE => 100,
            ItemTransfer::SUM_PRICE => 100,
        ], $stateMachine);
    }

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param string $merchantOrderReference
     *
     * @return \Generated\Shared\Transfer\MerchantOrderTransfer
     */
    public function createMerchantOrderWithRelatedData(
        SaveOrderTransfer $saveOrderTransfer,
        MerchantTransfer $merchantTransfer,
        ItemTransfer $itemTransfer,
        string $merchantOrderReference
    ): MerchantOrderTransfer {
        $merchantOrderTransfer = $this->haveMerchantOrder([
            MerchantOrderTransfer::MERCHANT_ORDER_REFERENCE => $merchantOrderReference,
            MerchantOrderTransfer::ID_ORDER => $saveOrderTransfer->getIdSalesOrder(),
            MerchantOrderTransfer::MERCHANT_REFERENCE => $merchantTransfer->getMerchantReference(),
        ]);

        $merchantOrderItemTransfer = $this->haveMerchantOrderItem([
            MerchantOrderItemTransfer::ID_ORDER_ITEM => $itemTransfer->getIdSalesOrderItem(),
            MerchantOrderItemTransfer::ID_MERCHANT_ORDER => $merchantOrderTransfer->getIdMerchantOrder(),
        ]);
        $merchantOrderTransfer->addMerchantOrderItem($merchantOrderItemTransfer);

        $merchantOrderTotalsTransfer = $this->haveMerchantOrderTotals($merchantOrderTransfer->getIdMerchantOrder());
        $merchantOrderTransfer->setTotals($merchantOrderTotalsTransfer);

        return $merchantOrderTransfer;
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return int
     */
    public function getUniqueProductCount(ArrayObject $itemTransfers): int
    {
        $itemSkus = [];
        foreach ($itemTransfers as $itemTransfer) {
            $itemSkus[] = $itemTransfer->getSku();
        }

        return count(array_unique($itemSkus));
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantOrderTransfer $merchantOrderTransfer
     *
     * @return int
     */
    public function getPersistedMerchantOrderGrandTotal(MerchantOrderTransfer $merchantOrderTransfer): int
    {
        $merchantOrderCriteriaTransfer = (new MerchantOrderCriteriaTransfer())
            ->setIdMerchantOrder($merchantOrderTransfer->getIdMerchantOrder());

        return (int)$this->getFacade()
            ->findMerchantOrder($merchantOrderCriteriaTransfer)
            ->getTotals()
            ->getGrandTotal();
    }

    /**
     * @return \Generated\Shared\Transfer\MerchantOrderTransfer
     */
    public function createMerchantOrder(): MerchantOrderTransfer
    {
        $merchantTransfer = $this->haveMerchant();
        $saveOrderTransfer = $this->getSaveOrderTransfer($merchantTransfer, static::DEFAULT_OMS_PROCESS_NAME);

        /** @var \Generated\Shared\Transfer\ItemTransfer $itemTransfer */
        $itemTransfer = $saveOrderTransfer->getOrderItems()->offsetGet(0);

        $merchantOrderReference = $this->getMerchantOrderReference(
            $saveOrderTransfer->getOrderReference(),
            $merchantTransfer->getMerchantReference(),
        );

        return $this->createMerchantOrderWithRelatedData(
            $saveOrderTransfer,
            $merchantTransfer,
            $itemTransfer,
            $merchantOrderReference,
        );
    }
}
