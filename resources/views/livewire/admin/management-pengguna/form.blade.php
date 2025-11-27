{{-- tempatmu bukan disini tampan, fokus dan cepat selesaikan --}}

{{-- Section Form --}}
<x-admin.ui.section title="Form Section" icon="bi-menu-button">
    <x-admin.ui.collapse title="Tambah Data" icon="fa-user-cog" variant="bordered">
        <form wire:submit='store' method="POST">
            @csrf
            <div class="space-y-4">

                {{-- Input Name & Email --}}
                <div class="grid grid-cols-2 space-x-4">
                    <x-admin.form.inputText wire:model.live='inputName' label="Nama Lengkap" :required="true"
                        placeholder="Masukan Nama Lengkap" />
                    <x-admin.form.inputText wire:model.live='inputEmail' type="email" label="Email" :required="true"
                        placeholder="Masukan Alamat Email" />
                </div>

                {{-- Input Password & Divisi --}}
                <div class="grid grid-cols-2 space-x-4">
                    <x-admin.form.inputText wire:model.live='inputPassword' type="password" label="Kata Sandi"
                        showPasswordToggle="true" :required="true" />

                    <div>
                        <x-admin.form.select wire:model.live='inputDivisi' name="inputDivisi" label="Divisi"
                            :options=$divisi required="true" />
                    </div>
                </div>

                {{-- Submit --}}
                <x-admin.button.success type="submit" icon="fa-plus" iconPrefix="fa" size="md">
                    Tambah Data User
                </x-admin.button.success>

            </div>
        </form>
        </x-admin.collapse.collapse>

</x-admin.ui.section>
