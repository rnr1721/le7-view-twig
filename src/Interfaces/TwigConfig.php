<?php

declare(strict_types=1);

namespace Core\Interfaces;

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
     * The autoescape setting in Twig determines whether output should be
     * automatically escaped to prevent XSS attacks and other security
     * vulnerabilities.
     * If the autoescape option is set to true, then Twig will automatically
     * escape all output. By default, this option is set to html and handles
     * special HTML characters such as <, >, ", ', and &. Other possible
     * values for this option are:
     * js: escapes data for use in a JavaScript context.
     * css: escapes data for use in CSS context.
     * url: escapes data for use in a URL context.
     * If you want to disable auto-escaping, set the autoescape option to false.
     * @return self
     */
    public function setAutoEscape(string|array $value): self;

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
     * @return array|false
     */
    public function getAutoEscape(): array|false;
}
