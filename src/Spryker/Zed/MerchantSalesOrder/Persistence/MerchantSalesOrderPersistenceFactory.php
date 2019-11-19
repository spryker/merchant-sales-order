<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantSalesOrder\Persistence;

use Orm\Zed\MerchantSalesOrder\Persistence\SpyMerchantSalesOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\MerchantSalesOrder\Persistence\Propel\Mapper\MerchantSalesOrderMapper;

/**
 * @method \Spryker\Zed\MerchantSalesOrder\MerchantSalesOrderConfig getConfig()
 * @method \Spryker\Zed\MerchantSalesOrder\Persistence\MerchantSalesOrderEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantSalesOrder\Persistence\MerchantSalesOrderRepositoryInterface getRepository()
 */
class MerchantSalesOrderPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\MerchantSalesOrder\Persistence\SpyMerchantSalesOrderQuery
     */
    public function createMerchantSalesOrderQuery(): SpyMerchantSalesOrderQuery
    {
        return SpyMerchantSalesOrderQuery::create();
    }

    /**
     * @return \Spryker\Zed\MerchantSalesOrder\Persistence\Propel\Mapper\MerchantSalesOrderMapper
     */
    public function createMerchantSalesOrderMapper(): MerchantSalesOrderMapper
    {
        return new MerchantSalesOrderMapper();
    }
}
