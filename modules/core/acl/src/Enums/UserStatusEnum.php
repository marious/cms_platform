<?php
namespace EG\ACL\Enums;

use Html;
use EG\Base\Supports\Enum;

class UserStatusEnum extends Enum
{
    public const ACTIVATED = 'activated';
    public const BEACTIVATED = 'deactivated';

    public function toHtml()
    {
        switch ($this->value) {
            case self::ACTIVATED:
                return Html::tag('span', self::ACTIVATED()->label(), ['class' => 'label-info status-label'])
                    ->toHtml();
            case self::DEACTIVATED:
                return Html::tag('span', self::DEACTIVATED()->label(), ['class' => 'label-warning status-label'])
                    ->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
