<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Widget mobile content position source class.
 * @api
 */
class MobileContentPosition implements OptionSourceInterface
{
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [ 'value' => 'overlay-image', 'label' => __('Overlay on top of image') ],
            [ 'value' => 'stacked-below-image', 'label' => __('Stacked below image') ]
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
            'overlay-image' => __('Overlay on top of image'),
            'stacked-below-image' => __('Stacked below image'),
        ];
    }
}
