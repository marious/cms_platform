<?php

register_page_template([
    'default' => 'Default'
]);

register_page_template([
    'layout2' => __('layout2'),
]);

register_sidebar([
    'id'          => 'second_sidebar',
    'name'        => 'Second sidebar',
    'description' => 'This is a sample sidebar for themedemo theme',
]);

register_sidebar([
    'id'          => 'footer_sidebar',
    'name'        => __('Footer sidebar'),
    'description' => __('This is footer sidebar section'),
]);

register_sidebar([
    'id'          => 'google_map',
    'name'        => __('Google Map'),
    'description' => __(''),
]);

register_sidebar([
    'id'          => 'recent_posts',
    'name'        => __('Recent posts'),
    'description' => __(''),
]);

add_shortcode('hero-section', 'Hero section', 'Hero section', function () {
    return Theme::partial('short-codes.hero-section');
});

add_shortcode('about-us-section', 'About us section', 'About us section', function () {
    return Theme::partial('short-codes.about-us-section');
});

add_shortcode('blog-section', 'Blog section', 'Blog section', function () {
    return Theme::partial('short-codes.blog-section');
});

add_shortcode('call-to-action', 'Call to action', 'Call to action', function () {
    return Theme::partial('short-codes.call-to-action');
});

add_shortcode('our-portfolio-section', 'Our portfolio section', 'Our portfolio section', function () {
    return Theme::partial('short-codes.our-portfolio-section');
});

add_shortcode('promo-section', 'Promo section', 'Promo section', function () {
    return Theme::partial('short-codes.promo-section');
});

add_shortcode('promo-section2', 'Promo section', 'Promo section', function () {
    return Theme::partial('short-codes.promo-section2');
});

add_shortcode('services-section', 'Services section', 'Services section', function () {
    return Theme::partial('short-codes.services-section');
});

add_shortcode('team-two-section', 'Team two section', 'Team two section', function () {
    return Theme::partial('short-codes.team-two-section');
});

add_shortcode('testimonial-section', 'Testimonial section', 'Testimonial section', function () {
    return Theme::partial('short-codes.testimonial-section');
});

theme_option()
    ->setField([
        'id'         => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Copyright'),
        'attributes' => [
            'name'    => 'copyright',
            'value'   => '© 2020 En_Vi_Ti_En. All right reserved.',
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
            'value'   => '',
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
            'value'   => '',
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
            'value'   => __('Egypt Cairo'),
            'options' => [
                'class'        => 'form-control',
                'data-counter' => 255,
            ],
        ],
    ]);

add_action('init', function () {
    config(['filesystems.disks.public.root' => public_path('storage')]);
}, 124);
