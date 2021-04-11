<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface;

/**
 * Find regions by search criteria interface
 *
 * @api
 */
interface GetRegionListInterface
{
    /**
     * Retrieve list of regions
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return RegionSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): RegionSearchResultInterface;
}
