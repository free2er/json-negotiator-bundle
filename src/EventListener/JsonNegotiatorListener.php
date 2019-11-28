<?php

declare(strict_types=1);

namespace Free2er\Json\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Преобразователь тела JSON-запросов
 */
class JsonNegotiatorListener implements EventSubscriberInterface
{
    /**
     * Допустимые типы тела запроса
     *
     * @var string[]
     */
    private $contentTypes;

    /**
     * Допустимые методы запроса
     *
     * @var string[]
     */
    private $methods;

    /**
     * Возвращает подписку на события
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => 'parseRequest'];
    }

    /**
     * Конструктор
     *
     * @param array $contentTypes
     * @param array $methods
     */
    public function __construct(array $contentTypes, array $methods)
    {
        $this->contentTypes = $contentTypes;
        $this->methods      = $methods;
    }

    /**
     * Преобразует тело JSON-запроса
     *
     * @param ControllerEvent $event
     *
     * @throws BadRequestHttpException
     */
    public function parseRequest(ControllerEvent $event)
    {
        if (!$this->isJson($request = $event->getRequest())) {
            return;
        }

        if (is_array($payload = json_decode($request->getContent(), true))) {
            $request->request->replace($payload);
            return;
        }

        if ($error = json_last_error()) {
            throw new BadRequestHttpException(json_last_error_msg(), null, $error);
        }

        throw new BadRequestHttpException('Invalid JSON payload received');
    }

    /**
     * Проверяет наличие JSON в теле запроса
     *
     * @param Request $request
     *
     * @return bool
     */
    private function isJson(Request $request): bool
    {
        return $request->request->count() === 0
            && in_array($request->getMethod(), $this->methods, true)
            && in_array($request->getContentType(), $this->contentTypes, true)
            && $request->getContent();
    }
}
