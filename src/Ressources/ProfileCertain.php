<?php
namespace Wabel\CertainAPI\Ressources;

use Wabel\CertainAPI\Interfaces\CertainRessourceInterface;
use Wabel\CertainAPI\CertainRessourceAbstract;
use Wabel\CertainAPI\Exceptions\RessourceException;
/**
 * ProfileCertain about the Profile entity
 *
 * @author rbergina
 */
class ProfileCertain extends CertainRessourceAbstract implements CertainRessourceInterface
{
    public function getRessourceName(){
        return 'Profile';
    }
    public function getMandatoryFields()
    {
        return array();
    }

    public function getProfileByEmail($email)
    {
        $resultCertain =  $this->getProfileCertainReturnByEmail($email);
        if($resultCertain->size == 1){
            return $resultCertain->profiles[0];
            
        } elseif($resultCertain->size > 1){
            throw new RessourceException('Duplicate entries');
        } else{
                return $resultCertain;
        }
    }

    public function getProfileCertainReturnByEmail($email)
    {
        return $this->get(null, ['email'=> $email]);
    }
}