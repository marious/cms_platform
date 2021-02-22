<?php

namespace EG\Ecommerce\Forms;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Forms\FormAbstract;
use EG\Ecommerce\Http\Requests\ProductCollectionRequest;
use EG\Ecommerce\Models\ProductCollection;

class ProductCollectionForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->hasMultiLangTabs()
            ->setupModel(new ProductCollection)
            ->setValidatorClass(ProductCollectionRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
//                'help_block' => [
//                    'text' => $this->getModel() ? trans('plugins/ecommerce::product-collections.slug_help_block',
//                        ['slug' => $this->getModel()->slug]) : null,
//                ],
            ])
//            ->add('slug', 'text', [
//                'label'      => trans('core/base::forms.slug'),
//                'label_attr' => ['class' => 'control-label required'],
//                'attr'       => [
//                    'data-counter' => 120,
//                ],
//            ])
            ->add('description', 'textarea', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('plugins/ecommerce::products.form.description'),
                    'data-counter' => 400,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
