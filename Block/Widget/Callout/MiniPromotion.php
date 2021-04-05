<?php

/**
 * Content Widgets
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\ContentWidgets\Block\Widget\Callout;

use Augustash\ContentWidgets\Block\Widget\Callout\Promotion as ParentCallout;

/**
 * Widget mini promotional block class.
 */
class MiniPromotion extends ParentCallout
{
    /**
     * @var string
     */
    protected $_template = 'widget/mini_promotion.phtml';

    /**
     * @var string
     */
    protected $_defaultMode = 'left';

}