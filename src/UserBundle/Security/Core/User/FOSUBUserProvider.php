<?php

namespace UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $username = $response->getUsername();

        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setterId = $setter . 'Id';
        $setterToken = $setter . 'AccessToken';

        //disconnect previously connected user
        if (null !== $previousUser = $this->userManager->findUserBy(array($this->getProperty($response) => $username))) {
            $previousUser->$setterId(null);
            $previousUser->$setterToken(null);
            $this->userManager->updateUser($previousUser);
        }

        //connect current user
        $user->$setterId($username);
        $user->$setterToken($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {       
        
        $username = $response->getUsername();
        $email = $response->getEmail();
        if(!$email){
            $email = $response->getUsername();
        }
        $realname = $response->getRealName();
        
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        if (null === $user) {
            $user = $this->userManager->findUserByEmail($email);

            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setterId = $setter . 'Id';
            $setterToken = $setter . 'AccessToken';

            if (null === $user) {
                $user = $this->userManager->createUser();
                $user->$setterId($username);
                $user->$setterToken($response->getAccessToken());

                $user->setUsername($realname);
                $user->setEmail($email);
                $user->setPassword($username);
                $user->setEnabled(true);
                $this->userManager->updateUser($user);

                return $user;
            } else {
                $user->$setterId($username);
                $user->$setterToken($response->getAccessToken());

                $this->userManager->updateUser($user);

                return $user;
            }
        }

        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }
}