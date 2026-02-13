<?php

namespace app\utils;

use flight\Engine;

class ViewHelper {
    /**
     * Render a view within the base layout
     */
    public static function render(Engine $app, $view, $data = []) {
        // If the requested view lives in a subfolder but the file is missing,
        // try a fallback to the same filename at the root of the views folder.
        $viewsPath = $app->get('flight.views.path');
        $ext = $app->get('flight.views.extension') ?: '.php';
        $requested = $viewsPath . DIRECTORY_SEPARATOR . $view . $ext;
        if (!\file_exists($requested) && strpos($view, '/') !== false) {
            $fallbackView = basename($view);
            $fallbackPath = $viewsPath . DIRECTORY_SEPARATOR . $fallbackView . $ext;
            if (\file_exists($fallbackPath)) {
                $view = $fallbackView;
            }
        }

        // Render the view file to a string
        ob_start();
        $app->render($view, $data);
        $content = ob_get_clean();
        
        // Render the layout with the content
        $app->render('layout/base', ['content' => $content, 'title' => $data['title'] ?? 'Takalo-takalo']);
    }
}
