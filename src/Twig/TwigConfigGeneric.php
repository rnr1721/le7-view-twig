<?php

declare(strict_types=1);

namespace Core\View\Twig;

use Core\Interfaces\TwigConfig;
use \Exception;

class TwigConfigGeneric implements TwigConfig
{

    private array $config = [
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

    public function setDelimitersVariable(string $left, string $right): self
    {
        $this->config['leftDelimiterVariable'] = $left;
        $this->config['rightDelimiterVariable'] = $right;
        return $this;
    }

    public function setDelimitersBlock(string $left, string $right): self
    {
        $this->config['leftDelimiterBlock'] = $left;
        $this->config['rightDelimiterBlock'] = $right;
        return $this;
    }

    public function setDelimitersComment(string $left, string $right): self
    {
        $this->config['leftDelimiterComment'] = $left;
        $this->config['rightDelimiterComment'] = $right;
        return $this;
    }

    public function setCacheDir(string $compiledDir): self
    {
        $this->config['cacheDir'] = $compiledDir;
        return $this;
    }

    public function setDebug(bool $value = false): self
    {
        $this->config['debug'] = $value;
        return $this;
    }

    public function setExtensionsDir(string|array $dir): self
    {
        if (is_array($dir)) {
            foreach ($dir as $item) {
                $this->addExtensionsDir($item);
            }
        } else {
            $this->addExtensionsDir($dir);
        }
        return $this;
    }

    private function addExtensionsDir(string $dir): void
    {
        $this->config['extensions'][] = $dir;
    }

    public function setAutoReload(bool $value): self
    {
        $this->config['autoreload'] = $value;
        return $this;
    }

    public function setStrictVariables(bool $value): self
    {
        $this->config['strict_variables'] = $value;
        return $this;
    }

    public function setCharSet(string $charset): self
    {
        $this->config['charset'] = $charset;
        return $this;
    }

    public function setAutoEscape(string|array $field, bool $value = true): self
    {
        $allowed = ['html', 'css', 'js', 'url', 'html_attr', 'xml'];
        if (is_string($field)) {
            $field = explode(',', $field);
        }
        foreach ($field as $item) {
            if (!array_key_exists($item, $this->config['autoescape'])) {
                if (in_array($item, $allowed)) {
                    $this->config['autoescape'][$item] = $value;
                } else {
                    throw new Exception("Allowed Twig autoescape items:" . implode(',', $allowed));
                }
            }
        }
        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getLeftDelimiterVariable(): string
    {
        return $this->config['leftDelimiterVariable'];
    }

    public function getRightDelimiterVariable(): string
    {
        return $this->config['rightDelimiterVariable'];
    }

    public function getLeftDelimiterBlock(): string
    {
        return $this->config['leftDelimiterBlock'];
    }

    public function getRightDelimiterBlock(): string
    {
        return $this->config['rightDelimiterBlock'];
    }

    public function getLeftDelimiterComment(): string
    {
        return $this->config['leftDelimiterComment'];
    }

    public function getRightDelimiterComment(): string
    {
        return $this->config['rightDelimiterComment'];
    }

    public function getCacheDir(): string
    {
        return $this->config['cacheDir'];
    }

    public function getDebug(): bool
    {
        return $this->config['debug'];
    }

    public function getExtensionsDir(): array
    {
        return $this->config['extensions'];
    }

    public function getAutoReload(): bool
    {
        return $this->config['autoreload'];
    }

    public function getStrictVariables(): bool
    {
        return $this->config['strict_variables'];
    }

    public function getCharSet(): string
    {
        return $this->config['charset'];
    }

    public function getAutoEscape(): array|false
    {
        if (count($this->config['autoescape']) === 0) {
            return false;
        }
        return $this->config['autoescape'];
    }

}
