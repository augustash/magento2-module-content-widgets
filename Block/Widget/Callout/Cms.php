<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2020 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\AbstractCallout;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Cms\Model\ResourceModel\Page as PageResource;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template\Context;

/**
 * Widget CMS callout block.
 */
class Cms extends AbstractCallout
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    protected $cmsPageResource;

    /**
     * Cms page
     *
     * @var \Magento\Cms\Helper\Page
     */
    protected $cmsPageHelper;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Cms\Model\ResourceModel\Page $cmsPageResource
     * @param \Magento\Cms\Helper\Page $cmsPageHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        PageResource $cmsPageResource,
        PageHelper $cmsPageHelper,
        array $data = []
    ) {
        $this->cmsPageResource = $cmsPageResource;
        $this->cmsPageHelper = $cmsPageHelper;
        parent::__construct($context, $data);
    }

    /**
     * Prepare page URL. Use passed identifier or retrieve using passed page ID.
     *
     * @return string
     */
    public function getHref()
    {
        if (!$this->getData('page_id')) {
            throw new LocalizedException(__('CMS page ID is not set.'));
        }

        if (!$this->getData('href')) {
            $href = $this->cmsPageHelper->getPageUrl($this->getData('page_id'));
            $this->setData('href', $href);
        }

        return $this->getData('href');
    }

    /**
     * Prepare label attribute using passed title or retrieve page title
     * from DB using page ID.
     *
     * @return string
     */
    public function getLabel()
    {
        if (!$this->getData('anchor_text')) {
            if ($this->getData('page_id')) {
                $text = $this->cmsPageResource
                    ->getCmsPageTitleById($this->getData('page_id'));
                $this->setData('anchor_text', $text);
            } elseif ($this->getTitle()) {
                $this->setData('anchor_text', $this->getTitle());
            } else {
                $this->setData('anchor_text', 'Go');
            }
        }

        return $this->getData('anchor_text');
    }
}
