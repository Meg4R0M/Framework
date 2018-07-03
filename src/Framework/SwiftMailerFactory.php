<?php
namespace Framework;

use Psr\Container\ContainerInterface;

/**
 * Class SwiftMailerFactory
 * @package Framework
 */
class SwiftMailerFactory
{

    /**
     * @param ContainerInterface $container
     * @return \Swift_Mailer
     */
    public function __invoke(ContainerInterface $container): \Swift_Mailer
    {
        if ($container->get('env') === 'production') {
            $transport = new \Swift_SendmailTransport();
        } else {
            $transport = new \Swift_SmtpTransport('localhost', 1025);
        }
        return new \Swift_Mailer($transport);
    }//end __invoke()
}//end class
