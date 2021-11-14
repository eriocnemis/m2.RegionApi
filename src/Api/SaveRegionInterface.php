<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Save region data interface
 *
 * @api
 */
interface SaveRegionInterface
{
    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return RegionInterface
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): RegionInterface;
}
