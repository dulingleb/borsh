@extends('layout.main')

@section('content')
    <h1 class="mb-4">Добавление блюда</h1>
    <form action="{{ route('dishes.store') }}" method="post" id="form-store-menu">
        <div class="mb-3 row">
            <label for="title" class="col-sm-2 col-form-label">Название</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="composition" class="col-sm-2 col-form-label">Состав</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="composition" id="composition">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="weight" class="col-sm-2 col-form-label">Вес</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="number" class="form-control" name="weight" id="weight" min="0" step="10" aria-describedby="basic-addon-weight">
                    <span class="input-group-text" id="basic-addon-weight">грамм</span>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Цена</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="number" class="form-control" name="price" id="price" min="0" step="0.1"  aria-describedby="basic-addon-price">
                    <span class="input-group-text" id="basic-addon-price">руб.</span>
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-4" type="submit">
            Добавить
            <div class="spinner-border spinner-border-sm text-light ms-2 d-none" role="status" id="submit-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </button>
    </form>
@endsection

@extends('popups.main')

@push('scripts')
    <script type="text/javascript">
        $('#form-store-menu').on('submit', function () {
            $('#submit-spinner').removeClass('d-none');
            var modal = new bootstrap.Modal(document.getElementById('modal'), {
                keyboard: false
            });
            $.ajax({
                type: 'post',
                url: '{{ route('dishes.store') }}',
                data: $(this).serialize(),
                success: function (e) {
                    $('#modal .modal-body').text('Блюдо успешно сохранено');
                    $('#modal .modal-title').removeClass('text-danger').addClass('text-success').text('Успех');
                    $('#modal').on('hidden.bs.modal', function (event) {
                        document.location.href = '{{ route('dishes.index') }}';
                    });
                },
                error: function (x, e) {
                    $('#modal .modal-body').text('');
                    $.each(x.responseJSON, function (i, e) {
                        $('#modal .modal-body').append(e + '<br>');
                    });
                    $('#modal .modal-title').removeClass('text-success').addClass('text-danger').text('Ошибка');
                },
                complete: function () {
                    $('#submit-spinner').addClass('d-none');
                    modal.show();
                }
            })

            return false;
        });
    </script>
@endpush
