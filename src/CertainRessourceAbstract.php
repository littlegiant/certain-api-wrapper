<?php
namespace Wabel\CertainAPI;

use Wabel\CertainAPI\Interfaces\CertainRessourceInterface;
use Wabel\CertainAPI\Interfaces\CertainResponseInterface;

/**
 * CertainRessourceAbstracct for common action about Ressource
 *
 * @author rbergina
 */

use Wabel\CertainAPI\CertainApiService;

abstract class CertainRessourceAbstract implements CertainRessourceInterface, CertainResponseInterface
{
    /**
     * CertainApiService
     * @var CertainApiService
     */
    protected $certainApiService;
    /**
     * array of results with information about the request
     * @var array
     */
    protected $results;
    
    /**
     * @param CertainApiService $certainApiService
     */
    public function __construct(CertainApiService $certainApiService)
    {
        $this->certainApiService = $certainApiService;
    }


    /**
     * Get information about ressource
     * @param string $ressourceId
     * @param array $params
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainRessourceAbstract
     * @throws Exceptions\RessourceException
     */
    public function get($ressourceId= null,$params= array(), $assoc = false, $contentType='json'){
        $ressourceName = $this->getRessourceName();;
        if($ressourceName == '' || is_null($ressourceName)){
            throw new Exceptions\RessourceException('No ressource name provided.');
        }
        $this->results = $this->certainApiService->get($ressourceName, $ressourceId,$params, $assoc, $contentType);
        return $this;
    }
    
    /**
     * Add/Update information to certain
     * @param array $bodyData
     * @param array $query
     * @param string $ressourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainRessourceAbstract
     * @throws Exceptions\RessourceException
     * @throws Exceptions\RessourceMandatoryFieldException
     */
    public function post($bodyData, $query=array(), $ressourceId= null, $assoc = false, $contentType='json'){
        $ressourceName = $this->getRessourceName();;
        if($ressourceName == '' || is_null($ressourceName)){
            throw new Exceptions\RessourceException('No ressource name provided.');
        }
        if($ressourceId === null && count($this->getMandatoryFields())>0){
            foreach ($this->getMandatoryFields() as $field) {
                if(!in_array($field,  array_keys($bodyData))){
                    throw new Exceptions\RessourceMandatoryFieldException(sprintf('The field %s is required',$field));
                }
            }
        }
        $this->results = $this->certainApiService->post($ressourceName, $ressourceId, $bodyData, $query, $assoc, $contentType);
        return $this;
    }


    /**
     * Delete information from certain
     * @param string $ressourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainRessourceAbstract
     * @throws Exceptions\RessourceException
     */
    public function delete($ressourceId, $assoc = false, $contentType='json'){
        $ressourceName = $this->getRessourceName();;
        if($ressourceName == '' || is_null($ressourceName)){
            throw new Exceptions\RessourceException('No ressource name provided.');
        }
        $this->results = $this->certainApiService->delete($ressourceName, $ressourceId, $assoc, $contentType);
        return $this;
    }

    /**
     * Check is a successful request
     * @return boolean
     */
    public function isSuccessFul()
    {
        return $this->results['success'];
    }

    /**
     * Get the results
     * @return \stdClass|\stdClass[]|array
     */
    public function getResults()
    {
        return $this->results['results'];
    }

    /**
     * Get the succes value, results,  success or fail reason
     * @return array
     */
    public function getCompleteResults(){
        return $this->results;
    }

}