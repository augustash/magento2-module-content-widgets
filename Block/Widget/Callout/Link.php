<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\AbstractCallout;
use Augustash\ImageOptimizer\Helper\Data as ImageOptimizerHelper;
use Augustash\ImageOptimizer\Service\ImageResizer;
use Magento\Catalog\Model\ResourceModel\AbstractResource;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Store\Model\Store;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template\Context;

/**
 * Widget callout link block.
 */
class Link extends AbstractCallout
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
     * @var \Magento\Catalog\Model\ResourceModel\AbstractResource|null
     */
    protected $entityResource = null;

    /**
     * @var \Magento\UrlRewrite\Model\UrlFinderInterface
     */
    protected $urlFinder;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\ImageOptimizer\Helper\Data $imageOptimizerHelper
     * @param \Augustash\ImageOptimizer\Service\ImageResizer $imageResizer
     * @param \Magento\Catalog\Model\ResourceModel\AbstractResource|null $entityResource
     * @param \Magento\UrlRewrite\Model\UrlFinderInterface $urlFinder
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        ImageOptimizerHelper $imageOptimizerHelper,
        ImageResizer $imageResizer,
        $entityResource,
        UrlFinderInterface $urlFinder,
        Context $context,
        array $data = []
    ) {
        $this->imageOptimizerHelper = $imageOptimizerHelper;
        $this->imageResizer = $imageResizer;
        $this->entityResource = $entityResource;
        $this->urlFinder = $urlFinder;

        parent::__construct($context, $data);
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

        $resizedImageUrl = $this->getResizedImageUrlForImage('image');
        return $resizedImageUrl;
    }

    /**
     * Resize image and return the relative URL to the cached
     * version of the resized image.
     *
     * @param string $imageStyle
     * @return string
     */
    public function getResizedImageUrlForImage($imageStyle = 'image')
    {
        $resizer = $this->getImageResizer();
        $resizeWidth = $this->getResizeWidthForImage($imageStyle);
        $mediaPath = $this->getImageOptimizerHelper()->getPath('media');
        $filepath = $mediaPath . \DIRECTORY_SEPARATOR . $this->getData($imageStyle);

        $resizedImageUrl = $resizer->resize($filepath, $resizeWidth);
        return $resizedImageUrl;
    }

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
     * Prepare URL using passed ID path and return it.
     *
     * @return string|false
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getHref()
    {
        if (!$this->getData('href')) {
            if (!$this->getData('id_path')) {
                throw new LocalizedException(__('Link id_path is not set.'));
            }

            $href = false;
            $rewriteData = $this->parseIdPath($this->getData('id_path'));
            $store = $this->hasData('store_id')
                ? $this->_storeManager->getStore($this->getData('store_id'))
                : $this->_storeManager->getStore();
            $filterData = [
                UrlRewrite::ENTITY_ID => $rewriteData[1],
                UrlRewrite::ENTITY_TYPE => $rewriteData[0],
                UrlRewrite::STORE_ID => $store->getId(),
            ];

            if (!empty($rewriteData[2]) && $rewriteData[0] == ProductUrlRewriteGenerator::ENTITY_TYPE) {
                $filterData[UrlRewrite::METADATA]['category_id'] = $rewriteData[2];
            }

            $rewrite = $this->urlFinder->findOneByData($filterData);
            if ($rewrite) {
                $href = $store->getUrl('', [
                    '_direct' => $rewrite->getRequestPath(),
                ]);

                if ($this->addStoreCodeParam($store, $href)) {
                    $href .= (strpos($href, '?') === false ? '?' : '&')
                        . '___store='
                        . $store->getCode();
                }
            }

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
    public function getLabel(): string
    {
        if (!$this->getData('anchor_text')) {
            if ($this->entityResource) {
                $idPath = explode('/', $this->getData('id_path'));
                if (isset($idPath[1])) {
                    $id = $idPath[1];
                    if ($id) {
                        $text = $this->entityResource->getAttributeRawValue(
                            $id,
                            'name',
                            $this->_storeManager->getStore()
                        );
                        $this->setData('anchor_text', $text);
                    }
                }
            } else {
                $this->setData('anchor_text', 'Go');
            }
        }

        return $this->getData('anchor_text');
    }

    /**
     * Parse id_path parameter.
     *
     * @param string $idPath
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function parseIdPath($idPath): array
    {
        $rewriteData = explode('/', $idPath);

        if (!isset($rewriteData[0]) || !isset($rewriteData[1])) {
            throw new LocalizedException(__('Incorrect id_path structure.'));
        }

        return $rewriteData;
    }

    /**
     * Checks whether store code query param should be appended to the URL.
     *
     * @param \Magento\Store\Model\Store $store
     * @param string $url
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function addStoreCodeParam(Store $store, string $url): bool
    {
        return $this->getData('store_id')
            && !$store->isUseStoreInUrl()
            && $store->getId() !==  $this->_storeManager->getStore()->getId()
            && strpos($url, '___store') === false;
    }

    /**
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->getHref()) {
            return parent::_toHtml();
        }

        return '';
    }
}
