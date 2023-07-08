<?php

namespace MPesic381\Placeholders;

use Exception;

class Placeholders
{
    protected array $replacements = [];
    protected array $config = [];
    protected $start;
    protected $end;
    protected $behavior;

    private const BEHAVIOUR_ERROR = 'error';
    private const BEHAVIOUR_SKIP = 'skip';
    private const BEHAVIOUR_PRESERVE = 'preserve';

    private array $behaviours = [
        self::BEHAVIOUR_ERROR,
        self::BEHAVIOUR_SKIP,
        self::BEHAVIOUR_PRESERVE
    ];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Sets a global replacement for a placeholder
     *
     * @param  string  $string
     * @param  string  $value
     * @return void
     */
    public function set(string $string, string $value): void
    {
        $this->replacements[$string] = $value;
    }

    /**
     * @param  string  $start
     * @param  string  $end
     * @return void
     */
    public function setStyle(string $start, string $end): void
    {
        $this->setStart($start);
        $this->setEnd($end);
    }

    /**
     * @param  bool  $escaped
     * @return string
     */
    public function getStart(bool $escaped = false): string
    {
        $start = $this->start ?? $this->config['start'];
        return $escaped ? preg_quote($start) : $start;
    }

    /**
     * @param  string  $start
     * @return void
     */
    public function setStart(string $start): void
    {
        $this->start = $start;
    }

    /**
     * @param  string  $end
     * @return void
     */
    public function setEnd(string $end): void
    {
        $this->end = $end;
    }

    /**
     * @param  bool  $escaped
     * @return string
     */
    public function getEnd(bool $escaped = false): string
    {
        $end = $this->end ?? $this->config['end'];
        return $escaped ? preg_quote($end) : $end;
    }

    /**
     * @param  string  $behavior
     * @return void
     * @throws Exception
     */
    public function setBehavior(string $behavior): void
    {
        if (! in_array($behavior, $this->behaviours)) {
            throw new Exception("Could not find that behaviour. Choose one of the following: " . implode(','), $this->behaviours);
        }
        $this->behavior = $behavior;
    }

    /**
     * @return string
     */
    public function getBehavior(): string
    {
        return $this->behavior ?? $this->config['behavior'];
    }

    /**
     * Checks a string for placeholders and then replaces them with the appropriate values
     *
     * @param  string  $string  A string containing placeholders
     * @param  array  $replacements  An array of key/value replacements
     * @return string               The new string
     * @throws Exception
     */
    public function parse(string $string, array $replacements = []): string
    {
        $replacements = array_merge($this->replacements, $replacements);
        foreach ($replacements as $key => $val) {
            $string = str_ireplace($this->getStart().$key.$this->getEnd(), $val, $string);
        }

        $skipped = $this->catchSkippedPlaceholders($string);

        return match($this->getBehavior()) {
            self::BEHAVIOUR_ERROR => !$skipped ? $string : throw new Exception("Could not find a replacement for ".$skipped[0], 1),
            self::BEHAVIOUR_SKIP => $this->removeSkippedPlaceholders($string, $skipped),
            self::BEHAVIOUR_PRESERVE => $string
        };
    }

    /**
     * Checks for any placeholders that are in the
     * string and then throws an Exception if one exists
     * @param  string $string The string to check
     */
    protected function catchSkippedPlaceholders(string $string)
    {
        $matches = [];
        $pattern = "/".$this->getStart(true).".*?".$this->getEnd(true)."/";
        preg_match($pattern, $string, $matches);

        return $matches;
    }

    /**
     * @param  string  $string
     * @param  array  $placeholders
     * @return string
     */
    protected function removeSkippedPlaceholders(string $string, array $placeholders = []): string
    {
        foreach ($placeholders as $placeholder) {
            $string = str_replace($placeholder, '', $string);
        }

        return $string;
    }
}
