<x-admin::layout>

    <h1>{{ 'This is Admin dashboard' }}</h1>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</x-admin::layout>
