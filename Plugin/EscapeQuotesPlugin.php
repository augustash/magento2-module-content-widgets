<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Plugin;

use Magento\Widget\Model\Widget as Subject;

/**
 * Escape/replace double quotes from WYSIWYG or raw HTML content
 * because the widget directive also uses double quotes.
 */
class EscapeQuotesPlugin
{
    /**
     * Escape/replace double quotes in HTML content to avoid
     * premature closures and loss of data.
     *
     * @param \Magento\Widget\Model\Widget $subject
     * @param string $type
     * @param array $params
     * @param bool $asIs
     * @return array
     */
    public function beforeGetWidgetDeclaration(
        Subject $subject,
        $type,
        $params = [],
        $asIs = true
    ): array {
        foreach ($params as $name => $value) {
            if (\is_string($value)) {
                // Replace double quotes if value contains HTML content
                if ($value != \strip_tags($value)) { // check if value contains HTML tags
                    $html = \str_replace('"', "'", $value);
                    $params[$name] = $html;
                }
            }
        }

        return [$type, $params, $asIs];
    }
}
