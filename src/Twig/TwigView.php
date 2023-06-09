<?php

namespace Core\View\Twig;

use Core\Interfaces\ViewInterface;
use Core\Interfaces\WebPageInterface;
use Core\View\ViewTrait;
use Core\View\ViewException;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;
use Twig\Environment;
use \Throwable;

class TwigView implements ViewInterface
{

    use ViewTrait;

    private Environment $twig;
    private WebPageInterface $webPage;

    public function __construct(
            Environment $twig,
            WebPageInterface $webPage,
            ServerRequestInterface $request,
            ResponseInterface $response,
            CacheInterface $cache,
            EventDispatcherInterface $eventDispatcher
    )
    {
        $this->twig = $twig;
        $this->webPage = $webPage;
        $this->request = $request;
        $this->response = $response;
        $this->cache = $cache;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * 
     * @param string $layout
     * @param array<array-key, string> $vars
     * @return string
     */
    public function fetch(string $layout, array $vars = []): string
    {
        try {
            $this->assign($this->webPage->getWebpage());
            $this->assign($vars);
            $template = $this->twig->load($layout);
            $rendered = $template
                    ->render($this->vars);
            $this->clear();
            return $rendered;
        } catch (Throwable $e) {
            throw new ViewException($e->getMessage());
        }
        return '';
    }

}
