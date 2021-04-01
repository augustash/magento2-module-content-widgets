<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\Callout\Link as ParentCallout;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template as ParentTemplate;
use Magento\Framework\Exception\LocalizedException;

class Custom extends ParentCallout implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/custom_callout.phtml';

    /**
     * {@inheritdoc}
     */
    public function getHref()
    {
        try {
            parent::getHref();
            return $this->getData('href');
        } catch (\Exception $e) {
            return false;
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
            return '';
        }
    }

    /**
     * Prepare button label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        if (!$this->getData('anchor_text')) {
            return '';
        }

        return $this->getData('anchor_text');
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
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        return ParentTemplate::_toHtml();
    }
}
