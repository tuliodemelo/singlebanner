<?php

namespace Fulcrum\Banner\Model\Source;


class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $banner;

    public function __construct(\Fulcrum\Banner\Model\Banners $banner)
    {
        $this->banner = $banner;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->getOptionArray();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

    public static function getOptionArray()
    {
        return [1 => __('Active'), 0 => __('Inactive')];
    }
}
