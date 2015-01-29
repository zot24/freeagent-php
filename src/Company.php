<?php

namespace CloudManaged\FreeAgent;

use CloudManaged\FreeAgent\Api\ApiResource;
use CloudManaged\FreeAgent\Errors\CompanyError;

class Company extends ApiResource
{
    public function __construct(FreeAgent $freeAgent)
    {
        parent::__construct($freeAgent);
    }

    public function getCompanyUrl()
    {
        return $this->baseURL . 'company';
    }

    /**
     * General company information
     * The list of basic information about a company held by FreeAgent.
     *
     * @see https://dev.freeagent.com/docs/company#general-company-information
     * @return CompanyEntity
     */
    public function getGeneralCompanyInformation()
    {
        $response = $this->fetchCompanyDetails();
        return $this->companyDetails(json_decode($response));
    }

    protected function fetchCompanyDetails()
    {
        try {
            $url = $this->getCompanyUrl();
            return $this->retrieve($url, []);
        } catch (ApiError $e) {
            throw new CompanyError($e);
        }
    }

    protected function companyDetails($response)
    {
        $response = (array)($response->company);
        $company = new CompanyEntity($response);
        return $company;
    }
}
