<?php
namespace EG\Blog\Forms;

use EG\Blog\Models\Tag;
use EG\Base\Forms\FormAbstract;
use EG\Base\Enums\BaseStatusEnum;
use EG\Blog\Http\Requests\TagRequest;
use Language;


class TagForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {

        $this
            ->setupModel(new Tag)
            ->setValidatorClass(TagRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                    'data-lang' => $this->getLang(),
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
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }

    public function getLang()
    {
        $lang = Language::getDefaultLocale();
        if (isset($_GET['ref_lang'])) {
            $lang = $_GET['ref_lang'];
        }
        return $lang;
    }
}

