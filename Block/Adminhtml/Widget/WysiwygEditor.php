<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Adminhtml\Widget;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory as ElementFactory;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class WysiwygEditor extends Template
{

    const TEXT_AREA_ID = 'calloutDescriptionWidget';

    /**
     * @var \Magento\Framework\Data\Form\Element\Factory
     */
    protected $elementFactory;

    /**
     * @var \Magento\Framework\View\Helper\SecureHtmlRenderer
     */
    protected $secureRenderer;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param \Magento\Framework\View\Helper\SecureHtmlRenderer $secureRenderer
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        ElementFactory $elementFactory,
        SecureHtmlRenderer $secureRenderer,
        Context $context,
        array $data = []
    ) {
        $this->secureRenderer = $secureRenderer;
        $this->elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $input = $this->elementFactory->create("textarea", ['data' => $element->getData()]);
        $input->setId(self::TEXT_AREA_ID);
        $input->setForm($element->getForm());
        $input->setClass("widget-option input-textarea admin__control-text");
        if ($element->getRequired()) {
            $input->addClass('required-entry');
        }

        $element->setData('after_element_html', $input->getElementHtml() . $this->addAfterHtmlJs() . $this->getAfterElementHtmlCss());
        return $element;
    }

    /**
     * Initialize WYSIWYG editor.
     *
     * @return string
     */
    public function addAfterHtmlJs()
    {
        $scriptString = <<<HTML
    require([
        'jquery',
        'mage/adminhtml/wysiwyg/tiny_mce/setup'
    ], function(jQuery){
        wysiwygcompany_description = new wysiwygSetup(
            '{$this->getHtmlId()}',
            {
                "width":"100%%",  // defined width of editor
                "height":"200px", // height of editor
                "plugins":[], // for image
                "tinymce4":{
                    "toolbar":"formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table charmap",
                    "plugins":"advlist autolink lists link charmap media noneditable table contextmenu paste code help table"
                }
            }
        );
        wysiwygcompany_description.setup("exact");
    });
HTML;
        return $this->secureRenderer->renderTag('script', [], $scriptString, false);
    }

    /**
     * @return string
     */
    protected function getAfterElementHtmlCss()
    {
        $html = <<<HTML
<style>
    .admin__field-control.control .control-value {
        display: none !important;
    }
</style>
HTML;
        return $html;
    }

    /**
     * Return hard-coded dom element ID.
     *
     * @return string
     */
    public function getHtmlId()
    {
        return self::TEXT_AREA_ID;
    }
}
