<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Adminhtml\Widget;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory as ElementFactory;
use Magento\Widget\Block\BlockInterface;

/**
 * Widget text area block.
 */
class Textarea extends Template implements BlockInterface
{
    /**
     * @var \Magento\Framework\Data\Form\Element\Factory
     */
    protected $elementFactory;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        ElementFactory $elementFactory,
        array $data = []
    ) {
        $this->elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    /**
     * Prepare element HTML.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        /** @var \Magento\Framework\Data\Form\Element\Text $input */
        $input = $this->elementFactory->create(
            "textarea",
            [
                'data' => $element->getData()
            ]
        );
        $input->setId($element->getId());
        $input->setForm($element->getForm());
        $input->setClass("widget-option input-textarea admin__control-text");

        if ($element->getRequired()) {
            $input->addClass('required-entry');
        }

        $element->setData(
            'after_element_html',
            $input->getElementHtml()
        );

        return $element;
    }
}
