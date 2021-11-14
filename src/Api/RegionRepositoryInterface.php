<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface;

/**
 * Regions repository interface
 *
 * Repository considered as an implementation of Facade pattern which provides a simplified
 * interface for proper work of WebApi request parser.
 *
 * It's not recommended to use(Only WebApi).
 *
 * @api
 */
interface RegionRepositoryInterface
{
    /**
     * Retrieve region by id
     *
     * @param int $regionId
     * @return \Eriocnemis\RegionApi\Api\Data\RegionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($regionId): RegionInterface;

    /**
     * Retrieve list of regions
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): RegionSearchResultInterface;

    /**
     * Validate region
     *
     * @param RegionInterface $region
     * @return bool
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function validate(RegionInterface $region): bool;

    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return \Eriocnemis\RegionApi\Api\Data\RegionInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function save(RegionInterface $region): RegionInterface;

    /**
     * Delete by id
     *
     * @param int $regionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($regionId): bool;
}
