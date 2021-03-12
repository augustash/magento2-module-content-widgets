<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\Callout\Link as ParentCallout;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;

/**
 * Widget Banner block class.
 */
class Banner extends ParentCallout
{
    /**
     * @var string
     */
    protected $_template = 'widget/banner.phtml';

    /**
     * @var string
     */
    protected $_defaultMode = 'background';

    /**
     * Get large banner image URL.
     *
     * @return string
     */
    public function getLargeImage()
    {
        if (!$this->getData('large_image')) {
            throw new LocalizedException(__('Large image is not set.'));
        }

        return sprintf(
            '%s%s',
            $this->getMediaUrl(),
            $this->getData('large_image')
        );
    }

    /**
     * Get medium banner image URL.
     *
     * @return null|string
     */
    public function getMediumImage(): ?String
    {
        if (!$this->getData('medium_image')) {
            return null;
            // throw new LocalizedException(__('Medium image is not set.'));
        }

        return sprintf(
            '%s%s',
            $this->getMediaUrl(),
            $this->getData('medium_image')
        );
    }

    /**
     * Get small banner image URL.
     *
     * @return null|string
     */
    public function getSmallImage(): ?String
    {
        if (!$this->getData('small_image')) {
            return null;
            // throw new LocalizedException(__('Small image is not set.'));
        }

        return sprintf(
            '%s%s',
            $this->getMediaUrl(),
            $this->getData('small_image')
        );
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
     * Should text color be inverted?
     *
     * @return boolean
     */
    public function getInvertedColor(): bool
    {
        return (bool) $this->getData('inverted_color');
    }

    /**
     * Return the URL to the pub/media directory
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }
}