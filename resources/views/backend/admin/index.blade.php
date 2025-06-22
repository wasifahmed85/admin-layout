{{-- <x-admin::layout>
    <x-slot name="title">Index Page</x-slot>
    <x-slot name="page_slug">admin</x-slot>

<div class="container">
    <h1>Users List</h1>
    <table id="usersTable" class="display nowrap" style="width:100%">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 py-2.5" >
            @foreach($admins as $user)
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('js')
    <script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            responsive: true
        });
    });
</script>
@endpush
</x-admin::layout> --}}