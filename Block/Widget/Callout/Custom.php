<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\Callout\OptionalLink as ParentCallout;
use Magento\Widget\Block\BlockInterface;

class Custom extends ParentCallout
{
    /**
     * @var string
     */
    protected $_template = 'widget/custom_callout.phtml';

    /**
     * @var string
     */
    protected $_defaultMode = 'left';

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        try {
            $description = htmlspecialchars_decode(parent::getDescription());
            return $description;
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Should content be allowed to breakout of the parent container.
     *
     * @return boolean
     */
    public function getBreakoutParentContainer(): bool
    {
        return (bool) $this->getData('breakout_parent_container');
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

    /**
     * Return array of allowed HTML tags that escapeHtml should let through.
     *
     * @return array
     */
    public function getAllowedHtmlTags(): array
    {
        return ['p', 'a', 'strong', 'em', 'b', 'i', 'ul', 'ol', 'li', 'span', 'div', 'br'];
    }
}
