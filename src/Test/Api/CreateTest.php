<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Test\Api;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterfaceFactory;
use Eriocnemis\RegionApi\Api\RegionRepositoryInterface;

/**
 * Create region provider test
 */
class CreateTest extends WebapiAbstract
{
    /**
     * Resource path of rest api
     */
    private const RESOURCE_PATH = '/V1/eriocnemis/region';

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
    private const SERVICE_OPERATION = 'save';

    /**
     * @var RegionInterface|null
     */
    private $region;

    /**
     * @var RegionInterfaceFactory
     */
    private $regionFactory;

    /**
     * @var RegionRepositoryInterface
     */
    private $regionRepository;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

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
     * This method is called before a test is executed
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();

        $this->regionFactory = $objectManager->create(RegionInterfaceFactory::class);
        $this->regionRepository = $objectManager->create(RegionRepositoryInterface::class);
        $this->dataObjectHelper = $objectManager->create(DataObjectHelper::class);
        $this->dataObjectProcessor = $objectManager->create(DataObjectProcessor::class);

        parent::setUp();
    }

    /**
     * This method is called after a test is executed
     *
     * @return void
     */
    protected function tearDown(): void
    {
        if (null !== $this->region) {
            $this->regionRepository->delete((int)$this->region->getId());
            $this->region = null;
        }
    }

    /**
     * Test get region by id API
     *
     * @return void
     */
    public function testExecute()
    {
        $this->createTempData();

        if (null !== $this->region) {
            $fixtureData = $this->getFixtureData() + $this->dataObjectProcessor->buildOutputDataArray(
                $this->region,
                RegionInterface::class
            );

            $this->regionRepository->delete((int)$this->region->getId());
            $this->region = null;

            $serviceInfo = $this->getServiceInfo();
            $requestData = ['region' => $this->getFixtureData()];

            $response = $this->_webApiCall($serviceInfo, $requestData);

            $regionId = null;
            if (is_array($response) && !empty($response['id'])) {
                $regionId = $response['id'];
                $fixtureData['id'] = $regionId;
            }
            $this->assertNotNull($regionId);

            $this->region = $this->regionRepository->get((int)$regionId);
            $regionData = $this->dataObjectProcessor->buildOutputDataArray(
                $this->region,
                RegionInterface::class
            );

            $this->assertEquals($fixtureData, $regionData, 'Region data is invalid.');
        }
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
     * Add test data to database
     *
     * @return void
     */
    private function createTempData()
    {
        $region = $this->regionFactory->create();
        $this->dataObjectHelper->populateWithArray($region, $this->getFixtureData(), RegionInterface::class);
        $this->region = $this->regionRepository->save($region);

        $this->assertInstanceOf(RegionInterface::class, $this->region);
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
