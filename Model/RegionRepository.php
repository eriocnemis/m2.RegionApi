<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface;
use Eriocnemis\RegionApi\Api\RegionRepositoryInterface;
use Eriocnemis\RegionApi\Api\GetRegionByIdInterface;
use Eriocnemis\RegionApi\Api\GetRegionListInterface;
use Eriocnemis\RegionApi\Api\ValidateRegionInterface;
use Eriocnemis\RegionApi\Api\SaveRegionInterface;
use Eriocnemis\RegionApi\Api\DeleteRegionByIdInterface;

/**
 * Regions repository facade
 *
 * Repository considered as an implementation of Facade pattern which provides a simplified
 * interface for proper work of WebApi request parser.
 *
 * It's not recommended to use(Only WebApi).
 *
 * @api
 */
class RegionRepository implements RegionRepositoryInterface
{
    /**
     * @var GetRegionByIdInterface
     */
    private $getRegionById;

    /**
     * @var GetRegionListInterface
     */
    private $getRegionList;

    /**
     * @var ValidateRegionInterface
     */
    private $validateRegion;

    /**
     * @var SaveRegionInterface
     */
    private $saveRegion;

    /**
     * @var DeleteRegionByIdInterface
     */
    private $deleteRegion;

    /**
     * Initialize facade
     *
     * @param GetRegionByIdInterface $getRegionById
     * @param GetRegionListInterface $getRegionList
     * @param ValidateRegionInterface $validateRegion
     * @param DeleteRegionByIdInterface $deleteRegion
     * @param SaveRegionInterface $saveRegion
     */
    public function __construct(
        GetRegionByIdInterface $getRegionById,
        GetRegionListInterface $getRegionList,
        ValidateRegionInterface $validateRegion,
        DeleteRegionByIdInterface $deleteRegion,
        SaveRegionInterface $saveRegion
    ) {
        $this->getRegionById = $getRegionById;
        $this->getRegionList = $getRegionList;
        $this->validateRegion = $validateRegion;
        $this->deleteRegion = $deleteRegion;
        $this->saveRegion = $saveRegion;
    }

    /**
     * Retrieve region by id
     *
     * @param int $regionId
     * @return \Eriocnemis\RegionApi\Api\Data\RegionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($regionId): RegionInterface
    {
        return $this->getRegionById->execute($regionId);
    }

    /**
     * Retrieve list of regions
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): RegionSearchResultInterface
    {
        return $this->getRegionList->execute($searchCriteria);
    }

    /**
     * Validate region
     *
     * @param RegionInterface $region
     * @return bool
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function validate(RegionInterface $region): bool
    {
        return $this->validateRegion->execute($region);
    }

    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return \Eriocnemis\RegionApi\Api\Data\RegionInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function save(RegionInterface $region): RegionInterface
    {
        return $this->saveRegion->execute($region);
    }

    /**
     * Delete by id
     *
     * @param int $regionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($regionId): bool
    {
        return $this->deleteRegion->execute($regionId);
    }
}
