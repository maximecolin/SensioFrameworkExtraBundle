<?php

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SecurityListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function testAccessDenied()
    {
        $securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
        $securityContext->expects($this->once())->method('isGranted')->will($this->throwException(new AccessDeniedException()));

        $listener = new SecurityListener($securityContext);
        $request = $this->createRequest(new Security(array('expression' => 'has_role("ROLE_ADMIN")')));

        $event = new FilterControllerEvent($this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface'), function () { return new Response(); }, $request, null);

        $listener->onKernelController($event);
    }

    private function createRequest(Security $security = null)
    {
        return new Request(array(), array(), array(
            '_security' => $security,
        ));
    }

    private function getKernel()
    {
        return $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
    }
}
