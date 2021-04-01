<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Html\Link;
use Magento\Widget\Block\BlockInterface;

/**
 * Widget callout block.
 */
abstract class AbstractCallout extends Link implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/callout.phtml';

    /**
     * @var string
     */
    protected $_defaultMode = 'left';

    /**
     * Get callout image URL.
     *
     * @return string
     */
    public function getImage()
    {
        if (!$this->getData('image')) {
            throw new LocalizedException(__('Callout image is not set.'));
        }

        $mediaUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return sprintf(
            '%s%s',
            $mediaUrl,
            $this->getData('image')
        );
    }

    /**
     * Get callout heading.
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getHeading()
    {
        if (!$this->getData('heading')) {
            throw new LocalizedException(__('Callout heading is not set.'));
        }

        return $this->getData('heading');
    }

    /**
     * Get callout subtitle.
     *
     * @return string
     */
    public function getSubtitle()
    {
        if (!$this->getData('subtitle')) {
            return '';
        }

        return $this->getData('subtitle');
    }

    /**
     * Get callout description.
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDescription()
    {
        if (!$this->getData('description')) {
            throw new LocalizedException(__('Callout description is not set.'));
        }

        return $this->getData('description');
    }

    /**
     * Get display mode.
     *
     * @return string
     */
    public function getDisplayMode()
    {
        if (!$this->getData('display_mode')) {
            return $this->_defaultMode;
        }

        return $this->getData('display_mode');
    }
}
