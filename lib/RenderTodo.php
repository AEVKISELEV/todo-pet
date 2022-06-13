<?php

namespace Todo\lib;

class RenderTodo implements Render
{
    public static function renderTemplate(string $path, array $templateData = []): string
    {
        if(!file_exists($path))
        {
            return "";
        }
        extract($templateData, EXTR_OVERWRITE);
        ob_start();

        include $path;

        return  ob_get_clean();
    }

    public static function renderLayout(string $content, string $path, array $templateData = []):void
    {
        $data = array_merge($templateData, [
            'content' => $content
        ]);
        $result = self::renderTemplate($path, $data);
        echo $result;
    }
}