<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\Callout\Link as ParentCallout;

/**
 * Widget promotional block class.
 */
class Promotion extends ParentCallout
{
    /**
     * @var string
     */
    protected $_template = 'widget/promotion.phtml';

    /**
     * @var string
     */
    protected $_defaultMode = 'center';

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        try {
            return parent::getImage();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        try {
            return parent::getDescription();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get badge label.
     *
     * @return string
     */
    public function getBadgeLabel(): string
    {
        if (!$this->getData('badge_label')) {
            return __('Special');
        }

        return $this->getData('badge_label');
    }

    /**
     * Should special badge be shown?
     *
     * @return boolean
     */
    public function getShowBadge(): bool
    {
        return (bool) $this->getData('show_badge');
    }

    /**
     * Should text color be inverted?
     *
     * @return boolean
     */
    public function getInvertedColor(): bool
    {
        return (bool) $this->getData('inverted_color');
    }
}
