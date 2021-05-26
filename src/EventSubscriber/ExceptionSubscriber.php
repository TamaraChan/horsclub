<?php


namespace App\EventSubscriber;


use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\VarDumper\VarDumper;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /** @var ContainerInterface*/
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * The code must not depend on runtime state as it will only be called at compile time.
     * All logic depending on runtime state must be put into the individual methods handling the events.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'handleException'
        ];
    }

    public function handleException(ExceptionEvent $event)
    {

        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $response = new Response($this->container->get('twig')->render('page_not_found.html.twig'));
            $event->setResponse($response);
        }
    }
}