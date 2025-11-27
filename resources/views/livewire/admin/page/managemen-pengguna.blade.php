{{-- tidak semua yang kamu anggap teman itu menganggapmu teman ☺️ --}}
<div>
    @session('alert')
        @if ($value['type'] == 'success')
            <x-admin.ui.alert.success :title="$value['title']" :message="$value['message']" icon="true" />
        @elseif ($value['type'] == 'warning')
            <x-admin.ui.alert.success :title="$value['title']" :message="$value['message']" icon="true" />
        @elseif ($value['type'] == 'error')
            <x-admin.ui.alert.success :title="$value['title']" :message="$value['message']" icon="true" />
        @elseif ($value['type'] == 'info')
            <x-admin.ui.alert.success :title="$value['title']" :message="$value['message']" icon="true" />
        @endif
    @endsession

    {{-- Form input data --}}
    <livewire:admin.management-pengguna.form />

    {{-- Section Table --}}
    <livewire:admin.management-pengguna.table />

</div>
