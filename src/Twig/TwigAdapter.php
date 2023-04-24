<?php

namespace Core\View\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Core\Interfaces\View;
use Core\Interfaces\ViewTopology;
use Core\Interfaces\ViewAdapter;
use Core\Interfaces\WebPage;
use Core\Interfaces\TwigConfig;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

class TwigAdapter implements ViewAdapter
{

    protected TwigConfig $twigConfig;
    protected ViewTopology $viewTopology;
    protected WebPage $webPage;
    protected ServerRequestInterface $request;
    protected ResponseFactoryInterface $responseFactory;
    protected CacheInterface $cache;

    public function __construct(
            TwigConfig $twigConfig,
            ViewTopology $viewTopology,
            WebPage $webPage,
            ServerRequestInterface $request,
            ResponseFactoryInterface $responseFactory,
            CacheInterface $cache
    )
    {
        $this->twigConfig = $twigConfig;
        $this->viewTopology = $viewTopology;
        $this->webPage = $webPage;
        $this->request = $request;
        $this->responseFactory = $responseFactory;
        $this->cache = $cache;
    }

    public function getView(array|string|null $templatePath = null, ?ResponseInterface $response = null): View
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

        return new TwigView(
                $twig,
                $this->webPage,
                $this->request,
                $response,
                $this->cache
        );
    }

}
