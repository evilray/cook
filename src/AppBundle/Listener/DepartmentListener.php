<?php
namespace AppBundle\Listener;


use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class DepartmentListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ObjectManager
     */
    protected $manager;

    public function __construct(ObjectManager $manager, ContainerInterface $container)
    {
        $this->manager = $manager;
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $department = $this->container->get('session')->get('department');
        if(null === $department){
            $department = $this->manager->getRepository('AppBundle:Department')->findOneBy(['slug'=>'kgd']);
            $this->container->get('session')->set('department', $department);
        }

        $securityContext = $this->container->get(
            'security.token_storage',
            ContainerInterface::NULL_ON_INVALID_REFERENCE
        );

    }
}