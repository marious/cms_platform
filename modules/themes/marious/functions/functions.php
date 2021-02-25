<?php
add_shortcode('banner-section', 'Banner section', 'Banner section', function () {
   return Theme::partial('short-codes.banner-section');
});

add_shortcode('clients-section', 'Clients section', 'Clients section', function () {
    return Theme::partial('short-codes.clients-section');
});

add_shortcode('counter-section', 'Counter section', 'Counter section', function () {
    return Theme::partial('short-codes.counter-section');
});

add_shortcode('gallery-section', 'Gallery section', 'Gallery section', function () {
    return Theme::partial('short-codes.gallery-section');
});

add_shortcode('intouch-section', 'Intouch section', 'Intouch section', function () {
    return Theme::partial('short-codes.intouch-section');
});

add_shortcode('mission-section', 'Mission section', 'Mission section', function () {
    return Theme::partial('short-codes.mission-section');
});

add_shortcode('news-section', 'News section', 'News section', function () {
    return Theme::partial('short-codes.news-section');
});

add_shortcode('services-section', 'Services section', 'Services section', function () {
    return Theme::partial('short-codes.services-section');
});


add_shortcode('testimonial-section', 'Testimonial section', 'Testimonial section', function () {
    return Theme::partial('short-codes.testimonial-section');
});

theme_option()
    ->setField([
        'id'         => 'site_description',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Site description'),
        'attributes' => [
            'name'    => 'site_description',
            'value'   => __('Leaders Group Company'),
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 255,
            ],
        ],
    ])
    ->setField([
        'id'         => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'googleFonts',
        'label'      => __('Primary font'),
        'attributes' => [
            'name'  => 'primary_font',
            'value' => 'Roboto',
        ],
    ])
    ->setField([
        'id'         => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Copyright'),
        'attributes' => [
            'name'    => 'copyright',
            'value'   => '© '.date('Y').' Leaders Group All Right Reserved.',
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => __('Change copyright'),
                'data-counter' => 250,
            ]
        ],
        'helper' => __('Copyright on footer of site'),
    ])
    ->setField([
        'id'         => 'phone_number',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Phone number'),
        'attributes' => [
            'name'    => 'phone_number',
            'value'   => '0123 456 789',
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setField([
        'id'         => 'contact_email',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'email',
        'label'      => __('Email'),
        'attributes' => [
            'name'    => 'contact_email',
            'value'   => 'test@gmail.com',
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setField([
        'id'         => 'address',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Address'),
        'attributes' => [
            'name'    => 'address',
            'value'   => __('Here will be the address'),
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 255,
            ],
        ],
    ])
    ->setSection([
        'title'      => __('Social'),
        'desc'       => __('Social links'),
        'id'         => 'opt-text-subsection-social',
        'subsection' => true,
        'icon'       => 'fa fa-share-alt',
    ])
    ->setField([
        'id'         => 'facebook',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Facebook',
        'attributes' => [
            'name'    => 'facebook',
            'value'   => null,
            'options' => [
                'class'       => 'form-control',
                'placeholder' => 'https://facebook.com/@username',
            ],
        ],
    ])
    ->setField([
        'id'         => 'twitter',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Twitter',
        'attributes' => [
            'name'    => 'twitter',
            'value'   => null,
            'options' => [
                'class'       => 'form-control',
                'placeholder' => 'https://twitter.com/@username',
            ],
        ],
    ])
    ->setField([
        'id'         => 'youtube',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Youtube',
        'attributes' => [
            'name'    => 'youtube',
            'value'   => null,
            'options' => [
                'class'       => 'form-control',
                'placeholder' => 'https://youtube.com/@channel-url',
            ],
        ],
    ]);


add_action('init', function () {
    config(['filesystems.disks.public.root' => public_path('storage')]);
}, 124);
