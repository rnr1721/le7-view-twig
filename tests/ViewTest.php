<?php

use Core\View\Twig\TwigAdapter;
use Core\Interfaces\TwigConfig;
use Core\View\Twig\TwigConfigGeneric;
use Core\Interfaces\ViewTopology;
use Core\View\ViewTopologyGeneric;
use Core\Interfaces\ViewAdapter;
use Core\View\WebPageGeneric;
use Core\Testing\MegaFactory;
use Psr\SimpleCache\CacheInterface;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class ViewTest extends PHPUnit\Framework\TestCase
{

    private string $compiledDirectory;
    private string $testsDirectory;
    private MegaFactory $megaFactory;

    protected function setUp(): void
    {
        $this->testsDirectory = getcwd() . DIRECTORY_SEPARATOR . 'tests';
        $this->compiledDirectory = $this->testsDirectory . DIRECTORY_SEPARATOR . 'compiled';
        $this->megaFactory = new MegaFactory($this->testsDirectory);
        $this->megaFactory->mkdir($this->compiledDirectory);
    }

    public function testConfig()
    {

        $defConfig = [
            'autoescape' => [],
            'charset' => 'utf-8',
            'strict_variables' => true,
            'autoreload' => true,
            'leftDelimiterVariable' => '{{',
            'rightDelimiterVariable' => '}}',
            'leftDelimiterComment' => '{#',
            'rightDelimiterComment' => '#}',
            'leftDelimiterBlock' => '{%',
            'rightDelimiterBlock' => '%}',
            'cacheDir' => '',
            'debug' => true,
            'extensions' => []
        ];

        $config = new TwigConfigGeneric();

        $this->assertEquals($config->getConfig(), $defConfig);

        $config->setAutoEscape('html,js,url');
        $this->assertEquals(['html' => true, 'js' => true, 'url' => true], $config->getAutoEscape());
        $config->setAutoReload(false);
        $this->assertFalse($config->getAutoReload());
        $config->setCacheDir('/my/cache/dir');
        $this->assertEquals('/my/cache/dir', $config->getCacheDir());
        $config->setCharSet('windows-1251');
        $this->assertEquals('windows-1251', $config->getCharSet());
        $config->setDebug(false);
        $this->assertFalse($config->getDebug());
        $config->setDelimitersBlock('[[', ']]');
        $this->assertEquals('[[', $config->getLeftDelimiterBlock());
        $this->assertEquals(']]', $config->getRightDelimiterBlock());
        $config->setDelimitersVariable('[[', ']]');
        $this->assertEquals('[[', $config->getLeftDelimiterVariable());
        $this->assertEquals(']]', $config->getRightDelimiterVariable());
        $config->setDelimitersComment('[[', ']]');
        $this->assertEquals('[[', $config->getLeftDelimiterComment());
        $this->assertEquals(']]', $config->getRightDelimiterComment());
        $config->setExtensionsDir(['/dir1', '/dir2']);
        $this->assertEquals(['/dir1', '/dir2'], $config->getExtensionsDir());
        $config->setStrictVariables(false);
        $this->assertFalse($config->getStrictVariables());
    }

    public function testTwig()
    {

        $adapter = $this->getTwigAdapter();
        $view = $adapter->getView();

        $view->assign('one', 'variableone');
        $view->assign('two', 'variabletwo');

        $response = $view->render('testlayout.twig', ['three' => 'variablethree'], 201);

        $response->getBody()->rewind();
        $content = $response->getBody()->getContents();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('variableonevariabletwovariablethree', $content);
    }

    public function getTwigAdapter(CacheInterface $cache = null): ViewAdapter
    {
        if (empty($cache)) {
            $cache = $this->megaFactory->getCache()->getFileCache();
        }
        $logger = $this->megaFactory->getLogger(true, 'test.log');

        $config = $this->getTwigConfig();
        $viewTopology = $this->getViewTopology();
        $webPage = new WebPageGeneric($viewTopology);
        $request = $this->megaFactory->getServer()->getServerRequest('https://example.com/page/open', 'GET');
        $responseFactory = $this->megaFactory->getServer()->getResponseFactory();

        return new TwigAdapter($config, $viewTopology, $webPage, $request, $responseFactory, $cache, $logger);
    }

    public function getViewTopology(): ViewTopology
    {
        $viewTopology = new ViewTopologyGeneric();
        $viewTopology->setBaseUrl('https://example.com')
                ->setCssUrl('https://example.com/css')
                ->setFontsUrl('https://example.com/fonts')
                ->setImagesUrl('https://https://example.com/images')
                ->setJsUrl('https://example.com/js')
                ->setLibsUrl('https://example.com/libs')
                ->setThemeUrl('https://example.com/theme')
                ->setTemplatePath($this->testsDirectory . DIRECTORY_SEPARATOR . 'mock_templates');
        return $viewTopology;
    }

    public function getTwigConfig(): TwigConfig
    {
        $twigConfig = new TwigConfigGeneric();
        $twigConfig->setCacheDir($this->compiledDirectory);
        $twigConfig->setAutoReload(true);
        $twigConfig->setDebug(true);
        return $twigConfig;
    }

}
