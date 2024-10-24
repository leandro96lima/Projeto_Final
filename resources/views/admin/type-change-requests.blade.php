<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Type Change Requests') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl mb-6">{{ __('Type Change Requests') }}</h1>

                    <table class="table-auto w-full text-left">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">{{ __('User') }}</th>
                            <th class="px-4 py-2">{{ __('Requested Type') }}</th>
                            <th class="px-4 py-2">{{ __('Reason') }}</th>
                            <th class="px-4 py-2">{{ __('Status') }}</th>
                            <th class="px-4 py-2">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td class="border px-4 py-2">{{ $request->user_id }}</td>
                                <td class="border px-4 py-2">{{ $request->requested_type }}</td>
                                <td class="border px-4 py-2">{{ $request->reason }}</td>
                                <td class="border px-4 py-2">{{ $request->status }}</td>
                                <td class="border px-4 py-2 inline-flex items-center">
{{--                                    <form method="POST" action="{{ route('admin.type-change-requests.approve', $request) }}" class="inline-block mx-1">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.type-change-requests.reject', $request) }}" class="inline-block mx-1">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
