@extends('layout.main')

@section('content')

    <h1 class="float-left">Блюда</h1>
    <a href="{{ route('dishes.create') }}" class="btn btn-success float-right">Добавить</a>
    <div class="clearfix"></div>
    <hr>

    <input type="text" id="searchDishes" class="form-control mb-4 mt-4 w-25" placeholder="Поиск...">
    <table class="table table-striped table-hover dishes" style="font-size: 18px;">
        <thead>
            <tr>
                <th>Название, состав</th>
                <th>Цена</th>
                <th>Вес</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($dishes as $dish)
                <tr onclick="location.href = '{{ route('dishes.edit', ['id' => $dish->id]) }}';" id="{{ $dish->id }}">
                    <td class="w-75" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $dish->composition }}">{{ $dish->title }}</td>
                    <td>{{ $dish->price }} руб.</td>
                    <td>{{ $dish->weight }} г.</td>
                    <td>
                        <a href="javascript:;" class="text-danger" onclick="if (confirm('Вы действительно хотите удалить это блюдо')) deleteDish({{ $dish->id }}); event.stopPropagation();">Удалить</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('popups.main')

@push('scripts')
    <script>
        function deleteDish(id) {
            var modal = new bootstrap.Modal(document.getElementById('modal'), {
                keyboard: false
            });
            $.ajax({
                type: 'delete',
                url: '{{ route('dishes.index') }}/dishes/' + id,
                success: function (e) {
                    $('#modal .modal-body').text('Блюдо успешно удалено');
                    $('#modal .modal-title').removeClass('text-danger').addClass('text-success').text('Успех');
                    $('#' + id).remove();
                },
                error: function (x, e) {
                    $('#modal .modal-body').text(x.statusText);
                    $('#modal .modal-title').removeClass('text-success').addClass('text-danger').text('Ошибка');
                    console.log(x);
                },
                complete: function () {
                    modal.show();
                }
            })
        }

        $("#searchDishes").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".dishes tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
@endpush
