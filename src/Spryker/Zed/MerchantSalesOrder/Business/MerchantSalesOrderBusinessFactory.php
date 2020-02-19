<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantSalesOrder\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderCreator;
use Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderCreatorInterface;
use Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderItemCreator;
use Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderItemCreatorInterface;
use Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderTotalsCreator;
use Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderTotalsCreatorInterface;
use Spryker\Zed\MerchantSalesOrder\Business\MerchantSalesOrderItem\MerchantOrderItemWriter;
use Spryker\Zed\MerchantSalesOrder\Business\MerchantSalesOrderItem\MerchantOrderItemWriterInterface;
use Spryker\Zed\MerchantSalesOrder\Business\OrderItem\OrderItemExpander;
use Spryker\Zed\MerchantSalesOrder\Business\OrderItem\OrderItemExpanderInterface;
use Spryker\Zed\MerchantSalesOrder\MerchantSalesOrderDependencyProvider;

/**
 * @method \Spryker\Zed\MerchantSalesOrder\Persistence\MerchantSalesOrderEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantSalesOrder\Persistence\MerchantSalesOrderRepositoryInterface getRepository()
 * @method \Spryker\Zed\MerchantSalesOrder\MerchantSalesOrderConfig getConfig()
 */
class MerchantSalesOrderBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderCreatorInterface
     */
    public function createMerchantOrderCreator(): MerchantOrderCreatorInterface
    {
        return new MerchantOrderCreator(
            $this->getEntityManager(),
            $this->createMerchantOrderItemCreator(),
            $this->createMerchantOrderTotalsCreator(),
            $this->getMerchantOrderPostCreatePlugins()
        );
    }

    /**
     * @return \Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderItemCreatorInterface
     */
    public function createMerchantOrderItemCreator(): MerchantOrderItemCreatorInterface
    {
        return new MerchantOrderItemCreator($this->getEntityManager());
    }

    /**
     * @return \Spryker\Zed\MerchantSalesOrder\Business\Creator\MerchantOrderTotalsCreatorInterface
     */
    public function createMerchantOrderTotalsCreator(): MerchantOrderTotalsCreatorInterface
    {
        return new MerchantOrderTotalsCreator($this->getEntityManager());
    }

    /**
     * @return \Spryker\Zed\MerchantSalesOrder\Business\MerchantSalesOrderItem\MerchantOrderItemWriterInterface
     */
    public function createMerchantOrderItemWriter(): MerchantOrderItemWriterInterface
    {
        return new MerchantOrderItemWriter($this->getEntityManager(), $this->getRepository());
    }

    /**
     * @return \Spryker\Zed\MerchantSalesOrder\Business\OrderItem\OrderItemExpanderInterface
     */
    public function createOrderItemExpander(): OrderItemExpanderInterface
    {
        return new OrderItemExpander();
    }

    /**
     * @return \Spryker\Zed\MerchantSalesOrderExtension\Dependency\Plugin\MerchantOrderPostCreatePluginInterface[]
     */
    public function getMerchantOrderPostCreatePlugins(): array
    {
        return $this->getProvidedDependency(MerchantSalesOrderDependencyProvider::PLUGINS_MERCHANT_ORDER_POST_CREATE);
    }
}
