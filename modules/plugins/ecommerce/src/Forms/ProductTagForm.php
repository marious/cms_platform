<?php

namespace EG\Ecommerce\Forms;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Forms\FormAbstract;
use EG\Ecommerce\Http\Requests\ProductTagRequest;
use EG\Ecommerce\Models\ProductTag;
use Language;

class ProductTagForm extends FormAbstract
{

//    public $template = 'core/base::forms.form-tabs-multi-lang';

    public function __construct()
    {
        parent::__construct();

       if (count(Language::getSupportedLocales()) > 1) {
           $this->template = 'core/base::forms.form-tabs-multi-lang';
       }

    }

    public function buildForm()
    {
        $this
            ->hasMultiLangTabs()
            ->setupModel(new ProductTag)
            ->setValidatorClass(ProductTagRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                    'data-lang' => Language::getDefaultLocale(),
                    'class' => 'slug-field form-control',
                ],
            ])
            ->add('description', 'textarea', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
