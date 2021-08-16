<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Test\Api;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterfaceFactory;
use Eriocnemis\RegionApi\Api\RegionRepositoryInterface;

/**
 * Get region list provider test
 */
class GetListTest extends WebapiAbstract
{
    /**
     * Resource path of rest api
     */
    private const RESOURCE_PATH = '/V1/eriocnemis/region/search';

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
    private const SERVICE_OPERATION = 'getList';

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
    protected $dataObjectHelper;

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
    protected function setUp()
    {
        $objectManager = Bootstrap::getObjectManager();

        $this->regionFactory = $objectManager->create(RegionInterfaceFactory::class);
        $this->regionRepository = $objectManager->create(RegionRepositoryInterface::class);
        $this->dataObjectHelper = $objectManager->create(DataObjectHelper::class);

        parent::setUp();
    }

    /**
     * This method is called after a test is executed
     */
    protected function tearDown()
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
            $searchCriteria = $this->getSearchCriteria();
            $serviceInfo = $this->getServiceInfo($searchCriteria);

            $response = $this->_webApiCall($serviceInfo, $searchCriteria);

            if (is_array($response)) {
                $this->assertArrayHasKey('search_criteria', $response);
                $this->assertArrayHasKey('total_count', $response);
                $this->assertArrayHasKey('items', $response);

                $this->assertEquals($searchCriteria['searchCriteria'], $response['search_criteria']);
                $this->assertTrue($response['total_count'] == 1);
                $this->assertCount(1, $response['items']);

                $this->assertNotNull($response['items'][0]['id']);
                $this->assertEquals($this->getFixtureData(), $response['items'][0]);
            } else {
                $this->fail('Wrong response data format');
            }
        }
    }

    /**
     * Retrieve service info
     *
     * @param mixed[] $searchCriteria
     * @return mixed[]
     */
    private function getServiceInfo($searchCriteria)
    {
        return [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($searchCriteria),
                'httpMethod' => Request::HTTP_METHOD_GET
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
        if ($this->region) {
            $this->data['id'] = $this->region->getId();
        }
        return $this->data;
    }

    /**
     * Retrieve search criteria
     *
     * @return mixed[]
     */
    private function getSearchCriteria()
    {
        return [
            'searchCriteria' => [
                'filter_groups' => [
                    [
                        'filters' => [
                            [
                                'field' => 'region_id',
                                'value' => $this->region ? $this->region->getId() : null,
                                'condition_type' => 'eq',
                            ]
                        ]
                    ]
                ],
                'current_page' => 1,
                'page_size' => 2,
            ]
        ];
    }
}
