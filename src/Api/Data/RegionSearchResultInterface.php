<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Region search results interface
 *
 * @api
 */
interface RegionSearchResultInterface extends SearchResultsInterface
{
    /**
     * Retrieve regions
     *
     * @return \Eriocnemis\RegionApi\Api\Data\RegionInterface[]
     */
    public function getItems();

    /**
     * Set regions
     *
     * @param \Eriocnemis\RegionApi\Api\Data\RegionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
