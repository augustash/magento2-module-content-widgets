<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget;

use Augustash\ImageOptimizer\Helper\Data as ImageOptimizerHelper;
use Augustash\ImageOptimizer\Service\ImageResizer;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Html\Link;

/**
 * Widget callout block.
 */
abstract class AbstractCallout extends Link implements BlockInterface
{
    /**
     * @var \Augustash\ImageOptimizer\Helper\Data
     */
    protected $imageOptimizerHelper;

    /**
     * @var \Augustash\ImageOptimizer\Service\ImageResizer
     */
    protected $imageResizer;

    /**
     * @var string
     */
    protected $_template = 'widget/callout.phtml';

    /**
     * @var string
     */
    protected $_defaultMode = 'left';

    /**
     * Return the Augustash_ImageOptimizer ImageResizer class.
     *
     * @return \Augustash\ImageOptimizer\Service\ImageResizer
     */
    public function getImageResizer(): ImageResizer
    {
        return $this->imageResizer;
    }

    /**
     * Return the Augustash_ImageOptimizer helper class.
     *
     * @return \Augustash\ImageOptimizer\Helper\Data $imageOptimizerHelper
     */
    public function getImageOptimizerHelper(): ImageOptimizerHelper
    {
        return $this->imageOptimizerHelper;
    }

    /**
     * Return integer value of the width of width the image should be resized to.
     * Defaults to 400 if no matching image style is found (i.e., 'small_image',
     * 'medium_image', 'large_image', and 'image').
     *
     * @param string $imageStyle
     * @return int
     */
    public function getResizeWidthForImage($imageStyle = 'image')
    {
        switch (strtolower(trim($imageStyle))) {
            case 'icon_image':
                $width = $this->getIconImageResizeWidth();
                break;

            case 'thumbnail_image':
                $width = $this->getThumbnailImageResizeWidth();
                break;

            case 'small_image':
                $width = $this->getSmallImageResizeWidth();
                break;

            case 'medium_image':
                $width = $this->getMediumImageResizeWidth();
                break;

            case 'large_image':
                $width = $this->getLargeImageResizeWidth();
                break;

            case 'image':
            default:
                $width = $this->getImageResizeWidth();
                break;
        }

        return (int)$width;
    }

    /**
     * Return integer value of the width the image should be resized to.
     * Defaults to 400 if not specified.
     *
     * @return int
     */
    public function getImageResizeWidth()
    {
        if (!$this->getData('image_resize_width')) {
            return 400;
        }

        return (int)$this->getData('image_resize_width');
    }

    /**
     * Return integer value of the width the large image should be resized to.
     * Defaults to 1280 if not specified.
     *
     * @return int
     */
    public function getLargeImageResizeWidth()
    {
        if (!$this->getData('large_image_resize_width')) {
            return 1280;
        }

        return (int)$this->getData('large_image_resize_width');
    }

    /**
     * Return integer value of the width the medium image should be resized to.
     * Defaults to 768 if not specified.
     *
     * @return int
     */
    public function getMediumImageResizeWidth()
    {
        if (!$this->getData('medium_image_resize_width')) {
            return 768;
        }

        return (int)$this->getData('medium_image_resize_width');
    }

    /**
     * Return integer value of the width the small image should be resized to.
     * Defaults to 320 if not specified.
     *
     * @return int
     */
    public function getSmallImageResizeWidth()
    {
        if (!$this->getData('small_image_resize_width')) {
            return 320;
        }

        return (int)$this->getData('small_image_resize_width');
    }

    /**
     * Return integer value of the width the thumbnail image should be resized to.
     * Defaults to 80 if not specified.
     *
     * @return int
     */
    public function getThumbnailImageResizeWidth()
    {
        if (!$this->getData('thumbnail_image_resize_width')) {
            return 80;
        }

        return (int)$this->getData('thumbnail_image_resize_width');
    }

    /**
     * Return integer value of the width the icon image should be resized to.
     * Defaults to 80 if not specified.
     *
     * @return int
     */
    public function getIconImageResizeWidth()
    {
        if (!$this->getData('icon_image_resize_width')) {
            return 40;
        }

        return (int)$this->getData('icon_image_resize_width');
    }

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
