<?php

declare(strict_types=1);

namespace Core\Interfaces;

use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;

interface TwigConfig
{

    /**
     * Set both left and right delimiters for Twig (variables)
     * @param string $left Left delimiter
     * @param string $right Right delimiter
     * @return self
     */
    public function setDelimitersVariable(string $left, string $right): self;

    /**
     * Set both left and right delimiters for Twig (block)
     * @param string $left Left delimiter
     * @param string $right Right delimiter
     * @return self
     */
    public function setDelimitersBlock(string $left, string $right): self;

    /**
     * Set both left and right delimiters for Twig (comments)
     * @param string $left Left delimiter
     * @param string $right Right delimiter
     * @return self
     */
    public function setDelimitersComment(string $left, string $right): self;

    /**
     * Directory for Twig compiled files
     * @param string $compiledDir
     * @return self
     */
    public function setCacheDir(string $compiledDir): self;

    /**
     * Set error reporting level
     * @param bool $value Turn on or off debug
     * @return self
     */
    public function setdebug(bool $value): self;

    /**
     * Set Twig extensions directory
     * @param string|array $dir Directory
     * @return self
     */
    public function setExtensionsDir(string|array $dir): self;

    /**
     * When auto_reload is set to true, Twig will automatically recompile
     * templates if they have changed. This can be useful during application
     * development because you don't have to restart the server every time
     * you change templates.
     * @param bool $value
     * @return self
     */
    public function setAutoReload(bool $value): self;

    /**
     * The strict_variables option in Twig determines whether an exception
     * should be thrown if the variable is not defined in the template. By
     * default, this option is disabled, which means that if a variable is
     * not defined, Twig simply outputs it as an empty string. When
     * strict_variables is set to true, Twig throws an exception if you
     * try to access an undefined variable. This is useful for detecting
     * errors in templates during development, but can cause problems if
     * used in a production environment, especially if template variables
     * are defined dynamically based on conditions.
     * @param bool $value
     * @return self
     */
    public function setStrictVariables(bool $value): self;

    /**
     * 'utf-8' by default
     * @param string $charset
     * @return self
     */
    public function setCharSet(string $charset): self;

    /**
     * Sets the default auto-escaping strategy (name, html, js, css, url,
     * html_attr, or a PHP callback that takes the template "filename" and
     * returns the escaping strategy to use -- the callback cannot be a
     * function name to avoid collision with built-in escaping strategies);
     * set it to false to disable auto-escaping. The name escaping strategy
     * determines the escaping strategy to use for a template based on the
     * template filename extension (this strategy does not incur any overhead
     * at runtime as auto-escaping is done at compilation time.)
     * @param string $value
     * @return self
     */
    public function setAutoEscape(string $value): self;

    /**
     * Get config as single array
     * @return array
     */
    public function getConfig(): array;

    /**
     * Get Smarty left delimiter for variables
     * @return string
     */
    public function getLeftDelimiterVariable(): string;

    /**
     * Get Smarty right delimiter for variables
     * @return string
     */
    public function getRightDelimiterVariable(): string;

    /**
     * Get Smarty left delimiter for blocks
     * @return string
     */
    public function getLeftDelimiterBlock(): string;

    /**
     * Get Smarty right delimiter for blocks
     * @return string
     */
    public function getRightDelimiterBlock(): string;

    /**
     * Get Smarty left delimiter for comments
     * @return string
     */
    public function getLeftDelimiterComment(): string;

    /**
     * Get Smarty right delimiter for comments
     * @return string
     */
    public function getRightDelimiterComment(): string;

    /**
     * Get directory to store compiled files
     * @return string
     */
    public function getCacheDir(): string;

    /**
     * Get error reporting level
     * @return bool
     */
    public function getDebug(): bool;

    /**
     * Get application plugins directory
     * @return array
     */
    public function getExtensionsDir(): array;

    /**
     * Get Twig AutoReload option value
     * @return bool
     */
    public function getAutoReload(): bool;

    /**
     * Get strict_variables option value
     * @return bool
     */
    public function getStrictVariables(): bool;

    /**
     * Get charset (utf-8 by default)
     * @return string
     */
    public function getCharSet(): string;

    /**
     * Get AutoEscape option
     * @return string|false
     */
    public function getAutoEscape(): string|false;

    /**
     * Get added Twig filters
     * @return array
     */
    public function getFilters(): array;

    /**
     * Get added Twig extensions
     * @return array
     */
    public function getExtensions(): array;

    /**
     * Add own twig filter
     * @param TwigFilter $filter
     * @return self
     */
    public function addFilter(TwigFilter $filter): self;

    /**
     * Add own twig extension
     * @param ExtensionInterface $extension
     * @return self
     */
    public function addExtension(ExtensionInterface $extension): self;
}
