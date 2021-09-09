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

        $resizedImageUrl = $this->getResizedImageUrlForImage('large_image');
        return $resizedImageUrl;
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
        }

        $resizedImageUrl = $this->getResizedImageUrlForImage('medium_image');
        return $resizedImageUrl;
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
        }

        $resizedImageUrl = $this->getResizedImageUrlForImage('small_image');
        return $resizedImageUrl;
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
     * Should text color be inverted?
     *
     * @return boolean
     */
    public function getInvertedColor(): bool
    {
        return (bool) $this->getData('inverted_color');
    }

    /**
     * Return preference for how the content should be positioned on mobile
     * or small devices (i.e., 'overlay-image' or 'stacked-below-image').
     *
     * @return string
     */
    public function getMobileContentPosition()
    {
        return $this->getData('mobile_content_position');
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

    /**
     * Return the custom CSS that will be embedded
     * within a template in a <style> tag.
     *
     * @return null|string
     */
    public function getCssStyles(): ?string
    {
        if (!$this->getData('css_styles')) {
            return null;
        }

        return $this->getData('css_styles');
    }
}
