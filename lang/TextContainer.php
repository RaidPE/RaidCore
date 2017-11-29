<?php

namespace Raid\lang;

class TextContainer
{
    protected $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function __toString() : string
    {
        return $this->getText();
    }
}