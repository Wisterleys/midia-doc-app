<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
                const mask={
                cpf(value){
                    return value.replace(/\D/g,'')
                    .replace(/([\d]{3})(\d)/,'$1.$2')
                    .replace(/([\d]{3})(\d)/,'$1.$2')
                    .replace(/([\d]{3})(\d{1,2})/,'$1-$2')
                    .replace(/(-[\d]{2})\d+?$/,'$1')
                }
            }

            document.getElementById('cpf').addEventListener("input",$input=>{
                const camp=$input.target.dataset.mask
                $input.target.value= mask[camp]($input.target.value)
            });
        });
    </script>
</x-app-layout>
