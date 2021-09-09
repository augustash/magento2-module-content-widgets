<?php

/**
 * Content Widgets
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Adminhtml\Widget;

use Augustash\ContentWidgets\Block\Adminhtml\Widget\Textarea as ParentClass;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Widget CSS text area block.
 */
class CssTextarea extends ParentClass
{
    /**
     * Prepare element HTML.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        $element = parent::prepareElementHtml($element);

        $element->setData(
            'value',
            \html_entity_decode(\urldecode($element->getData('value')))
        );


        return $element;
    }
}
