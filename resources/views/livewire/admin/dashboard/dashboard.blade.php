{{-- The whole world belongs to you. --}}

<div class="">

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">2,548</p>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-green-600 font-medium">+12.3% from last month</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">$24,894</p>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-green-600 font-medium">+8.2% from last month</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">New Orders</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">356</p>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-red-600 font-medium">-2.1% from last month</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Conversion Rate</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">24.8%</p>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-green-600 font-medium">+3.7% from last month</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Bar Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Monthly Revenue</h3>
            <div class="h-80">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">User Distribution</h3>
            <div class="h-80">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Users</h3>
            <div class="flex space-x-2">
                <button
                    class="px-4 py-2 text-sm font-medium rounded-md bg-primary-600 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Export CSV
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Import
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    New User
                </button>
            </div>
        </div>
        <div class="px-6 py-4">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                John Doe
                            </th>
                            <td class="px-6 py-4">
                                john.doe@example.com
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                Administrator
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Jane Smith
                            </th>
                            <td class="px-6 py-4">
                                jane.smith@example.com
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                Editor
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Robert Johnson
                            </th>
                            <td class="px-6 py-4">
                                robert.j@example.com
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                Author
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Sarah Williams
                            </th>
                            <td class="px-6 py-4">
                                sarah.w@example.com
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                Subscriber
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Michael Brown
                            </th>
                            <td class="px-6 py-4">
                                michael.b@example.com
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                Contributor
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-6 py-4 border-t dark:border-gray-700 flex items-center justify-between">
            <p class="text-sm text-gray-700 dark:text-gray-400">Showing <span class="font-medium">1</span>
                to <span class="font-medium">5</span> of <span class="font-medium">100</span> results</p>
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 text-sm font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                    Previous
                </button>
                <button
                    class="px-3 py-1 text-sm font-medium rounded-md bg-primary-600 text-white hover:bg-primary-700">
                    1
                </button>
                <button
                    class="px-3 py-1 text-sm font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                    2
                </button>
                <button
                    class="px-3 py-1 text-sm font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                    3
                </button>
                <button
                    class="px-3 py-1 text-sm font-medium rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                    Next
                </button>
            </div>
        </div>
    </div>

</div>
