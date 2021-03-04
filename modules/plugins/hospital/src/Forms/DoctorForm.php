<?php

namespace EG\Hospital\Forms;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Forms\FormAbstract;
use EG\Hospital\Http\Requests\DoctorRequest;
use EG\Hospital\Models\Doctor;
use Language;

class DoctorForm extends FormAbstract
{
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
            ->setupModel(new Doctor)
            ->setValidatorClass(DoctorRequest::class)
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
            ->add('department_id', 'select', [
                'label'         => trans('plugins/hospital::hospital.department'),
                'label_attr'    => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'       => get_departments(),
            ])
            ->add('phone', 'number', [
                'label'      => trans('core/base::forms.phone'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.phone_placeholder'),
                    'data-counter' => 25,
                    'class' => 'form-control',
                ],
            ])
            ->add('mobile', 'number', [
                'label'      => trans('core/base::forms.mobile'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.mobile_placeholder'),
                    'data-counter' => 25,
                    'class' => 'form-control',
                ],
            ])
            ->add('description', 'editor', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                ],
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
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
