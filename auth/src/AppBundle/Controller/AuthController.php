<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

// Doctrine Entities for DB interaction

use AppBundle\Entity\Log;
use AppBundle\Entity\Secret;
use AppBundle\Entity\User_details;

class AuthController extends Controller{
    
    /**
     * @Route("/user/{id}", name="auth")
     */
    public function indexAction(Request $request,$id,EntityManagerInterface $em){

        // this is the clients GET request

        $request = Request::createFromGlobals();
        
        // client provides API Key through user info : curl <link>/user/{user-id} -u <API Key>
        // submited API Key is stored in $apikey variable
        
         $apikey = $request->getUserInfo();

         $success = false;
         $logInfo = 'Log info :';
         $responseErrorLog;

         $userDetails;

         // check if user exists and assign user info to local variable

         $currentUserDetails = $this->getUserDetails($id, $em);


         if(!$currentUserDetails){
            $logInfo .= 'User '."$id".' does not exist.';
            $success = false;
            $responseErrorLog = 'User does not exist.'; 
         }
         else{
            $logInfo .='User '."$id".' exists.';
            $success = true;
         }

         //Check if API key exists

        if($success){
            if(!$this->doesApiKeyExists($apikey)){
                $logInfo .= ' No API key.';
                $success = false;
                $responseErrorLog = 'API key does not exist.'; 
            }
            else{
                $logInfo .=' API key found.';
                $success = true;
            }
        }

         // check if  api key for user {id} matches with our db entry

        if($success){
            if(!$this->doesApiKeyMatchForUser($apikey, $id, $em)){
                $logInfo .= ' Api key mismatch';
                $success = false;
                $responseErrorLog = 'Wrong API key for user'."$id .";  
             }
             else{
                $logInfo .=' Correct Api key';
                $success = true;
             }         
        }

        //Make new log entry

        $this->updateLog("$id",$success,$logInfo,$em);

        if($success){
             $resonseValue = array('id'=>$currentUserDetails->getId(),
                             'name'=>$currentUserDetails->getName(),
                             'last name'=>$currentUserDetails->getLastName(),
                             'created_at'=>$currentUserDetails->getCreatedAt());
        
        }
        else{
            $resonseValue = array('ERROR' => "$responseErrorLog");
        }
        return $this->json($resonseValue);

    }

    private static function getUserDetails($user, $em ){
        return $em->getRepository('AppBundle:User_details')->find($user);
            
    }

    private static function doesApiKeyMatchForUser($apiKey, $user, $em ){
        $secret = $em->getRepository('AppBundle:Secret')->findOneByUserid($user);
        if(!$secret){
            return false;
        }
        else{
            if($secret->getApikey()==$apiKey){
                return true;
            }
        }
        return false;
    }

    private static function doesApiKeyExists($apikey){
        if($apikey)
            return true;
        return false;
    }

    private static function updateLog($userid, $success, $info, $em){
        $log = new Log();
        $log->setUserid($userid);
        $log->setSuccess($success);
        $log->setInfo($info);
        $log->setCreatedAt();
        $em->persist($log);
        $em->flush();
    }

}
