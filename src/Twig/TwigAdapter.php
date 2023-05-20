<?php

namespace Core\View\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Core\Interfaces\ViewInterface;
use Core\Interfaces\ViewTopologyInterface;
use Core\Interfaces\ViewAdapterInterface;
use Core\Interfaces\WebPageInterface;
use Core\Interfaces\TwigConfigInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

class TwigAdapter implements ViewAdapterInterface
{

    protected TwigConfigInterface $twigConfig;
    protected ViewTopologyInterface $viewTopology;
    protected WebPageInterface $webPage;
    protected ServerRequestInterface $request;
    protected ResponseFactoryInterface $responseFactory;
    protected CacheInterface $cache;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
            TwigConfigInterface $twigConfig,
            ViewTopologyInterface $viewTopology,
            WebPageInterface $webPage,
            ServerRequestInterface $request,
            ResponseFactoryInterface $responseFactory,
            CacheInterface $cache,
            EventDispatcherInterface $eventDispatcher
    )
    {
        $this->twigConfig = $twigConfig;
        $this->viewTopology = $viewTopology;
        $this->webPage = $webPage;
        $this->request = $request;
        $this->responseFactory = $responseFactory;
        $this->cache = $cache;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getView(array|string|null $templatePath = null, ?ResponseInterface $response = null): ViewInterface
    {

        if ($response === null) {
            $response = $this->responseFactory->createResponse(404);
        }

        if ($templatePath === null) {
            $templatePath = $this->viewTopology->getTemplatePath();
        }

        $loader = new FilesystemLoader($templatePath);

        $twig = new Environment($loader, [
            'extensions' => $this->twigConfig->getExtensionsDir(),
            'cache' => $this->twigConfig->getCacheDir(),
            'auto_reload' => $this->twigConfig->getAutoReload(),
            'debug' => $this->twigConfig->getDebug(),
            'autoescape' => $this->twigConfig->getAutoEscape(),
            'strict_variables' => $this->twigConfig->getStrictVariables(),
            'charset' => $this->twigConfig->getCharSet(),
            'tag_variable' => [
                $this->twigConfig->getLeftDelimiterVariable(),
                $this->twigConfig->getRightDelimiterVariable()
            ],
            'tag_comment' => [
                $this->twigConfig->getLeftDelimiterComment(),
                $this->twigConfig->getRightDelimiterComment()
            ],
            'tag_block' => [
                $this->twigConfig->getLeftDelimiterBlock(),
                $this->twigConfig->getRightDelimiterBlock()
            ]
        ]);

        foreach ($this->twigConfig->getFilters() as $filter) {
            $twig->addFilter($filter);
        }

        foreach ($this->twigConfig->getFunctions() as $function) {
            $twig->addFunction($function);
        }

        foreach ($this->twigConfig->getExtensions() as $extension) {
            $twig->addExtension($extension);
        }

        return new TwigView(
                $twig,
                $this->webPage,
                $this->request,
                $response,
                $this->cache,
                $this->eventDispatcher
        );
    }

}
