<?php

namespace Todo\lib;

interface Render
{
    public static function renderTemplate(string $path, array $templateData = []): string;
    public static function renderLayout(string $content, string $path, array $templateData = []): void;
}