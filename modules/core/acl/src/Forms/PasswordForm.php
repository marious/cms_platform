<?php

namespace EG\ACL\Forms;

use Html;
use EG\ACL\Models\User;
use EG\Base\Forms\FormAbstract;
use EG\ACL\Http\Requests\UpdatePasswordRequest;

class PasswordForm extends FormAbstract
{
    public function buildForm()
    {
        $this
            ->setupModel(new User)
            ->setValidatorClass(UpdatePasswordRequest::class)
            ->setFormOption('template', 'core/base::forms.form-no-wrap')
            ->setFormOption('id', 'password-form')
            ->add('old_password', 'password', [
                'label'     => trans('core/acl::users.current_password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 60
                ],
                'wrapper' => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ]
            ])
            ->add('password', 'password', [
                'label'     => trans('core/acl::users.new_password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 60
                ],
                'wrapper' => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
                'help_block' => [
                    'text' => Html::tag('span', 'Password Strength', ['class' => 'hidden'])->toHtml(),
                    'tag' => 'div',
                    'attr' => [
                        'class' => 'pwstrength_viewport_progress',
                    ]
                ]
            ])
            ->add('password_confirmation', 'password', [
                'label' => trans('core/acl::users.confirm_new_password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 60
                ],
                'wrapper' => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ]
            ])
            ->setActionButtons(view('core/acl::users.profile.actions')->render());

    }
}
