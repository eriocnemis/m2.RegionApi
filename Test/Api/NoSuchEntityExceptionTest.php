<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionApi\Test\Api;

use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Get region by id provider with NoSuchEntityException test
 */
class NoSuchEntityExceptionTest extends WebapiAbstract
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
    private const SERVICE_OPERATION = 'get';

    /**
     * Expected response message
     */
    private const EXPECTED_MESSAGE = 'Region with id "%value" does not exist.';

    /**
     * Test get region by id API with NoSuchEntityException
     *
     * @return void
     * @throws \Exception
     */
    public function testExecute()
    {
        $notExistingId = -1;
        $serviceInfo = $this->getServiceInfo($notExistingId);

        try {
            (constant('TESTS_WEB_API_ADAPTER') === self::ADAPTER_REST)
                ? $this->_webApiCall($serviceInfo)
                : $this->_webApiCall($serviceInfo, ['regionId' => $notExistingId]);
            $this->fail('Expected throwing exception');
        } catch (\Exception $e) {
            if (constant('TESTS_WEB_API_ADAPTER') === self::ADAPTER_REST) {
                $this->assertRestException($notExistingId, $e);
            } elseif (constant('TESTS_WEB_API_ADAPTER') === self::ADAPTER_SOAP) {
                $this->assertSoapException($notExistingId, $e);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Retrieve service info
     *
     * @param int $regionId
     * @return mixed[]
     */
    private function getServiceInfo($regionId)
    {
        return [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '/' . $regionId,
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
     * Assert rest exception
     *
     * @param int $regionId
     * @param \Exception $e
     * @return void
     */
    private function assertRestException($regionId, $e)
    {
        $errorData = $this->processRestExceptionResult($e);

        self::assertEquals(self::EXPECTED_MESSAGE, $errorData['message']);
        self::assertEquals($regionId, $errorData['parameters']['value']);
        self::assertEquals(Exception::HTTP_NOT_FOUND, $e->getCode());
    }

    /**
     * Assert soap exception
     *
     * @param int $regionId
     * @param \SoapFault $e
     * @return void
     */
    private function assertSoapException($regionId, $e)
    {
        $this->assertInstanceOf('SoapFault', $e);
        $this->checkSoapFault($e, self::EXPECTED_MESSAGE, 'env:Sender', ['value' => $regionId]);
    }
}
