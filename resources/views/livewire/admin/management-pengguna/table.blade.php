{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

<x-admin.ui.section title="Table Section" icon="bi-bar-chart-steps">

    {{-- Sort and filter --}}
    <div class="mb-2 p-2 bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="grid grid-cols-6 gap-4">

                    {{-- Sorting --}}
                    <div>
                        <x-admin.form.select wire:model.live='filterUrutan' name="status" label="Status" :options="[
                            'Nama' => [
                                'name_asc' => 'Ascending',
                                'name_desc' => 'Descending',
                            ],
                            'Email' => [
                                'name_asc' => 'Ascending',
                                'name_desc' => 'Descending',
                            ],
                            'Divisi' => [
                                'name_asc' => 'Ascending',
                                'name_desc' => 'Descending',
                            ],
                        ]"
                            :hasGroups="true" />
                    </div>

                    {{-- Filter by status --}}
                    <div>
                        <x-admin.form.select wire:model.live='filterStatus' name="status" label="Status"
                            :options="[
                                'all' => 'Semua Data',
                                'aktif' => 'Aktif',
                                'non-aktif' => 'Tidak Aktif',
                            ]" />
                    </div>

                    {{-- Filter by divisi --}}
                    <div>
                        <x-admin.form.select wire:model.live='filterDivisi' name="divisi" label="Divisi"
                            :options=$divisi />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pengguna</h3>
            <div class="flex space-x-2">

                {{-- Input Search --}}
                <x-admin.form.inputText wire:model.live="inputSearch" placeholder="Cari data ..." />

                {{-- Button Download --}}
                {{-- <x-admin.button.primary icon="fa-download" iconPrefix="fa"
                    size="sm">Export</x-admin.button.primary> --}}

                {{-- Button Upload --}}
                {{-- <x-admin.button.secondary icon="fa-upload" iconPrefix="fa" size="sm"
                    outline>Import</x-admin.button.secondary> --}}

            </div>
        </div>

        <div class="px-6 py-4">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Divisi</th>
                            <th class="px-6 py-3">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->email }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->deleted_at == null)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->divisi->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <x-admin.button.primary icon="fa-edit" iconPrefix="fa" size="sm" />
                                        <x-admin.button.danger icon="fa-trash" iconPrefix="fa" size="sm" />
                                        <x-admin.button.success icon="fa-print" iconPrefix="fa" size="sm" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $users->links() }}

</x-admin.ui.section>
