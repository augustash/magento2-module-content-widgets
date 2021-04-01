<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Adminhtml\Widget;

use Magento\Backend\Block\Widget\Form\Element;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory as ElementFactory;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;

class Editor extends Element
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $wysiwygConfig;

    /**
     * @var \Magento\Framework\Data\Form\Element\Factory
     */
    protected $elementFactory;

    /**
     * Class constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        ElementFactory $elementFactory,
        WysiwygConfig $wysiwygConfig,
        Context $context,
        $data = []
    ) {
        $this->elementFactory = $elementFactory;
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $data);
    }

    /**
     * Prepare WYSIWYG element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        $editor = $this->elementFactory
            ->create('editor', ['data' => $element->getData()])
            ->setLabel('')
            ->setForm($element->getForm())
            ->setWysiwyg(true)
            ->setConfig(
                $this->wysiwygConfig->getConfig(
                    [
                        'add_variables' => false,
                        'add_widgets' => false
                    ]
                )
            );

        if ($element->getRequired()) {
            $editor->addClass('required-entry');
        }

        $element->setData(
            'after_element_html',
            $this->_getAfterElementHtml() . $editor->getElementHtml()
        );

        return $element;
    }

    /**
     * @return string
     */
    protected function _getAfterElementHtml()
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
}
