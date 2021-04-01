<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Model\Config\Source\Displaymode;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Widget callout display mode class.
 * @api
 */
class Callout implements OptionSourceInterface
{
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'left',
                'label' => __('Left')
            ],
            [
                'value' => 'right',
                'label' => __('Right')
            ],
        ];
    }

    /**
     * Get options in "key-value" format.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'left' => __('Left'),
            'right' => __('Right'),
        ];
    }
}
