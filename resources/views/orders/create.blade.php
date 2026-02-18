@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('order.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Название заказа" required>
    <input type="number" step="0.01" name="price" placeholder="Цена" required>
    <button type="submit">Создать заказ</button>
</form>
