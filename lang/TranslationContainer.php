<?php

namespace Raid\lang;

class TranslationContainer extends TextContainer
{
    protected $params = [];

    public function __construct(string $text, array $params = [])
    {
        parent::__construct($text);
        $this->setParameters($params);
    }

    public function getParameters() : array
    {
        return $this->params;
    }

    function getParameter(int $i)
    {
        return $this->params[$i] ?? null;
    }

    public function setParameter(int $i, string $str)
    {
        if($i < 0 or $i > count($this->params))
            throw new \InvalidArgumentException("Invalid index $i, have " . count($this->params));

        $this->params[$i] = $str;
    }

    public function setParameters(array $params)
    {
        $i = 0;
        foreach($params as $str)
        {
            $this->params[$i] = (string) $str;

            ++$i;
        }
    }
}