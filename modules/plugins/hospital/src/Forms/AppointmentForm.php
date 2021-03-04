<?php

namespace EG\Hospital\Forms;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Forms\FormAbstract;
use EG\Hospital\Http\Requests\AppointmentRequest;
use EG\Hospital\Models\Appointment;
use Language;

class AppointmentForm extends FormAbstract
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buildForm()
    {
        $this
            ->setupModel(new Appointment())
            ->setValidatorClass(AppointmentRequest::class)
            ->withCustomFields()
            ->add('patient_name', 'text', [
                'label'      => trans('plugins/hospital::appointment.form.patient_name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/hospital::appointment.form.patient_name'),
                    'class' => 'form-control',
                ],
            ])
            ->add('patient_phone', 'number', [
                'label'      => trans('plugins/hospital::appointment.form.patient_phone'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/hospital::appointment.form.patient_phone'),
                    'class' => 'form-control',
                ],
            ])
            ->add('patient_email', 'text', [
                'label'      => trans('plugins/hospital::appointment.form.patient_email'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('plugins/hospital::appointment.form.patient_email'),
                    'class' => 'form-control',
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
            ->add('appointment_date', 'text', [
                'label'         => trans('plugins/hospital::appointment.form.appointment_date'),
                'label_attr'    => ['class' => 'required control-label'],
                'attr'       => [
                    'id'                => 'datetimepicker',
                    'class'             => 'form-control form-date-time',
                    'date-date'         => 
                ],
            ])

            ->add('message', 'textarea', [
                'label'      => trans('plugins/hospital::appointment.form.message'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                ],
            ]);


    }
}
