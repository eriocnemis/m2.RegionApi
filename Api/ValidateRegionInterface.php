<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Api;

use Magento\Framework\Validation\ValidationException;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Validate region data interface
 *
 * @api
 */
interface ValidateRegionInterface
{
    /**
     * Validate region
     *
     * @param RegionInterface $region
     * @return bool
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): bool;
}
