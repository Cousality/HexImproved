<x-layout>
    @include('components.nav')

    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">

            <h1 class="text-3xl font-bold text-center mb-6">
                Login
            </h1>

            <form action="" method="POST" class="space-y-4">

                @csrf



                <div>
                    <label class="block mb-1 font-medium">
                        Email
                    </label>

                    <input type="email" name="email" class="w-full border rounded-lg p-3" placeholder="Enter email">
                </div>


                <div>
                    <label class="block mb-1 font-medium">
                        Password
                    </label>

                    <input type="password" name="password" class="w-full border rounded-lg p-3"
                        placeholder="Enter password">
                </div>




                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">
                    Login
                </button>

            </form>


        </div>

    </div>

</x-layout>
