@extends('layout.main')

@section('content')
    <h1>Меню</h1>
    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="formWeek" class="form-label">День</label>
                <select class="form-control" id="formWeek">
                    <option value="Понедельник" selected>Понедельник</option>
                    <option value="Вторник">Вторник</option>
                    <option value="Среда">Среда</option>
                    <option value="Четверг">Четверг</option>
                    <option value="Пятница">Пятница</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Блюда</label>
                <div class="dish-inputs">
                    <select class="form-control basicAutoSelect" name="dish" id="0"
                            placeholder="type to search..."
                            data-url="{{ route('menu.autocomplete') }}" autocomplete="off"></select>
                </div>

                <button type="button" class="btn btn-primary mt-4 add-dish">Добавить</button>

            </div>

        </div>

        <div class="col-6">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#vk">ВК</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#instagram">Инстаграм</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active container" id="vk">
                    <div class="menu">
                        <div class="content">
                            <h2 class="text-center">Понедельник</h2>
                            <ul>

                            </ul>
                        </div>
                    </div>
                    <button class="btn btn-primary download-vk">Скачать</button>
                </div>
                <div class="tab-pane container" id="instagram">
                    <div class="menu">
                        <div class="content">
                            <h2 class="text-center">Понедельник</h2>
                            <ul>

                            </ul>
                        </div>
                    </div>
                    <button class="btn btn-primary download-instagram">Скачать</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('popups.main')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@master/dist/latest/bootstrap-autocomplete.min.js"></script>
    <script src="/js/dom-to-image.js"></script>

    <script>
        $(document).ready(() => {
            //$('#vk .menu').innerHeight($('#vk .menu').innerWidth() * 1.77);

            $('.basicAutoSelect').autoComplete({
                minLength: 2
            });

            $(document).on('autocomplete.select', '.basicAutoSelect',  (e, ui) => {
                console.log($('.menu .content ul #' + e.currentTarget.id).length);
                var code = '<span class="menu-title">' + ui.text + ' ' + ui.weight + 'г' + ' — ' + ui.price + ' руб.' + '</span>';
                if (ui.composition) code = code + '<span class="menu-composition">' + ui.composition + '</span>';

                if ($('li[data-menu-id=' + e.currentTarget.id + ']').length > 0) {
                    $('li[data-menu-id=' + e.currentTarget.id + ']').html(code);
                } else {
                    $('.menu .content ul').append('<li data-menu-id="' + e.currentTarget.id + '">' + code + '</li>');
                }

            });

            $('#formWeek').on('change', function () {
                $('.menu .content h2').text($(this).val());
            });

            $('.add-dish').on('click', () => {
                var last = $('.dish-inputs .basicAutoSelect').last().attr('id');
                $('.dish-inputs').append('<select class="form-control basicAutoSelect mt-3" id="' + (last + 1) + '" placeholder="поиск..." data-url="{{ route('menu.autocomplete') }}" autocomplete="off"></select>');
                $('.basicAutoSelect').autoComplete({
                    minLength: 2
                });
            });

            $('.download-vk').on('click', function () {
                var node = document.getElementById('my-node');
                domtoimage.toJpeg(document.querySelector("#vk .menu"))
                    .then(function (dataUrl) {
                        var link = document.createElement('a');
                        link.download = $('#formWeek').val() + '.jpg';
                        link.href = dataUrl;
                        link.click();
                    }).catch(function(e) {
                    console.log(e);
                });
            });

            $('.download-instagram').on('click', function () {
                var node = document.getElementById('my-node');
                domtoimage.toJpeg(document.querySelector("#instagram .menu"))
                    .then(function (dataUrl) {
                        var link = document.createElement('a');
                        link.download = $('#formWeek').val() + '.jpg';
                        link.href = dataUrl;
                        link.click();
                    }).catch(function(e) {
                    console.log(e);
                });
            });

        })
    </script>

@endpush
