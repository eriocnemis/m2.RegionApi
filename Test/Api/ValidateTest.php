<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Test\Api;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Validate region provider test
 */
class ValidateTest extends WebapiAbstract
{
    /**
     * Resource path of rest api
     */
    private const RESOURCE_PATH = '/V1/eriocnemis/region/validate';

    /**
     * Soap service name
     */
    private const SERVICE_NAME = 'eriocnemisRegionApiRegionRepositoryV1';

    /**
     * Soap service version
     */
    private const SERVICE_VERSION = 'V1';

    /**
     * Soap service operation
     */
    private const SERVICE_OPERATION = 'validate';

    /**
     * @var mixed[]
     */
    private $data = [
        'country_id' => 'US',
        'code' => 'XX',
        'default_name' => 'Test Default Name',
        'labels' => [
            [
                'name' => 'Test Name',
                'locale' => 'en_US'
            ]

        ],
        'status' => 0
    ];

    /**
     * Test get region by id API
     *
     * @return void
     */
    public function testExecute()
    {
        $serviceInfo = $this->getServiceInfo();
        $requestData = ['region' => $this->getFixtureData()];

        $result = false;
        $response = $this->_webApiCall($serviceInfo, $requestData);
        if (is_bool($response)) {
            $result = (bool)$response;
        }
        $this->assertTrue($response);
    }

    /**
     * Retrieve service info
     *
     * @return mixed[]
     */
    private function getServiceInfo()
    {
        return [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . self::SERVICE_OPERATION
            ]
        ];
    }

    /**
     * Retrieve fixture data of the region
     *
     * @return mixed[]
     */
    private function getFixtureData()
    {
        return $this->data;
    }
}
