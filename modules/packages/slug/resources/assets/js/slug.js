class SlugBoxManagement {
    init() {
        $('.change_slug').on('click', event =>  {
            const lang = $(event.currentTarget).data('lang');

            $(`.${lang + '-'}default-slug`).unwrap();
            let $slug_input = $(`#${lang + '-'}editable-post-name`);
            $slug_input.html('<input type="text" id="'+lang +'-new-post-slug" class="form-control" value="' + $slug_input.text() + '" autocomplete="off">');
            $(`#${lang + '-'}edit-slug-box .cancel`).show();
            $(`#${lang + '-'}edit-slug-box .save`).show();
            $(event.currentTarget).hide();
        });

        $('.edit-slug-box .cancel').on('click', (event) => {
            const lang = $(event.currentTarget).data('lang');
            let currentSlug = $(`#${lang + '-'}current-slug`).val();
            let $permalink = $(`#${lang + '-'}sample-permalink`);
            $permalink.html('<a class="'+lang +'-permalink" href="' + $('#'+lang+'_slug_id').data('view') + currentSlug.replace('/', '') + '">' + $permalink.html() + '</a>');
            $(`#${lang + '-'}editable-post-name`).text(currentSlug);
            $(`#${lang + '-'}edit-slug-box .cancel`).hide();
            $(`#${lang + '-'}edit-slug-box .save`).hide();
            $(`#${lang + '_'}change_slug`).show();
        });

        let createSlug = (name, id, exist, lang) => {
            const dashedLang = lang ? lang + '-' : '';
            const underScoredLang = lang ? lang + '_' : '';
            $.ajax({
                url: $(`#${underScoredLang}slug_id`).data('url'),
                type: 'POST',
                data: {
                    name: name,
                    slug_id: id,
                    model: $('input[name=model]').val(),
                    lang: lang,
                },
                success: data =>  {
                    let $permalink = $(`#${dashedLang}sample-permalink`);
                    let $slug_id = $(`#${underScoredLang}slug_id`);
                    if (exist) {
                        $permalink.find(`.${lang ? lang + '-' : ''}permalink`).prop('href', $slug_id.data('view') + data.replace('/', ''));
                    } else {
                        $permalink.html('<a class="'+ dashedLang +'permalink" target="_blank" href="' + $slug_id.data('view') + data.replace('/', '') + '">' + $permalink.html() + '</a>');
                    }

                    // $('.page-url-seo p').text($slug_id.data('view') + data.replace('/', ''));

                    $(`#${dashedLang}editable-post-name`).text(data);
                    $(`#${dashedLang}current-slug`).val(data);
                    $(`#${dashedLang}edit-slug-box .cancel`).hide();
                    $(`#${dashedLang}edit-slug-box .save`).hide();
                    $(`#${underScoredLang}change_slug`).show();
                    $(`#${dashedLang}edit-slug-box`).removeClass('hidden');
                },
                error: data =>  {
                    Falcon.handleError(data);
                }
            });
        };

        $('.edit-slug-box .save').on('click', (event) => {
            const lang = $(event.currentTarget).data('lang');
            let $post_slug = $(`#${lang}-new-post-slug`);
            let name = $post_slug.val();

            let id = $(`#${lang + '_'}slug_id`).data('id');
            if (id == null) {
                id = 0;
            }
            if (name != null && name !== '') {
                createSlug(name, id, false, lang);
            } else {
                $post_slug.closest('.form-group').addClass('has-error');
            }
        });

        $('.slug-field').blur((e) => {
            let lang = $(e.currentTarget).data('lang');

            if ($(`#${lang ? lang + '-' : ''}edit-slug-box`).hasClass('hidden')) {
                // let name = $('#name').val();
                let name = e.currentTarget.value;

                if (name !== null && name !== '') {
                    createSlug(name, 0, true, lang);
                }
            }

        });
    }
}

$(document).ready(() => {
    new SlugBoxManagement().init();
});
