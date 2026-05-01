   @if (Session::has('success'))
   <div class="bg-green-300 border-green-500 rounded p-4 mb-4 shadow-sm">
       <p class="text-green-700 font-medium">{{ Session::get('success') }}</p>
   </div>
   @endif
   @if (Session::has('error'))
   <div class="bg-red-300 border-red-500 rounded p-4 mb-4 shadow-sm">
       <p class="text-red-700 font-medium">{{ Session::get('error') }}</p>
   </div>
   @endif