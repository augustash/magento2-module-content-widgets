<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Plugin;

use Magento\Widget\Model\Widget as Subject;

/**
 * Fix image chooser URL class.
 */
class FixImageChooserUrlPlugin
{
    /**
     * Fixes image URLs within widget templates.
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
                if (preg_match('/(___directive\/)([a-zA-Z0-9,_-]+)/', $value, $matches)) {
                    $directive = \base64_decode(strtr($matches[2], '-_,', '+/='));
                    $params[$name] = \str_replace(
                        ['{{media url="', '"}}'],
                        ['', ''],
                        $directive
                    );
                }
            }
        }

        return [$type, $params, $asIs];
    }
}
