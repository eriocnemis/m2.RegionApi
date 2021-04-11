<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Get region by id interface
 *
 * @api
 */
interface GetRegionByIdInterface
{
    /**
     * Retrieve region by id
     *
     * @param int $regionId
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    public function execute($regionId): RegionInterface;
}
